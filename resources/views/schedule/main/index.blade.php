<?php 
    /*
     *  Main SRDD registration page
     */

     use App\Models\Track;
     use App\Http\Controllers\CalendarController;

    // format the srdd date for use with teh DATE field
    $srdd_date = config('constants.db_srdd_date'); 
 ?>
@extends('template.app')

@section('content')
<div class="container">
    <x-global.toolbar >
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
        with a '🔓' are closed for registration and those with '🚫' have no more seating. Go to 
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
            @foreach(Track::all() as $track) {{-- iterate thru the defined tracks --}}
                @php 
                    $bgc = config('constants.colors.tracks.' . $track->color);
                    echo "<span class=\"font-bold text-slate-900 block w-1/2 mx-8 m-2 px-4 rounded-sm $bgc\">$track->title</span>";
                @endphp
            @endforeach
        </x-srdd.title-box>
    </x-srdd.callout>
    <div id="calendar" class="text-std mx-4 mb-8 mt-2 p-4"></div>
</div>
{{-- Add all the current sessions --}}

<script> 
    window.onload = function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new Calendar(calendarEl, {
            contentHeight: 700,
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
            slotMinTime: '6:00:00',
            slotMaxTime: '21:00:00',
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