{{--
  -- This widget wraps the content in a outline box with an inset title 
  --}}

@props(['title', 'state' => 1])

{{--
<div x-data="{open: {{ $state }} }">
  <div class=" mx-10 mt-4 mb-2 pb-5 w-auto border border-indigo-900 dark:border-indigo-200 rounded-md"> 
    <div class="relative -top-3 ml-6 px-2 inline bg-slate-50 dark:bg-slate-900 font-bold text-cyan-700 dark:text-cyan-50 ">
        <button @click="open = ! open" class=" bg-slate-50 dark:bg-slate-900 text-cyan-700 dark:text-cyan-50 hover:text-amber-700">
          {{ $title }}
          <span x-show="open" ><i class="bi bi-caret-down"></i></span>
          <span x-show="!open" ><i class="bi bi-caret-right"></i></span>
        </button>
    </div>
    <div x-show="open" >
      {{ $slot }}
    </div>
  </div>
</div>
--}}

<div class=" mx-10 mt-4 mb-2 pb-5 w-auto border border-indigo-900 dark:border-indigo-200 rounded-md"> 
    <div class="relative -top-3 ml-6 px-2 inline bg-slate-50 dark:bg-slate-900 font-bold text-cyan-700 dark:text-cyan-50 ">
      {{ $title }}
    </div>
    {{ $slot }}
</div>