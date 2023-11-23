<?php
    /*
     *  This is the main landing page for the registration applicaiton
     */


?>
@extends('template.app')

@section('content')
    <div class="container">
        <x-srdd.callout :title="__('Welcome to the Staff Recognition and Development Day registration tool!')" >
            {!! Str::markdown(__('ui.markdown.welcome')); !!}
        </x-srdd.callout>
        {{-- Add in the Login and Registration forms --}}
        <x-srdd.login/>
        <x-srdd.registration/>
        
        @if (Route::has('login'))
                <div class="">
                    @auth
                    @else
                        
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
    </div>

@endsection