<?php 
    /*
     *  All about this application
     */

    // current Laravel Framework version
    $laravel_ver = Illuminate\Foundation\Application::VERSION;

    // current tailwinds version
    $tw_ver = json_decode(file_get_contents( base_path('node_modules/tailwindcss/package.json')), true );

    // current fullcalendar version
    $fc_ver = json_decode(file_get_contents( base_path('node_modules/@fullcalendar/core/package.json')), true );
    
    // current flatpickr version
    $fp_ver = json_decode(file_get_contents( base_path('node_modules/flatpickr/package.json')), true );
    
    // current jQuery version
    $jq_ver = json_decode(file_get_contents( base_path('node_modules/jquery/package.json')), true );
    
    // current Tippy version
    $tippy_ver = json_decode(file_get_contents( base_path('node_modules/tippy.js/package.json')), true );

    //current git commit info
    $git = rtrim('Version Info: ' . shell_exec("git show --no-patch --format=%cd --date=short ") . " / " . shell_exec("git log --oneline -1 | cut -f1 -d' '")); 
    $tag = shell_exec("git describe --abbrev=0 --tags");

    // Common license references
    $lic_mit = "<a href=\"https://github.com/twbs/bootstrap/blob/main/LICENSE\" target=\"_blank\">MIT</a>";

 ?>
@extends('template.app')

@section('content')
<div class="container w-full">
    <x-global.toolbar :icon="__('bi-info-circle')">
        <li class="mx-6" data-tippy-content="{{ $git }}"><i class="bi bi-github mr-1"></i>{{ $tag }}</li>
    </x-global.toolbar>
    <x-srdd.callout :title="__('SRDD Registration Tool')">
        <em>Staff Recognition &amp; Development Day</em> is a time for us to recognize and thank the hard work done by UAF staff throughout the year.
	    It is also an opportunity to celebrate some longevity milestones for our staff.  Lastly, it is a day for staff to be able
	    to participate in fun training and informational sessions that can help in their personal and professional development.
	    <br/>
	    This web application was created to enable UAF employees to easily view and register for those training and event sessions. It
	    consists of 3 modules: Registration, Reports and Administration. 
        <br/>
	    <div class="text-sm text-indigo-600 ml-24 mt-4">
            <i class="text-yellow-400 bi bi-cone">Module descriptions are upcoming </i>
        </div>
    </div>
    </x-srdd.callout>

    {{-- List out the libraries and licenses used --}}
    <x-srdd.title-box :title="__('Libraries and Licenses')">
        <p class="px-8 text-std text-sm italic">
            Note that there are many other packeges included in the Laravel framework.  This table only lists the major
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
            
            <div class="px-2 table-row col-span-3">FullCalendar</div>
            <div class="px-2 table-row col-span-1">{{ $fc_ver['version'] }}</div>
            <div class="px-2 table-row col-span-4">Javascript based calendar for sessions and schedules</div>
            <div class="px-2 table-row col-span-2">{!! $lic_mit !!}</div>
            <div class="px-2 table-row col-span-2"><a href="https://fullcalendar.io" target="_blank">FullCalendar JS</a></div>

            <div class="px-2 table-row col-span-3">Flatpickr</div>
            <div class="px-2 table-row col-span-1">{{ $fp_ver['version'] }}</div>
            <div class="px-2 table-row col-span-4">Date/Time JS input widget</div>
            <div class="px-2 table-row col-span-2">{!! $lic_mit !!}</div>
            <div class="px-2 table-row col-span-2"><a href="https://flatpickr.js.org" target="_blank">FlatpickrJS</a></div>

            <div class="px-2 table-row col-span-3">jQuery</div>
            <div class="px-2 table-row col-span-1">{{ $jq_ver['version'] }}</div>
            <div class="px-2 table-row col-span-4">Javascript DOM library</div>
            <div class="px-2 table-row col-span-2">{!! $lic_mit !!}</div>
            <div class="px-2 table-row col-span-2"><a href="https://jquery.com" target="_blank">jQuery</a></div>

            <div class="px-2 table-row col-span-3">Tippy.js</div>
            <div class="px-2 table-row col-span-1">{{ $tippy_ver['version'] }}</div>
            <div class="px-2 table-row col-span-4">Javascript Tooltip Engine</div>
            <div class="px-2 table-row col-span-2">{!! $lic_mit !!}</div>
            <div class="px-2 table-row col-span-2"><a href="https://tippyjs.bootcss.com" target="_blank">Tippy.js</a></div>

            {{-- 
              -- empty row divs for other library copy/paste
              -- 
            <div class="px-2 table-row col-span-3"></div>
            <div class="px-2 table-row col-span-1"></div>
            <div class="px-2 table-row col-span-4"></div>
            <div class="px-2 table-row col-span-2">{!! $lic_mit !!}</div>
            <div class="px-2 table-row col-span-2"><a href="" target="_blank"></a><</div>
              --}}
        </div>
    </x-srdd.title-box>

    {{-- Legal boilerplate --}}
    <x-srdd.notice :title="__('Notice of Nondiscrimination')">
        <div class="mx-auto w-9/10 p-2 text-center text-sm">
            <span>
                {!! Str::inlineMarkdown(__('ui.markdown.boilerplate')); !!}
            </span>
        </div>
    </x-srdd.notice>
</div>

@endsection
