@php
$aspects = [
    'location' => 'Location',
    'condition' => 'Property Condition',
    'layout' => 'Layout and Space',
    'amenities' => 'Amenities',
    'value' => 'Value for Money'
];
@endphp

<form action="{{ route('forms.submit', ['formType' => 'feedback']) }}" method="POST" class="space-y-6">
    @csrf


    <div class="flex items-center justify-center mb-6">
        <svg class="h-8 w-8 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
        </svg>
        <h1 class="text-3xl font-bold text-primary">AJ Real Estate</h1>
    </div>



    <div class="bg-primary text-white p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">{{ __('Viewer Information') }}</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="full_name" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Full Name') }}</label>
            <input type="text" id="full_name" name="full_name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div>
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Email Address') }}</label>
            <input type="email" id="email" name="email" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
    </div>

    <div class="bg-primary text-white p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">{{ __('Property Information') }}</h2>
    </div>

    <div>
        <label for="property_address" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Property Address') }}</label>
        <input type="text" id="property_address" name="property_address" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>

    <div>
        <label for="viewing_date" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Viewing Date') }}</label>
        <input type="date" id="viewing_date" name="viewing_date" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>

    <div class="bg-primary text-white p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">{{ __('Your Feedback') }}</h2>
    </div>

    <div>
        <label for="overall_impression" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Overall Impression') }}</label>
        <select id="overall_impression" name="overall_impression" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option value="">{{ __('Select your overall impression') }}</option>
            <option value="excellent">{{ __('Excellent') }}</option>
            <option value="very_good">{{ __('Very Good') }}</option>
            <option value="good">{{ __('Good') }}</option>
            <option value="fair">{{ __('Fair') }}</option>
            <option value="poor">{{ __('Poor') }}</option>
        </select>
    </div>

    <div class="space-y-4">
        <p class="block text-gray-700 text-sm font-bold">{{ __('Please rate the following aspects:') }}</p>
        @foreach($aspects as $key => $aspect)
            <div>
                <label for="{{ $key }}" class="block text-gray-700 text-sm mb-2">{{ __($aspect) }}</label>
                <select id="{{ $key }}" name="ratings[{{ $key }}]" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">{{ __('Select a rating') }}</option>
                    <option value="5">{{ __('5 - Excellent') }}</option>
                    <option value="4">{{ __('4 - Very Good') }}</option>
                    <option value="3">{{ __('3 - Good') }}</option>
                    <option value="2">{{ __('2 - Fair') }}</option>
                    <option value="1">{{ __('1 - Poor') }}</option>
                </select>
            </div>
        @endforeach
    </div>

    <div>
        <label for="liked_most" class="block text-gray-700 text-sm font-bold mb-2">{{ __('What did you like most about the property?') }}</label>
        <textarea id="liked_most" name="liked_most" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
    </div>

    <div>
        <label for="improvements" class="block text-gray-700 text-sm font-bold mb-2">{{ __('What could be improved?') }}</label>
        <textarea id="improvements" name="improvements" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
    </div>

    <div>
        <label for="additional_comments" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Additional Comments') }}</label>
        <textarea id="additional_comments" name="additional_comments" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
    </div>

    <div class="flex items-center">
        <input type="checkbox" id="follow_up" name="follow_up" class="mr-2">
        <label for="follow_up" class="text-sm text-gray-700">{{ __('I would like a follow-up regarding this property') }}</label>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="bg-primary hover:bg-opacity-90 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
            {{ __('Submit Feedback') }}
        </button>
    </div>
</form>
