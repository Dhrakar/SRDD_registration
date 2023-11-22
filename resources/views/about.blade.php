<?php 
    /*
     *  All about this application
     */

    // current Laravel Framework version
    $laravel_ver = Illuminate\Foundation\Application::VERSION;

    // current tailwinds version
    $tw_ver = json_decode(file_get_contents( base_path('node_modules/tailwindcss/package.json')), true );

    //current git commit info
    $git = rtrim('Latest git hash: ' . shell_exec("git log --oneline -1 | cut -f1 -d' '")); 

    // Common license references
    $lic_mit = "<a href=\"https://github.com/twbs/bootstrap/blob/main/LICENSE\" target=\"_blank\">MIT</a>";

 ?>
@extends('template.app')

@section('content')
<div class="container w-full">
    <h1>About This Application</h1>
    <x-srdd.callout>
        
        <em>Staff Recognition &amp; Development Day</em> is a time for us to recognize and thank the hard work done by UAF staff throughout the year.
	    It is also an opportunity to celebrate some longevity milestones for our staff.  Lastly, it is a day for staff to be able
	    to participate in fun training and informational sessions that can help in their personal and professional development.
	    <br/>
	    This web application was created to enable UAF employees to easily view and register for those training and event sessions. It
	    consists of 3 modules
        <br/>
	    <div class="ml-8 text-md">Registration</div>
	    <div class="ml-8 text-md">Reports</div>
	    <div class="ml-8 text-md">Administration</div>
    </x-srdd.callout>

    {{-- List out the libraries and licenses used --}}
    <div class="mx-10 mt-4 pb-5 w-auto border border-indigo-900 rounded-md">
        <div class="ml-10 px-2 -translate-y-3 w-min bg-white font-bold">
            Libraries&nbsp;and&nbsp;Licenses
        </div> 
        <p class="px-8 text-sm italic ">Note that there are many other packeges included in the Laravel framework.  This table only lists the major
            packages that have been installed beyond laravel.
        </p>
        <div class="mx-2 grid grid-cols-12 gap-0 auto-cols-max-12">
            <div class="px-2 table-header col-span-3">Package</div>
            <div class="px-2 table-header col-span-1">Version</div>
            <div class="px-2 table-header col-span-4">Usage</div>
            <div class="px-2 table-header col-span-2">License</div>
            <div class="px-2 table-header col-span-2">Link</div>

            <div class="px-2 table-row col-span-3">Laravel</div>
            <div class="px-2 table-row col-span-1">{{ $laravel_ver }}</div>
            <div class="px-2 table-row col-span-4">Core PHP Framework</div>
            <div class="px-2 table-row col-span-2">{!! $lic_mit !!}</div>
            <div class="px-2 table-row col-span-2"><a href="https://laravel.com" target="_blank">Laravel Home</a></div>

            <div class="px-2 table-row col-span-3">Bootstrap Icons</div>
            <div class="px-2 table-row col-span-1">1.10.3</div>
            <div class="px-2 table-row col-span-4">SVG/font for symbols</div>
            <div class="px-2 table-row col-span-2">{!! $lic_mit !!}</div>
            <div class="px-2 table-row col-span-2"><a href="https://icons.getbootstrap.com" target="_blank">Bootstrap Icons</a></div>

            <div class="px-2 table-row col-span-3">Tailwind CSS</div>
            <div class="px-2 table-row col-span-1">{{ $tw_ver['version'] }}</div>
            <div class="px-2 table-row col-span-4">Compiled CSS Utility Classes</div>
            <div class="px-2 table-row col-span-2">{!! $lic_mit !!}</div>
            <div class="px-2 table-row col-span-2"><a href="https://tailwindcss.com/" target="_blank">Tailwinds CSS</a></div>
            
            <div class="px-2 table-row col-span-3">Google Auth API</div>
            <div class="px-2 table-row col-span-1"></div>
            <div class="px-2 table-row col-span-4">Javascript components for UA Google SSO</div>
            <div class="px-2 table-row col-span-2"></div>
            <div class="px-2 table-row col-span-2"></div>

<div class="px-2 table-row col-span-3"></div>
<div class="px-2 table-row col-span-1"></div>
<div class="px-2 table-row col-span-4"></div>
<div class="px-2 table-row col-span-2"></div>
<div class="px-2 table-row col-span-2"></div>

<div class="px-2 table-row col-span-3"></div>
<div class="px-2 table-row col-span-1"></div>
<div class="px-2 table-row col-span-4"></div>
<div class="px-2 table-row col-span-2"></div>
<div class="px-2 table-row col-span-2"></div>
        </div>
    </div>
</div>

@endsection
