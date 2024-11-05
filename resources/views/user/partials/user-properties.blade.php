@if(isset($userListings) && $userListings->count() > 0)
    <p class="text-lg mb-6">Number of property listings: {{ $userListings->count() }}</p>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($userListings as $listing)
            <div class="bg-white bg-opacity-25 rounded-lg shadow-lg p-6 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                @if($listing->images->count() > 0)
                    <img src="{{ Storage::url($listing->images->first()->image_path) }}"
                         alt="{{ $listing->title }}"
                         class="w-full h-48 object-cover rounded-lg mb-4">
                @endif
                <h3 class="text-xl font-semibold mb-2">{{ $listing->title }}</h3>
                <p class="text-sm mb-2">{{ $listing->city }}</p>
                <p class="text-lg font-bold mb-4">₱{{ number_format($listing->price, 2) }}</p>

                <!-- Status Information -->
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm">Status:</span>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full
                            {{ $listing->status === 'approved'
                                ? 'bg-[#14532d] text-white'
                                : ($listing->status === 'pending'
                                    ? 'bg-[#052e16] text-white'
                                    : 'bg-red-500 text-white') }}">
                            {{ ucfirst($listing->status) }}
                        </span>
                    </div>
                    <p class="text-sm">Submitted: {{ $listing->created_at->format('M d, Y') }}</p>
                    @if($listing->status === 'approved')
                        <p class="text-sm text-green-400">
                            Approved: {{ $listing->approved_at ? $listing->approved_at->format('M d, Y') : 'N/A' }}
                        </p>
                    @elseif($listing->status === 'pending')
                        <p class="text-sm text-yellow-400">
                            Awaiting admin approval
                        </p>
                    @endif
                </div>

                <!-- Additional Status Tags -->
                <div class="flex flex-wrap gap-2 mb-4">
                    @if($listing->is_featured)
                        <span class="px-2 py-1 text-xs font-semibold bg-yellow-500 text-white rounded-full">
                            Featured
                        </span>
                    @endif
                    @if($listing->is_exclusive)
                        <span class="px-2 py-1 text-xs font-semibold bg-purple-500 text-white rounded-full">
                            Exclusive
                        </span>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between items-center">
                    <a href="{{ route('list-sell-property.show', $listing) }}"
                       class="flex items-center text-white hover:text-[#14532d] transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <span class="text-sm font-semibold">View Details</span>
                    </a>

                    @if($listing->status === 'pending')
                        <a href="{{ route('list-sell-property.edit', $listing) }}"
                           class="flex items-center text-white hover:text-[#14532d] transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span class="text-sm font-semibold">Edit</span>
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@else
    <p class="text-lg">No property listings submitted.</p>
@endif
