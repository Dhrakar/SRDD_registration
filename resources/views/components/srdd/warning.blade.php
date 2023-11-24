{{--
  -- Creates a warning message box for info that needs to be emphasized.  Can also have a title 
  --}}

@props(['title' => 'Warning'])

<div class="ml-8 mr-3 mt-2 mb-10 px-2 py-4 rounded-sm border-l-8 border-red-700 dark:border-red-100 bg-red-200 dark:bg-red-700 shadow-md text-sm text-red-700 dark:text-red-50">
    <i class="font-bold text-xl bi bi-exclamation-triangle"></i>
    <span class="pl-4 font-semibold text-lg">
        {{ $title }}
    </span>
     <x-global.divider/>
     <span class="text-justify text-sm indent-4">
        {{ $slot }}
    </span>
</div>