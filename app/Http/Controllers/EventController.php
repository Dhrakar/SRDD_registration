<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Models\Event;
use App\Models\Track;
use App\Models\User;
use App\Models\Session;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    { 
        return view('admin.events.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // get totals for relationships
        $track_keys = Track::all()->keys()->implode(',');
         $user_keys = User::all()->keys()->implode(',');

        // validate the data from the form
        $validated = $request->validate([
            'track_id'    => 'required|numeric',             // limit to current, valid tracks
            'user_id'     => 'required|numeric',              // limit to current, valid users 
            'year'        => 'nullable|numeric|gte:' . config('constants.srdd_year'), // limit to the curr SRDD year+
            'title'       => 'required|string|max:80', 
            'description' => 'required|string|max:150',
            'needs_reg'   => 'boolean',
        ]);
        
        $event = Event::create($validated);
            
        return redirect(route('events.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('admin.events.edit', [
            'event' => $event,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        // get totals for relationships
        $track_keys = Track::all()->keys()->implode(',');
         $user_keys = User::all()->keys()->implode(',');

        // validate the data from the form
        $validated = $request->validate([
            'track_id'    => 'required|numeric',             // limit to current, valid tracks
            'user_id'     => 'required|numeric',              // limit to current, valid users 
            'year'        => 'nullable|numeric|gte:' . config('constants.srdd_year'), // limit to the curr SRDD year+
            'title'       => 'required|string|max:80', 
            'description' => 'required|string|max:150',
            'needs_reg'   => 'boolean',
        ]);
        
        $event->update($validated);
            
        return redirect(route('events.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event): RedirectResponse
    {
        // grab any related Sessiona and schedules and delete since without the event they are invalid
        if( $event->sessions->count() > 0) {
            foreach( $event->sessions as $session) {
                if( $session->schedules->count() > 0) {
                    foreach($session->schedules as $schedule) {
                        $schedule->delete();
                    }
                }
                $session->delete();
            }
        }
        $event->delete();
        
        return redirect(route('events.index'));
    }
}
