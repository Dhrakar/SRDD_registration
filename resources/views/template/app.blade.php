<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <title>{{ config('app.name', 'Application') }}</title>

        {{-- Meta tags, CSS and JS libraries --}}
        <x-global.header/>
    </head>
    <body>
        {{-- Hidden items for pre-conditioning tailwinds and modals --}}
        <x-global.tw-hidden/>

        {{-- Banner and navigation blocks --}}
        <header>
            <x-global.banner/>
            <x-global.nav/>
        </header>

        {{-- pull in body content --}}
        <main  class="bg-slate-50 dark:bg-slate-900 min-h-screen">
            @yield('content')
        </main>

        {{-- page footer --}}
        <footer class="fixed bottom-0 left-0 w-full bg-slate-50 dark:bg-slate-900">
            <x-global.footer/>
        </footer>

        <x-global.scripts/>
    </body>
</html>