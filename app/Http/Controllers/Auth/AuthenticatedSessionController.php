<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('home'); //was auth.login
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        Log::debug("AuthenticatedSessionController::store()");
        // since this is for the normal login, we do not let folks use alska.edu
        Validator::make(
            $request->all(), 
            [
                'email' => ['required', 'string', 'email', 'max:255', 'doesnt_end_with:alaska.edu'],
            ],
            [
                'email.doesnt_end_with' => 'Please use the University of Alaska Google SSO option to login with an @alaska.edu account',
            ]
        )->validate();

        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Log::debug("AuthenticatedSessionController::destroy()");
        
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        Log::debug(" -> Deleted Laravel session ... ");

        // check if the Google one-touch login cookie is set and remove if it is (try to prevent 419 error)
        if(isset($_COOKIE['g_state'])) { 
            unset($_COOKIE['g_state']);
            setcookie('g_state', '', time()-3600);
         }
         Log::debug(" -> Deleted Google state cookie ... ");

        return redirect('/');
    }
}
