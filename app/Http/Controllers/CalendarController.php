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
        $this->srdd_date= date("Y-m-d", strtotime(config('constants.srdd_date')));

        // build out teh array of currently defined track colors
        $this->colors = config('constants.colors.tracks');

        // get all the currently defined sessions for this SRDD
        $this->sessions = Session::where('date_held', $this->srdd_date)->get();
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Events string for pseudo-JSON
        $this->out = "events: [ "; 

        // Build the main calendar from the current sessions for this SRDD
        foreach ($this->sessions as $session) {
            $this->out .= "{ "
                 .  "id: \""    . $session->id . "\", "
                 .  "title: \"" . $session->event->title . " " . (($session->event->needs_reg)?'📋':'') ."\", "
                 .  "description: \"" . $session->event->description . "\", "
                // if the time slot id is 1, then use custom times in the session
                 .  "start: \"" . $this->srdd_date . 'T' . (($session->slot->id == 1)?$session->start_time:$session->slot->start_time) . "\", "
                 .  "end: \""   . $this->srdd_date . 'T' . (($session->slot->id == 1)?$session->end_time:$session->slot->end_time) . "\", "
                 .  "classNames: \"" . $this->colors[$session->event->track->color] . "\", "
                 .  "textColor: \"" . (($session->is_closed)?'#b91c1c':'#334155') . "\", " 
                 .  "borderColor: \"" . '#c084fc' . "\", "
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
