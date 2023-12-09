{{-- For use with the div tables in the comment col --}}
<div {{ $attributes->merge([ 'class' => 'text-xs text-indigo-700 dark:text-indigo-100 italic pl-2']) }}>
    {{ $slot }}
</div>