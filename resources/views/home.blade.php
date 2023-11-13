<?php
    /*
     *  This is the main landing page for the registration applicaiton
     */


?>
@extends('template.app')

@section('content')

    <div class="container">
        <h1> Welcome to the Staff Recognition and Development Day registration tool</h1>
        <div class="callout">
            <span class="text-justify"> 
                {!! Str::markdown(__('ui.markdown.welcome')); !!}
            </span>
        </div>
        @if (Route::has('login'))
                <div class="">
                    @auth
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
    </div>

@endsection