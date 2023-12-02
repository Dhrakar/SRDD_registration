<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Logout;
use App\Models\User;

class UpdateLoggedOutUser
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
    public function handle(Logout $event): void
    {
        // update the last login date
        DB::table('users')
        ->where('id', $event->user->id)
        ->update(['last_login' => now()]);
    }
}
