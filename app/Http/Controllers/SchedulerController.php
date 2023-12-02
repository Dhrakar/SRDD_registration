<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Event;
use App\Models\Track;
use App\Models\User;
use App\Models\Session;
use App\Models\Schedule;


class SchedulerController extends Controller
{
    /**
     * Display landing page with calendar
     */
    public function index(): View
    { 

    return \App\Http\Controllers\CalendarController::class;
 
    }
}
