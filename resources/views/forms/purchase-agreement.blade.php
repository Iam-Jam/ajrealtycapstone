@php
$contingencies = [
    'financing' => 'Financing Contingency',
    'inspection' => 'Home Inspection Contingency',
    'appraisal' => 'Appraisal Contingency',
    'sale' => 'Home Sale Contingency'
];
@endphp

<form method="POST" action="{{ route('purchase-agreements.store') }}">
    @csrf
    <div class="flex items-center justify-center mb-6">
        <svg class="h-8 w-8 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
        </svg>
        <h1 class="text-3xl font-bold text-primary">AJ Real Estate</h1>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div>
        <label for="property_id" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Property ID') }}</label>
        <input type="text" id="property_id" name="property_id" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('property_id') }}">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="buyer_name" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Buyer\'s Name') }}</label>
            <input type="text" id="buyer_name" name="buyer_name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('buyer_name') }}">
        </div>
        <div>
            <label for="seller_name" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Seller\'s Name') }}</label>
            <input type="text" id="seller_name" name="seller_name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('seller_name') }}">
        </div>
    </div>

    <div>
        <label for="property_address" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Property Address') }}</label>
        <input type="text" id="property_address" name="property_address" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('property_address') }}">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="purchase_price" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Purchase Price (₱)') }}</label>
            <input type="number" id="purchase_price" name="purchase_price" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" step="0.01" value="{{ old('purchase_price') }}">
        </div>
        <div>
            <label for="earnest_money" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Earnest Money Deposit (₱)') }}</label>
            <input type="number" id="earnest_money" name="earnest_money" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" step="0.01" value="{{ old('earnest_money') }}">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="closing_date" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Closing Date') }}</label>
            <input type="date" id="closing_date" name="closing_date" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" min="{{ date('Y-m-d') }}" value="{{ old('closing_date', date('Y-m-d')) }}">
        </div>
        <div>
            <label for="possession_date" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Possession Date') }}</label>
            <input type="date" id="possession_date" name="possession_date" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" min="{{ date('Y-m-d') }}" value="{{ old('possession_date', date('Y-m-d')) }}">
        </div>
    </div>

    <div>
        <label class="block text-gray-700 text-sm font-bold mb-2">{{ __('Contingencies') }}</label>
        <div class="space-y-2">
            @foreach($contingencies as $value => $label)
                <div class="flex items-center">
                    <input type="checkbox" id="{{ $value }}_contingency" name="contingencies[]" value="{{ $value }}" class="mr-2" {{ in_array($value, old('contingencies', [])) ? 'checked' : '' }}>
                    <label for="{{ $value }}_contingency">{{ __($label) }}</label>
                </div>
            @endforeach
        </div>
    </div>

    <div>
        <label for="additional_terms" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Additional Terms and Conditions') }}</label>
        <textarea id="additional_terms" name="additional_terms" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('additional_terms') }}</textarea>
    </div>

    <div class="form-group">
        <div class="form-check">
            <input type="checkbox" name="agree_terms" id="agree_terms" class="form-check-input" value="1" {{ old('agree_terms') ? 'checked' : '' }} required>
            <label class="form-check-label" for="agree_terms">
                I agree to the terms and conditions of this purchase agreement
            </label>
        </div>
        @error('agree_terms')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="flex justify-end">
        <button type="submit" class="bg-primary hover:bg-opacity-90 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
            {{ __('Submit Purchase Agreement') }}
        </button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const closingDateInput = document.getElementById('closing_date');
    const possessionDateInput = document.getElementById('possession_date');

    closingDateInput.addEventListener('change', function() {
        possessionDateInput.min = this.value;
        if (possessionDateInput.value < this.value) {
            possessionDateInput.value = this.value;
        }
    });
});
</script>
