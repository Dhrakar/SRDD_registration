<?php
    /*
     *  This is the main landing page for the registration applicaiton
     */


?>
@extends('template.app')

@section('content')
    <div class="container">
        @guest 
        <x-global.toolbar :icon="__('bi-person-plus')">
            <li class="mx-6">
                <a  class="text-md text-slate-100 hover:text-teal-200" 
                    href="{{ route('register') }}">
                    {{__('ui.link.register')}}
                </a>
            </li>
        </x-global.toolbar>
        @endguest
        @auth 
        <x-global.toolbar>
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
        </x-global.toolbar>
        @endauth
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
        <x-srdd.title-box :title="__('ui.menu.login')">
            @guest 
                <x-srdd.login/>
            @endguest
            @auth
                <x-srdd.success :title="__('Logged In')">
                    Welcome back <span class="font-bold text-greem-700">{{ Auth::user()->name }}</span>! You last 
                    logged in on {{ Auth::user()->last_login }}.
                </x-srdd.success>
            @endauth
        </x-srdd.title-box>
        
    </div>

@endsection