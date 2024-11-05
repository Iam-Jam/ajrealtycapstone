<!-- Main Container -->
<div class="space-y-6">
    <h2 class="text-2xl font-semibold text-white mb-6">Manage Property Listings</h2>

    <!-- All Listed Properties Section -->
    <div class="bg-white/10 border border-green-700 rounded-lg p-6 backdrop-filter backdrop-blur-md">
        <div class="mb-6">
            <h3 class="text-xl text-white">All Listed Properties</h3>

            <!-- Pending Approval Section -->
            <div class="mt-6">
                <h4 class="text-yellow-400 font-semibold mb-4">Pending Approval ({{ $pendingListings?->count() ?? 0 }})</h4>

                @if(!empty($pendingListings) && $pendingListings->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($pendingListings as $listing)
                            <div class="bg-white/5 border border-green-600 rounded-lg p-4">
                                <!-- Property Image -->
                                <div class="relative h-48 mb-4">
                                    @if($listing->images?->isNotEmpty())
                                        <img src="{{ asset($listing->images->first()->image_path) }}"
                                             alt="{{ $listing->title }}"
                                             class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <div class="w-full h-full bg-gray-600 rounded-lg flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <span class="absolute top-2 right-2 px-2 py-1 bg-yellow-500 text-white text-xs font-semibold rounded-full">
                                        Pending
                                    </span>
                                </div>

                                <!-- Property Details -->
                                <h3 class="text-lg font-semibold text-white mb-2">{{ $listing->title }}</h3>
                                <div class="space-y-1 text-gray-300 text-sm mb-4">
                                    <p>Submitted by: {{ $listing->user?->name }}</p>
                                    <p>User Type: {{ ucfirst($listing->user?->user_type ?? 'N/A') }}</p>
                                    <p>{{ $listing->city }}</p>
                                    <p class="text-lg font-bold">₱{{ number_format($listing->price, 2) }}</p>
                                    <p class="text-xs">{{ $listing->created_at?->format('M d, Y') }}</p>
                                </div>

                                <!-- Action Buttons -->
                                <div class="grid grid-cols-2 gap-2">
                                    <form action="{{ route('list-sell-property.toggle-status', $listing) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition duration-300">
                                            Approve
                                        </button>
                                    </form>
                                    <a href="{{ route('list-sell-property.show', $listing) }}"
                                       class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-300 text-center">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-white text-center py-4">No pending listings found.</p>
                @endif
            </div>

            <!-- Approved Listings Section -->
            <div class="mt-8">
                <h4 class="text-green-400 font-semibold mb-4">Approved Listings ({{ $approvedListings?->count() ?? 0 }})</h4>

                @if(!empty($approvedListings) && $approvedListings->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($approvedListings as $listing)
                            <div class="bg-white/5 border border-green-600 rounded-lg p-4">
                                <!-- Property Image -->
                                <div class="relative h-48 mb-4">
                                    @if($listing->images?->isNotEmpty())
                                        <img src="{{ asset($listing->images->first()->image_path) }}"
                                             alt="{{ $listing->title }}"
                                             class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <div class="w-full h-full bg-gray-600 rounded-lg flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="absolute top-2 right-2 flex flex-wrap gap-1">
                                        <span class="px-2 py-1 bg-green-500 text-white text-xs font-semibold rounded-full">
                                            Approved
                                        </span>
                                        @if($listing->is_featured)
                                            <span class="px-2 py-1 bg-purple-500 text-white text-xs font-semibold rounded-full">
                                                Featured
                                            </span>
                                        @endif
                                        @if($listing->is_exclusive)
                                            <span class="px-2 py-1 bg-yellow-500 text-white text-xs font-semibold rounded-full">
                                                Exclusive
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Property Details -->
                                <h3 class="text-lg font-semibold text-white mb-2">{{ $listing->title }}</h3>
                                <div class="space-y-1 text-gray-300 text-sm mb-4">
                                    <p>Submitted by: {{ $listing->user?->name }}</p>
                                    <p>User Type: {{ ucfirst($listing->user?->user_type ?? 'N/A') }}</p>
                                    <p>{{ $listing->city }}</p>
                                    <p class="text-lg font-bold">₱{{ number_format($listing->price, 2) }}</p>
                                    <p class="text-xs">Approved: {{ $listing->approved_at?->format('M d, Y') }}</p>
                                </div>

                                <!-- Action Buttons -->
                                <div class="space-y-2">
                                    <div class="grid grid-cols-2 gap-2">
                                        <a href="{{ route('list-sell-property.show', $listing) }}"
                                           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-300 text-center">
                                            View Details
                                        </a>
                                        <form action="{{ route('list-sell-property.toggle-status', $listing) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                    class="w-full px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition duration-300">
                                                Unpublish
                                            </button>
                                        </form>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <form action="{{ route('toggle-featured', $listing) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                    class="w-full px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition duration-300">
                                                {{ $listing->is_featured ? 'Remove Featured' : 'Mark Featured' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('toggle-exclusive', $listing) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                    class="w-full px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-lg transition duration-300">
                                                {{ $listing->is_exclusive ? 'Remove Exclusive' : 'Mark Exclusive' }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-white text-center py-4">No approved listings found.</p>
                @endif
            </div>
        </div>
    </div>
</div>
