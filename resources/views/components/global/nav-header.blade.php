{{--
  -- Creates the navigation sub-tabs.  Optional href for the icon
  --}}


@props(['target' => '#'])

<div class="bg-slate-700 text-sm font-bold py-1 w-screen" style="list-style-type: none;">
    <ui class="flex">
        <li class="mx-2 text-indigo-300">
            <a class=""
                href="{{ $target }}"
            >
                <i class="bi bi-pc-display-horizontal"></i>
            </a>
        </li>

        {{-- Remaining list items for menu --}}
        {{ $slot }}
    </ul>
</div>