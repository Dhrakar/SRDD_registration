<?php

namespace App\Http\Controllers;

use App\Mail\AttendeeSchedule;
use App\Mail\Test;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;
use Illuminate\Session\Store;
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
        return view('schedule.attendee.index' );
    }
    
    /**
     * Validates and adds sessions to a schedule for the logged in user
     * 
     */
    public function store(Request $request, Session $session): RedirectResponse
    { 
        
        // First, unset the flash var
        $request->session()->flash('status','OK');
        // check to see if we can add this event session
        if($session->is_closed) {
            $request->session()->flash('status','This session is not open for registration and has not been added to your calendar.');
        // now check to see if there are any available seats
        } elseif ( ($session->venue->max_seats - $session->schedules->count()) == 0 ) {
            $request->session()->flash('status','This session has no more room and has not been added to your calendar.');
        // ok, good to go for adding
        } else {
            DB::table('schedules')->insert([
                'user_id' => auth()->user()->id,
                'session_id' => $session->id
            ]);
        }
        
        return redirect(route('calendar'));
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
     * Creates a new set of default sessions for this user
     */
    public function init(Request $request, User $user): RedirectResponse
    {
        // iterate to grab just sessions with events that do not need registration
        foreach( Session::all() as $session) {
            if($session->event->needs_reg == 0) {
                // add to the schedule
                DB::table('schedules')->insert([
                    'user_id' => $user->id,
                    'session_id' => $session->id
                ]);
            }
        }

        return redirect(route('schedule'));

    }


    /**
     * Returns the events for this user in a JSON format
     */
    public function print(User $user): View
    {
        
        // build a collection of events for this user
        $my_events = $this->get_sched_json($user);

        return view('schedule.attendee.print', [
            'events' => $my_events,
            ]
        );
    }

    /**
     * Emails the user's schedule
     */
    public function email(Request $request, User $user)
    {
        // build a collection of events for this user
        $events = $this->get_schedule($user);

            Mail::to($request->user())
                ->send(new AttendeeSchedule($events));
                
        return view('schedule.attendee.email');
    }
    /**
     * Helper function to get a collection of the users scheduled sessions
     */
    public function get_schedule(User $user): Collection
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
                 'track' => $schedule->session->event->track->title,
                 'color' => $schedule->session->event->track->color,
                ]);
            };
        }

        return $events;
    }

    /**
     * Converts the schedule to a JSON string
     */
    public function get_sched_json(User $user): string
    {
        // get the formatted event date
        $srdd_date = config('constants.db_srdd_date');

        // get the events for this user
        $events = $this->get_schedule($user);

        // Build string for pseudo-JSON
        $out = "events: [ "; 
        // now that we have good start times, iterate and sort by start times
        foreach($events as $event) {
            if($event['id'] != 0) { // skip the dummy row
                // add to event array     
                $out .= "{ "           
                .  "id: \""    . $event['id'] . "\", "
                .  "title: \"" 
                .      ' [ ' . $event['location'] . ' ] ' 
                .      '\'' . $event['title'] . '\''
                .      ' (' . $event['track'] . ') '
                .      "\", "
                .  "start: \"" . $srdd_date . 'T' . $event['start_time'] . "\", "
                .  "end: \""   . $srdd_date . 'T' . $event['end_time'] . "\", "
                . "}, ";
            }
             
        }
        $out .= "], ";

        return $out;
    }
}
