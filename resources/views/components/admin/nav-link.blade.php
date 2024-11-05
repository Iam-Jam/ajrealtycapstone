{{-- resources/views/components/admin/nav-link.blade.php --}}
@props(['active'])

@php
$classes = ($active ?? false)
    ? 'flex items-center px-4 py-2 text-white bg-green-800 rounded-lg'
    : 'flex items-center px-4 py-2 text-white hover:bg-green-800 rounded-lg';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
