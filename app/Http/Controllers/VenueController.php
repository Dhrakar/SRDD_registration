<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.venues.index');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // validate the data from the form
        $validated = $request->validate([
            'location' => 'required|string|max:40',
            'max_seats' => 'required|integer',
        ]);
        
        $venue = Venue::create($validated);
            
        return redirect(route('venues.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Venue $venue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venue $venue): View
    {
        //$this->authorize('update', $slot);
 
        return view('admin.venues.edit', [
            'venue' => $venue,
        ]);
    }

    /** 
     * Verification that the user really wants to do the deletion
    */
    public function delete(Request $request, Venue $venue): View
    {
        // send the confirm message
        return view('admin.venues.edit', [
            'venue' => $venue,
            'confirm' => 'NEED',
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Venue $venue): RedirectResponse
    {
        //alidate the data from the form
        $validated = $request->validate([
            'location' => 'required|string|max:40',
            'max_seats' => 'required|integer',
        ]);
        
        $venue->update($validated);
            
        return redirect(route('venues.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venue $venue): RedirectResponse
    {
        //First, grab any related sessions and reset the track #
        if($venue->sessions->count() > 0) {
            foreach($venue->sessions as $session) {
                $session->venue_id = 1;
                $session->save();
            }
         }
         
        // deletion is now verified, so wwhack it
        $venue->delete();

        return redirect(route('venues.index'));
    }
}
