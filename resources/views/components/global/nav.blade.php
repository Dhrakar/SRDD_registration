<?php
    /**
     * The main navigation menu for SRDD
     */
    
    use Illuminate\Support\Facades\Auth;

    // page variables for text color, etc
    $m_text_def  = "text-md text-slate-50 dark:text-rose-50 ";  // default menu text attributes 
    $m_text_sel  = "text-md font-semibold text-[#FFC000] dark:text-amber-300";  // test color when on that route

?>

<nav x-data="{ open: false }" class="bg-blue-900">
    {{-- Main Navigation Menu --}}
    <div class="max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 text-slate-200 hover:text-teal-200 dark:text-rose-300 dark:hover:text-rose-300">
            <div class="flex">
                {{-- Home Icon/Link --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}"
                       class="inline-flex items-center px-1 pt-1
                        {{ 
                            (   url()->current() == config('app.url')
                             || url()->current() == route('home') 
                             || url()->current() == route('schedule') 
                             || url()->current() == route('profile.edit')
                            )?$m_text_sel:$m_text_def 
                        }}"
                    >
                        <i id="_HOME" class="bi {{ config('constants.icon.home') }} mx-2"></i>
                        {{ __('ui.menu.home')}}
                    </a>
                </div>
                @auth
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('calendar') }}" 
                        class="inline-flex items-center px-1 pt-1 
                         {{ (url()->current() == route('calendar'))?$m_text_sel:$m_text_def }}"
                    >
                        {{ __('ui.menu.schedule') }}
                    </span>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('reports') }}"  
                        class="inline-flex items-center px-1 pt-1 
                         {{ (url()->current() == route('reports'))?$m_text_sel:$m_text_def }}"
                    >
                        {{ __('ui.menu.reports') }}
                    </span>
                </div>
                @if(Auth::user()->isAdmin()) {{-- Include admin menu if user has admin or higher --}}
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <a href="{{ route('admin.index') }}"
                            class="inline-flex items-center px-1 pt-1 
                            {{-- Check to see if this route is for any admin uri --}}
                            {{ (strpos(url()->current(), '/admin') !== false )?$m_text_sel:$m_text_def }}"
                        >
                            {{ __('ui.menu.admin') }}
                        </a>
                    </div>
                @endif
                @endauth
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('about') }}"
                        class="inline-flex items-center px-1 pt-1 
                        {{ (url()->current() == route('about'))?$m_text_sel:$m_text_def }}"
                    >
                        {{ __('ui.menu.about') }}
                    </a>
                </div>
            </div> {{-- END MENU LINKS --}}
        </div>
    </div>
</nav>