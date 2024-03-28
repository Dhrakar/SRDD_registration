<?php 
    /*
     *  Administrative access landing page
     */
    use Illuminate\Support\Carbon;

    // reformat the SRDD date
    $_date = config('constants.fmt_srdd_date');

     $min = App\Models\Venue::all()->keys();

 ?>
@extends('template.app')

@section('content')
<x-srdd.nav-admin/>
<div class="container">
    <x-srdd.callout :title="__('Admin and Configuration')">
        <p>
        These pages are where you can update, add or delete the various components of Staff Recognition Day.<br/><br/>
        <b>Note:</b> you will not be able to edit or delete any Track, Venue, Slot or User with ID #1 as those are 
        used as the default settings.
        </p>
    </x-srdd.calloutx>
    <x-srdd.title-box :title="__('Current Application Settings')">
        <div class="p-4 text-std">
        Event Date: {{ $_date }}
        </div>
    </x-srdd.title-box>
    @if(env('APP_DEBUG', false) === true)
        <div class="flex border-2 border-sky-600">
            <a href="{{ url('/test') }}">Widget Test Page</a>
            <a href="{{ url('/mailable') }}">Email Test Page</a>
        </div>
    @endif
</div>
@endsection
