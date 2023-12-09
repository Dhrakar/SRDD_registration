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
    $srdd_date = config('constants.db_srdd_date'); 
?>
@extends('template.app')

@section('content')
<div class="container">
    <x-srdd.nav-home />
    {{-- check for any sessions for this user --}}
    @if ($user->schedules->count() == 0) 
    <x-srdd.notice :title="__('Nothing Scheduled')">
        <span class="mb-8">
            {{ __('You do not have any sessions currently scheduled') }}
        </span>
        <br/><br/>
        <div lass="mt-6 mb-4 flex justify-end">
            <a  class="px-4 py-2 
                    bg-green-500 border border-green-300 rounded-md 
                    font-semibold text-xs text-slate-200 uppercase tracking-widest 
                    shadow-sm hover:bg-sky-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 
                    disabled:opacity-25 transition ease-in-out duration-150"
                href="{{ route('schedule.init') }}">Add Default Sessions</a>
            <a  class="px-4 py-2 
                    bg-sky-500 border border-sky-300 rounded-md 
                    font-semibold text-xs text-slate-200 uppercase tracking-widest 
                    shadow-sm hover:bg-sky-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 
                    disabled:opacity-25 transition ease-in-out duration-150"
                href="{{ route('calendar') }}">Goto Registration Page</a>
        </div>
        
    </x-srdd.notice>
    @else
    <x-srdd.notice :title="__('Event Calendar')">
        Here is a simplified version of your SRDD schedule that is suitable for printing or emailing.
    </x-srdd.notice>
    <div id="calendar" class="text-amber-900 mx-4 mb-8 mt-2 p-4 bg-amber-50 shadow-md"></div>
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