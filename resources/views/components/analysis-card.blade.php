<!-- resources/views/components/analysis-card.blade.php -->
@props(['trend', 'index'])

@php
    $bgColors = ['bg-primary-dark', 'bg-secondary', 'bg-accent'];
    $bgColor = $bgColors[$index % count($bgColors)];
@endphp

<div class="{{ $bgColor }} rounded-xl shadow-lg p-6 transform hover:scale-105 transition duration-300">
    <h3 class="text-xl font-bold mb-3 text-white">{{ $trend['title'] }}</h3>
    <p class="text-gray-300">{{ $trend['description'] }}</p>
</div>
