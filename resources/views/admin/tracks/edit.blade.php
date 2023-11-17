<?php 
    /*
     *  Administrative access landing page
     */

     use function Laravel\Folio\{middleware};
 
     middleware(['auth', 'verified']);

 ?>
@extends('template.app')

@section('content')
<x-admin.nav-admin/>
<div class="container">
  <div class="mx-20 mt-4 pb-5 w-auto border border-indigo-900 rounded-md">
    <div class="ml-10 px-2 -translate-y-3 w-min bg-white font-bold">
      Editing&nbsp;Track&nbsp;#{{$track->id}}
    </div> 
    <form method="POST" action="{{ route('tracks.update', $track) }}">
      @csrf
      @method ('patch')
        <div class="mx-2 grid grid-cols-6 auto-col-max-6 gap-0">
          <div class="col-span-1 table-header text-right pr-4">
            <label for="track-title">Title</label>
          </div>
          <x-input-error :messages="$errors->get('title')" class="mt-2" />
          <div class="col-span-4 border border-indigo-800">
            <input class="text-slate-900 w-4/5 "
              type="input" name="track-title" 
              value="{{$track->title}}" 
              maxlength="50"
              width="50"/>
          </div>
          <div class="col-span-1 text-xs text-red-600 italic pl-2">
            40 chars maximum
          </div>
          <div class="table-header col-span-1 text-right pr-4">
            <label for="track-desc">Description</label>
          </div>
          <div class="col-span-4 border border-indigo-800">
            <input class="text-slate-900 w-4/5 "
              type="input" name="track-desc" 
              value="{{$track->description}}" 
              maxlength="50"
              width="50"/>
          </div>
          <div class="col-span-1 text-xs text-red-600 italic pl-2">
            80 chars maximum
          </div>
          <div class="table-header col-span-1 text-right pr-4">
            <label for="track-color">Background Color</label>
          </div>
          <div class="col-span-4 border border-indigo-800">
            <select id="track-color" name="track-color">
              @for ($i = 1; $i < 6; $i++)
                <option value="{{$i}}" 
                  @if ($track->color == $i) 
                    selected="selected"
                  @endif
                  >{{$i}}
                </option>
              @endfor
            </select>
            <span class="w-32 px-4 rounded-md bg-sky-400">1</span>
            <span class="w-32 px-4 rounded-md bg-emerald-400">2</span>
            <span class="w-32 px-4 rounded-md bg-amber-400">3</span>
            <span class="w-32 px-4 rounded-md bg-indigo-400">4</span>
            <span class="w-32 px-4 rounded-md bg-slate-400">5</span>
          </div>
          <div class="col-span-1 text-xs text-red-600 italic pl-2">
            &nbsp;
          </div>
          <form method="POST" action="{{ route('tracks.destroy', $track) }}">
            @csrf
            @method('delete')
            <x-danger-button class="col-span-1 mt-4 mx-2" >
                {{ __('ui.button.delete') }}
            </x-danger-button>
          </form>
          <div class="col-span-2">&nbsp;</div>
          <a class="inline-flex items-center mt-4 mx-2 px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
            href="{{ route('tracks.index') }}">           
            {{__('ui.button.cancel') }}
          </a>
          <x-primary-button class="col-span-1 mt-4 mx-2">
                {{ __('ui.button.update') }}
          </x-primary-button>
        </div>
    </form>
  </div>
</div>
@endsection

