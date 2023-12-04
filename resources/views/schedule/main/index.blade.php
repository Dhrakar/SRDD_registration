<?php 
    /*
     *  Main SRDD registration page
     */

     use Illuminate\Support\Js;
     use App\Http\Controllers\CalendarController;

    // format the srdd date for use with teh DATE field
    $srdd_date = date("Y-m-d", strtotime(config('constants.srdd_date'))); 
 ?>
@extends('template.app')

@section('content')
<div class="container">
    <x-global.toolbar >
        <li class="mx-6">
            <a  class="text-md text-slate-100 hover:text-teal-200"" 
                href="{{route('schedule')}}">
                <i class="bi bi-eyeglasses"></i>
                {{__('Review')}}
            </a>
        </li>
    </x-global.toolbar>
    <x-srdd.callout :title="__('Event Calendar')">
        This is the main calendar of events for this year's SRDD.  Events that are outlined in green are automatically
        added when you sign up for the day.
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