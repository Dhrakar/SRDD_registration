<?php 
    /*
     *  This is the admin landing page for Venue models and it shows all of them in a table
 ``  */

    use App\Models\Venue;
    use App\Models\Session;

    // did we get a deletion request? 
    if( isset($_GET['CONFIRM']) ) {
      $venue = Venue::find($_GET['CONFIRM']); 
      unset($_GET['CONFIRM']);
  }

 ?>

@extends('template.app')

@section('content')
<x-global.nav-admin/>
@isset($venue) {{-- dialog for validating an venue deletion --}}
<x-srdd.warning :title="__('Verify Deletion')">
    <b>Warning!</b> Are you sure that you want to delete Venue # {{ $venue->id }} "{{ $venue->location }}"?
    <div class="pl-4 max-h-32">
        @if ($venue->sessions->count() > 0) {{-- Any associated sessions? --}}
            This Venue is the location for {{ $venue->sessions->count() }} Sessions:<br/>
            @foreach ($venue->sessions->all() as $session )
                <span class="pl-4">
                    <i class="bi bi-dot"></i>
                    ID: {{ $session->id }} on {{ $session->date_held }} 
                    <br/>
                </span>
            @endforeach
            <br/>
            <i>If you confirm this deletion, those sessions will defaults to Venue #1.</i>
        @endif
    </div>
    <form method="post" action="{{ route('venues.destroy', $venue) }}" class="inline-block">
        @csrf 
        @method('delete')
        <div class="mt-6 mb-4 flex justify-end">
            <a class="px-4 py-2 
                    bg-white border border-gray-300 rounded-md 
                    font-semibold text-xs text-gray-700 uppercase tracking-widest 
                    shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 
                    disabled:opacity-25 transition ease-in-out duration-150"
                href="{{route('venues.index')}}">
                {{__('Cancel')}}
            </a>
            <x-danger-button class="ml-3">
                {{ __('Delete') }}
            </x-danger-button>
        </div>
    </form>  
</x-srdd.warning>
@endisset
<div class="container w-full">
    <x-srdd.callout :title="__('Session Venues')">
    Session Venues are the various locations that are used to present Sessions. Each venue has a total number
    of available seats for those locations that are size limited.  Note that a value of -1 for the max-seats 
    indicates that the seating is unlimited.
    </x-srdd.callout>

    {{-- Create a new Venue --}}
    <x-srdd.title-box :title="__('Add a New Venue')"  :state="0">
        <form method="POST" action="{{ route('venues.store') }}">
            @csrf
            <x-input-error :messages="$errors->get('location')" class="mt-2" />
            <x-input-error :messages="$errors->get('max_seats')" class="mt-2" />

            <div class="mx-2 grid grid-cols-6 auto-col-max-6 gap-0">
                <div class="col-span-1 table-header text-right pr-4">
                  <label for="title">Location</label>
                </div>
                <div class="col-span-3 border border-indigo-800">
                  <input class="text-slate-900 w-4/5 pl-1"
                    type="input" name="location" 
                    value="" 
                    maxlength="50"
                    width="50"/>
                </div>
                <div class="col-span-2 text-xs text-red-600 italic pl-2">
                  40 chars maximum
                </div>
                <div class="col-span-1 table-header text-right pr-4">
                  <label for="title">Total # of Seats</label>
                </div>
                <div class="col-span-3 border border-indigo-800">
                  <input class="text-slate-900 w-4/5 pl-1"
                    type="input" name="max_seats" 
                    value="-1" 
                    maxlength="50"
                    width="50"/>
                </div>
                <div class="col-span-2 text-xs text-red-600 italic pl-2">
                  -1 indicates unlimited
                </div>
                <div class="col-span-1">&nbsp;</div>
                <x-primary-button class="col-span-2 mt-4 mx-2">
                    {{ __('ui.button.new-slot') }}
                </x-primary-button>
            </div>
        </form>
    </x-srdd.title-box>

    {{-- List existing venues --}}
    <x-srdd.title-box :title="__('Currently Configured Locations')">
        <div class="mx-2 grid grid-cols-8 gap-0 auto-cols-max-12">
            <div class="px-2 table-header col-span-1">Id</div>
            <div class="px-2 table-header col-span-4">Location</div>
            <div class="px-2 table-header col-span-1">Max Seats</div>
            <div class="px-2 table-header col-span-2">Edit/Delete</div>
            @foreach(Venue::all() as $venue) {{-- iterate thru the defined venues --}}
                <div class="table-row col-span-1">{{ $venue->id }}</div>
                <div class="table-row col-span-4">{{ $venue->location }}</div>
                <div class="table-row col-span-1">
                  @if ($venue->max_seats < 0)
                    {{ __('Unlimited') }}
                  @else 
                  {{ $venue->max_seats}}
                  @endif
                </div>
                <div class="table-row col-span-2">
                @if($venue->id != 1 ) {{-- don't allow venue 1 to be edited or deleted --}}
                  <div class="flex justify-center">
                    <a href="{{ route('venues.edit', $venue) }}">
                        <i class="bi bi-pencil-square mx-2"></i>
                    </a>
                    <form name="event_{{ $venue->id  }}" method="get" action="{{ route('venues.index') }}">
                        <input type="hidden" id="CONFIRM" name="CONFIRM" value="{{ $venue->id  }}"/>
                        <button type="submit" >
                            <i class="text-red-500 bi bi-trash mx-2"></i>
                        </button>
                    </form>
                  </div>
                @else
                    <i class="text-slate-400 bi bi-pencil-square mx-2"></i>
                    <i class="text-slate-400 bi bi-trash mx-2"></i>
                @endif
                </div>
          @endforeach
        </div>
    </x-srdd.title-box>
</div>
@endsection
