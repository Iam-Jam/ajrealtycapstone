@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 pt-16">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900">My Listed Properties</h1>
                @can('list-property')
                <a href="{{ route('properties.list-sell.create') }}"
                   class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark transition duration-300">
                    List New Property
                </a>
                @endcan
            </div>

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <div class="p-6">
                    @if($properties->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($properties as $property)
                                <div class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition duration-300">
                                    @if($property->images->count() > 0)
                                        <img src="{{ Storage::url($property->images->first()->image_path) }}"
                                             alt="{{ $property->title }}"
                                             class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-400">No image available</span>
                                        </div>
                                    @endif

                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $property->title }}</h3>
                                        <p class="text-gray-600 mb-2">{{ $property->city }}</p>
                                        <p class="text-primary font-bold mb-2">${{ number_format($property->price, 2) }}</p>
                                        <div class="flex items-center text-sm text-gray-500 mb-2">
                                            <span class="mr-3">{{ $property->bedrooms }} Beds</span>
                                            <span class="mr-3">{{ $property->bathrooms }} Baths</span>
                                            <span>{{ $property->sqm }} sqm</span>
                                        </div>
                                        <div class="flex justify-between items-center mt-4">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                                        {{ $property->status === 'approved' ? 'bg-green-100 text-green-800' :
                                                           ($property->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                                            'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($property->status) }}
                                            </span>
                                            <a href="{{ route('properties.list-sell.show', $property) }}"
                                               class="text-primary hover:text-primary-dark font-medium">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6">
                            {{ $properties->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">You haven't listed any properties yet.</p>
                            @can('list-property')
                                <a href="{{ route('properties.list-sell.create') }}"
                                   class="mt-4 inline-block bg-primary text-white px-6 py-2 rounded-md hover:bg-primary-dark transition duration-300">
                                    List Your First Property
                                </a>
                            @endcan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
