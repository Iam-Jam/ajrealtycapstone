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

<form action="{{ route('forms.submit', 'property-disclosure') }}" method="POST">
    @csrf
    <div class="flex items-center justify-center mb-6">
        <svg class="h-8 w-8 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
        </svg>
        <h1 class="text-3xl font-bold text-primary">AJ Real Estate</h1>
    </div>

    <!-- Seller and Property Information -->
    <div class="bg-primary text-white p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">{{ __('Seller and Property Information') }}</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="seller_name" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Seller\'s Name') }}</label>
            <input type="text" id="seller_name" name="seller_name" value="{{ old('seller_name') }}" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('seller_name') border-red-500 @enderror">
            @error('seller_name')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="property_address"
                class="block text-gray-700 text-sm font-bold mb-2">{{ __('Property Address') }}</label>
            <input type="text" id="property_address" name="property_address" value="{{ old('property_address') }}"
                required
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
    <div class="space-y-4">
        @foreach ($structuralItems as $key => $item)
            <div class="flex items-center">
                <input type="checkbox" id="{{ $key }}" name="structural[{{ $key }}]" value="1"
                    {{ old("structural.$key") ? 'checked' : '' }} class="mr-2">
                <label for="{{ $key }}" class="text-sm text-gray-700">{{ __($item) }}</label>
            </div>
        @endforeach
    </div>

    <!-- Systems and Utilities -->
    <div class="bg-primary text-white p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">{{ __('Systems and Utilities') }}</h2>
    </div>
    <div class="space-y-4">
        @foreach ($systemItems as $key => $item)
            <div class="flex items-center">
                <input type="checkbox" id="{{ $key }}" name="systems[{{ $key }}]" value="1"
                    {{ old("systems.$key") ? 'checked' : '' }} class="mr-2">
                <label for="{{ $key }}" class="text-sm text-gray-700">{{ __($item) }}</label>
            </div>
        @endforeach
    </div>

    <!-- Environmental Concerns -->
    <div class="bg-primary text-white p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">{{ __('Environmental Concerns') }}</h2>
    </div>
    <div class="space-y-4">
        @foreach ($environmentalItems as $key => $item)
            <div class="flex items-center">
                <input type="checkbox" id="{{ $key }}" name="environmental[{{ $key }}]"
                    value="1" {{ old("environmental.$key") ? 'checked' : '' }} class="mr-2">
                <label for="{{ $key }}" class="text-sm text-gray-700">{{ __($item) }}</label>
            </div>
        @endforeach
    </div>

    <!-- Additional Issues -->
    <div>
        <label for="additional_issues"
            class="block text-gray-700 text-sm font-bold mb-2">{{ __('Additional Issues or Comments') }}</label>
        <textarea id="additional_issues" name="additional_issues" rows="4"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('additional_issues') border-red-500 @enderror">{{ old('additional_issues') }}</textarea>
        @error('additional_issues')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Confirmation -->
    <div class="flex items-center">
        <input type="checkbox" id="confirm_disclosure" name="confirm_disclosure" required
            class="mr-2 @error('confirm_disclosure') border-red-500 @enderror">
        <label for="confirm_disclosure"
            class="text-sm text-gray-700">{{ __('I confirm that the information provided in this disclosure statement is true and accurate to the best of my knowledge.') }}</label>
    </div>
    @error('confirm_disclosure')
        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
    @enderror

    <div class="flex justify-end">
        <button type="submit"
            class="bg-primary hover:bg-opacity-90 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
            {{ __('Submit Disclosure Statement') }}
        </button>
    </div>
</form>
