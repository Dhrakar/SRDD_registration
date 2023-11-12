<?php
  // page variables for text color, etc
  $m_text_def  = config('constants.colors.menu.def-text');  // default text color
  $m_text_sel  = config('constants.colors.menu.sel-text');  // test color when on that route
?>

<nav x-data="{ open: false }" class="bg-blue-900">
    {{-- Main Navigation Menu --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                {{-- Menu Icon --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}"
                       class="inline-flex items-center px-1 pt-1
                         {{ (url()->current() == route('home'))?$m_text_sel:$m_text_def }}"
                    >
                        <i class="bi {{ config('constants.icon.home') }} text-xl"></i>
                    </a>
                </div>
                {{-- Links --}}
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <span class="inline-flex items-center px-1 pt-1 ">
                        {{ __('ui.menu.register') }}
                    </span>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <span class="inline-flex items-center px-1 pt-1 ">
                        {{ __('ui.menu.schedule') }}
                    </span>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('admin.index') }}"
                        class="inline-flex items-center px-1 pt-1 
                        {{ (url()->current() == route('admin.index'))?$m_text_sel:$m_text_def }}"
                    >
                        {{ __('admin') }}
                    </a>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('about') }}"
                        class="inline-flex items-center px-1 pt-1 
                        {{ (url()->current() == route('about'))?$m_text_sel:$m_text_def }}"
                    >
                        {{ __('ui.menu.about') }}
                    </a>
                </div>
            </div> {{-- END MENU LINKS --}}

            {{-- User dropdown --}}
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth {{-- Only show dropdown if logged in --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>
                                <i class="bi {{ config('constants.icon.user') }}"></i>
                                {{ Auth::user()->name }}
                            </div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endauth
            </div>
            {{-- Hamburger menu --}}
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md {{ $m_text_def }} hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>