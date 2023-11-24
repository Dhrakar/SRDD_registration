{{--
  -- Creates a callout box for info that needs to be emphasized.  Can also have a title 
  --}}

@props(['title' => 'Information'])

<div class="w-4/5 mx-auto mt-2 mb-10 px-2 py-4 rounded-md border-2 border-l-8 border-sky-800 dark:border-sky-100 bg-sky-50 dark:bg-sky-500 shadow-md">
    <span class="py-2 text-2xl text-left italic text-blue-800 dark:text-blue-200">
            {{ $title }}
    </span>
    <x-global.divider/>
    <span class="text-justify text-sm  text-blue-800 dark:text-blue-200 indent-4">
        {{ $slot }}
    </span>
</div>
