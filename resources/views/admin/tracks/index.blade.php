<?php 
    /*
     *  This is the admin landing page for Track models and it shows all of them in a table
 ``  */

    use App\Models\Track;

 ?>

@extends('template.app')

@section('content')
<x-admin.nav-admin/>
<div class="container w-full">
  <x-srdd.callout>
    {!! Str::markdown(__('ui.markdown.intro-tracks')); !!}
  </x-srdd.callout>

  {{-- Create a new Track --}}
  <div class="mx-10 mt-4 pb-5 w-auto border border-indigo-900 rounded-md">
        <div class="ml-10 px-2 -translate-y-3 w-min bg-white font-bold">
        Create&nbsp;New&nbsp;Track
        </div>
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
              <select id="color" name="color">
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
            <x-primary-button class="col-span-2 mt-4 mx-2">
                {{ __('ui.button.new-track') }}
            </x-primary-button>
        </div>
        </form>
      </div>

  {{-- List existing tracks --}}
  <div class="mx-10 mt-4 pb-5 w-auto border border-indigo-900 rounded-md">
      <div class="ml-10 px-2 -translate-y-3 w-min bg-white font-bold">
      Currently&nbsp;Configured&nbsp;Tracks
      </div> 
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
              <div class="table-row col-span-2 inline:block">
                  @if($track->id != 1 ) {{-- don't allow track 1 to be edited or deleted --}}
                  <a href="{{ route('tracks.edit', $track) }}">
                      <i class="bi bi-pencil-square mx-2"></i>
                  </a>
                  <button {{-- Confirms delete using modal below --}}
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion')"
                  ><i class="text-red-500 bi bi-trash mx-2"></i></button>
                  @else
                      <i class="text-slate-400 bi bi-pencil-square mx-2"></i>
                      <i class="text-slate-400 bi bi-trash mx-2"></i>
                  @endif
              </div>
          @endforeach
      </div>
      <x-modal name="confirm-deletion" focusable>
        <form method="post" action="{{ route('tracks.destroy', $track) }}" class="p-6">
          @csrf
          @method('delete')
          <p class="text-lg font-medium text-gray-900">
              {{ __('Are you sure you want to delete this track?') }}
          </p>
          <div class="mt-6 flex justify-end">
              <x-secondary-button x-on:click="$dispatch('close')">
                  {{ __('Cancel') }}
              </x-secondary-button>
              <x-danger-button class="ml-3">
                  {{ __('Confirm Delete') }}
              </x-danger-button>
          </div>
        </form>
      </x-modal>
  </div>
    
</div>
@endsection