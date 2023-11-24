<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.slots.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // validate the data from the form
        $validated = $request->validate([
            'title' => 'required|string|max:40',
            'start_time' => 'required|before:end_time',
            'end_time' => 'required',
        ]);
        
        $slot = Slot::create($validated);
            
        return redirect(route('slots.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Slot $slot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slot $slot): View
    {
        // $this->authorize('update', $slot);
 
        return view('admin.slots.edit', [
            'slot' => $slot,
        ]);
        
    }

    /** 
     * Verification that the user really wants to do the deletion
    */
    public function delete(Request $request, Slot $slot): View
    {
        // send the confirm message
        return view('admin.slots.edit', [
            'slot' => $slot,
            'confirm' => 'NEED',
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slot $slot): RedirectResponse
    {
        // validate the data from the form
        $validated = $request->validate([
            'title' => 'required|string|max:40',
            'start_time' => 'required|before:end_time',
            'end_time' => 'required',
        ]);
        
        $slot->update($validated);
            
        return redirect(route('slots.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slot $slot): RedirectResponse
    {
        // deletion is now verified, so wwhack it
        $slot->delete();

        return redirect(route('slots.index'));
    }
}
