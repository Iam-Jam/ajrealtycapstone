@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    @php
        $structuralItems = [
            'foundation' => 'Foundation issues',
            'roof' => 'Roof leaks or damage',
            'walls' => 'Wall cracks or damage',
            'floors' => 'Floor damage or unevenness',
            'ceilings' => 'Ceiling damage or leaks',
            'windows' => 'Window problems',
            'doors' => 'Door issues',
        ];

        $systemItems = [
            'plumbing' => 'Plumbing issues',
            'electrical' => 'Electrical system problems',
            'hvac' => 'Heating or air conditioning issues',
            'water_heater' => 'Water heater problems',
            'sewer' => 'Sewer or septic system issues',
        ];

        $environmentalItems = [
            'asbestos' => 'Presence of asbestos',
            'lead_paint' => 'Lead-based paint',
            'mold' => 'Mold or mildew issues',
            'radon' => 'Radon gas',
            'pests' => 'Pest infestations',
        ];
    @endphp

<div class="container mx-auto px-4 py-8 mt-11"> <!-- Added mt-8 for top margin -->
    <div class="flex flex-col md:flex-row justify-between items-start mb-6"> <!-- Changed to flex-col for mobile and added items-start -->
        <h1 class="text-3xl font-bold mb-4 md:mb-0">Edit Property Disclosure</h1> <!-- Added mb-4 for mobile spacing -->
        <a href="{{ route('profile.submitted-forms') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center mt-4">
            <svg class="w-4 h-4 mr-2 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to My Submitted Forms
        </a>
    </div>

    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('profile.property-disclosures.update', $propertyDisclosure) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Seller and Property Information -->
        <div class="bg-primary text-white p-4 rounded-lg mb-6">
            <h2 class="text-2xl font-semibold">{{ __('Seller and Property Information') }}</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="seller_name" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Seller\'s Name') }}</label>
                <input type="text" id="seller_name" name="seller_name" value="{{ old('seller_name', $propertyDisclosure->seller_name) }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('seller_name') border-red-500 @enderror">
                @error('seller_name')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="property_address" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Property Address') }}</label>
                <input type="text" id="property_address" name="property_address" value="{{ old('property_address', $propertyDisclosure->property_address) }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('property_address') border-red-500 @enderror">
                @error('property_address')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

<!-- Structural Conditions -->
<div class="bg-primary text-white p-4 rounded-lg mb-6">
    <h2 class="text-2xl font-semibold">{{ __('Structural Conditions') }}</h2>
</div>
<div class="space-y-4 mb-6">
    @php
        $structuralIssues = old('structural', json_decode($propertyDisclosure->structural_issues, true)) ?? [];
    @endphp
    @foreach ($structuralItems as $key => $item)
        <div class="flex items-center">
            <input type="checkbox" id="structural_{{ $key }}" name="structural[{{ $key }}]" value="1"
                {{ isset($structuralIssues[$key]) && $structuralIssues[$key] ? 'checked' : '' }} class="mr-2">
            <label for="structural_{{ $key }}" class="text-sm text-gray-700">{{ __($item) }}</label>
        </div>
    @endforeach
</div>

<!-- Systems and Utilities -->
<div class="bg-primary text-white p-4 rounded-lg mb-6">
    <h2 class="text-2xl font-semibold">{{ __('Systems and Utilities') }}</h2>
</div>
<div class="space-y-4 mb-6">
    @php
        $systemIssues = old('systems', json_decode($propertyDisclosure->system_issues, true)) ?? [];
    @endphp
    @foreach ($systemItems as $key => $item)
        <div class="flex items-center">
            <input type="checkbox" id="systems_{{ $key }}" name="systems[{{ $key }}]" value="1"
                {{ isset($systemIssues[$key]) && $systemIssues[$key] ? 'checked' : '' }} class="mr-2">
            <label for="systems_{{ $key }}" class="text-sm text-gray-700">{{ __($item) }}</label>
        </div>
    @endforeach
</div>

<!-- Environmental Concerns -->
<div class="bg-primary text-white p-4 rounded-lg mb-6">
    <h2 class="text-2xl font-semibold">{{ __('Environmental Concerns') }}</h2>
</div>
<div class="space-y-4 mb-6">
    @php
        $environmentalIssues = old('environmental', json_decode($propertyDisclosure->environmental_issues, true)) ?? [];
    @endphp
    @foreach ($environmentalItems as $key => $item)
        <div class="flex items-center">
            <input type="checkbox" id="environmental_{{ $key }}" name="environmental[{{ $key }}]" value="1"
                {{ isset($environmentalIssues[$key]) && $environmentalIssues[$key] ? 'checked' : '' }} class="mr-2">
            <label for="environmental_{{ $key }}" class="text-sm text-gray-700">{{ __($item) }}</label>
        </div>
    @endforeach
</div>

        <!-- Additional Issues -->
        <div class="mb-6">
            <label for="additional_issues" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Additional Issues or Comments') }}</label>
            <textarea id="additional_issues" name="additional_issues" rows="4"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('additional_issues') border-red-500 @enderror">{{ old('additional_issues', $propertyDisclosure->additional_issues) }}</textarea>
            @error('additional_issues')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirmation -->
        <div class="flex items-center mb-6">
            <input type="checkbox" id="confirm_disclosure" name="confirm_disclosure" required
                class="mr-2 @error('confirm_disclosure') border-red-500 @enderror">
            <label for="confirm_disclosure" class="text-sm text-gray-700">{{ __('I confirm that the information provided in this disclosure statement is true and accurate to the best of my knowledge.') }}</label>
        </div>
        @error('confirm_disclosure')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror

        <div class="flex justify-end space-x-4">
            <button type="submit" class="bg-primary hover:bg-opacity-90 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
                {{ __('Update Disclosure Statement') }}
            </button>
        </div>
    </form>

    <form action="{{ route('profile.property-disclosures.destroy', $propertyDisclosure) }}" method="POST" class="mt-6">
        @csrf
        @method('DELETE')
        <div class="flex justify-end">
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300" onclick="return confirm('Are you sure you want to delete this disclosure?')">
                {{ __('Delete Disclosure') }}
            </button>
        </div>
    </form>
</div>
@endsection
