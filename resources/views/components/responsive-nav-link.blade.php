@props(['active'])

@php
$classes = ($active ?? false)
    ? 'flex items-center px-3 py-2 text-sm font-semibold text-tr-accent-d bg-tr-accent/10 rounded-lg border-l-2 border-tr-accent transition-all duration-150'
    : 'flex items-center px-3 py-2 text-sm font-medium text-tr-muted hover:text-tr-text hover:bg-tr-raised rounded-lg border-l-2 border-transparent transition-all duration-150';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
