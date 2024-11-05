@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Seller Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Your Properties</h2>
            <p class="text-3xl font-bold">{{ $propertyCount }}</p>
            <a href="{{ route('seller.properties') }}" class="text-blue-500 hover:underline mt-2 inline-block">View All</a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Total Views</h2>
            <p class="text-3xl font-bold">{{ $totalViews }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Pending Inquiries</h2>
            <p class="text-3xl font-bold">{{ $pendingInquiries }}</p>
            <a href="{{ route('seller.inquiries') }}" class="text-blue-500 hover:underline mt-2 inline-block">View All</a>
        </div>
    </div>

    <div class="mt-8">
        <h2 class="text-2xl font-semibold mb-4">Recent Properties</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($recentProperties as $property)
                @include('properties.property-card', ['property' => $property])
            @endforeach
        </div>
    </div>

    <div class="mt-8">
        <a href="{{ route('properties.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Add New Property</a>
    </div>
</div>
@endsection
