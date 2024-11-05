@php
$utilities = [
    'electricity' => 'Electricity',
    'gas' => 'Gas',
    'water' => 'Water',
    'trash' => 'Trash Collection',
    'internet' => 'Internet',
    'cable' => 'Cable TV'
];
@endphp

<form action="{{ route('forms.submit', ['formType' => 'lease-agreement']) }}" method="POST" class="space-y-6">
    @csrf


    <div class="flex items-center justify-center mb-6">
        <svg class="h-8 w-8 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
        </svg>
        <h1 class="text-3xl font-bold text-primary">AJ Real Estate</h1>
    </div>


    <!-- Parties Information -->
    <div class="bg-primary text-white p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">{{ __('Parties Information') }}</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="landlord_name" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Landlord\'s Name') }}</label>
            <input type="text" id="landlord_name" name="landlord_name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div>
            <label for="tenant_name" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Tenant\'s Name') }}</label>
            <input type="text" id="tenant_name" name="tenant_name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
    </div>

    <!-- Property Information -->
    <div class="bg-primary text-white p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">{{ __('Property Information') }}</h2>
    </div>
    <div>
        <label for="property_address" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Property Address') }}</label>
        <input type="text" id="property_address" name="property_address" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>

    <!-- Lease Terms -->
    <div class="bg-primary text-white p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">{{ __('Lease Terms') }}</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Lease Start Date') }}</label>
            <input type="date" id="start_date" name="start_date" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div>
            <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Lease End Date') }}</label>
            <input type="date" id="end_date" name="end_date" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
    </div>

    <!-- Rent and Deposits -->
    <div class="bg-primary text-white p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">{{ __('Rent and Deposits') }}</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="monthly_rent" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Monthly Rent Amount ($)') }}</label>
            <input type="number" id="monthly_rent" name="monthly_rent" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div>
            <label for="security_deposit" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Security Deposit Amount ($)') }}</label>
            <input type="number" id="security_deposit" name="security_deposit" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
    </div>
    <div>
        <label for="rent_due_date" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Rent Due Date') }}</label>
        <input type="text" id="rent_due_date" name="rent_due_date" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="{{ __('e.g., 1st of each month') }}">
    </div>

    <!-- Utilities and Services -->
    <div class="bg-primary text-white p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">{{ __('Utilities and Services') }}</h2>
    </div>
    <div class="space-y-2">
        @foreach($utilities as $key => $utility)
            <div class="flex items-center">
                <input type="checkbox" id="{{ $key }}" name="utilities[]" value="{{ $key }}" class="mr-2">
                <label for="{{ $key }}">{{ __($utility) }} {{ __('included in rent') }}</label>
            </div>
        @endforeach
    </div>

    <!-- Rules and Regulations -->
    <div class="bg-primary text-white p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">{{ __('Rules and Regulations') }}</h2>
    </div>
    <div class="space-y-4">
        <div>
            <label for="pet_policy" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Pet Policy') }}</label>
            <textarea id="pet_policy" name="pet_policy" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        </div>
        <div>
            <label for="smoking_policy" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Smoking Policy') }}</label>
            <textarea id="smoking_policy" name="smoking_policy" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        </div>
        <div>
            <label for="maintenance_responsibilities" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Maintenance Responsibilities') }}</label>
            <textarea id="maintenance_responsibilities" name="maintenance_responsibilities" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        </div>
    </div>

    <!-- Additional Terms -->
    <div class="bg-primary text-white p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">{{ __('Additional Terms') }}</h2>
    </div>
    <div>
        <label for="additional_terms" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Additional Terms and Conditions') }}</label>
        <textarea id="additional_terms" name="additional_terms" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
    </div>

    <div class="flex items-center">
        <input type="checkbox" id="agree_terms" name="agree_terms" required class="mr-2">
        <label for="agree_terms" class="text-sm text-gray-700">{{ __('I agree to the terms and conditions of this Lease Agreement') }}</label>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="bg-primary hover:bg-opacity-90 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
            {{ __('Submit Lease Agreement') }}
        </button>
    </div>
</form>
