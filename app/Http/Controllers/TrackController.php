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
            'color' => 'required|numeric|between:1,4',
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

    public function update(Track $track): RedirectResponse
    {
        dd($track);
    }
}
