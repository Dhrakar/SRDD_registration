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
        This is the main calendar of events for this year's SRDD.  Each session will show the location and the number
        seats remaining (for venues that have limited seating).  Events with a 📋 require registration, while those 
        with a 🔓 are closed for registration.  Sessions for <i>core</i> events will be automatically added to new
        schedules.  Go to <i>My Schedule</i> to see a calendar of your registered sessions.
        <div class="ml-4 mt-2 ">
            <x-srdd.title-box :title="__('Track Colors')">
                @foreach(Track::all() as $track) {{-- iterate thru the defined tracks --}}
                    @php 
                        $bgc = config('constants.colors.tracks.' . $track->color);
                        echo "<span class=\"font-bold text-slate-900 block w-1/2 mx-8 m-2 px-4 rounded-sm $bgc\">$track->title</span>";
                    @endphp
                @endforeach
            </x-srdd.title-box>
        </div>
    </x-srdd.callout>
    <div id="calendar" class="text-std mx-4 mb-8 mt-2 p-4"></div>
</div>
{{-- Add all the current sessions --}}
<script> 
    window.onload = function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new Calendar(calendarEl, {
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
        });
        calendar.render();
    }
</script>
@endsection