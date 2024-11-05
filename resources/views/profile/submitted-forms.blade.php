<!-- resources/views/profile/submitted-forms.blade.php -->
@if(isset($userListings) && $userListings->count() > 0)
<div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
    <div class="bg-primary text-white p-4">
        <h3 class="text-xl font-semibold">{{ __('My Property Listings') }}</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($userListings as $listing)
                <div class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition duration-300">
                    @if($listing->images->count() > 0)
                        <img src="{{ Storage::url($listing->images->first()->image_path) }}"
                             alt="{{ $listing->title }}"
                             class="w-full h-48 object-cover">
                    @endif
                    <div class="p-4">
                        <h4 class="text-lg font-semibold mb-2">{{ $listing->title }}</h4>
                        <p class="text-gray-600">{{ $listing->city }}</p>
                        <p class="text-primary font-bold">₱{{ number_format($listing->price, 2) }}</p>
                        <div class="mt-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                {{ $listing->status === 'approved' ? 'bg-green-100 text-green-800' :
                                   ($listing->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                    'bg-red-100 text-red-800') }}">
                                {{ ucfirst($listing->status) }}
                            </span>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('list-sell-property.show', $listing) }}"
                               class="text-primary hover:text-primary-dark font-medium">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif
