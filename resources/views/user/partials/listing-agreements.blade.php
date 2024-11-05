<h2 class="text-3xl font-semibold mb-6">Listing Agreements</h2>
@if($listingAgreements->isEmpty())
    <p class="text-lg">No listing agreements submitted.</p>
@else
    <p class="text-lg mb-6">Number of listing agreements: {{ $listingAgreements->count() }}</p>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($listingAgreements as $agreement)
            <div class="bg-white bg-opacity-25 rounded-lg shadow-lg p-6 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                <h3 class="text-xl font-semibold mb-2">{{ $agreement->property_address }}</h3>
                <p class="text-sm mb-4">Submitted on: {{ $agreement->created_at->format('M d, Y') }}</p>
                <div class="flex justify-end">
                    <a href="{{ route('listings.show', $agreement) }}"
                       class="inline-flex items-center px-4 py-2 bg-[#14532d] text-white rounded-lg hover:bg-[#052e16] transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <span class="text-sm font-semibold">View Details</span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endif
