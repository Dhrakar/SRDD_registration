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
use Illuminate\Support\Facades\LOG;
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
        
        Log::debug("ScheduleController::__store(" . $session->id . ")");
        Log::debug(" IN -> Status: " . session('status'));

        // build an array of the sessions this person is already registered for (if any)
        $_regSess = Schedule::where('user_id', auth()->user()->id)->pluck('session_id')->toArray();

        // check for errors in adding to this session
        if($session->is_closed) {
            session()->flash('status','ERR:This session is not open for registration and has not been added to your calendar.');

        // now check to see if there are any available seats
        } elseif ( ($session->venue->max_seats - $session->schedules->count()) == 0 ) {
            session()->flash('status','ERR:This session has no more room and has not been added to your calendar.');

        // lastly, check to see if this person is already registered
        } elseif ( in_array($session->id, $_regSess)) {  // true if already in this session            
                session()->flash('status','ERR:You are already registered for "' . $session->event->title . '"');  
        }

        // see if we need to warn about overlapping sessions
        if( session('status') == 'CONFIRM') {
            // just clear the status since we are confirming an eariler overlap and skip checking for other overlaps
            session()->forget('status');
        } elseif(session()->missing('status')) {
            // iterate through the list of registered sessions to see if there are overlaps
            foreach($_regSess as $_id) {
                $_tmpSess = Session::where('id', $_id)->first();

                // see if the slots are set
                if( isset($_tmpSess->slot->id) && isset($session->slot->id) ) {
                    // if the 'custom' time slot, check the individual start/stop times
                    if( $session->slot->id == 1 && $_tmpSess->slot->id == 1 ) {
                        // if the session to add start is >= the check session start and the add session end <= compare session end
                        if( isset($_tmpSess->start_time) && isset($session->start_time)&& isset($_tmpSess->end_time) && isset($session->end_time)
                          && $_tmpSess->start_time >= $session->start_time 
                          && $_tmpSess->end_time >= $session->end_time ) 
                        {
                            session()->flash('status','WARN|' . $session->id . ':' . $_tmpSess->event->title);
                        }
                        // if this is a regular time slot, see it if matches the registered session
                    } elseif($_tmpSess->slot->id == $session->slot->id ) {
                        session()->flash('status','WARN|' . $session->id . ':' . $_tmpSess->event->title);
                    }
                }
            }
        }
        // if no errors or warnings, 
        if(session('status') === null ) {
          // ok, good to go for adding             
          session()->flash('status','OK:' . $session->event->title);
          DB::table('schedules')->insert([
            'year' => config('constants.srdd_year'),
            'user_id' => auth()->user()->id,
            'session_id' => $session->id
          ]);
        }
        
        Log::debug(" OUT -> Status: " . session('status'));

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
        // iterate to grab just sessions with events that do not need registration and are open
        foreach( Session::all() as $session) {
            if($session->event->needs_reg == 0 && ! $session->is_closed ) {
                // add to the schedule
                DB::table('schedules')->insert([
                    'year'       => config('constants.srdd_year'),
                    'user_id'    => $user->id,
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
        if($user->schedules->where('year', config('constants.srdd_year'))->count() > 0) {
            foreach($user->schedules->where('year', config('constants.srdd_year')) as $schedule) {
                $events->push([
                    'id' => $schedule->id,
            'start_time' => ($schedule->session->slot->id == 1)?$schedule->session->start_time:$schedule->session->slot->start_time,
              'end_time' => ($schedule->session->slot->id == 1)?$schedule->session->end_time:$schedule->session->slot->end_time,
                   'url' => $schedule->session->url,
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
