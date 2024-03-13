<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use App\Models\User;

class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index');
    }

    public function edit(User $user): View
    {
        // $this->authorize('update', $track);
 
        return view('admin.users.edit', [
            'account' => $user,
        ]);
    }
    
    public function update(Request $request, User $user): RedirectResponse
    { 
        // validate the data from the form
        $validated = $request->validate([
                  'name' => 'required|string|max:40',
                 'level' => 'required|numeric|in:' . implode(",", array_values(config('constants.auth_level'))),
        ]);
        
        $user->update($validated);

        return redirect(route('users.index'));
    }

    public function store(Request $request): RedirectResponse
    {
        // validate the form data
        $validated = $request->validate([
            'name' => 'required|string|max:40',
           'level' => 'required|numeric|in:' . implode(",", array_values(config('constants.auth_level'))),
           'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
       ]);

       $user = User::create([
            'name' => $request->name,
           'level' => $request->level,
           'email' => $request->email,
        'password' => Hash::make(Str::random(20)),  // we don't care what this passwd will be since it will be reset later
       ]);


       return redirect(route('users.index'));
    }
}
