<!-- resources/views/components/trend-widget.blade.php -->
@props(['trend'])

<div class="bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg rounded-lg shadow-lg p-4">
    <div class="flex items-center justify-between mb-2">
        <h3 class="text-lg font-semibold text-white">{{ $trend['title'] }}</h3>
        <div class="w-2 h-2 rounded-full bg-{{ $trend['color'] }}-500"></div>
    </div>
    <p class="text-sm text-gray-300 mb-4">{{ $trend['description'] }}</p>
    <div class="w-full bg-gray-200 rounded-full h-2.5">
        <div class="bg-{{ $trend['color'] }}-500 h-2.5 rounded-full" style="width: {{ $trend['percentage'] }}%"></div>
    </div>
    <p class="text-xs text-gray-300 mt-1 text-right">{{ $trend['percentage'] }}%</p>
</div>
