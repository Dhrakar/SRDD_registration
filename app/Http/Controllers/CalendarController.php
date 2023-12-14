<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\View\View;
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
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        // get all the currently defined sessions for this SRDD
        $this->sessions = Session::where('date_held', $this->srdd_date)->get();

        // Events string for pseudo-JSON
        $this->out = "events: [ "; 

        // Build the main calendar from the current sessions for this SRDD
        foreach ($this->sessions as $session) {
            // how many folks are registered for this session?
            $_reg = $session->schedules->count();
            $this->out .= "{ "
                 .  "id: \""    . $session->id . "\", "
                 .  "title: \""
                 .    $session->event->title 
                 .    " " . (($session->event->needs_reg)?'📋':'') 
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
                 .   ' (' . (($session->venue->max_seats < 0)?'Unlimited':( $session->venue->max_seats - $_reg)) . ' seats ) <br/>'
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
                 .  "url: \"" 
                 . ((! $session->is_closed)?route('schedule.add', $session):'') . "\", "
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
