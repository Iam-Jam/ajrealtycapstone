<form action="{{ route('forms.submit', ['formType' => 'contact-inquiry']) }}" method="POST" class="space-y-6">
    @csrf

    <div class="flex items-center justify-center mb-6">
        <svg class="h-8 w-8 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
        </svg>
        <h1 class="text-3xl font-bold text-primary">AJ Real Estate</h1>
    </div>

    <div class="bg-primary text-white p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">{{ __('Your Information') }}</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="full_name" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Full Name') }}</label>
            <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('full_name') border-red-500 @enderror">
            @error('full_name')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Email Address') }}</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror">
            @error('email')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Phone Number') }}</label>
        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('phone') border-red-500 @enderror">
        @error('phone')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="property_address" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Property Address (if applicable)') }}</label>
        <input type="text" id="property_address" name="property_address" value="{{ old('property_address') }}"
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>

    <div>
        <label for="inquiry_type" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Inquiry Type') }}</label>
        <select id="inquiry_type" name="inquiry_type" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('inquiry_type') border-red-500 @enderror">
            <option value="">{{ __('Select an inquiry type') }}</option>
            <option value="general" {{ old('inquiry_type') == 'general' ? 'selected' : '' }}>{{ __('General Question') }}</option>
            <option value="property" {{ old('inquiry_type') == 'property' ? 'selected' : '' }}>{{ __('Specific Property Inquiry') }}</option>
            <option value="showing" {{ old('inquiry_type') == 'showing' ? 'selected' : '' }}>{{ __('Schedule a Showing') }}</option>
            <option value="selling" {{ old('inquiry_type') == 'selling' ? 'selected' : '' }}>{{ __('Selling a Property') }}</option>
            <option value="other" {{ old('inquiry_type') == 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
        </select>
        @error('inquiry_type')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="message" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Your Message') }}</label>
        <textarea id="message" name="message" rows="4" required
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
        @error('message')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center">
        <input type="checkbox" id="subscribe_newsletter" name="subscribe_newsletter" value="1" {{ old('subscribe_newsletter') ? 'checked' : '' }} class="mr-2">
        <label for="subscribe_newsletter" class="text-sm text-gray-700">{{ __('Subscribe to our newsletter for updates and listings') }}</label>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="flex justify-end">
        <button type="submit" class="bg-primary hover:bg-opacity-90 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
            {{ __('Submit Inquiry') }}
        </button>
    </div>
</form>
