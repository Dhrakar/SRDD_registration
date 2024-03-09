<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
        {{-- Set to relative position if in debug mode --}}
      class="{{ (env('APP_DEBUG', false) === true)?'relative min-h-full pb-24':'' }}"
>
    <head>

        <title>{{ config('app.name', 'Application') }}</title>

        {{-- Meta tags, CSS and JS libraries --}}
        <x-global.header/>
    </head>
    <body class="bg-slate-50 dark:bg-slate-800 ">
        {{-- Hidden items for pre-conditioning tailwinds and modals --}}
        <x-global.tw-hidden/>

        {{-- Banner and navigation blocks --}}
        <header>
            <x-global.banner/>
            <x-global.nav/>
        </header>

        {{-- pull in body content --}}
        <main  class="min-h-screen">
            @yield('content')
        </main>

        {{-- page footer.  Fix to bottom in debug mode --}}
        <footer class="{{ (env('APP_DEBUG', false) === true)?'fixed bottom-0 left-0 w-full h-28 bg-slate-50 dark:bg-slate-900 overflow-auto':''}}">
            <x-global.footer/>
        </footer>
    </body>
</html>