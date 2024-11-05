@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 mt-11">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">{{ __('Listing Agreement Details') }}</h2>
        <a href="{{ route('profile.submitted-forms') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to My Submitted Forms
        </a>
    </div>

    <!-- Seller Information -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <div class="bg-primary text-white p-4">
            <h3 class="text-xl font-semibold">{{ __('Seller Information') }}</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-gray-700 text-sm font-bold mb-2">{{ __('Seller\'s Full Name') }}</p>
                <p class="text-gray-900">{{ $listingAgreement->seller_name }}</p>
            </div>
            <div>
                <p class="text-gray-700 text-sm font-bold mb-2">{{ __('Seller\'s Phone Number') }}</p>
                <p class="text-gray-900">{{ $listingAgreement->seller_phone }}</p>
            </div>
        </div>
    </div>

    <!-- Property Information -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <div class="bg-primary text-white p-4">
            <h3 class="text-xl font-semibold">{{ __('Property Information') }}</h3>
        </div>
        <div class="p-6 space-y-6">
            <div>
                <p class="text-gray-700 text-sm font-bold mb-2">{{ __('Property Address') }}</p>
                <p class="text-gray-900">{{ $listingAgreement->property_address }}</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-gray-700 text-sm font-bold mb-2">{{ __('City') }}</p>
                    <p class="text-gray-900">{{ $listingAgreement->property_city }}</p>
                </div>
                <div>
                    <p class="text-gray-700 text-sm font-bold mb-2">{{ __('State') }}</p>
                    <p class="text-gray-900">{{ $listingAgreement->property_state }}</p>
                </div>
                <div>
                    <p class="text-gray-700 text-sm font-bold mb-2">{{ __('ZIP Code') }}</p>
                    <p class="text-gray-900">{{ $listingAgreement->property_zip }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Listing Details -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <div class="bg-primary text-white p-4">
            <h3 class="text-xl font-semibold">{{ __('Listing Details') }}</h3>
        </div>
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-gray-700 text-sm font-bold mb-2">{{ __('Listing Price') }}</p>
                    <p class="text-gray-900">${{ number_format($listingAgreement->listing_price, 2) }}</p>
                </div>
                <div>
                    <p class="text-gray-700 text-sm font-bold mb-2">{{ __('Commission Rate') }}</p>
                    <p class="text-gray-900">{{ $listingAgreement->commission_rate }}%</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-gray-700 text-sm font-bold mb-2">{{ __('Listing Start Date') }}</p>
                    <p class="text-gray-900">{{ $listingAgreement->listing_start_date }}</p>
                </div>
                <div>
                    <p class="text-gray-700 text-sm font-bold mb-2">{{ __('Listing End Date') }}</p>
                    <p class="text-gray-900">{{ $listingAgreement->listing_end_date }}</p>
                </div>
            </div>
            <div>
                <p class="text-gray-700 text-sm font-bold mb-2">{{ __('Property Description') }}</p>
                <p class="text-gray-900">{{ $listingAgreement->property_description }}</p>
            </div>
            <div>
                <p class="text-gray-700 text-sm font-bold mb-2">{{ __('Special Conditions or Terms') }}</p>
                <p class="text-gray-900">{{ $listingAgreement->special_conditions ?: 'None' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
