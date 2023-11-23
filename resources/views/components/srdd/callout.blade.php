{{--
  -- Creates a callout box for info that needs to be emphasized.  Can also have a title 
  --}}

  @props(['title' => 'Info'])
<div class="ml-8 mr-3 mt-2 mb-10 px-2 py-4 rounded-md border-2 border-l-8 border-sky-800 dark:border-sky-100 bg-sky-50 dark:bg-sky-500 shadow-md">
    <span class="py-2 text-2xl text-left italic text-blue-800 dark:text-blue-200">
        {{ $title }}
    </span>
    <br/>
    <div class=" bg-slate-500 dark:bg-sky-400 h-px w-full mx-auto"></div>
    <br/>
    <span class="text-justify text-sm text-slate-700 dark:text-slate-50 indent-4">
        {{ $slot }}
    </span>
</div>
