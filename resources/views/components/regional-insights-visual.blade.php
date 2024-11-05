<!-- resources/views/components/regional-insights-visual.blade.php -->
@props(['insights'])

<div class="bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg rounded-lg shadow-lg p-6">
    <div class="grid grid-cols-2 gap-4">
        @foreach($insights as $insight)
            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-{{ $insight['color'] }}-500 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        {!! $insight['icon'] !!}
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">{{ $insight['title'] }}</h3>
                <p class="text-sm text-gray-300">{{ $insight['description'] }}</p>
                <div class="mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-{{ $insight['color'] }}-500 h-2.5 rounded-full" style="width: {{ $insight['percentage'] }}%"></div>
                    </div>
                    <p class="text-sm text-gray-300 mt-1">{{ $insight['percentage'] }}% Growth</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
