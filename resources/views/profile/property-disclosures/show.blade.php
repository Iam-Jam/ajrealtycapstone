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
        <h1 class="text-3xl font-bold mb-4 md:mb-0">Property Disclosure Details</h1> <!-- Added mb-4 for mobile spacing -->
        <a href="{{ route('profile.submitted-forms') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center mt-4">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to My Submitted Forms
        </a>
    </div>

    <div class="bg-white shadow-md rounded my-6">
        <!-- Seller and Property Information -->
        <div class="bg-primary text-white p-4 rounded-t-lg">
            <h2 class="text-2xl font-semibold">{{ __('Seller and Property Information') }}</h2>
        </div>
        <table class="text-left w-full border-collapse">
            <tr>
                <th class="py-4 px-6 bg-grey-lightest font-bold text-sm text-grey-dark border-b border-grey-light">Seller's Name</th>
                <td class="py-4 px-6 border-b border-grey-light">{{ $propertyDisclosure->seller_name }}</td>
            </tr>
            <tr>
                <th class="py-4 px-6 bg-grey-lightest font-bold text-sm text-grey-dark border-b border-grey-light">Property Address</th>
                <td class="py-4 px-6 border-b border-grey-light">{{ $propertyDisclosure->property_address }}</td>
            </tr>
        </table>

        <!-- Structural Conditions -->
        <div class="bg-primary text-white p-4 border-t border-grey-light">
            <h2 class="text-2xl font-semibold">{{ __('Structural Conditions') }}</h2>
        </div>
        <div class="p-4">
            @php
                $structuralIssues = json_decode($propertyDisclosure->structural_issues, true) ?? [];
            @endphp
            @foreach ($structuralItems as $key => $item)
                <div class="flex items-center mb-2">
                    <span class="w-6 h-6 flex items-center justify-center border rounded mr-2 {{ in_array($key, $structuralIssues) ? 'bg-blue-500 text-white' : 'border-gray-300' }}">
                        @if(in_array($key, $structuralIssues))
                            &#10003;
                        @endif
                    </span>
                    <span class="text-sm text-gray-700">{{ __($item) }}</span>
                </div>
            @endforeach
        </div>

        <!-- Systems and Utilities -->
        <div class="bg-primary text-white p-4 border-t border-grey-light">
            <h2 class="text-2xl font-semibold">{{ __('Systems and Utilities') }}</h2>
        </div>
        <div class="p-4">
            @php
                $systemIssues = json_decode($propertyDisclosure->system_issues, true) ?? [];
            @endphp
            @foreach ($systemItems as $key => $item)
                <div class="flex items-center mb-2">
                    <span class="w-6 h-6 flex items-center justify-center border rounded mr-2 {{ in_array($key, $systemIssues) ? 'bg-blue-500 text-white' : 'border-gray-300' }}">
                        @if(in_array($key, $systemIssues))
                            &#10003;
                        @endif
                    </span>
                    <span class="text-sm text-gray-700">{{ __($item) }}</span>
                </div>
            @endforeach
        </div>

        <!-- Environmental Concerns -->
        <div class="bg-primary text-white p-4 border-t border-grey-light">
            <h2 class="text-2xl font-semibold">{{ __('Environmental Concerns') }}</h2>
        </div>
        <div class="p-4">
            @php
                $environmentalIssues = json_decode($propertyDisclosure->environmental_issues, true) ?? [];
            @endphp
            @foreach ($environmentalItems as $key => $item)
                <div class="flex items-center mb-2">
                    <span class="w-6 h-6 flex items-center justify-center border rounded mr-2 {{ in_array($key, $environmentalIssues) ? 'bg-blue-500 text-white' : 'border-gray-300' }}">
                        @if(in_array($key, $environmentalIssues))
                            &#10003;
                        @endif
                    </span>
                    <span class="text-sm text-gray-700">{{ __($item) }}</span>
                </div>
            @endforeach
        </div>

        <!-- Additional Issues -->
        <div class="bg-primary text-white p-4 border-t border-grey-light">
            <h2 class="text-2xl font-semibold">{{ __('Additional Issues or Comments') }}</h2>
        </div>
        <div class="p-4">
            <p class="text-sm text-gray-700">{{ $propertyDisclosure->additional_issues ?: 'No additional issues reported.' }}</p>
        </div>
    </div>

    <div class="mt-4 flex justify-end">
        <a href="{{ route('profile.property-disclosures.edit', $propertyDisclosure) }}" class="bg-primary hover:bg-opacity-90 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
            Edit Disclosure Statement
        </a>
    </div>
</div>
@endsection
