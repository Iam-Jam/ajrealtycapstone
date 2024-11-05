@extends('layouts.app')

@section('title', 'Home - AJ Real Estate')

@section('content')

<!-- Hero Section -->
<div class="relative min-h-screen bg-cover bg-center flex items-center justify-center pt-20" style="background-image: url('{{ asset('uploads/uploads/homepage2.jpg') }}');">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="container mx-auto px-4 z-10">
        <div class="flex flex-col items-center justify-center text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 text-white">Find Your Dream Home Today</h1>
            <div class="p-8 bg-white bg-opacity-20 backdrop-filter backdrop-blur-md rounded-lg max-w-2xl">
                <p class="text-xl md:text-2xl text-white mb-6">Discover Your Perfect Living Space</p>
                <div class="flex flex-wrap gap-4 justify-center">
                    <a href="#featured-properties" class="inline-block bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-opacity-90 transition duration-300">
                        View Properties
                    </a>
                    <a href="{{ route('appointments.create') }}" class="inline-block bg-secondary text-white px-6 py-3 rounded-lg font-semibold hover:bg-opacity-90 transition duration-300">
                        Book Appointment Now
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Quick Stats Section -->
<div class="bg-white py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
            <div class="p-6">
                <div class="text-4xl font-bold text-primary mb-2">500+</div>
                <div class="text-gray-600">Properties Listed</div>
            </div>
            <div class="p-6">
                <div class="text-4xl font-bold text-primary mb-2">1000+</div>
                <div class="text-gray-600">Happy Clients</div>
            </div>
            <div class="p-6">
                <div class="text-4xl font-bold text-primary mb-2">15+</div>
                <div class="text-gray-600">Years Experience</div>
            </div>
            <div class="p-6">
                <div class="text-4xl font-bold text-primary mb-2">24/7</div>
                <div class="text-gray-600">Support Available</div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Properties Section -->
<section id="featured-properties" class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-primary mb-4">Featured Properties</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Discover our hand-picked selection of premium properties</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($featuredProperties as $property)
            <div class="bg-white rounded-lg overflow-hidden shadow-lg group hover:shadow-xl transition duration-300">
                <div class="relative">
                    <img src="{{ asset($property['image']) }}"
                         alt="{{ $property['title'] }}"
                         class="w-full h-64 object-cover transition duration-300 group-hover:scale-105">
                    <div class="absolute top-4 left-4">
                        <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $property['label'] }}
                        </span>
                    </div>
                    <div class="absolute bottom-4 right-4">
                        <span class="bg-primary text-white px-4 py-2 rounded-lg text-lg font-bold">
                            ₱{{ number_format($property['price']) }}
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3">{{ $property['title'] }}</h3>
                    <p class="text-gray-600 mb-4">{{ $property['description'] }}</p>
                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <div class="flex items-center justify-center p-2 bg-gray-50 rounded-lg">
                            <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span>{{ $property['beds'] }} Beds</span>
                        </div>
                        <div class="flex items-center justify-center p-2 bg-gray-50 rounded-lg">
                            <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                            </svg>
                            <span>{{ $property['baths'] }} Baths</span>
                        </div>
                        <div class="flex items-center justify-center p-2 bg-gray-50 rounded-lg">
                            <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                            </svg>
                            <span>{{ $property['sqft'] }} sqft</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-12">
            <a href="{{ route('properties.index') }}" class="inline-block bg-secondary text-white px-8 py-3 rounded-lg font-semibold hover:bg-opacity-90 transition duration-300">
                View All Properties
            </a>
        </div>
    </div>
</section>


<!-- Call to Action Section -->
<section class="py-16 bg-primary">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Ready to Find Your Dream Home?</h2>
        <p class="text-white text-lg mb-8 max-w-2xl mx-auto">Schedule a viewing today and take the first step towards your new home</p>
        <a href="{{ route('appointments.create') }}" class="inline-block bg-white text-primary px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
            Book An Appointment Now
        </a>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-primary mb-4">How can we help you?</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Experience the difference with our premium real estate services</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6">
                <div class="bg-primary bg-opacity-10 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Expert Guidance</h3>
                <p class="text-gray-600">Professional support throughout your property journey</p>
            </div>
            <div class="text-center p-6">
                <div class="bg-primary bg-opacity-10 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">24/7 Support</h3>
                <p class="text-gray-600">Always available to assist you whenever you need</p>
            </div>
            <div class="text-center p-6">
                <div class="bg-primary bg-opacity-10 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Best Deals</h3>
                <p class="text-gray-600">Competitive prices and exclusive property offers</p>
            </div>
        </div>
    </div>
</section>



<!-- Success/Error Messages -->


@if (session('error'))
    <div class="fixed bottom-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg z-50">
        <p>{{ session('error') }}</p>
    </div>
@endif

@endsection
