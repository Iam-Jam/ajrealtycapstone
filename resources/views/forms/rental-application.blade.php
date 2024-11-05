<form action="{{ route('forms.submit', ['formType' => 'rental-application']) }}" method="POST" class="space-y-6">
    @csrf

    <div class="flex items-center justify-center mb-6">
        <svg class="h-8 w-8 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
        </svg>
        <h1 class="text-3xl font-bold text-primary">AJ Real Estate</h1>
    </div>


    <!-- Personal Information -->
    <div class="bg-primary text-white p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">{{ __('Personal Information') }}</h2>
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
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Phone Number') }}</label>
            <input type="tel" id="phone" name="phone" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div>
            <label for="dob" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Date of Birth') }}</label>
            <input type="date" id="dob" name="dob" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
    </div>

    <!-- Current Address -->
    <div class="bg-primary text-white p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">{{ __('Current Address') }}</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="current_address" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Street Address') }}</label>
            <input type="text" id="current_address" name="current_address" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div>
            <label for="current_city" class="block text-gray-700 text-sm font-bold mb-2">{{ __('City') }}</label>
            <input type="text" id="current_city" name="current_city" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="current_state" class="block text-gray-700 text-sm font-bold mb-2">{{ __('State') }}</label>
            <input type="text" id="current_state" name="current_state" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div>
            <label for="current_zip" class="block text-gray-700 text-sm font-bold mb-2">{{ __('ZIP Code') }}</label>
            <input type="text" id="current_zip" name="current_zip" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
    </div>

    <!-- Employment Information -->
    <div class="bg-primary text-white p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">{{ __('Employment Information') }}</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="employer" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Current Employer') }}</label>
            <input type="text" id="employer" name="employer" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div>
            <label for="job_title" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Job Title') }}</label>
            <input type="text" id="job_title" name="job_title" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="employment_length" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Length of Employment') }}</label>
            <input type="text" id="employment_length" name="employment_length" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div>
            <label for="monthly_income" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Monthly Income') }}</label>
            <input type="number" id="monthly_income" name="monthly_income" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
    </div>

    <!-- References -->
    <div class="bg-primary text-white p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">{{ __('References') }}</h2>
    </div>
    <div class="space-y-6">
        @for ($i = 1; $i <= 2; $i++)
            <div class="border-b pb-4">
                <h3 class="text-lg font-semibold mb-2">{{ __('Reference') }} {{ $i }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="ref{{ $i }}_name" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Name') }}</label>
                        <input type="text" id="ref{{ $i }}_name" name="ref{{ $i }}_name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label for="ref{{ $i }}_relationship" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Relationship') }}</label>
                        <input type="text" id="ref{{ $i }}_relationship" name="ref{{ $i }}_relationship" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label for="ref{{ $i }}_phone" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Phone') }}</label>
                        <input type="tel" id="ref{{ $i }}_phone" name="ref{{ $i }}_phone" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label for="ref{{ $i }}_email" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Email') }}</label>
                        <input type="email" id="ref{{ $i }}_email" name="ref{{ $i }}_email" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>
            </div>
        @endfor
    </div>

    <!-- Additional Information -->
    <div>
        <label for="additional_info" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Additional Information') }}</label>
        <textarea id="additional_info" name="additional_info" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
    </div>

    <div class="flex items-center">
        <input type="checkbox" id="agree_terms" name="agree_terms" required class="mr-2">
        <label for="agree_terms" class="text-sm text-gray-700">{{ __('I confirm that the information provided is accurate and complete') }}</label>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="bg-primary hover:bg-opacity-90 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
            {{ __('Submit Rental Application') }}
        </button>
    </div>
</form>
