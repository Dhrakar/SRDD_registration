<?php 
    /*
     *  This is the admin landing page for Slot models and it shows all of them in a table
 ``  */

    use App\Models\Slot;

 ?>

@extends('template.app')

@section('content')
<x-admin.nav-admin/>
<div class="container w-full">
    <x-srdd.callout :title="__('Session Slots')">
    Session Slots are used to organize multiple sessions into specific time slots.  For example, from 9 am to 10 am.
    This helps to filter sessions so that attendees don't sign up for multiple, overlapping sessions.
    </x-srdd.callout>

    {{-- Create a new Slot --}}
    <x-global.title-box :title="__('Add a New Time Slot')">
        <form method="POST" action="{{ route('slots.store') }}">
            @csrf
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
            <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
            <x-input-error :messages="$errors->get('end_time')" class="mt-2" />

            <div class="mx-2 grid grid-cols-6 auto-col-max-6 gap-0">
                <div class="col-span-1 table-header text-right pr-4">
                  <label for="title">Title</label>
                </div>
                <div class="col-span-3 border border-indigo-800">
                  <input class="text-slate-900 w-4/5 pl-1"
                    type="input" name="title" 
                    value="" 
                    maxlength="50"
                    width="50"/>
                </div>
                <div class="col-span-2 text-xs text-red-600 italic pl-2">
                  40 chars maximum
                </div>
                <div class="col-span-1 table-header text-right pr-4">
                  <label for="start_time">Starting Time</label>
                </div>
                <div class="col-span-3 border border-indigo-800">
                    <i class="bi bi-clock px-2 text-std"></i>
                  <input class="text-slate-900"
                    type="time" name="start_time" id="start_time"
                    value="08:00" 
                    maxlength="10"
                    width="10"/>
                </div>
                <div class="col-span-2 text-xs text-red-600 italic pl-2">
                  24hr, only between 0800 and 1800
                </div>
                <div class="col-span-1 table-header text-right pr-4">
                  <label for="end_time">Ending Time</label>
                </div>
                <div class="col-span-3 border border-indigo-800">
                    <i class="bi bi-clock px-2 text-std"></i>
                    <input class="text-slate-900"
                        type="time" name="end_time" id="end_time"
                        value="09:00 " 
                        maxlength="10"
                        width="10"
                    />
                </div>
                <div class="col-span-2 text-xs text-red-600 italic pl-2">
                    24hr, only between 0800 and 1800
                </div>
                <div class="col-span-1">&nbsp;</div>
                <x-primary-button class="col-span-2 mt-4 mx-2">
                    {{ __('ui.button.new-slot') }}
                </x-primary-button>
            </div>
        </form>
    </x-global.title-box>

    {{-- List existing slots --}}
    <x-global.title-box :title="__('Currently Configured Tracks')">
        <div class="mx-2 grid grid-cols-12 gap-0 auto-cols-max-12">
            <div class="px-2 table-header col-span-1">Id</div>
            <div class="px-2 table-header col-span-3">Title</div>
            <div class="px-2 table-header col-span-2">Start Time</div>
            <div class="px-2 table-header col-span-2">End Time</div>
            <div class="px-2 table-header col-span-4">Edit/Delete</div>
            @php
                $tmp = Slot::all();
                $slots = $tmp->sortBy('start_time'); 
            @endphp
            @foreach($slots as $slot) {{-- iterate thru the defined slots --}}
              <div class="table-row col-span-1">{{ $slot->id }}</div>
              <div class="table-row col-span-3">{{ $slot->title }}</div>
              <div class="table-row col-span-2">{{ $slot->start_time}}</div>
              <div class="table-row col-span-2">{{ $slot->end_time}}</div>

              <div class="table-row col-span-4 inline:block">
                    @if($slot->id != 1 ) {{-- don't allow slot 1 to be edited or deleted --}}
                    <a href="{{ route('slots.edit', $slot) }}">
                        <i class="bi bi-pencil-square mx-2"></i>
                    </a>
                    <form method="post" action="{{ route('slots.delete', $slot) }}" class="inline-block">
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
    </x-global.title-box>
    <script>
        // wait until everything is loaded and then create the time widgets
        window.onload = function () {
            flatpickr("#start_time", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i:S",
                time_24hr: true,
                minTime: "08:00",
                maxTime: "17:00"
            });
            flatpickr("#end_time", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i:S",
                time_24hr: true,
                minTime: "09:00",
                maxTime: "18:00"
            });
        }
    </script>
@endsection