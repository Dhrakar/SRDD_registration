<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\LOG;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Track;
use App\Models\User;
use App\Models\Session;
use App\Models\Schedule;

class CalendarController extends Controller
{
   
    /**
     * Class variables
     */
    
    protected string $srdd_date;
    protected array $colors;
    protected Collection $sessions;
    public string $out;

    public function __construct() {
        // build sql version of the SRDD date constant
        $this->srdd_date = config('constants.db_srdd_date');

        // build out teh array of currently defined track colors
        $this->colors = config('constants.colors.tracks');

        // build an array of the schedules for this year
        // $reg = DB::table('schedules')
        // ->where('schedules.year', config('constants.srdd_year'))
        // ->where('user_id', $this->userid)
        // ->get()
        // ;
        // $this->regArray = $reg->values()->toArray(); 
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        Log::debug("CalendarController::__invoke()");

        // get the id for the current user
        $userid = Auth::user()->id;
        // use that to filter to a collection of the sessions this user is registered for (the values are the session ids)
        $sched = Schedule::where('year', config('constants.srdd_year'))->where('user_id', $userid)->get('session_id')->toArray();  

        // get all the currently defined sessions for this SRDD
        $this->sessions = Session::where('date_held', $this->srdd_date)->get();

        // Events string for pseudo-JSON
        $this->out = "events: [ "; 

        // Build the main calendar from the current sessions for this SRDD
        foreach ($this->sessions as $session) {
            // how many folks are registered for this session?
            $_reg = $session->schedules->count();

            // is the curent user one of those registered already?
            $_isReg = false;
            foreach( $sched as $_sch ) { 
                if($_sch['session_id'] == $session->id) {
                    $_isReg = true;
                    break;
                }
            }
            $this->out .= "{ "
                 .  "id: \""    . $session->id . "\", "
                 .  "title: \""
                 .    $session->event->title 
                 .    " " . (   // show the check icon if already registered
                             ($_isReg)?'✅':''
                            )        
                 .    " " . ( // show the calendar icon if this session needs registration
                             ($session->event->needs_reg)?'📋':''
                            ) 
                 .    " " . ( // show the lock icon for closed or, if needed, the no-entry icon for full
                             ($session->is_closed)?'🔓': 
                             " " . (((($session->venue->max_seats - $_reg) < 1 ) && ($session->venue->max_seats > 0))?'🚫':'')
                            )
                 .    "\", "
                 .  "description: \""
                 .   'Presenter -- ' 
                 .   ($session->event->instructor->name??'None') . '<br/>'
                 .   'Location -- '
                 .   $session->venue->location
                 .   ( 
                       ($session->is_closed)?' (CLOSED)<br/>':
                       ' (' . (($session->venue->max_seats < 0)?'Unlimited':( $session->venue->max_seats - $_reg)) . ' seats ) <br/>'
                     )
                 .   $session->event->description . "\", "
                // if the time slot id is 1, then use custom times in the session
                 .  "start: \"" . $this->srdd_date . 'T' . (($session->slot->id == 1)?$session->start_time:$session->slot->start_time) . "\", "
                 .  "end: \""   . $this->srdd_date . 'T' . (($session->slot->id == 1)?$session->end_time:$session->slot->end_time) . "\", "
                 .   (($session->venue->id == 2 )? 
                         // if this an online session, use distinctive colors
                          "backgroundColor: \"" . config('constants.colors.tracks_css.0') . "\","
                        . "textColor: \"" . config('constants.colors.tracks_css.' . $session->event->track->id) . " \","
                        . "borderColor: \"" . '#292524' . "\", "
                      :  // no, so use normal colors 
                          "backgroundColor: \"" . config('constants.colors.tracks_css.' . $session->event->track->id) .  "\", "
                        . "textColor: \"" . config('constants.colors.tracks_css.0') . "\", " 
                        . "borderColor: \"" . '#292524' . "\", "
                     )
                    // URL for adding this session
                 .  "url: \"" . route('schedule.add', $session) . "\", "
                 . "}, ";
        }
        $this->out .= "], ";
        
        // this returns the views/schedule/index.blade.php directly without the SchedulerController::index()
        return view('schedule.main.index', [
            'events' => $this->out, 
            ]
        );
    }
}
