<?php 
    /*
     *  This is the admin landing page for Venue models and it shows all of them in a table
 ``  */

    use App\Models\Venue;

 ?>

@extends('template.app')

@section('content')
<x-global.nav-admin/>
<div class="container w-full">
    <x-srdd.callout :title="__('Session Venues')">
    Session Venues are the various locations that are used to present Sessions. Each venue has a total number
    of available seats for those locations that are size limited.  Note that a value of -1 for the max-seats 
    indicates that the seating is unlimited.
    </x-srdd.callout>

    {{-- Create a new Venue --}}
    <x-srdd.title-box :title="__('Add a New Venue')">
        <form method="POST" action="{{ route('venues.store') }}">
            @csrf
            <x-input-error :messages="$errors->get('location')" class="mt-2" />
            <x-input-error :messages="$errors->get('max_seats')" class="mt-2" />

            <div class="mx-2 grid grid-cols-6 auto-col-max-6 gap-0">
                <div class="col-span-1 table-header text-right pr-4">
                  <label for="title">Location</label>
                </div>
                <div class="col-span-3 border border-indigo-800">
                  <input class="text-slate-900 w-4/5 pl-1"
                    type="input" name="location" 
                    value="" 
                    maxlength="50"
                    width="50"/>
                </div>
                <div class="col-span-2 text-xs text-red-600 italic pl-2">
                  40 chars maximum
                </div>
                <div class="col-span-1 table-header text-right pr-4">
                  <label for="title">Total # of Seats</label>
                </div>
                <div class="col-span-3 border border-indigo-800">
                  <input class="text-slate-900 w-4/5 pl-1"
                    type="input" name="max_seats" 
                    value="-1" 
                    maxlength="50"
                    width="50"/>
                </div>
                <div class="col-span-2 text-xs text-red-600 italic pl-2">
                  -1 indicates unlimited
                </div>
                <div class="col-span-1">&nbsp;</div>
                <x-primary-button class="col-span-2 mt-4 mx-2">
                    {{ __('ui.button.new-slot') }}
                </x-primary-button>
            </div>
        </form>
    </x-srdd.title-box>

    {{-- List existing slots --}}
    <x-srdd.title-box :title="__('Currently Configured Time Slots')">
        <div class="mx-2 grid grid-cols-8 gap-0 auto-cols-max-12">
            <div class="px-2 table-header col-span-1">Id</div>
            <div class="px-2 table-header col-span-3">Location</div>
            <div class="px-2 table-header col-span-1">Max Seats</div>
            <div class="px-2 table-header col-span-3">Edit/Delete</div>
            @foreach(Venue::all() as $venue) {{-- iterate thru the defined venues --}}
                <div class="table-row col-span-1">{{ $venue->id }}</div>
                <div class="table-row col-span-3">{{ $venue->location }}</div>
                <div class="table-row col-span-1">{{ $venue->max_seats}}</div>
                <div class="table-row col-span-3 inline:block">
                @if($venue->id != 1 ) {{-- don't allow venue 1 to be edited or deleted --}}
                    <a href="{{ route('venues.edit', $venue) }}">
                        <i class="bi bi-pencil-square mx-2"></i>
                    </a>
                    <form method="post" action="{{ route('venues.delete', $venue) }}" class="inline-block">
                        @csrf 
                        <input type="hidden" name="DEL_CONFIRM" value="NEED">
                        <button type="submit"><i class="text-red-500 bi bi-trash mx-2"></i></button>
                    </form>
                @else
                    <i class="text-slate-400 bi bi-pencil-square mx-2"></i>
                    <i class="text-slate-400 bi bi-trash mx-2"></i>
                @endif
                </div>
          @endforeach
        </div>
    </x-srdd.title-box>
</div>
@endsection
