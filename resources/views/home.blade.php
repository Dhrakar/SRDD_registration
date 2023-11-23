<?php
    /*
     *  This is the main landing page for the registration applicaiton
     */


?>
@extends('template.app')

@section('content')
    <div class="container">
        <x-global.nav-header />
        <x-srdd.callout :title="__('Welcome to the Staff Recognition and Development Day registration tool!')" >
            {!! Str::markdown(__('ui.markdown.welcome')); !!}
        </x-srdd.callout>
        
        {{-- Add in the Login form if needed --}}
        @guest 
        <x-srdd.login/>
        @endguest
        
        
    </div>

@endsection