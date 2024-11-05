<!-- resources/views/components/insight-widget.blade.php -->
@props(['insight'])

<div class="bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg rounded-lg shadow-lg p-4">
    <div class="flex items-center mb-4">
        <div class="w-10 h-10 rounded-full bg-{{ $insight['color'] }}-500 flex items-center justify-center mr-3">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                {!! $insight['icon'] !!}
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-white">{{ $insight['title'] }}</h3>
    </div>
    <p class="text-sm text-gray-300 mb-4">{{ $insight['description'] }}</p>
    <div class="w-full bg-gray-200 rounded-full h-2.5">
        <div class="bg-{{ $insight['color'] }}-500 h-2.5 rounded-full" style="width: {{ $insight['percentage'] }}%"></div>
    </div>
    <p class="text-xs text-gray-300 mt-1 text-right">{{ $insight['percentage'] }}% Growth</p>
</div>
