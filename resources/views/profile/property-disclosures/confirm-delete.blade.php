@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Confirm Deletion</h1>
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
        <p class="font-bold">Warning!</p>
        <p>Are you sure you want to delete this property disclosure? This action cannot be undone.</p>
    </div>
    <form action="{{ route('profile.property-disclosures.destroy', $propertyDisclosure) }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="hidden" name="confirm" value="yes">
        <div class="flex justify-end space-x-4">
            <a href="{{ route('profile.property-disclosures.edit', $propertyDisclosure) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                Cancel
            </a>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring focus:ring-red-300 disabled:opacity-25 transition">
                Confirm Delete
            </button>
        </div>
    </form>
</div>
@endsection
