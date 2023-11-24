{{--
  -- Creates a warning message box for info that needs to be emphasized.  Can also have a title 
  --}}

@props(['title' => 'Warning'])

<div class="ml-8 mr-3 mt-2 mb-10 
            px-2 py-4 
            w-8/12
            border-1 border-l-8 border-amber-700 dark:border-amber-100 
            bg-amber-200 dark:bg-amber-700 
            shadow-md rounded-md
            text-amber-700 dark:text-amber-50">
    <i class="font-bold text-3xl bi bi-exclamation-triangle"></i>
    <span class="pl-4 font-semibold text-lg">
        {{ $title }}
    </span>
     <x-srdd.divider/>
     <span class="text-justify text-sm indent-4">
        {{ $slot }}
    </span>
</div>