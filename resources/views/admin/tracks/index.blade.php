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
<div>
    <h1>Currently Configured Tracks...</h1>
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
@endsection