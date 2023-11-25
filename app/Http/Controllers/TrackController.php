<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Models\Track;

class TrackController extends Controller
{
    public function index(): View
    {
        return view('admin.tracks.index');
    }

    public function store(Request $request): RedirectResponse
    {
        // validate the data from the form
        $validated = $request->validate([
            'title' => 'required|string|max:40',
            'description' => 'required|string|max:80',
            'color' => 'required|numeric|between:1,' . count(config('constants.colors.tracks')),
        ]);
        
        $track = Track::create($validated);
            
        return redirect(route('tracks.index'));
    }

    public function edit(Track $track): View
    {
        // $this->authorize('update', $track);
 
        return view('admin.tracks.edit', [
            'track' => $track,
        ]);
    }

    public function update(Request $request, Track $track): RedirectResponse
    { 
        // validate the data from the form
        $validated = $request->validate([
            'title' => 'required|string|max:40',
            'description' => 'required|string|max:80',
            'color' => 'required|numeric|between:1,' . count(config('constants.colors.tracks')),
        ]);
        
        $track->update($validated);

        return redirect(route('tracks.index'));
    }

    public function destroy(Track $track): RedirectResponse
    {
        //First, grab any related events and reset the track #
         if($track->events->count() > 0) {
            foreach($track->events as $event) {
                $event->track_id = 1;
                $event->save();
            }
         }

        $track->delete();
        
        return redirect(route('tracks.index'));
    }
}
