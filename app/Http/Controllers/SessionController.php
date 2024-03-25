<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Event;
use App\Models\Venue;
use App\Models\Slot;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\LOG;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Log::debug("SessionController::index()");
        return view('admin.sessions.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // get totals for relationships
        $event_keys = Event::all()->implode(',');
        $venue_keys = Venue::all()->implode(','); 
         $slot_keys = Slot::all()->implode(',');

        // validate the data from the form
        $validated = $request->validate([
              'event_id' => 'required|numeric',      // limit to valid events
              'venue_id' => 'required|numeric',      // limit to valid locations
               'slot_id' => 'required|numeric',        // limit to valid time slots (can be 'custom' which is ID #1)
                   'url' => 'nullable|url',         // optional, but if included must be a valid URL 
             'date_held' => 'required|date',                                     // 
            'start_time' => 'sometimes|required_if:slot_id,1',      // if the slot is custom, then this is required
              'end_time' => 'sometimes|required_if:slot_id,1',                   // if the slot is custom, then this is required
             'is_closed' => 'boolean',                                // not required, but must be boolean
        ]);

        $session = Session::create($validated);
            
        return redirect(route('sessions.index'));
    }

    /**
     * close all of the current sessions for this SRDD 
     */
    public function close(Request $request)
    {
        Log::debug("SessionController::close()");

        Session::where('date_held', config('constants.db_srdd_date'))->update(['is_closed' => 1]);

        return redirect(route('sessions.index'));
    }

    /**
     * open all of the current sessions for this SRDD 
     */
    public function open(Request $request)
    {
        Log::debug("SessionController::open()");

        Session::where('date_held', config('constants.db_srdd_date'))->update(['is_closed' => 0]);

        return redirect(route('sessions.index'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Session $session)
    {
        return view('admin.sessions.edit', [
            'session' => $session,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Session $session)
    {
        // get totals for relationships
        $event_keys = Event::all()->keys();
        $venue_keys = Venue::all()->keys(); 
         $slot_keys = Slot::all()->keys();

        // validate the data from the form
        $validated = $request->validate([
              'event_id' => 'required|numeric',      // limit to valid events
              'venue_id' => 'required|numeric',      // limit to valid locations
               'slot_id' => 'required|numeric',        // limit to valid time slots (can be 'custom' which is ID #1)
                   'url' => 'nullable|url',         // optional, but if included must be a valid URL 
             'date_held' => 'required|date',                                     // 
            'start_time' => 'sometimes|required_if:slot_id,1',      // if the slot is custom, then this is required
              'end_time' => 'sometimes|required_if:slot_id,1',                   // if the slot is custom, then this is required
             'is_closed' => 'boolean',                                // not required, but must be boolean
        ]);

        $session->update($validated);
            
        return redirect(route('sessions.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Session $session): RedirectResponse
    {
        // grab any relevant schedules and delete them as well
        if($session->schedules->count() > 0 ) {
            foreach ($session->schedules as $schedule ) {
                $schedule->delete();
            }
        }

        $session->delete();

        return redirect(route('sessions.index'));
    }
}
