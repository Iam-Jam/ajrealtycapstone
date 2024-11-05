<!-- resources/views/components/market-trends-visual.blade.php -->
@props(['trends'])

<div class="bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg rounded-lg shadow-lg p-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @foreach($trends as $trend)
            <div class="flex items-center space-x-4">
                <div class="w-2 h-2 rounded-full bg-{{ $trend['color'] }}-500"></div>
                <div>
                    <h3 class="text-lg font-semibold text-white">{{ $trend['title'] }}</h3>
                    <p class="text-sm text-gray-300">{{ $trend['description'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-6">
        <div class="w-full h-4 bg-gray-200 rounded-full overflow-hidden">
            @foreach($trends as $trend)
                <div class="h-full bg-{{ $trend['color'] }}-500" style="width: {{ $trend['percentage'] }}%; float: left;"></div>
            @endforeach
        </div>
    </div>
</div>
