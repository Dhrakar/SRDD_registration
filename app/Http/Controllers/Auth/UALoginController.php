<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;

class UALoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Google (UA Domain) Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating Google Accounts that have an 
    | @alaska.edu address. It checks to see if a user exists (via email) and 
    | calls login with those creds if so.  If not, calls register to get a new
    | user created.  If a non-UA email is provided, then the user is bounced
    | back to the home screen to try again. 
    |
    */

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Handles the Sign in with Google login for UA domain users
     */
    public function ualogin(Request $request)
    {
        Log::debug("UALoginController::ualogin()");
        $data = $request->all();

        // validate that the user supplied an @alaska.edu address and redirect back
        // if not with an error
        $_validator = Validator::make(
            $data, 
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'ends_with:alaska.edu'],
            ],
            [
                'email.ends_with' => '<strong>' . $data['email'] . '</strong> is not an email address in the UA domain. Please login with an @alaska.edu account',
            ]
        )->validateWithBag('domain');

        Log::debug(" -> validated form ... checking user");

        // now look to see if this person is already a user & get their obj from database
        $user = User::where('email',$data['email'])->first();

        // they are not already a user, so create a new user obj
        if(!$user){
            Log::debug(" -> Creating new user account for " . $data['email']);
            $user = User::create([
                'name' => $data['name'], 
                'email' => $data['email'],
                'password' => Hash::make(env('UA_DEF_PASSWD')),
                'level' => config('constants.auth_level')['attendee'],
                'login_count' => 0,
                'email_verified_at'  => now(),
            ]);
        } else {
            Log::debug(" -> Account " . $data['email'] . " already exists");
        }

        // set the previous login date
        session(['prevLogin' => Str::substr($user->last_login, 0, 10)]);

        // set the google token session var (to ensure that @alaska.edu logins are only done via the gsuite widget)
        session(['uaToken' => $data['token']]);

        // regenerate the session ID
        $request->session()->regenerate();

        // with the user object, log them in
        Auth::login($user);

        // update the last login and login count since the AuthenticatedUsers trait does not fire for this login
        $user->login_count = $user->login_count + 1;
        $user->last_login = now();
        $user->save();

        // delete the token session var
        session()->forget('uaToken');

        // zip back over to the main home view
        return redirect()->intended('login');
    }

}