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
        $validated = $request->validate([
            'title' => 'required|string|max:40',
        ]);
 
        $request->track()->create($validated);
 
        return redirect(route('admin.tracks.index'));
    }

    public function edit(Track $track): View
    {
        // $this->authorize('update', $track);
 
        return view('admin.tracks.edit', [
            'track' => $track,
        ]);
    }
}
