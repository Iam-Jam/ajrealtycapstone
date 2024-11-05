@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 mt-11">Confirm Deletion</h1>
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
        <p class="font-bold">Warning!</p>
        <p>Are you sure you want to delete this purchase agreement? This action cannot be undone.</p>
    </div>
    <form action="{{ route('purchase-agreements.destroy', $purchaseAgreement) }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="hidden" name="confirm" value="yes">
        <div class="flex justify-end space-x-4">
            <a href="{{ route('purchase-agreements.edit', $purchaseAgreement) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
                Cancel
            </a>
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
                Confirm Delete
            </button>
        </div>
    </form>
</div>
@endsection
