<?php 
    /*
     *  Administrative access landing page
     */

     $min = App\Models\Venue::all()->keys();

 ?>
@extends('template.app')

@section('content')
<x-global.nav-admin/>
<div class="container">
    <x-srdd.callout :title="__('Admin and Configuration')">
        These pages are where you can update, add or delete the various components of Staff Recognition Day.
        Note that you will not be able to edit or delete any Track, Venue or Slot or User with ID #1
    </x-srdd.calloutx>
    <x-srdd.title-box :title="__('Current Application Settings')">
        <div class="p-4 text-std">
        Event Date: {{config('constants.srdd_date')}}
        </div>
    </x-srdd.title-box>
</div>
@endsection
