<!-- resources/views/components/market-trend.blade.php -->
@props(['title', 'description'])

<div class="bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg rounded-lg shadow-lg p-6">
    <h3 class="text-xl font-bold mb-2 text-white">{{ $title }}</h3>
    <p class="text-gray-200">{{ $description }}</p>
</div>
