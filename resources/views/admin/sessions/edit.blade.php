<?php
  /**
   *  This is used to edit Sessions
   */

   use App\Models\Event;
    use App\Models\Venue;
    use App\Models\Slot;
    use App\Models\Session;

    // build collections for the dropdown selectors
     $events = Event::where('year', config('constants.srdd_year'))->get()->sortBy('title');
     $venues = Venue::all()->sortBy('location');
      $slots = Slot::all()->sortBy('start_time');

    // format the srdd date for use with the DATE field
    $srdd_date = config('constants.db_srdd_date'); 
?>
@extends('template.app')

@section('content')
<x-srdd.nav-admin/>
<div class="container">
    <x-srdd.title-box :title="__('Editing Session #' . $session->id)">
        <form method="POST" action="{{ route('sessions.update', $session) }}">
            @csrf
            @method ('patch')

            {{-- form validation errors --}}
            <x-input-error :messages="$errors->get('event_id')" class="mt-2" />
            <x-input-error :messages="$errors->get('venue_id')" class="mt-2" />
            <x-input-error :messages="$errors->get('slot_id')" class="mt-2" />
            <x-input-error :messages="$errors->get('date_held')" class="mt-2" />
            <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
            <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
            <x-input-error :messages="$errors->get('is_closed')" class="mt-2" />
            <x-input-error :messages="$errors->get('url')" class="mt-2" />

            <div class="mx-1 grid grid-cols-6 auto-col-max-6 gap-0">
            {{-- pick a related Event (from just this year's events)--}}
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="event_id">
                        {{ config('constants.srdd_year') }} Event
                    </label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <select id="event_id" name="event_id"  class="ml-1 mr-8">
                        @foreach ($events as $event )
                            <option value="{{$event->id}}" 
                            @if ($session->event_id == $event->id)
                                selected="selected"
                            @endif
                            >{{$event->title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-1 text-xs text-red-600 dark:text-red-200 italic pl-2">
                    Select the Event for this Session 
                </div>

                {{-- pick a related Venue --}}
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="venue_id">Location</label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <select id="venue_id" name="venue_id"  class="ml-1 mr-8">
                        @foreach ($venues as $venue )
                            <option value="{{$venue->id}}"
                            @if ($session->venue_id == $venue->id)
                                selected="selected"
                            @endif
                            >{{$venue->location}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                    Select the location for this session
                </div>

                {{-- Pick a time slot --}}
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="slot_id">Time Slot</label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <select id="slot_id" name="slot_id"  class="ml-1 mr-8">
                        @foreach ($slots as $slot )
                            <option value="{{$slot->id}}"
                            @if ($session->slot_id == $slot->id)
                                selected="selected"
                            @endif
                            >
                                <i>{{$slot->title}}</i> &dash; {{$slot->start_time}} to {{$slot->end_time}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                    Select the time slot (Set to Custom if you need to use the Session start/end times)
                </div>
    
                {{-- set the date for this session --}}
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="date_held">Session Date</label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <i class="bi bi-calendar3 px-2 text-std"></i>
                    <input class="text-slate-900"
                        type="date" name="date_held" id="date_held"
                        value="{{$session->date_held}}" 
                        maxlength="10"
                        width="10"
                    />
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                    Set to the year of the SRDD
                </div>
                <div class="col-span-1 table-header text-right pr-4">
                  <label for="start_time">Starting Time</label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <i class="bi bi-clock px-2 text-std"></i>
                  <input class="text-slate-900"
                    type="time" name="start_time" id="start_time"
                    value="{{ $session->start_time }}" 
                    maxlength="10"
                    width="10"/>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                  24hr, only used if Time Slot is 'Custom'
                </div>
                <div class="col-span-1 table-header text-right pr-4">
                  <label for="end_time">Ending Time</label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <i class="bi bi-clock px-2 text-std"></i>
                    <input class="text-slate-900"
                        type="time" name="end_time" id="end_time"
                        value="{{ $session->end_time }}" 
                        maxlength="10"
                        width="10"
                    />
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                    24hr, only used if Time Slot is 'Custom'
                </div>

                {{-- dropdown for closed session  --}}
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="is_closed">Session Registration?</label>
                </div>
                <div class="col-span-4 border border-indigo-800 flex">
                    <select class="ml-1 mr-8 text-sm" id="is_closed" name="is_closed">
                        @if($session->is_closed == 0)
                            <option value="0" selected="selected">Open</option>
                            <option value="1">Closed</option>
                        @else
                            <option value="0" >Open</option>
                            <option value="1" selected="selected">Closed</option>
                        @endif
                    </select>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                     Used to lock session registrations once SRDD is done
                </div>
                {{-- edit/add the description URL --}}
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="is_closed">Session Desc. Link</label>
                </div>
                <div class="col-span-4 border border-indigo-800 flex">
                    <input class="text-slate-900 w-4/5 "
                           type="input" name="url" 
                           value="{{ $session->url }}" 
                           maxlength="500"
                           width="50"/>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                     Optional link to the session description at the SRDD website
                </div>

                {{-- action buttons --}}
                <div class="col-span-1">&nbsp;</div>
                <a class="inline-flex items-center mt-4 mx-2 px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                    href="{{ route('sessions.index') }}">           
                    {{__('ui.button.cancel') }}
                </a>
                <x-primary-button class="col-span-1 mt-4 mx-2">
                    {{ __('ui.button.update') }}
                </x-primary-button>
            </div>
        </form>
    </x-srdd.title-box>
    <script>
        // wait until everything is loaded and then create the time widgets
        window.onload = function () {
            flatpickr("#date_held", {
                enableTime: false,
                defaultDate: Date.parse('{{ config('constants.srdd_date') }}'),
            });
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
</div>
@endsection