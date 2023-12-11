<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
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
                 'level' => 'required|numeric|in:' . implode(",", array_keys(config('constants.auth_level'))),
        ]);
        
        $user->update($validated);

        return redirect(route('users.index'));
    }
}
