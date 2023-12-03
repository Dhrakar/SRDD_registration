<?php 
    /*
     *  This is the admin landing page for Track models and it shows all of them in a table
 ``  */

    use App\Models\Track;
    use App\Models\Event;

    // did we get a deletion request? 
    if( isset($_GET['CONFIRM']) ) {
      $track = Track::find($_GET['CONFIRM']); 
      unset($_GET['CONFIRM']);
  }
 ?>

@extends('template.app')

@section('content')
<x-srdd.nav-admin/>
<div class="container w-full">
@isset($track) {{-- dialog for validating an track deletion --}}
<x-srdd.warning :title="__('Verify Deletion')">
    <b>Warning!</b> Are you sure that you want to delete Track # {{ $track->id }} "{{ $track->title }}"?
    <div class="pl-4 max-h-32">
        @if ($track->events->count() > 0) {{-- Any associated events? --}}
            This Track has been included in these {{ $track->events->count() }} Events:<br/>
            @foreach ($track->events->all() as $event )
                <span class="pl-4">
                    <i class="bi bi-dot"></i>
                    ID: {{ $event->id }} on {{ $event->title }} 
                    <br/>
                </span>
            @endforeach
            <br/>
            <i>If you confirm this deletion, those events will be updated to use the default Track 1.</i>
        @endif
    </div>
    <form method="post" action="{{ route('tracks.destroy', $track) }}" class="inline-block">
        @csrf 
        @method('delete')
        <div class="mt-6 mb-4 flex justify-end">
            <a class="px-4 py-2 
                    bg-white border border-gray-300 rounded-md 
                    font-semibold text-xs text-gray-700 uppercase tracking-widest 
                    shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 
                    disabled:opacity-25 transition ease-in-out duration-150"
                href="{{route('tracks.index')}}">
                {{__('ui.button.cancel')}}
            </a>
            <x-danger-button class="ml-3">
                {{ __('ui.button.delete') }}
            </x-danger-button>
        </div>
    </form>  
</x-srdd.warning>
@endisset
  <x-srdd.callout :title="__('Session Tracks')">
  Tracks are used to help organize Sessions into theme categories.  These categories can help attendees look for
the types of event sessions that they are interested in.  Events that belong to the
<b class="bg-sky-400 rounded-md px-1">Core Events</b> track are also automatically added to the schedules of each attendee.  
This way, events like the Longevity Awards are always included.
  </x-srdd.callout>
  {{-- Create a new Track --}}
  <x-srdd.title-box :title="__('Add a New Track')"  :state="0">
    <form method="POST" action="{{ route('tracks.store') }}">
      @csrf
      <x-input-error :messages="$errors->get('title')" class="mt-2" />
      <x-input-error :messages="$errors->get('description')" class="mt-2" />
      <x-input-error :messages="$errors->get('color')" class="mt-2" />
      <div class="mx-2 grid grid-cols-6 auto-col-max-6 gap-0">
          <div class="col-span-1 table-header text-right pr-4">
            <label for="title">Title</label>
          </div>
          <div class="col-span-4 border border-indigo-800">
            <input class="text-slate-900 w-4/5 "
              type="input" name="title" 
              value="" 
              maxlength="50"
              width="50"/>
          </div>
          <div class="col-span-1 text-xs text-red-600 italic pl-2">
            40 chars maximum
          </div>
          <div class="table-header col-span-1 text-right pr-4">
            <label for="description">Description</label>
          </div>
          <div class="col-span-4 border border-indigo-800">
            <input class="text-slate-900 w-4/5 "
              type="input" name="description" 
              value="" 
              maxlength="50"
              width="50"/>
          </div>
          <div class="col-span-1 text-xs text-red-600 italic pl-2">
            80 chars maximum
          </div>
          <div class="table-header col-span-1 text-right pr-4">
            <label for="color">Background Color</label>
          </div>
          <div class="col-span-4 border border-indigo-800">
            <select id="color" name="color" class="ml-1 mr-8">
              <option value="1" selected="selected">1</option>
            @for ($i = 2; $i < count(config('constants.colors.tracks')); $i++)
              <option value="{{$i}}">{{$i}}</option>
            @endfor
          </select>
          @php
            // build the color swatches using the config colors
            for ( $i = 1; $i < count(config('constants.colors.tracks')); $i++ ) {
              $color = config('constants.colors.tracks.' . $i);
              echo "<span class=\"w-32 px-4 rounded-md $color\">$i</span>";
            }
          @endphp
          </div>
          <div class="col-span-1 text-xs text-red-600 italic pl-2">
            Background color for tracks
          </div>
          <div class="col-span-1">&nbsp;</div>
          <x-primary-button class="col-span-1 mt-4 mx-2 justify-center">
              {{ __('ui.button.new-track') }}
          </x-primary-button>
        </div>
    </form>
  </x-srdd.title-box>

  {{-- List existing tracks --}}
  
  <x-srdd.title-box :title="__('Currently Configured Tracks')">
      <div class="mx-2 grid grid-cols-12 gap-0 auto-cols-max-12">
          <div class="px-2 table-header col-span-1">Id</div>
          <div class="px-2 table-header col-span-3">Title</div>
          <div class="px-2 table-header col-span-4">Description</div>
          <div class="px-2 table-header col-span-2">Color</div>
          <div class="px-2 table-header col-span-2">Edit/Delete</div>
          @foreach(Track::all() as $track) {{-- iterate thru the defined tracks --}}
              <div class="table-row col-span-1">{{ $track->id }}</div>
              <div class="table-row col-span-3">{{ $track->title }}</div>
              <div class="table-row col-span-4">{{ $track->description}}</div>
              <div class="table-row col-span-2">
                  @php 
                      $bgc = config('constants.colors.tracks.' . $track->color);
                      $cn = substr($bgc, 3, strlen($bgc) - 7);
                      echo "<span class=\"block w-4/5 m-2 px-4 rounded-md $bgc\">$cn</span>";
                  @endphp
              </div>
              <div class="table-row col-span-2">
                  @if($track->id != 1 ) {{-- don't allow track 1 to be edited or deleted --}}
                    <a href="{{ route('tracks.edit', $track) }}">
                        <i class="bi bi-pencil-square mx-2"></i>
                    </a>
                    <form name="track_{{ $track->id  }}" method="get" action="{{ route('tracks.index') }}">
                        <input type="hidden" id="CONFIRM" name="CONFIRM" value="{{ $track->id  }}"/>
                        <button type="submit" >
                            <i class="text-red-500 bi bi-trash mx-2"></i>
                        </button>
                    </form>
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