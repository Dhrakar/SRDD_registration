<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\LOG;
use App\Models\Event;
use App\Models\Track;
use App\Models\User;
use App\Models\Session;
use App\Models\Schedule;

class ReportController extends Controller
{
    /**
     * Class variables
     */
    protected string $srdd_date;
    protected Collection $sessions;

    public function __construct() {

        // build sql version of the SRDD date constant
        $this->srdd_date = config('constants.db_srdd_date');
    }

    /**
     * Landing page
     */
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Shows the listing for an individual session
     */
    public function show(Request $request, Session $session)
    {
        if( $this->_validate_access($session) ) {
            return view('reports.show', [
                'session' => $session,
            ]); 
        } else {
            session()->flash('status', 'ERR');
            return redirect(route('reports'));
        }
    }

    /**
     * Prints out a session (must be either an admin or the instructor)
     */
    public function print(Request $request, Session $session)
    {
        if( $this->_validate_access($session) ) {
            return view('reports.print', [
                'session' => $session,
            ]); 
        } else {
            session()->flash('status', 'ERR');
            return redirect(route('reports'));
        }
    }

    /**
     * Internal function for checking if a person can load/print the session
     */
    protected function _validate_access(Session $session) 
    {
        $_usr = Auth::user();

        // check to see if the current user is the lead or is admin
        return ($_usr->level >= config('constants.auth_level')['admin'] || $session->event->user_id == $_usr->id);
          
    }
}
