@props(['active'])

@php
$classes = ($active ?? false)
    ? 'inline-flex items-center px-3 py-1.5 text-sm font-semibold text-tr-accent-d bg-tr-accent/10 rounded-lg transition-all duration-150'
    : 'inline-flex items-center px-3 py-1.5 text-sm font-medium text-tr-muted hover:text-tr-text hover:bg-tr-raised rounded-lg transition-all duration-150';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
