{{--
  -- Creates the navigation sub-tabs.  Optional href for the icon
  --}}


@props(
        [
            'target' => '#',
            'icon'   => 'bi-tools'
        ])

<div class="bg-slate-700 dark:bg-slate-700 text-sm text-slate-200 hover:text-teal-200 font-bold py-1 w-screen" style="list-style-type: none;">
    <ui class="flex">
        <li class="mx-2">
            <button id="theme-toggle" type="button" data-tippy-content="Toggle Dark/Light Mode">
                <span id="theme-toggle-dark-icon" class="hidden">
                    <i class="bi bi-moon-stars "></i>
                </span>
                <span id="theme-toggle-light-icon" class="hidden">
                    <i class="bi bi-sun "></i>
                </span>
                </button>
        </li>
        <li class="mx-2">
            <a  class=""
                href="{{ $target }}"
                title="{{ gethostname() }}"
            >
                <i class="bi {{ $icon }}"></i>
            </a>
        </li>

        {{-- Dynamic  list items for menu --}}
        {{ $slot }}

        {{-- Logout link if someone is logged in --}}
        @auth 
        <li class="mx-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a  class="text-md text-slate-200 hover:text-teal-200" 
                    onclick="event.preventDefault(); this.closest('form').submit();"
                    href="{{ route('logout') }}"
                >
                    <i class="bi bi-box-arrow-right"></i>
                    {{ __('ui.menu.nav-home.logout') }}
                </a>
            </form>
        </li>
        @endauth
    </ul>
</div>