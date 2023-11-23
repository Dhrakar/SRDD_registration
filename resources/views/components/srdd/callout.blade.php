{{--
  -- Creates a callout box for info that needs to be emphasized.  Can also have a title 
  --}}

@props(['title'])

<div class="w-4/5 mx-auto mt-2 mb-10 px-2 py-4 rounded-md border-2 border-l-8 border-sky-800 dark:border-sky-100 bg-sky-50 dark:bg-sky-500 shadow-md">
    @if ($title)
        <span class="py-2 text-2xl text-left italic text-blue-800 dark:text-blue-200">
            {{ $title }}
        </span>
        <x-global.divider/>
    @endif
    <span class="text-justify text-sm text-std indent-4">
        {{ $slot }}
    </span>
</div>
