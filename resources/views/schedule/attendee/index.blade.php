<?php
    /**
     * User calendar
     * 
     * @param $my_events Collection all of the scheduled sessions for this user if any
     */
 
    use App\Models\Schedule;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\SchedulerController; 

    // current user
    $user = Auth::user();

    // format the srdd date for use with the DATE field
    $srdd_date = config('constants.db_srdd_date'); 

    // Get the schedule for this person
    $_sched = new SchedulerController();
    $event_collection = $_sched->get_schedule($user);

    // did we get a deletion request? Did the last one get deleted? 
    if( isset($_GET['CONFIRM']) && Schedule::all()->count() > 0) {
        $schedule = Schedule::find($_GET['CONFIRM']); 
        unset($_GET['CONFIRM']);
    }
?>
@extends('template.app')

@section('content')
<div class="container">
@isset($schedule) {{-- dialog for validating a deletion --}}
<x-srdd.warning :title="__('Verify Deletion')">
    <b>Warning!</b> Are you sure that you want to delete this session for {{ $schedule->session->event->title }}?
    <div class="pl-4 max-h-32">
    <form method="post" action="{{ route('schedule.destroy', $schedule) }}" class="inline-block">
        @csrf 
        @method('delete')
        <div class="mt-6 mb-4 flex justify-end">
            <a class="px-4 py-2 
                    bg-white border border-gray-300 rounded-md 
                    font-semibold text-xs text-gray-700 uppercase tracking-widest 
                    shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 
                    disabled:opacity-25 transition ease-in-out duration-150"
                href="{{route('schedule')}}">
                {{__('ui.button.cancel')}}
            </a>
            <x-danger-button class="ml-3">
                {{ __('ui.button.delete') }}
            </x-danger-button>
        </div>
    </form>  
    </div>
</x-srdd.warning>
@endisset
    <x-srdd.nav-home />
    {{-- check for any sessions for this user --}}
    @if ($user->schedules->count() < 1) 
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
                href="{{ route('schedule.init', $user) }}">Add Default Sessions</a>
            <a  class="px-4 py-2 
                    bg-sky-500 border border-sky-300 rounded-md 
                    font-semibold text-xs text-slate-200 uppercase tracking-widest 
                    shadow-sm hover:bg-sky-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 
                    disabled:opacity-25 transition ease-in-out duration-150"
                href="{{ route('calendar') }}">Goto Registration Page</a>
        </div>
        
    </x-srdd.notice>
    @else
    <x-srdd.callout :title="__('My Event Calendar')">
        This is the overall schedule of the sessions that you have signed up for.
    </x-srdd.callout>
    <x-srdd.title-box :title="__('SRDD Schedule')">
        <div class="mx-2 grid grid-cols-11 gap-0 auto-cols-max-11">
            <div class="px-2 table-header col-span-1">Start Time</div>
            <div class="px-2 table-header col-span-1">End Time</div>
            <div class="px-2 table-header col-span-1">Location</div>
            <div class="px-2 table-header col-span-1">Instructor</div>
            <div class="px-2 table-header col-span-2">Event</div>
            <div class="px-2 table-header col-span-4">Description</div>
            <div class="px-2 table-header col-span-1">Remove</div>
            @foreach($event_collection->sortBy('start_time') as $event)
                <div class="{{ ($event['id'] == 0)?'hidden':'table-row' }} col-span-1">
                    {{ $event['start_time'] }}
                </div>
                <div class="{{ ($event['id'] == 0)?'hidden':'table-row' }} col-span-1">
                    {{ $event['end_time'] }}
                </div>
                <div class="{{ ($event['id'] == 0)?'hidden':'table-row' }} col-span-1">
                    {{ $event['location'] }}
                </div>
                <div class="{{ ($event['id'] == 0)?'hidden':'table-row' }} col-span-1">
                    {{ $event['instructor'] }}
                </div>
                <div class="{{ ($event['id'] == 0)?'hidden':'table-row' }} col-span-2">
                    <div class="m-2 {{ config('constants.colors.tracks.' . $event['color']) }} rounded-md">
                        {{ $event['title'] }}
                    </div>
                </div>
                <div class="{{ ($event['id'] == 0)?'hidden':'table-row' }} col-span-4">
                    {{ $event['description'] }}
                </div>
                <div class="{{ ($event['id'] == 0)?'hidden':'table-row' }} col-span-1">
                    <form name="schedule_{{ $event['id']  }}" method="get" action="{{ route('schedule') }}">
                        <input type="hidden" id="CONFIRM" name="CONFIRM" value="{{ $event['id']  }}"/>
                        <button type="submit" >
                            <i class="text-red-500 bi bi-trash mx-2"></i>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </x-srdd.title-box>
    @endif
</div>
@endsection