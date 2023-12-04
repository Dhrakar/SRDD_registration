{{--
  -- Creates the navigation sub-tabs.  Optional href for the icon
  --}}


@props(
        [
            'target' => '#',
            'icon'   => 'bi-tools'
        ])

<div class="bg-slate-700 text-sm font-bold py-1 w-screen" style="list-style-type: none;">
    <ui class="flex">
        <li class="mx-2">
            <a class=""
                href="{{ $target }}"
            >
                <i class="bi {{ $icon }} text-emerald-300"></i>
            </a>
        </li>

        {{-- Dynamic  list items for menu --}}
        {{ $slot }}

        {{-- Logout link if someone is logged in --}}
        @auth 
        <li class="mx-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a  class="text-md text-slate-100 hover:text-teal-200" 
                    onclick="event.preventDefault(); this.closest('form').submit();"
                    href="{{ route('logout') }}"
                >
                    <i class="bi bi-box-arrow-right"></i>
                    {{ __('ui.menu.nav-home.logout') }}
                </a>
        </li>
        @endauth
    </ul>
</div>