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

    // format the srdd date for use with teh DATE field
    $srdd_date = date("Y-m-d", strtotime(config('constants.srdd_date'))); 

        // holds the track colors
        $colors = config('constants.colors.tracks');
 
        // grab and iterate thru the sessions for this year's SRDD
        $sessions = Session::where('date_held', $srdd_date)->get();
        $out = " events: [ ";
        foreach ($sessions as $session) {
            $out .= "{ "
                 .  "id: \""    . $session->id . "\", "
                 .  "title: \"" . $session->event->title . " " . (($session->event->needs_reg)?'📋':'') ."\", "
                 .  "description: \"" . $session->event->description . "\", "
                // if the time slot id is 1, then use custom times in the session
                 .  "start: \"" . $srdd_date . 'T' . (($session->slot->id == 1)?$session->start_time:$session->slot->start_time) . "\", "
                 .  "end: \""   . $srdd_date . 'T' . (($session->slot->id == 1)?$session->end_time:$session->slot->end_time) . "\", "
                 .  "classNames: \"" . $colors[$session->event->track->color] . "\", "
                 .  "textColor: \"" . (($session->is_closed)?'#b91c1c':'#334155') . "\", " 
                 .  "borderColor: \"" . '#c084fc' . "\", "
                 . "}, ";
        }
        $out .= "], ";

        return view('schedule.index', [
            'events' => $out, 
            ]
        );
    }
}
