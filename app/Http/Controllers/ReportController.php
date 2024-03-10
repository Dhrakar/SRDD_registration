<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
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

}
