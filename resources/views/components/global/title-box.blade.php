{{--
  -- This widget wraps teh content in a outline box with an inset title 
  --}}

@props(['title'])

<div class="mx-10 mt-4 pb-5 w-auto border border-indigo-900 dark:border-indigo-200 rounded-md">
    <div class="relative -top-3 ml-4 px-2 inline bg-slate-50 dark:bg-slate-900 font-bold text-cyan-700 dark:text-cyan-50">
        {{ $title }}
    </div>
    {{ $slot }}
</div>