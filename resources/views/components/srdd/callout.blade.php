{{--
  -- Creates a callout box for info that needs to be emphasized.  Can also have a title 
  --}}

@props(['title' => 'Information'])

<div class="mt-2 mb-8 mx-auto
            px-2 py-4 
            w-10/12
            border-l-8 border-stone-700 dark:border-stone-100 
            bg-stone-100 dark:bg-stone-800 
            shadow-slate-400 shadow-sm
            text-indigo-700 dark:text-indigo-50">
    <span class="pl-4 font-semibold text-2xl">
        {{ $title }}
    </span>
     <x-srdd.divider/>
     <span class="text-justify text-sm indent-4 p-8">
        {{ $slot }}
    </span>
</div>
