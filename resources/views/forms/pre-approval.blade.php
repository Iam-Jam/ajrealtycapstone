<form action="{{ route('forms.submit', ['formType' => 'pre-approval']) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf


    <div class="flex items-center justify-center mb-6">
        <svg class="h-8 w-8 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
        </svg>
        <h1 class="text-3xl font-bold text-primary">AJ Real Estate</h1>
    </div>

    

    <div class="bg-primary text-white p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">{{ __('Buyer Information') }}</h2>
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

    <div>
        <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Phone Number') }}</label>
        <input type="tel" id="phone" name="phone" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>

    <div class="bg-primary text-white p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">{{ __('Pre-Approval Details') }}</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="lender_name" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Lender Name') }}</label>
            <input type="text" id="lender_name" name="lender_name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div>
            <label for="approval_date" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Approval Date') }}</label>
            <input type="date" id="approval_date" name="approval_date" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
    </div>

    <div>
        <label for="approval_amount" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Approved Amount ($)') }}</label>
        <input type="number" id="approval_amount" name="approval_amount" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>

    <div>
        <label for="pre_approval_letter" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Upload Pre-Approval Letter') }}</label>
        <input type="file" id="pre_approval_letter" name="pre_approval_letter" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
        <p class="text-sm text-gray-600 mt-1">{{ __('Accepted file types: PDF, DOC, DOCX, JPG, JPEG, PNG. Max file size: 5MB.') }}</p>
    </div>

    <div>
        <label for="additional_notes" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Additional Notes') }}</label>
        <textarea id="additional_notes" name="additional_notes" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
    </div>

    <div class="flex items-center">
        <input type="checkbox" id="terms_agreement" name="terms_agreement" required class="mr-2">
        <label for="terms_agreement" class="text-sm text-gray-700">{{ __('I confirm that the information provided is accurate and I authorize the real estate agency to verify this pre-approval with the lender if necessary.') }}</label>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="bg-primary hover:bg-opacity-90 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
            {{ __('Upload Pre-Approval Letter') }}
        </button>
    </div>
</form>
