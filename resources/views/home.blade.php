<?php
    /*
     *  This is the main landing page for the registration applicaiton
     */


?>
@extends('template.app')

@section('content')
    <div class="container">
        <x-global.nav-header>
            <li class="mx-6">
                <a  class="text-md text-slate-100 hover:text-teal-200" href="#">
                    <i class="bi bi-eyeglasses"></i>
                    {{__('Review')}}
                </a>
            </li>
            <li class="mx-6">
                <a  class="text-md text-slate-100 hover:text-teal-200" href="#">
                    <i class="bi bi-printer"></i>
                    {{__('Print')}}
                </a>
            </li>
            <li class="mx-6">
                <a  class="text-md text-slate-100 hover:text-teal-200" href="#">
                    <i class="bi bi-envelope-at"></i>
                    {{__('Email')}}
                </a>
            </li>
        </x-global.nav-header>
        <x-srdd.callout :title="__('Welcome to the Staff Recognition and Development Day registration tool!')" >
            <p>
                This registration tool will allow you to register for sessions presented by your fellow UAF 
                employees covering many diverse topics.  The main sessions will be presented on the 
                <a class="dark:text-amber-400 underline" href="https://media.uaf.edu/home" target="_blank">UAF Media Stream</a> server, while the 
                remaining fun/development sessions may be presented via individual Zoom Conference. Please 
                be sure to sign up for the sessions you are interested in so that we can send you any Zoom 
                informaiton for these sessions.  Registration will also help us plan for future Staff 
                Recognition days.
            </p>
        </x-srdd.callout>
        
        {{-- Add in the Login form or logged in user info --}}
        <x-global.title-box :title="__('Login')">
            @guest 
                <x-srdd.login/>
            @endguest
            @auth
                <div class="ml-8 mr-3 mt-2 mb-10 px-2 py-4 rounded-sm border-l-8 border-green-700 dark:border-green-100 bg-green-200 dark:bg-green-700 shadow-md text-sm text-green-700 dark:text-green-50">
                    <i class="bi bi-info-circle"></i><span class="pl-4 font-semibold">Logged In</span>
                    <x-global.divider/>
                    Welcome back <span class="font-bold text-greem-700">{{ Auth::user()->name }}</span>! You last 
                    logged in on {{ Auth::user()->last_login }}.
                </div>
            @endauth
        </x-global.title-box>
        
    </div>

@endsection