<?php
    /*
     *  This is the main landing page for the registration applicaiton
     */

    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\Auth;

    // if one exists, massage the last login date to a better format
    if(isset(Auth::user()->last_login)) {
        $_ldate = Carbon::parse(Auth::user()->last_login)->toDayDateTimeString();
        $_usr = Auth::user()->name;
    } else {
        $_ldate = "N/A";
        $_usr = "Not logged in";
    }
    Log::debug("Home view called. User: " . $_usr . ", CSRF: " . csrf_token(). ", Google OT cookie? " . ( isset($_COOKIE['g_state'])?'YES':'NO' ) );
?>
@extends('template.app')

@section('content')
    <div class="container">
        <x-srdd.nav-home/>
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <x-srdd.callout :title="__('Welcome to the Staff Recognition and Development Day registration tool!')" >
            <p>
                This registration tool will allow you to register for sessions presented by your fellow UAF 
                employees covering many diverse topics.  The main sessions will be presented on the 
                <a class="dark:text-amber-400 underline" href="https://media.uaf.edu/home" target="_blank">UAF Media Stream</a> server, while the 
                remaining fun/development sessions may be presented via individual Zoom Conference. Please 
                be sure to sign up for the sessions you are interested in so that we can send you any Zoom 
                information for these sessions.  Registration will also help us plan for future Staff 
                Recognition days.
            </p>
        </x-srdd.callout>
        
        {{-- Add in the Login form or logged in user info --}}
        @guest 
            <x-srdd.dialog :title="__('Please Login or Register')">
                <x-srdd.login/>
            </x-srdd.dialog>
        @endguest
        @auth
            <x-srdd.success :title="__('Logged In')">
                Welcome {{ (Auth::user()->login_count > 1)?'back':'' }} 
                <span class="font-bold text-indigo-700">{{ Auth::user()->name }}</span>! 
                This is your {{ ordinal(Auth::user()->login_count) }} login 
                {{ (Auth::user()->login_count > 1)?'and your last login was on: ' . $_ldate:'' }}
            </x-srdd.success>
        @endauth
        
    </div>
@endsection