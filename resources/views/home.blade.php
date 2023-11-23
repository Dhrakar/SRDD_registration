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
                <div class="bg-emerald-200 dark:bg-emerald-800 border border-emerald-900 dark:border-emerald-100 rounded-md p-4 mx-4 text-std">
                    <i class="bi bi-info-circle"></i><span class="pl-4 font-semibold">Logged In</span>
                    <x-global.divider/>
                    Welcome back {{ Auth::user()->name }}! You last logged in on {{ Auth::user()->last_login }}.
                </div>
            @endauth
        </x-global.title-box>
        
    </div>

@endsection