<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Login;
use App\Models\User;

class UpdateLoggedInUser
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    { 
        // increment the login count
        $i = 1 + $event->user->login_count;
        DB::table('users')
            ->where('id', $event->user->id)
            ->update(['login_count' => $i]);
    }
}
