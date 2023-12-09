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
}
