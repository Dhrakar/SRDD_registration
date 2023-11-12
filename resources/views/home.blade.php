@extends('template.app')

@section('content')

    <div class="h-screen w-screen border border-slate-200 rounded-sm">
        <div id="welcome" class="p-5 bg-slate-100 text-sky-900 border-2 border-sky-950 rounded-sm">
            <span class="text-3xl mx-auto">
                Welcome to the Staff Recognition and Development Day registration tool
            </span>
            <span class="text-justify"> 
                {!! Str::markdown(__('ui.markdown.welcome')); !!}
            </span>
        </div>
        @if (Route::has('login'))
                <div class="">
                    @auth
                        <a href="{{ url('/home') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
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