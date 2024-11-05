@php
$responsibilities = [
    'property_search' => 'Conduct property searches based on buyer\'s criteria',
    'market_analysis' => 'Provide market analysis and property valuations',
    'negotiate' => 'Negotiate purchase terms on behalf of the buyer',
    'paperwork' => 'Prepare and explain all necessary paperwork',
    'coordinate' => 'Coordinate property inspections and appraisals',
    'communicate' => 'Maintain regular communication with the buyer',
    'advise' => 'Provide professional advice throughout the buying process',
    'closing' => 'Assist with the closing process'
];
@endphp

<form action="{{ route('forms.submit', ['formType' => 'buyers-agency']) }}" method="POST" class="space-y-6">
    @csrf

    <div class="flex items-center justify-center mb-6">
        <svg class="h-8 w-8 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
        </svg>
        <h1 class="text-3xl font-bold text-primary">AJ Real Estate</h1>
    </div>


    <div class="bg-primary text-white p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">{{ __('Buyer and Agent Information') }}</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="buyer_name" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Buyer\'s Name') }}</label>
            <input type="text" id="buyer_name" name="buyer_name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div>
            <label for="agent_name" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Agent\'s Name') }}</label>
            <input type="text" id="agent_name" name="agent_name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
    </div>

    <div>
        <label for="brokerage_name" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Brokerage Name') }}</label>
        <input type="text" id="brokerage_name" name="brokerage_name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>

    <div class="bg-primary text-white p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">{{ __('Agreement Details') }}</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Agreement Start Date') }}</label>
            <input type="date" id="start_date" name="start_date" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div>
            <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Agreement End Date') }}</label>
            <input type="date" id="end_date" name="end_date" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
    </div>

    <div>
        <label class="block text-gray-700 text-sm font-bold mb-2">{{ __('Agent\'s Responsibilities') }}</label>
        <div class="mt-2 space-y-2">
            @foreach($responsibilities as $key => $responsibility)
                <div class="flex items-center">
                    <input type="checkbox" id="{{ $key }}" name="responsibilities[]" value="{{ $key }}" class="mr-2">
                    <label for="{{ $key }}" class="text-sm text-gray-700">{{ $responsibility }}</label>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-primary text-white p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">{{ __('Compensation') }}</h2>
    </div>

    <div>
        <label for="compensation" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Agent Compensation') }}</label>
        <select id="compensation" name="compensation" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option value="">{{ __('Select compensation method') }}</option>
            <option value="commission">{{ __('Commission (% of purchase price)') }}</option>
            <option value="flat_fee">{{ __('Flat Fee') }}</option>
            <option value="hourly">{{ __('Hourly Rate') }}</option>
        </select>
    </div>

    <div>
        <label for="compensation_details" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Compensation Details') }}</label>
        <input type="text" id="compensation_details" name="compensation_details" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="{{ __('E.g., 3% of purchase price or $5000 flat fee') }}">
    </div>

    <div>
        <label for="additional_terms" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Additional Terms and Conditions') }}</label>
        <textarea id="additional_terms" name="additional_terms" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
    </div>

    <div class="flex items-center">
        <input type="checkbox" id="agree_terms" name="agree_terms" required class="mr-2">
        <label for="agree_terms" class="text-sm text-gray-700">{{ __('I agree to the terms and conditions of this Buyer\'s Agency Agreement') }}</label>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="bg-primary hover:bg-opacity-90 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
            {{ __('Submit Buyer\'s Agency Agreement') }}
        </button>
    </div>
</form>
