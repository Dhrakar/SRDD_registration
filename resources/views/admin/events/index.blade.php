<?php 
    /*
     *  This is the admin landing page for Event models and it shows all of them in a table
 ``  */

    use App\Models\Track;
    use App\Models\User;
    use App\Models\Event;
    use App\Models\Session;
    use Illuminate\Support\Facades\DB;

    // build collections for the dropdown selectors
         $tracks = Track::all();
    $instructors = User::all();

    // did we get a deletion request? 
    if( isset($_GET['CONFIRM']) ) {
        $event = Event::find($_GET['CONFIRM']); 
        unset($_GET['CONFIRM']);
    }
 ?>

@extends('template.app')
@section('content')
<x-srdd.nav-admin/>
@isset($event) {{-- dialog for validating an event deletion --}}
<x-srdd.warning :title="__('Verify Deletion')">
    <b>Warning!</b> Are you sure that you want to delete Event # {{ $event->id }} "{{ $event->title }}"?
    <div class="pl-4 max-h-32">
        @if ($event->sessions->count() > 0) {{-- Any associated sessions? --}}
            This Event has been included in these {{ $event->sessions->count() }} Sessions:<br/>
            @foreach ($event->sessions->all() as $session )
                <span class="pl-4">
                    <i class="bi bi-dot"></i>
                    ID: {{ $session->id }} on {{ $session->date_held }} 
                    <br/>
                </span>
            @endforeach
            <br/>
            <i>If you confirm this deletion, those sessions will also be deleted.</i>
        @endif
    </div>
    <form method="post" action="{{ route('events.destroy', $event) }}" class="inline-block">
        @csrf 
        @method('delete')
        <div class="mt-6 mb-4 flex justify-end">
            <a class="px-4 py-2 
                    bg-white border border-gray-300 rounded-md 
                    font-semibold text-xs text-gray-700 uppercase tracking-widest 
                    shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 
                    disabled:opacity-25 transition ease-in-out duration-150"
                href="{{route('events.index')}}">
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
    <x-srdd.callout :title="__('Session Events')">
        The core of Staff Recognition and Development Day are the Events that are held.  Whether it is Breakfast or Airial Silks, Events are what are held in 
        the Sessions and then organized by Tracks and presented in Venues. Events can be used for multiple years (like the Longevity ceremony).
    </x-srdd.callout>

    {{-- Create a new Event --}}
    <x-srdd.title-box :title="__('Add a New Event')"  :state="0">
        <form method="POST" action="{{ route('events.store') }}">
            @csrf
            <x-input-error :messages="$errors->get('track_id')" class="mt-2" />
            <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
            <x-input-error :messages="$errors->get('year')" class="mt-2" />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
            <x-input-error :messages="$errors->get('needs_reg')" class="mt-2" />
            <div class="mx-1 grid grid-cols-6 auto-col-max-6 gap-0">
                {{-- pick a related Track --}}
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="track_id">Track</label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <select id="track_id" name="track_id"  class="ml-1 mr-8">
                        <option value="0" selected="selected">&dash;</option>
                        @foreach ($tracks as $track )
                            <option value="{{$track->id}}">{{$track->title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                    Select a Track for this event
                </div>
                {{-- Pick the Instructor --}}
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="user_id">Instructor</label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <select id="user_id" name="user_id"  class="ml-1 mr-8">
                        <option value="0" selected="selected">&dash;</option>
                        @foreach ($instructors as $instructor )
                            <option value="{{$instructor->id}}">{{$instructor->name}} | {{$instructor->email}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                    Select an Instructor for this event
                </div>
                {{-- Set the year this event was added --}}
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="year">Event Year </label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <input class="text-slate-900 w-4/5 "
                        type="input" name="year" 
                        value="{{ config('constants.srdd_year') }}" 
                        maxlength="4"
                        width="5"/>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                    Defaults to the current SRDD year and must br &gt;= that year
                </div>
                {{-- set the title --}}
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="title">Title of Event</label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <input class="text-slate-900 w-4/5 "
                        type="input" name="title" 
                        value="" 
                        maxlength="50"
                        width="50"/>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                     40 chars max length
                </div>
                {{-- set the description --}}
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="description">Description of Event</label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <input class="text-slate-900 w-4/5 "
                        type="input" name="description" 
                        value="" 
                        maxlength="150"
                        width="80"/>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                     150 chars max length
                </div>
                {{-- dropdown for needing registration --}}
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="needs_reg">Registration Required</label>
                </div>
                <div class="col-span-4 border border-indigo-800 flex">
                    <select class="ml-1 mr-8 text-sm" id="needs_reg" name="needs_reg">
                        <option value="0" selected="selected">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                     Setting this also automatically adds these sessions to new schedules.
                </div>
                <div class="col-span-1">&nbsp;</div>
                <x-primary-button class="col-span-1 mt-4 mx-2 justify-center">
                    {{ __('ui.button.new-event') }}
                </x-primary-button>
            </div>
        </form>
    </x-srdd.title-box>  

    {{-- List existing tracks --}}
  
    <x-srdd.title-box :title="__('Currently Configured Events')">
        <div class="mx-2 grid grid-cols-12 gap-0 auto-cols-max-12">
            <div class="px-2 table-header col-span-1">Id</div>
            <div class="px-2 table-header col-span-1">Track</div>
            <div class="px-2 table-header col-span-2">Instructor</div>
            <div class="px-2 table-header col-span-1">Year</div>
            <div class="px-2 table-header col-span-2">Title</div>
            <div class="px-2 table-header col-span-3">Description</div>
            <div class="px-2 table-header col-span-1">Need Reg?</div>
            <div class="px-2 table-header col-span-1">Edit/Delete</div>
            @foreach(Event::all()->sortBy('year') as $event)
                <div class="table-row col-span-1">{{ $event->id  }}</div>
                <div class="table-row col-span-1">{{ $event->track->title }}</div>
                <div class="table-row col-span-2">
                    @if($event->user_id > 0) 
                      {{ $event->instructor->name }}
                    @else
                       &dash;
                    @endif
                </div>
                <div class="table-row col-span-1">{{ $event->year }}</div>
                <div class="table-row col-span-2">{{ $event->title }}</div>
                <div class="table-row col-span-3">{{ $event->description }}</div>
                <div class="table-row col-span-1 text-2xl">
                    @if ($event->needs_reg == 1)
                    <i class="bi bi-check-circle text-green-500"></i>
                    @else
                    <i class="bi bi-circle text-red-500"></i>
                    @endif
                </div>
                <div class="table-row col-span-1">
                    @if ($event->year < config('constants.srdd_year') )  {{-- don't allow edits/deletion of historical events --}}
                        <i class="text-slate-400 bi bi-pencil-square mx-2"></i>
                        <i class="text-slate-400 bi bi-trash mx-2"></i>
                    @else
                        <div class="flex justify-center">
                            <a href="{{ route('events.edit', $event) }}">
                                <i class="bi bi-pencil-square mx-2"></i>
                            </a>
                            <form name="event_{{ $event->id  }}" method="get" action="{{ route('events.index') }}">
                                <input type="hidden" id="CONFIRM" name="CONFIRM" value="{{ $event->id  }}"/>
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
</div>
@endsection