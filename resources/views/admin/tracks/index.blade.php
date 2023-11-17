<?php 
    /*
     *  This is the admin landing page for Track models and it shows all of them in a table
 ``  */

    use App\Models\Track;
    use function Laravel\Folio\{middleware};
 
    middleware(['auth', 'verified']);

 ?>

@extends('template.app')

@section('content')
<x-admin.nav-admin/>
<div class="container">
    <div class="mx-10 mt-4 pb-5 w-auto border border-indigo-900 rounded-md">
        <div class="ml-10 px-2 -translate-y-3 w-min bg-white font-bold">
        Currently&nbsp;Configured&nbsp;Tracks
        </div> 
        <div class="mx-2 grid grid-cols-12 gap-0 auto-cols-max-12">
            <div class="table-header col-span-1">Id</div>
            <div class="table-header col-span-3">Title</div>
            <div class="table-header col-span-5">Description</div>
            <div class="table-header col-span-2">Color</div>
            <div class="table-header col-span-1">Edit</div>
            @foreach(Track::all() as $track) {{-- iterate thru the defined tracks --}}
                <div class="table-row col-span-1">{{ $track->id }}</div>
                <div class="table-row col-span-3">{{ $track->title }}</div>
                <div class="table-row col-span-5">{{ $track->description}}</div>
                <div class="table-row col-span-2">
                <span class="w-32 px-8 rounded-md 
                    @switch($track->color)
                        @case (1) bg-sky-400 @break;
                        @case (2) bg-emerald-400 @break;
                        @case (3) bg-amber-400 @break;
                        @case (4) bg-indigo-400 @break;
                        @default: bg-slate-400
                    @endswitch">
                    &nbsp;
                </span>
                </div>
                <div class="table-row col-span-1">
                    @if($track->id != 1 ) {{-- don't allow track 1 to be edited/deleted  --}}
                    <a href="{{ route('tracks.edit', $track) }}">
                        <i class="bi bi-pencil-square mx-2"></i>
                        <i class="bi bi-trash"></i>
                    </a>
                    @else
                        <i class="text-slate-400 bi bi-pencil-square mx-2"></i>
                        <i class="text-slate-400 bi bi-trash"></i>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <div class="mx-auto my-4 w-4/5 h-1 bg-slate-400"></div>
    <div class="mx-10 mt-4 pb-5 w-auto border border-indigo-900 rounded-md">
        <div class="ml-10 px-2 -translate-y-3 w-min bg-white font-bold">
        Create&nbsp;New&nbsp;Track
        </div>
        <form method="POST" action="{{ route('tracks.store', $track) }}">
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
              <select name="color">
                <option value="1" selected="selected">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>
              <span class="w-32 px-4 rounded-md bg-sky-400">1</span>
              <span class="w-32 px-4 rounded-md bg-emerald-400">2</span>
              <span class="w-32 px-4 rounded-md bg-amber-400">3</span>
              <span class="w-32 px-4 rounded-md bg-indigo-400">4</span>
            </div>
            <div class="col-span-1 text-xs text-red-600 italic pl-2">
              &nbsp;
            </div>
            <div class="col-span-1">&nbsp;</div>
            <x-primary-button class="col-span-2 mt-4 mx-2">
                {{ __('ui.button.new-track') }}
            </x-primary-button>
        </div>
        </form>
    </div>
</div>
@endsection