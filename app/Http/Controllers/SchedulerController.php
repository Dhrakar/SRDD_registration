<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
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
        $user = auth()->user();
        $srdd_date= date("Y-m-d", strtotime(config('constants.srdd_date')));
        $my_events = new Collection();

        // Events string for pseudo-JSON
        $out = "events: [ "; 

        // are there any events to add for this user?
        if($user->schedules->count() > 0) {
            foreach($user->schedules as $schedule) {
                $my_events->push([
                    'id' => $schedule->id,
            'start_time' => ($schedule->session->slot->id == 1)?$schedule->session->start_time:$schedule->session->slot->start_time,
              'end_time' => ($schedule->session->slot->id == 1)?$schedule->session->end_time:$schedule->session->slot->end_time,
              'location' => $schedule->session->venue->location,
            'instructor' => $schedule->session->event->instructor->name ?? ' --- ',
                 'title' => $schedule->session->event->title,
           'description' => $schedule->session->event->description,
                 'color' => $schedule->session->event->track->color,
                ]);
            };
                // insert dummy row so that the form will actuallly render for the list of schedules when there is only 1 schedule
                // since this starts at 1 AM, it will always sort to the top.  The index file hides all divs with id #0
                // it is not associated with any user, so after the last 'legit' row is deleted, the index file will show no sessions
                $my_events->push([
                    'id' => 0,
            'start_time' => '01:00:00',
              'end_time' => '12:00:00',
              'location' => '-',
            'instructor' => '-',
                 'title' => '-',
           'description' => '-',
                 'color' => 1,
                ]);

            // now that we have good start times, iterate and sort by start times
            foreach($my_events as $event) {
                 // add to event array     
                 $out .= "{ "           
                 .  "id: \""    . $event['id'] . "\", "
                 .  "title: \"" . $event['title'] ."\", "
                 .  "start: \"" . $srdd_date . 'T' . $event['start_time'] . "\", "
                 .  "end: \""   . $srdd_date . 'T' . $event['end_time'] . "\", "
                 . "}, ";

                 
            }
        }

        $out .= "], ";

        return view('schedule.user.index', [
            'events' => $out, 
            'event_collection' => $my_events,
            ]
        );
    }

    /**
     * Validates and adds sessions to a schedule for the logged in user
     */
    public function store(Session $session): RedirectResponse
    { 
        // blind add the session for now
        DB::table('schedules')->insert([
            'user_id' => auth()->user()->id,
            'session_id' => $session->id
        ]);
        return redirect(route('schedule'));
    }

    /**
     * Creates a new set of default sessions for this user
     */
    public function init(Request $request): RedirectResponse
    {
        // iterate to grab just sessions with events that do not need registration
        foreach( Session::all() as $session) {
            if($session->event->needs_reg == 0) {
                // add to the schedule
                DB::table('schedules')->insert([
                    'user_id' => auth()->user()->id,
                    'session_id' => $session->id
                ]);
            }
        }

        return redirect(route('schedule'));

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule): RedirectResponse
    {
        // deletion already confirmed, and no dependencies... so delete
        $schedule->delete();

        return redirect(route('schedule'));
    }
}
