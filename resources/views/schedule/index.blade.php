<?php 
    /*
     *  Main SRDD registration page
     */

     use Illuminate\Support\Js;

    // format the srdd date for use with teh DATE field
    $srdd_date = date("Y-m-d", strtotime(config('constants.srdd_date'))); 

    $str = "Chancellor&#039;s Presentation"; 
    //dd(htmlspecialchars_decode($str, ENT_QUOTES));
 ?>
@extends('template.app')

@section('content')
<div class="container">
    <x-global.toolbar />
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
                allEventsButton: {
                    text: 'All Events',
                    click: function() {
                    }
                },
                myEventsButton: {
                    text: 'My Events',
                    click: function() {
                    }
                }
            },
            plugins: [timeGridPlugin],
            headerToolbar: {
                left: 'allEventsButton myEventsButton',
                center: 'title',
                right:  '',
            },
            initialView: 'timeGridDay',
            initialDate: '{{ $srdd_date }}',
            slotMinTime: '8:00:00',
            slotMaxTime: '18:00:00',
            {!! $events !!}
        });
        calendar.render();
    }
</script>
@endsection