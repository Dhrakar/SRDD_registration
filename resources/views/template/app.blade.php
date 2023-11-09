<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <title>{{ config('app.name', 'Application') }}</title>

        {{-- Meta tags, CSS and JS libraries --}}
        <x-global.header/>
    </head>
    <body>

        {{-- Banner and navigation blocks --}}
        <x-global.banner/>

        {{-- pull in body content --}}
        <main>
            @yield('content')
        </main>
        
        {{-- Include late-loading items --}}
        <x-global.scripts/>
    </body>
</html>