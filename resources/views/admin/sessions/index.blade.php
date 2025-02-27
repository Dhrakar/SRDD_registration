<?php 
    /*
     *  This is the admin landing page for Session models and it shows all of them in a table
 ``  */

    use App\Models\Event;
    use App\Models\Venue;
    use App\Models\Slot;
    use App\Models\Session;

    // build collections for the dropdown selectors
     $events = Event::where('year', config('constants.srdd_year'))->get()->sortBy('title');
     $venues = Venue::all()->sortBy('location');
      $slots = Slot::all()->sortBy('start_time');

    // format the srdd date for use with teh DATE field
    $srdd_date = config('constants.db_srdd_date'); 

    // did we get a deletion request? 
    if( isset($_GET['CONFIRM']) ) {
      $session = Session::find($_GET['CONFIRM']); 
      unset($_GET['CONFIRM']);
  }

 ?>

@extends('template.app')

@section('content')
<x-srdd.nav-admin/>
@isset($session) {{-- dialogs for validating a session deletion --}}
<x-srdd.warning :title="__('Verify Deletion')" >
    <b>Warning!</b> Are you sure that you want to delete Session # {{ $session->id }}?
    <div class="pl-4 max-h-32">
        @if ($session->schedules->count() > 0) {{-- Any associated user schedules? --}}
        
            This Session has been added to these {{ $session->schedules->count() }} User Schedules:<br/>
            @foreach ($session->schedules->all() as $schedule )
                <span class="pl-4">
                    <i class="bi bi-dot"></i>
                    ID: {{ $schedule->id }} &dash; Event: {{ $schedule->session->event->title }} , User: {{ $schedule->user->name }}
                    <br/>
                </span>
            @endforeach
            <br/>
            <i>If you confirm this deletion, those schedules will also be deleted.</i>
        @endif
    </div>
    <form method="post" action="{{ route('sessions.destroy', $session) }}" class="inline-block">
        @csrf 
        @method('delete')
        <div class="mt-4 mb-4 flex justify-end">
            <a class="px-4 py-2 
                    bg-white border border-gray-300 rounded-md 
                    font-semibold text-xs text-gray-700 uppercase tracking-widest 
                    shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 
                    disabled:opacity-25 transition ease-in-out duration-150"
                href="{{route('sessions.index')}}">
                {{__('ui.button.cancel')}}
            </a>
            <x-danger-button class="ml-3">
                {{ __('ui.button.delete') }}
            </x-danger-button>
        </div>
    </form>  
</x-srdd.warning>
@endisset
<div class="container w-full">
    <x-srdd.callout :title="__('Sessions')">
    Sessions are where it all comes together.  Each Session is a time and place where an Event is held.  Users sign up for Sessions that are then
    added to their Schedule for the day.  
    </x-srdd.callout>
    {{-- Create a new Session --}}
    <x-srdd.title-box :title="__('Add a New Session')"  :state="0">
        <form method="POST" action="{{ route('sessions.store') }}">
            @csrf
                {{-- validation error messages
                  -- Need to go before form to avoid breaking layout
                --}}
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
                            <option value="{{$event->id}}">{{$event->title}}</option>
                        @endforeach
                    </select>
                </div>
                <x-srdd.row-comment class="col-span-1">
                    Select the Event for this Session
                </x-srdd.row-comment>

                {{-- pick a related Venue --}}
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="venue_id">Location</label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <select id="venue_id" name="venue_id"  class="ml-1 mr-8">
                        @foreach ($venues as $venue )
                            <option value="{{$venue->id}}">{{$venue->location}}</option>
                        @endforeach
                    </select>
                </div>
                <x-srdd.row-comment class="col-span-1">
                    Select the location for this session
                </x-srdd.row-comment>

                {{-- Pick a time slot --}}
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="slot_id">Time Slot</label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <select id="slot_id" name="slot_id"  class="ml-1 mr-8">
                        @foreach ($slots as $slot )
                            <option value="{{$slot->id}}">
                                <i>{{$slot->title}}</i> &dash; {{$slot->start_time}} to {{$slot->end_time}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <x-srdd.row-comment class="col-span-1">
                    Select the time slot (Set to Custom if you need to use the Session start/end times)
                </x-srdd.row-comment>
    
                {{-- set the date for this session --}}
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="date_held">Session Date</label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <i class="bi bi-calendar3 px-2 text-std"></i>
                    <input class="text-slate-900"
                        type="date" name="date_held" id="date_held"
                        value="{{ $srdd_date }}" 
                        maxlength="10"
                        width="10"
                    />
                </div>
                <x-srdd.row-comment class="col-span-1">
                    Defaults to current SRDD date.
                </x-srdd.row-comment>
                <div class="col-span-1 table-header text-right pr-4">
                  <label for="start_time">Starting Time</label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <i class="bi bi-clock px-2 text-std"></i>
                  <input class="text-slate-900"
                    type="time" name="start_time" id="start_time"
                    value="{{ old('start_time') }}" 
                    maxlength="10"
                    width="10"/>
                </div>
                <x-srdd.row-comment class="col-span-1">
                  24hr, only used if Time Slot is 'Custom'
                </x-srdd.row-comment>
                <div class="col-span-1 table-header text-right pr-4">
                  <label for="end_time">Ending Time</label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <i class="bi bi-clock px-2 text-std"></i>
                    <input class="text-slate-900"
                        type="time" name="end_time" id="end_time"
                        value="{{ old('end_time') }}" 
                        maxlength="10"
                        width="10"
                    />
                </div>
                <x-srdd.row-comment class="col-span-1">
                    24hr, only used if Time Slot is 'Custom'
                </x-srdd.row-comment>

                {{-- dropdown for closed session  --}}
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="is_closed">Session Registration?</label>
                </div>
                <div class="col-span-4 border border-indigo-800 flex">
                    <select class="ml-1 mr-8 text-sm" id="is_closed" name="is_closed">
                        <option value="0" selected="selected">Open</option>
                        <option value="1">Closed</option>
                    </select>
                </div>
                <x-srdd.row-comment class="col-span-1">
                     Used to lock session registrations once SRDD is done
                </x-srdd.row-comment>

                {{-- Optional link to the SRDD website for each session --}}
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="url">Session Desc. Link</label>
                </div>
                <div class="col-span-4 border border-indigo-800 flex">
                    <input class="text-slate-900 w-4/5 "
                           type="input" name="url" 
                           value="{{ old('url') }}" 
                           maxlength="500"
                           width="50"/>
                </div>
                <x-srdd.row-comment class="col-span-1">
                     Optional link out to the SRDD website
                </x-srdd.row-comment>

                {{-- action button --}}
                <div class="col-span-1">&nbsp;</div>
                <x-primary-button class="col-span-1 mt-4 mx-2 justify-center">
                    {{ __('ui.button.new-session') }}
                </x-primary-button>
            </div>
        </form>
    </x-srdd.title-box>

    {{-- List existing sessions --}}
    <x-srdd.title-box :title="__('Currently Configured Sessions')">
        <div class="mt-2 mb-4 ml-4 flex gap-1">
            <a class="px-4 py-2 
                    bg-green-500 border border-green-300 rounded-md 
                    font-semibold text-xs text-std uppercase tracking-widest 
                    shadow-sm hover:green-50
                    disabled:opacity-25 transition ease-in-out duration-150"
                href="{{route('sessions.open')}}">
                <i class="bi bi-calendar-check"></i>&nbsp;{{__('Mark All Sessions OPEN')}}
            </a>
            <a class="px-4 py-2 
                    bg-red-500 border border-red-300 rounded-md 
                    font-semibold text-xs text-std uppercase tracking-widest 
                    shadow-sm hover:red-50
                    disabled:opacity-25 transition ease-in-out duration-150"
                href="{{route('sessions.close')}}">
                <i class="bi bi-calendar-x"></i>&nbsp;{{__('Mark All Sessions CLOSED')}}
            </a>
        </div>
        <div class="mx-2 grid grid-cols-12 gap-0 auto-cols-max-12">
            <div class="px-2 table-header col-span-1">Id</div>
            <div class="px-2 table-header col-span-1">Link</div>
            <div class="px-2 table-header col-span-1">Event</div>
            <div class="px-2 table-header col-span-2">Location</div>
            <div class="px-2 table-header col-span-1">Date Held</div>
            <div class="px-2 table-header col-span-2">Time Slot</div>
            <div class="px-2 table-header col-span-1">Start Time</div>
            <div class="px-2 table-header col-span-1">End Time</div>
            <div class="px-2 table-header col-span-1">Open?</div>
            <div class="px-2 table-header col-span-1">Edit/Delete</div>
            @foreach(Session::where('date_held', '=', $srdd_date)->get() as $session) {{-- iterate thru this year's sessions --}}
                <div class="table-row col-span-1">{{ $session->id }}</div>
                <div class="table-row col-span-1 py-2">
                    @if($session->url === null)
                        ---
                    @else
                    <a href="{{ $session->url }}"
                       class="px-2 py-1 rounded-md bg-sky-700 text-slate-50 uppercase text-xs"
                       id="SESS_{{ $session->id }}_URL"
                       target="_blank"><i class="bi bi-link-45deg"></i>&nbsp;Link</a>
                    <script type="module"> 
                        tippy('#SESS_{{ $session->id }}_URL', { 
                            content: "{{ $session->url }}",
                        }); 
                    </script>
                    @endif
                </div>
                <div class="table-row col-span-1"
                    @if($session->event->user_id > 0) 
                        data-tippy-content="{{ $session->event->instructor->name }}"
                    @endif
                >
                    {{ $session->event->title }}</div>
                <div class="table-row col-span-2">
                    {{ $session->venue->location}}
                </div>
                <div class="table-row col-span-1">
                    {{ $session->date_held}}
                </div>

                {{-- if the custom slot, show the custom times otherwise, show slot times --}}
                <div class="table-row col-span-2">
                    {{$session->slot->title}}
                </div>
                <div class="table-row col-span-1">
                    {{ ( $session->slot->id == 1)?$session->start_time:$session->slot->start_time }}
                </div>
                <div class="table-row col-span-1">
                    {{ ( $session->slot->id == 1)?$session->end_time:$session->slot->end_time }}
                </div>

                <div class="table-row col-span-1 text-2xl">
                    @if ($session->is_closed == 0)
                    <i class="bi bi-calendar-check text-green-500"></i>
                    @else
                    <i class="bi bi-calendar-x text-red-500"></i>
                    @endif
                </div>
                <div class="table-row col-span-1">
                    @if ($session->date_held < today() )  {{-- don't allow edits/deletion of historical sessions --}}
                        <i class="text-slate-400 bi bi-pencil-square mx-2"></i>
                        <i class="text-slate-400 bi bi-trash mx-2"></i>
                    @else
                        <div class="flex justify-center">
                            <a href="{{ route('sessions.edit', $session) }}">
                                <i class="bi bi-pencil-square mx-2"></i>
                            </a>
                            <form name="event_{{ $event->id  }}" method="get" action="{{ route('sessions.index') }}">
                                <input type="hidden" id="CONFIRM" name="CONFIRM" value="{{ $session->id  }}"/>
                                <button type="submit" >
                                    <i class="text-red-500 bi bi-trash mx-2"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </x-srdd.title-box>

    {{-- List prior sessions --}}
    <x-srdd.title-box :title="__('Prior Year Sessions')">
        <div x-data="{ expanded: false }">
            <div class="ml-4 my-2">
                <button @click="expanded = ! expanded" class="inline-flex items-center mx-5 px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    Toggle Prior Year's Events
                </button>
            </div>
            <div class="mx-2 grid grid-cols-12 gap-0 auto-cols-max-12">
                <div class="px-2 table-header col-span-1">Id</div>
                <div class="px-2 table-header col-span-1">Link</div>
                <div class="px-2 table-header col-span-1">Event</div>
                <div class="px-2 table-header col-span-2">Location</div>
                <div class="px-2 table-header col-span-1">Date Held</div>
                <div class="px-2 table-header col-span-2">Time Slot</div>
                <div class="px-2 table-header col-span-1">Start Time</div>
                <div class="px-2 table-header col-span-1">End Time</div>
                <div class="px-2 table-header col-span-1">Open?</div>
                <div class="px-2 table-header col-span-1"> - </div>
                @foreach(Session::where('date_held', '!=', $srdd_date)->orderBy('start_time')->get() as $session) {{-- iterate thru this year's sessions --}}
                    <div class="table-row col-span-1">{{ $session->id }}</div>
                    <div class="table-row col-span-1 py-2">
                        @if($session->url === null)
                            ---
                        @else
                        <a href="{{ $session->url }}"
                           class="px-2 py-1 rounded-md bg-sky-700 text-slate-50 uppercase text-xs"
                           id="SESS_{{ $session->id }}_URL"
                           target="_blank"><i class="bi bi-link-45deg"></i>&nbsp;Link</a>
                        <script type="module"> 
                            tippy('#SESS_{{ $session->id }}_URL', { 
                                content: "{{ $session->url }}",
                            }); 
                        </script>
                        @endif
                    </div>
                    <div class="table-row col-span-1"
                        @if($session->event->user_id > 0) 
                            data-tippy-content="{{ $session->event->instructor->name }}"
                        @endif
                    >
                        {{ $session->event->title }}</div>
                    <div class="table-row col-span-2">
                        {{ $session->venue->location}}
                    </div>
                    <div class="table-row col-span-1">
                        {{ $session->date_held}}
                    </div>
    
                    {{-- if the custom slot, show the custom times otherwise, show slot times --}}
                    <div class="table-row col-span-2">
                        {{$session->slot->title}}
                    </div>
                    <div class="table-row col-span-1">
                        {{ ( $session->slot->id == 1)?$session->start_time:$session->slot->start_time }}
                    </div>
                    <div class="table-row col-span-1">
                        {{ ( $session->slot->id == 1)?$session->end_time:$session->slot->end_time }}
                    </div>
    
                    <div class="table-row col-span-1 text-2xl">
                        @if ($session->is_closed == 0)
                        <i class="bi bi-calendar-check text-green-500"></i>
                        @else
                        <i class="bi bi-calendar-x text-red-500"></i>
                        @endif
                    </div>
                    <div class="table-row col-span-1">
                        &nbsp;
                    </div>
                @endforeach
            </div>
        </div>
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