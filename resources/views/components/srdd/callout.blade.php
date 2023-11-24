{{--
  -- Creates a callout box for info that needs to be emphasized.  Can also have a title 
  --}}

@props(['title' => 'Information'])

<div class="mt-2 mb-4 mx-auto
            px-2 py-4 
            w-10/12
            border-l-4 border-r-4 border-stone-800 dark:border-stone-100 
            bg-stone-100 dark:bg-stone-800 
            text-indigo-700 dark:text-indigo-50">
    <span class="pl-4 font-semibold text-2xl">
        {{ $title }}
    </span>
     <x-srdd.divider/>
     <span class="text-justify text-sm indent-4 p-8">
        {{ $slot }}
    </span>
</div>
