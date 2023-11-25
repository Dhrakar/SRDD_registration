<?php
  /**
   *  This is used to edit Events
   */

   use App\Models\Track;
    use App\Models\User;
    use App\Models\Event;
    use App\Models\Session;
    use Illuminate\Support\Facades\DB;

         $tracks = Track::all();
    $instructors = User::all();
?>
@extends('template.app')

@section('content')
<x-global.nav-admin/>
<div class="container">
    <x-srdd.title-box :title="__('Editing Event #' . $event->id)">
        <form method="POST" action="{{ route('events.update', $event) }}">
            @csrf
            @method ('patch')

            <div class="mx-1 grid grid-cols-6 auto-col-max-6 gap-0">
                {{-- pick a related Track --}}
                <x-input-error :messages="$errors->get('track_id')" class="mt-2" />
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="track_id">Track</label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <select id="track_id" name="track_id"  class="ml-1 mr-8">
                        @foreach ($tracks as $track )
                            <option value="{{$track->id}}" 
                                @if ($event->track_id == $track->id) 
                                    selected="selected"
                                @endif
                            >{{$track->title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                    Select a Track for this event
                </div>
                {{-- Pick the Instructor --}}
                <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="user_id">Instructor</label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <select id="user_id" name="user_id"  class="ml-1 mr-8">
                        <option value="0" selected="selected">&dash;</option>
                        @foreach ($instructors as $instructor )
                            <option value="{{$instructor->id}}"
                                @if ($event->user_id == $instructor->id) 
                                    selected="selected"
                                @endif
                            >{{$instructor->name}} | {{$instructor->email}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                    Select an Instructor for this event
                </div>
                {{-- Set the year this event was added --}}
                <x-input-error :messages="$errors->get('year')" class="mt-2" />
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="year">Event Year </label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <input class="text-slate-900 w-4/5 "
                        type="input" name="year" 
                        value="{{ $event->year }}" 
                        maxlength="4"
                        width="5"/>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                    Defaults to the current SRDD year
                </div>
                {{-- set the title --}}
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="title">Title of Event</label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <input class="text-slate-900 w-4/5 "
                        type="input" name="title" 
                        value="{{ $event->title }}" 
                        maxlength="50"
                        width="50"/>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                     40 chars max length
                </div>
                {{-- set the description --}}
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="description">Description of Event</label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <input class="text-slate-900 w-4/5 "
                        type="input" name="description" 
                        value="{{ $event->description }}" 
                        maxlength="80"
                        width="80"/>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                     80 chars max length
                </div>
                {{-- dropdown for needing registration --}}
                <x-input-error :messages="$errors->get('needs_reg')" class="mt-2" />
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="needs_reg">Registration Required</label>
                </div>
                <div class="col-span-4 border border-indigo-800 flex">
                    <select class="ml-1 mr-8 text-sm" id="needs_reg" name="needs_reg">
                        @if($event->needs_reg == 0)
                            <option value="0" selected="selected">No</option>
                            <option value="1">Yes</option>
                        @else
                            <option value="0" >No</option>
                            <option value="1" selected="selected">Yes</option>
                        @endif
                    </select>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                     Setting this also automatically adds these sessions to new schedules.
                </div>
                <div class="col-span-1">&nbsp;</div>
                <x-primary-button class="col-span-1 mt-4 mx-2">
                    {{ __('ui.button.update') }}
                </x-primary-button>
            </div>
        </form>
    </x-srdd.title-box>
</div>
@endsection