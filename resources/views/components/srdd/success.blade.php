{{--
  -- Creates a warning message box for info that needs to be emphasized.  Can also have a title 
  --}}

@props(['title' => 'Success'])

<div class="ml-8 mr-3 mt-2 mb-10 
            px-2 py-4 
            w-8/12
            border-1 border-l-8 border-green-700 dark:border-green-100 
            bg-green-200 dark:bg-green-700  
            shadow-md rounded-md
            text-green-700 dark:text-green-50">
    <i class="font-bold text-3xl bi bi-info-circle"></i>
    <span class="pl-4 font-semibold text-lg">
        {{ $title }}
    </span>
     <x-srdd.divider/>
     <span class="text-justify text-sm indent-4">
        {{ $slot }}
    </span>
</div>