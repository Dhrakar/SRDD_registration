{{--
  -- Creates a warning message box for info that needs to be emphasized.  Can also have a title 
  --}}

@props(['title' => 'Error'])

<div class="ml-8 mr-auto mt-2 mb-10 
            px-2 py-4 
            w-8/12 
            border-1 border-l-8 border-rose-700 dark:border-rose-200 
            bg-rose-200 dark:bg-rose-600 
            shadow-md rounded-md
            text-rose-700 dark:text-rose-50"
>
    <i class="font-bold text-3xl bi bi-exclamation-octagon"></i>
    <span class="pl-4 font-semibold text-lg">
        {{ $title }}
    </span>
     <x-srdd.divider/>
     <span class="text-justify text-sm indent-4">
        {{ $slot }}
    </span>
</div>