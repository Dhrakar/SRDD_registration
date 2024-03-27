<?php 
    /*
     *  Main SRDD registration page
     */

     use App\Models\Track;
     use App\Models\Session;
     use App\Http\Controllers\CalendarController;

    // format the srdd date for use with teh DATE field
    $srdd_date = config('constants.db_srdd_date'); 
    
    // set the status var if the flash seesion is set
    $status = Str::of(session('status'));
 ?>
@extends('template.app')

@section('content')
<div class="container">
    <x-global.toolbar :icon="__('bi-calendar-range')">
        <li class="mx-6">
            <a  class="text-md text-slate-100 hover:text-teal-200"" 
                href="{{route('schedule')}}">
                <i class="bi bi-eyeglasses"></i>
                {{__('ui.menu.nav-home.review')}}
            </a>
        </li>
    </x-global.toolbar>
    <x-srdd.callout :title="__('Event Calendar')">
        <p class="w-3/4 ml-4 text-justify">
            This is the main calendar of events for this year's SRDD.  Each session will show the location and the number
        seats remaining (for venues that have limited seating).  Events with a '📋' require registration, while those 
        with a '🔓' are closed for registration and those with '🚫' have no more seating. Sessions that you are already 
        registered for will have a '✅'. Go to 
        <a href="{{route('schedule')}}">{{__('ui.menu.nav-home.review')}}</a> to see a calendar of your registered sessions.
        </p>
        <x-srdd.notice :title="__('Adding Sessions')">
            To add an unlocked session to your own calendar, just click on that session.  Hovering over sissions 
            will show the description of the event.  <b>Note</b>: <br/>
             - you will be asked for confirmaiton if you try to add a session that overlaps with one you already signed up for.<br/>
             - if there are no more seats available for a session, you will not be able to sign up for it<br/>
             - Sessions for <i>core</i> events can be automatically added to new schedules  
        </x-srdd.notice>
        <x-srdd.title-box :title="__('Event Track Colors')">
                {{-- not using track 0 for now --}}
                <!-- <span class="font-bold block w-1/2 mx-8 m-2 px-4 rounded-sm text-slate-200" style="background-color: {{ config('constants.colors.tracks_css.0') }}">Online Zoom Session</span> -->
            @foreach(Track::all() as $track) {{-- iterate thru the defined tracks --}}
                @php 
                    $bgc = config('constants.colors.tracks.' . $track->color);
                    echo "<span class=\"font-bold text-slate-900 block w-1/2 mx-8 m-2 px-4 rounded-sm $bgc\">$track->title</span>";
                @endphp
            @endforeach
        </x-srdd.title-box>
    </x-srdd.callout>
    {{-- Do we have a return status from the schedulecontroller? --}}
    @if ($status->startsWith('OK'))
        {{-- Yes, and the session add was successful --}}
        <x-srdd.success :title="__('')">
            <i>{{ $status->substr(Str::position($status, ':')+1) }}</i> has been added to your calendar.
        </x-srdd.success>
    @elseif ($status->startsWith('WARN'))
        {{-- yes, and it was a warning about overlapping sessions --}}
        <x-srdd.warning :title="__('Session overlap')">
            @php 
                session()->flash('status','CONFIRM'); // set thee flag for if adding anyway
                $_title = $status->substr(Str::position($status, ':')+1);
                $_id = $status->substr(Str::position($status, '|')+1, (Str::position($status, ':') - Str::position($status, '|'))-1);
                $_sess = Session::where('id', $_id)->first();
            @endphp
            The session you are adding: <i>"{{ $_sess->event->title }}"</i> overlaps in time with: <i>"{{ $_title }}"</i> .  <br/>
            Are sure you want to add this session?
            <div class="mt-2 mb-4 ml-4 flex gap-1">
                <a class="px-1 py-2 
                        bg-white border border-gray-300 rounded-md 
                          font-semibold text-xs text-gray-700 uppercase tracking-widest 
                          shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 
                          disabled:opacity-25 transition ease-in-out duration-150"
                   href="{{route('calendar')}}">
                    {{__('ui.button.cancel')}}
                </a>
                <a class="px-1 py-2 
                        bg-green-500 border border-green-300 rounded-md 
                          font-semibold text-xs text-std uppercase tracking-widest 
                          shadow-sm hover:green-50
                          disabled:opacity-25 transition ease-in-out duration-150"
                    href="{{ route('schedule.add', $_sess ) }}">
                    {{__('ui.button.ok')}}
                </a>
            </div>
        </x-srdd.warning>
    @elseif ($status->startsWith('ERR'))
        {{-- yes, and it was an error of some sort --}}
        <x-srdd.error :title="__('Session not added')">
            <span class="italic">
                {{ session('status') }}
            </span>
        </x-srdd.error>
    @endif    
    <div id="calendar" class="text-std mx-4 mb-8 mt-2 p-4"></div>
</div>
{{-- Add all the current sessions --}}

<script> 
    window.onload = function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new Calendar(calendarEl, {
            contentHeight: 950,
            expandRows: true,
            customButtons: {
                srddButton: {
                    text: 'Return to SRDD',
                    click: function() {
                        calendar.gotoDate('{{ $srdd_date }}');
                    }
                }
            },
            plugins: [timeGridPlugin],
            headerToolbar: {
                left: 'title',
                center: '',
                right:  'prev srddButton next',
            },
            initialView: 'timeGridDay',
            initialDate: '{{ $srdd_date }}',
            slotMinTime: '08:00:00',
            slotMaxTime: '18:00:00',
            {!! $events !!}
            eventDidMount: function(info) {
                //console.log(info.event.extendedProps.description);
                var tooltip = tippy(info.el, {
                    content: info.event.extendedProps.description,
                    placement: "top-start",
                    aria: "describedby",
                    allowHTML: true,
                });
            },
        });
        calendar.render();
    }
</script>
@endsection