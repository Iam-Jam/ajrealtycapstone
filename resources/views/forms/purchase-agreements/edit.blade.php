@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    @php
        $contingencyItems = [
            'financing' => 'Financing',
            'inspection' => 'Inspection',
            'appraisal' => 'Appraisal',
            'sale' => 'Sale of Existing Home',
        ];
    @endphp

    <div class="container mx-auto px-4 py-8 mt-11">
        <div class="flex flex-col md:flex-row justify-between items-start mb-6">
            <h1 class="text-3xl font-bold mb-4 md:mb-0">Edit Purchase Agreement</h1>
            <a href="{{ route('profile.submitted-forms') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center mt-4">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to My Submitted Forms
            </a>
        </div>

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

        @if (session('warning'))
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
                {{ session('warning') }}
            </div>
        @endif

        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Oops!</strong>
            <span class="block sm:inline">Please check the form for errors.</span>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('purchase-agreements.update', $purchaseAgreement) }}">
            @csrf
            @method('PUT')

            <!-- Buyer and Property Information -->
            <div class="bg-primary text-white p-4 rounded-lg mb-6">
                <h2 class="text-2xl font-semibold">{{ __('Buyer and Property Information') }}</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label for="property_id" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Property ID') }}</label>
                    <input type="text" id="property_id" name="property_id" value="{{ old('property_id', $purchaseAgreement->property_id) }}" readonly
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-100">
                </div>
                <div>
                    <label for="buyer_name" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Buyer Name') }}</label>
                    <input type="text" id="buyer_name" name="buyer_name" value="{{ old('buyer_name', $purchaseAgreement->buyer_name) }}" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('buyer_name') border-red-500 @enderror">
                    @error('buyer_name')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="seller_name" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Seller Name') }}</label>
                    <input type="text" id="seller_name" name="seller_name" value="{{ old('seller_name', $purchaseAgreement->seller_name) }}" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('seller_name') border-red-500 @enderror">
                    @error('seller_name')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mb-6">
                <label for="property_address" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Property Address') }}</label>
                <input type="text" id="property_address" name="property_address" value="{{ old('property_address', $purchaseAgreement->property_address) }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('property_address') border-red-500 @enderror">
                @error('property_address')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Purchase Details -->
            <div class="bg-primary text-white p-4 rounded-lg mb-6">
                <h2 class="text-2xl font-semibold">{{ __('Purchase Details') }}</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="purchase_price" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Purchase Price') }}</label>
                    <input type="number" id="purchase_price" name="purchase_price" step="0.01" value="{{ old('purchase_price', $purchaseAgreement->purchase_price) }}" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('purchase_price') border-red-500 @enderror">
                    @error('purchase_price')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="earnest_money" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Earnest Money') }}</label>
                    <input type="number" id="earnest_money" name="earnest_money" step="0.01" value="{{ old('earnest_money', $purchaseAgreement->earnest_money) }}" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('earnest_money') border-red-500 @enderror">
                    @error('earnest_money')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Dates -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="closing_date" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Closing Date') }}</label>
                    <input type="date" id="closing_date" name="closing_date" value="{{ old('closing_date', $purchaseAgreement->closing_date->format('Y-m-d')) }}" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('closing_date') border-red-500 @enderror">
                    @error('closing_date')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="possession_date" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Possession Date') }}</label>
                    <input type="date" id="possession_date" name="possession_date" value="{{ old('possession_date', $purchaseAgreement->possession_date->format('Y-m-d')) }}" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('possession_date') border-red-500 @enderror">
                    @error('possession_date')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Contingencies -->
            <div class="bg-primary text-white p-4 rounded-lg mb-6">
                <h2 class="text-2xl font-semibold">{{ __('Contingencies') }}</h2>
            </div>
            <div class="space-y-4 mb-6">
                @php
                    $contingencies = old('contingencies', $purchaseAgreement->contingencies ?? []);
                @endphp
                @foreach ($contingencyItems as $key => $item)
                    <div class="flex items-center">
                        <input type="checkbox" id="contingencies_{{ $key }}" name="contingencies[]" value="{{ $key }}"
                            {{ in_array($key, $contingencies) ? 'checked' : '' }} class="mr-2">
                        <label for="contingencies_{{ $key }}" class="text-sm text-gray-700">{{ __($item) }}</label>
                    </div>
                @endforeach
            </div>

            <!-- Additional Terms -->
            <div class="mb-6">
                <label for="additional_terms" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Additional Terms') }}</label>
                <textarea id="additional_terms" name="additional_terms" rows="4"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('additional_terms') border-red-500 @enderror">{{ old('additional_terms', $purchaseAgreement->additional_terms) }}</textarea>
                @error('additional_terms')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Agreement Confirmation -->
            <div class="flex items-center mb-6">
                <input type="checkbox" id="agree_terms" name="agree_terms" value="1" {{ old('agree_terms', $purchaseAgreement->agree_terms) ? 'checked' : '' }} required
                    class="mr-2 @error('agree_terms') border-red-500 @enderror">
                <label for="agree_terms" class="text-sm text-gray-700">{{ __('I agree to the terms and conditions') }}</label>
            </div>
            @error('agree_terms')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror

            <div class="flex justify-end space-x-4">
                <button type="submit" name="action" value="update" class="bg-primary hover:bg-opacity-90 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
                    {{ __('Update Purchase Agreement') }}
                </button>
            </div>
        </form>

        <form action="{{ route('purchase-agreements.confirm-delete', $purchaseAgreement) }}" method="POST" class="mt-6">
            @csrf
            <div class="flex justify-end">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
                    {{ __('Delete Purchase Agreement') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
