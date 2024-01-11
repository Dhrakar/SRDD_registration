<?php 
    /*
     *  Administrative access landing page
     */
    use Illuminate\Support\Carbon;

    // reformat the SRDD date
    $_date = Carbon::parse(env('SRD_DAY', now()))->toFormattedDateString();

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
    <a href="{{ url('/test') }}">Widget Test Page</a>
    <a href="{{ url('/mailable') }}">Email Test Page</a>
</div>
@endsection
