<div id="listing-agreement-form" class="form-container">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">{{ __('Create Listing Agreement') }}</h2>

    <form action="{{ route('listing-agreements.store') }}" method="POST" class="space-y-6">
        @csrf


        <div class="flex items-center justify-center mb-6">
            <svg class="h-8 w-8 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
            </svg>
            <h1 class="text-3xl font-bold text-primary">AJ Real Estate</h1>
        </div>

        
        <!-- Seller Information -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-primary text-white p-4">
                <h3 class="text-xl font-semibold">{{ __('Seller Information') }}</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="seller_name" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Seller\'s Full Name') }}</label>
                    <input type="text" id="seller_name" name="seller_name" value="{{ old('seller_name') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="seller_phone" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Seller\'s Phone Number') }}</label>
                    <input type="tel" id="seller_phone" name="seller_phone" value="{{ old('seller_phone') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <!-- Property Information -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-primary text-white p-4">
                <h3 class="text-xl font-semibold">{{ __('Property Information') }}</h3>
            </div>
            <div class="p-6 space-y-6">
                <div>
                    <label for="property_address" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Property Address') }}</label>
                    <input type="text" id="property_address" name="property_address" value="{{ old('property_address') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="property_city" class="block text-gray-700 text-sm font-bold mb-2">{{ __('City') }}</label>
                        <input type="text" id="property_city" name="property_city" value="{{ old('property_city') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="property_state" class="block text-gray-700 text-sm font-bold mb-2">{{ __('State') }}</label>
                        <input type="text" id="property_state" name="property_state" value="{{ old('property_state') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="property_zip" class="block text-gray-700 text-sm font-bold mb-2">{{ __('ZIP Code') }}</label>
                        <input type="text" id="property_zip" name="property_zip" value="{{ old('property_zip') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>
        </div>

        <!-- Listing Details -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-primary text-white p-4">
                <h3 class="text-xl font-semibold">{{ __('Listing Details') }}</h3>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="listing_price" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Listing Price ($)') }}</label>
                        <input type="number" id="listing_price" name="listing_price" value="{{ old('listing_price') }}" min="0" step="1000" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="commission_rate" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Commission Rate (%)') }}</label>
                        <input type="number" id="commission_rate" name="commission_rate" value="{{ old('commission_rate') }}" min="0" max="100" step="0.1" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="listing_start_date" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Listing Start Date') }}</label>
                        <input type="date" id="listing_start_date" name="listing_start_date" value="{{ old('listing_start_date') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="listing_end_date" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Listing End Date') }}</label>
                        <input type="date" id="listing_end_date" name="listing_end_date" value="{{ old('listing_end_date') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div>
                    <label for="property_description" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Property Description') }}</label>
                    <textarea id="property_description" name="property_description" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('property_description') }}</textarea>
                </div>
                <div>
                    <label for="special_conditions" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Special Conditions or Terms') }}</label>
                    <textarea id="special_conditions" name="special_conditions" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('special_conditions') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Agreement -->
        <div class="flex items-center">
            <input type="checkbox" id="agree_terms" name="agree_terms" required class="mr-2">
            <label for="agree_terms" class="text-sm text-gray-700">{{ __('I agree to the terms and conditions of this listing agreement') }}</label>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-primary hover:bg-opacity-90 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-300">
                {{ __('Submit Listing Agreement') }}
            </button>
        </div>
    </form>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mt-6" role="alert">
            <p class="font-bold">{{ __('Whoops! There were some problems with your input.') }}</p>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

<!-- Global Notification Container -->
<div id="global-notification" class="fixed inset-x-0 top-20 flex items-center justify-center px-4 py-6 z-50 pointer-events-none hidden">
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg max-w-md w-full pointer-events-auto">
        <div class="flex items-center">
            <div class="text-lg font-bold mr-2">Success!</div>
            <p id="notification-message"></p>
            <button onclick="closeNotification()" class="ml-auto text-green-700 hover:text-green-900">
                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/>
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
    function showNotification(message) {
        const notification = document.getElementById('global-notification');
        const messageElement = document.getElementById('notification-message');
        messageElement.textContent = message;
        notification.classList.remove('hidden');

        // Auto-hide after 5 seconds
        setTimeout(closeNotification, 5000);
    }

    function closeNotification() {
        const notification = document.getElementById('global-notification');
        notification.classList.add('hidden');
    }

    // Check for notification on page load
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            showNotification("{{ session('success') }}");
        @endif
    });
</script>
