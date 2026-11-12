@props(['brand'])

@php
    $slug = is_string($brand) ? $brand : ($brand->slug ?? '');
    $name = is_string($brand) ? $brand : ($brand->name ?? '');

    $badgeClass = match($slug) {
        'fs-education' => 'badge-brand-fs',
        'aptech' => 'badge-brand-aptech',
        'arena-multimedia' => 'badge-brand-arena',
        default => 'bg-secondary text-white'
    };
@endphp

<span {{ $attributes->merge(['class' => 'badge ' . $badgeClass]) }}>
    {{ $name }}
</span>
