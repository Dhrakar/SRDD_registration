{{--
  -- Creates a warning message box for info that needs to be emphasized.  Can also have a title 
  --}}

@props(['title' => 'Dialog'])

<div class="ml-8 mr-3 mt-2 mb-10 
            px-2 py-4 
            w-8/12
            border-2 border-neutral-300 dark:border-neutral-500 
            bg-neutral-200 dark:bg-neutral-700 rounded-sm
            text-neutral-700 dark:text-neutral-50">
    <i class="font-bold text-3xl bi bi-layout-text-window"></i>
    <span class="pl-4 font-semibold">
        {{ $title }}
    </span>
     <x-srdd.divider/>
     <span class="text-justify text-sm indent-4">
        {{ $slot }}
    </span>
</div>