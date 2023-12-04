<?php
    /**
     * User calendar
     * 
     * @param $session 
     */
 
    use App\Models\Schedule;
    use App\Models\User;

    // current user
    $user = Auth::user();
    // format the srdd date for use with teh DATE field
    $srdd_date = date("Y-m-d", strtotime(config('constants.srdd_date'))); 
?>
@extends('template.app')

@section('content')
<div class="container">
    <x-srdd.nav-home />
    {{-- check for any sessions for this user --}}
    @if ($user->schedules->count() == 0) 
    <x-srdd.notice :title="__('Nothing Scheduled')">
        You do not have any sessions currently scheduled.  Go to the <a href="{{ route('calendar') }}">Registration Page</a>
        to sign up for sessions.
    </x-srdd.notice>
    @else
    <x-srdd.callout :title="__('Event Calendar')">
        This is your schedule of the sessions that you have signed up for.
    </x-srdd.callout>
    <div id="calendar" class="text-amber-900 mx-4 mb-8 mt-2 p-4 bg-amber-100"></div>
    @endif
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
            plugins: [listPlugin],
            headerToolbar: {
                left: 'title',
                center: '',
                right:  '',
            },
            initialView: 'listDay',
            initialDate: '{{ $srdd_date }}',
            slotMinTime: '6:00:00',
            slotMaxTime: '21:00:00',
            {!! $events !!}
        });
        calendar.render();
    }
</script>
@endsection