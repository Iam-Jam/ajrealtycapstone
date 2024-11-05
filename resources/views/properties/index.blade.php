@extends('layouts.app')

@section('content')
<main>
    <div class="relative bg-cover bg-center bg-fixed pt-16"
        style="background-image: url('/uploads/uploads/propertiescover.jpg');">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative z-10">
            <!-- Hero Section -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                <div class="text-center">
                    <h1 class="text-5xl font-bold text-white mb-6">Discover Your Dream Home</h1>
                    <p class="text-xl text-white mb-8">We offer a premium real estate experience tailored to your needs</p>
                </div>
                <form action="{{ route('properties.search') }}" method="GET" class="mb-8 flex justify-center">
                    <!-- Search Input with Suggestions -->
                    <div class="relative flex-1 max-w-xl">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Search by location, property type (lot, condo, house, etc.)"
                               class="w-full px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-[#052e16]"
                               list="propertyTypes"
                               style="min-width: 300px;">

                        <!-- Datalist for property type suggestions -->
                        <datalist id="propertyTypes">
                            <option value="lot">
                            <option value="house">
                            <option value="house and lot">
                            <option value="condo">
                            <option value="apartment">
                            <option value="townhouse">
                        </datalist>
                    </div>

                    <!-- Search Button -->
                    <button type="submit"
                            class="flex items-center px-4 py-2 bg-[#052e16] text-white rounded-r-md hover:bg-green-600">
                        Search
                    </button>
                </form>
            </section>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if(isset($searchResults) && $searchResults->count() > 0)
            <!-- Search Results Section -->
            <section class="mb-16">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-[#052e16]">Search Results</h2>
                    <span class="text-sm text-gray-500">Found {{ $searchResults->total() }} properties</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($searchResults as $property)
                        @include('properties.partials.property-card', ['property' => $property])
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $searchResults->links() }}
                </div>
            </section>
        @elseif(isset($searchResults) && $searchResults->count() == 0)
            <div class="text-center py-8">
                <p class="text-gray-500">No properties found matching your criteria.</p>
                <a href="{{ route('properties.index') }}" class="text-[#052e16] hover:underline mt-4 inline-block">
                    Return to all properties
                </a>
            </div>
        @else

            <!-- Featured Properties Section -->
            <section class="mb-16">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-[#052e16]">Featured Properties</h2>
                    <span class="text-sm text-gray-500">Showing {{ $featuredProperties->count() }} properties</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($featuredProperties as $property)
                        @include('properties.partials.property-card', [
                            'property' => $property
                        ])
                    @empty
                        <div class="col-span-full text-center py-8">
                            <p class="text-gray-500">No featured properties available.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- Exclusive Properties Section -->
            <section class="mb-16">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-[#052e16]">Exclusive Properties</h2>
                    <span class="text-sm text-gray-500">Showing {{ $exclusiveProperties->count() }} properties</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($exclusiveProperties as $property)
                        @include('properties.partials.property-card', [
                            'property' => $property
                        ])
                    @empty
                        <div class="col-span-full text-center py-8">
                            <p class="text-gray-500">No exclusive properties available.</p>
                        </div>
                    @endforelse
                </div>
            </section>
        @endif
    </div>

    <!-- Toast Messages -->
    @if(session('message'))
        <div x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 3000)"
             class="fixed bottom-0 right-0 m-8 p-4 rounded-lg {{ session('status') === 'success' ? 'bg-green-500' : 'bg-red-500' }} text-white">
            {{ session('message') }}
        </div>
    @endif
</main>
@endsection
