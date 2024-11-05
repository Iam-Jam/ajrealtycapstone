@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 mt-11">
    <div class="flex flex-col md:flex-row justify-between items-start mb-6">
        <h1 class="text-3xl font-bold mb-4 md:mb-0">Purchase Agreement Details</h1>
        <a href="{{ route('profile.submitted-forms') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center mt-4 md:mt-0">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to My Submitted Forms
        </a>
    </div>

    <div class="bg-white shadow-md rounded my-6">
        <!-- Property Information -->
        <div class="bg-primary text-white p-4 rounded-t-lg">
            <h2 class="text-2xl font-semibold">{{ __('Property Information') }}</h2>
        </div>
        <table class="text-left w-full border-collapse">
            <tr>
                <th class="py-4 px-6 bg-grey-lightest font-bold text-sm text-grey-dark border-b border-grey-light">Property Address</th>
                <td class="py-4 px-6 border-b border-grey-light">{{ $purchaseAgreement->property_address }}</td>
            </tr>
        </table>

        <!-- Buyer and Seller Information -->
        <div class="bg-primary text-white p-4 border-t border-grey-light">
            <h2 class="text-2xl font-semibold">{{ __('Buyer and Seller Information') }}</h2>
        </div>
        <table class="text-left w-full border-collapse">
            <tr>
                <th class="py-4 px-6 bg-grey-lightest font-bold text-sm text-grey-dark border-b border-grey-light">Buyer's Name</th>
                <td class="py-4 px-6 border-b border-grey-light">{{ $purchaseAgreement->buyer_name }}</td>
            </tr>
            <tr>
                <th class="py-4 px-6 bg-grey-lightest font-bold text-sm text-grey-dark border-b border-grey-light">Seller's Name</th>
                <td class="py-4 px-6 border-b border-grey-light">{{ $purchaseAgreement->seller_name }}</td>
            </tr>
        </table>

        <!-- Financial Details -->
        <div class="bg-primary text-white p-4 border-t border-grey-light">
            <h2 class="text-2xl font-semibold">{{ __('Financial Details') }}</h2>
        </div>
        <table class="text-left w-full border-collapse">
            <tr>
                <th class="py-4 px-6 bg-grey-lightest font-bold text-sm text-grey-dark border-b border-grey-light">Purchase Price</th>
                <td class="py-4 px-6 border-b border-grey-light">${{ number_format($purchaseAgreement->purchase_price, 2) }}</td>
            </tr>
            <tr>
                <th class="py-4 px-6 bg-grey-lightest font-bold text-sm text-grey-dark border-b border-grey-light">Earnest Money</th>
                <td class="py-4 px-6 border-b border-grey-light">${{ number_format($purchaseAgreement->earnest_money, 2) }}</td>
            </tr>
        </table>

        <!-- Important Dates -->
        <div class="bg-primary text-white p-4 border-t border-grey-light">
            <h2 class="text-2xl font-semibold">{{ __('Important Dates') }}</h2>
        </div>
        <table class="text-left w-full border-collapse">
            <tr>
                <th class="py-4 px-6 bg-grey-lightest font-bold text-sm text-grey-dark border-b border-grey-light">Closing Date</th>
                <td class="py-4 px-6 border-b border-grey-light">{{ $purchaseAgreement->closing_date->format('m/d/Y') }}</td>
            </tr>
            <tr>
                <th class="py-4 px-6 bg-grey-lightest font-bold text-sm text-grey-dark border-b border-grey-light">Possession Date</th>
                <td class="py-4 px-6 border-b border-grey-light">{{ $purchaseAgreement->possession_date->format('m/d/Y') }}</td>
            </tr>
        </table>

        <!-- Contingencies -->
        <div class="bg-primary text-white p-4 border-t border-grey-light">
            <h2 class="text-2xl font-semibold">{{ __('Contingencies') }}</h2>
        </div>
        <div class="p-4">
            <p class="text-sm text-gray-700">{{ implode(', ', $purchaseAgreement->contingencies) }}</p>
        </div>

        <!-- Additional Terms -->
        <div class="bg-primary text-white p-4 border-t border-grey-light">
            <h2 class="text-2xl font-semibold">{{ __('Additional Terms') }}</h2>
        </div>
        <div class="p-4">
            <p class="text-sm text-gray-700">{{ $purchaseAgreement->additional_terms ?: 'No additional terms specified.' }}</p>
        </div>
    </div>

    <div class="mt-4 flex justify-end">
        <a href="{{ route('purchase-agreements.edit', $purchaseAgreement) }}" class="bg-primary hover:bg-opacity-90 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
            Edit Purchase Agreement
        </a>
    </div>
</div>
@endsection
