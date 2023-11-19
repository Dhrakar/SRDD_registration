@props(['value'])

<label {{ $attributes->merge(['class' => 'inline pr-2 pt-2 align-middle text-right text-sm text-slate-700 border-1 border-indigo-100']) }}>
    {{ $value ?? $slot }}
</label>