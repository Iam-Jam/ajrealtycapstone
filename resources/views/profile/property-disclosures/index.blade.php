@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 mt-11">Edit Property Disclosure</h1>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('profile.property-disclosures.update', $propertyDisclosure) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="seller_name" class="block font-medium text-sm text-gray-700">Seller Name</label>
            <input type="text" name="seller_name" id="seller_name" value="{{ old('seller_name', $propertyDisclosure->seller_name) }}" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
            @error('seller_name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="property_address" class="block font-medium text-sm text-gray-700">Property Address</label>
            <input type="text" name="property_address" id="property_address" value="{{ old('property_address', $propertyDisclosure->property_address) }}" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
            @error('property_address')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Add more fields as needed -->

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                Update
            </button>
        </div>
    </form>

    <form action="{{ route('profile.property-disclosures.destroy', $propertyDisclosure) }}" method="POST" class="mt-6">
        @csrf
        @method('DELETE')
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring focus:ring-red-300 disabled:opacity-25 transition" onclick="return confirm('Are you sure you want to delete this disclosure?')">
            Delete
        </button>
    </form>
</div>
@endsection
