@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'bg-indigo-100 text-sm text-left text-slate-700 focus:ring-amber-600']) !!}>
