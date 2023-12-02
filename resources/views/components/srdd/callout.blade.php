{{--
  -- Creates a callout box for info that needs to be emphasized.  Can also have a title 
  --}}

@props(['title' => 'Information'])

<div class="mt-2 mb-10 ml-8 mr-8
            px-2 py-4 
            w-full
            bg-stone-100 dark:bg-stone-800 
            shadow-slate-400 shadow-md
            text-indigo-700 dark:text-indigo-50">
    <span class="pl-4 font-semibold text-2xl">
        {{ $title }}
    </span>
     <x-srdd.divider/>
     <span class="text-justify text-sm indent-4 p-8">
        {{ $slot }}
    </span>
</div>
