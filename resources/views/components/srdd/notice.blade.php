{{--
  -- Creates a warning message box for info that needs to be emphasized.  Can also have a title 
  --}}

@props(['title' => 'Notice'])

<div class="ml-8 mr-3 mt-2 mb-10 
            px-2 py-4 
            w-8/12
            border-1 border-l-8 border-sky-700 dark:border-sky-100 
            bg-sky-200 dark:bg-sky-700 
            shadow-md rounded-md
            text-sky-700 dark:text-sky-50">
    <i class="font-bold text-3xl bi bi-journal-text"></i>
    <span class="pl-4 font-semibold text-lg">
        {{ $title }}
    </span>
     <x-srdd.divider/>
     <span class="text-justify text-sm indent-4">
        {{ $slot }}
    </span>
</div>