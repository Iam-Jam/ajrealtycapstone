<form action="{{ route('forms.submit', ['formType' => 'digital-signature']) }}" method="POST" class="space-y-6">
    @csrf

    <div class="flex items-center justify-center mb-6">
        <svg class="h-8 w-8 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
        </svg>
        <h1 class="text-3xl font-bold text-primary">AJ Real Estate</h1>
    </div>


    <div class="bg-primary text-white p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">{{ __('Client Information') }}</h2>
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
        <h2 class="text-2xl font-semibold">{{ __('Authorization Details') }}</h2>
    </div>

    <div class="space-y-4">
        <p class="text-gray-700">{{ __('By completing this authorization, you agree to the use of electronic signatures for real estate documents. Please read the following statements carefully:') }}</p>

        <div class="flex items-start">
            <input type="checkbox" id="consent_esign" name="consent_esign" required class="mt-1 mr-2">
            <label for="consent_esign" class="text-sm text-gray-700">{{ __('I consent to use electronic signatures on documents related to real estate transactions with AJ Real Estate. I understand that my electronic signature will be legally binding, equivalent to my handwritten signature.') }}</label>
        </div>

        <div class="flex items-start">
            <input type="checkbox" id="consent_documents" name="consent_documents" required class="mt-1 mr-2">
            <label for="consent_documents" class="text-sm text-gray-700">{{ __('I agree to receive and sign documents electronically, including but not limited to purchase agreements, disclosures, and other related real estate documents.') }}</label>
        </div>

        <div class="flex items-start">
            <input type="checkbox" id="understand_right" name="understand_right" required class="mt-1 mr-2">
            <label for="understand_right" class="text-sm text-gray-700">{{ __('I understand that I have the right to request paper copies of any documents I sign electronically, and that I may withdraw this consent at any time by notifying AJ Real Estate in writing.') }}</label>
        </div>

        <div class="flex items-start">
            <input type="checkbox" id="software_requirements" name="software_requirements" required class="mt-1 mr-2">
            <label for="software_requirements" class="text-sm text-gray-700">{{ __('I confirm that I have the necessary software and hardware to receive, view, and sign electronic documents (e.g., PDF reader, email access, internet connection).') }}</label>
        </div>
    </div>

    <div>
        <label for="signature" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Electronic Signature') }}</label>
        <input type="text" id="signature" name="signature" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="{{ __('Type your full name as your electronic signature') }}">
    </div>

    <div>
        <label for="signature_date" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Date') }}</label>
        <input type="date" id="signature_date" name="signature_date" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>

    <div class="flex justify-end">
        <button type="submit" class="bg-primary hover:bg-opacity-90 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
            {{ __('Submit Authorization') }}
        </button>
    </div>
</form>
