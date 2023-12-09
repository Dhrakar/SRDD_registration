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
        
        // build a collection of events for this user
        $my_events = $this->_get_schedule($user);

        return view('schedule.user.index', [
            'event_collection' => $my_events,
            ]
        );
    }

    /**
     * Returns the events for this user in a JSON format
     */
    public function print(): View
    {
        $user = auth()->user();
        $srdd_date = config('constants.db_srdd_date');
        
        // build a collection of events for this user
        $my_events = $this->_get_schedule($user);

        // Events string for pseudo-JSON
        $out = "events: [ "; 
        // now that we have good start times, iterate and sort by start times
        foreach($my_events as $event) {
            if($event['id'] != 0) { // skip the dummy row
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

        return view('schedule.user.print', [
            'events' => $out,
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

    /**
     * Helper function to get a collection of the users scheduled sessions
     */
    protected function _get_schedule(User $user): Collection
    {
        // create a new collection
        $events = new Collection();

        // are there any events to add for this user?
        if($user->schedules->count() > 0) {
            foreach($user->schedules as $schedule) {
                $events->push([
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
        }

        return $events;
    }
}
