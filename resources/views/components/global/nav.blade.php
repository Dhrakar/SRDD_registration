<?php
  // page variables for text color, etc
  $m_text_def  = "text-md text-slate-50 hover:text-teal-200";  // default menu text attributes 
  $m_text_sel  = "text-md font-semibold text-[#FFC000] ";  // test color when on that route
?>

<nav x-data="{ open: false }" class="bg-blue-900">
    {{-- Main Navigation Menu --}}
    <div class="max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                {{-- Home Icon/Link --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}"
                       class="inline-flex items-center px-1 pt-1
                        {{ 
                            (   url()->current() == env('APP_URL')
                             || url()->current() == route('home') 
                             || url()->current() == route('profile.edit')
                            )?$m_text_sel:$m_text_def 
                        }}"
                    >
                        <i class="bi {{ config('constants.icon.home') }} mx-2"></i>
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
                    <a href="{{ route('reports.index') }}"  
                        class="inline-flex items-center px-1 pt-1 
                         {{ (url()->current() == route('reports.index'))?$m_text_sel:$m_text_def }}"
                    >
                        {{ __('ui.menu.reports') }}
                    </span>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('admin.index') }}"
                        class="inline-flex items-center px-1 pt-1 
                        {{-- Check to see if this route is for any admin uri --}}
                        {{ (strpos(url()->current(), 'admin') !== false )?$m_text_sel:$m_text_def }}"
                    >
                        {{ __('ui.menu.admin') }}
                    </a>
                </div>
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