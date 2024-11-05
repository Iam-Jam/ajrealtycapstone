@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 pt-16">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-5xl mx-auto bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="bg-primary p-4">
                <h2 class="text-2xl font-bold text-white">Edit Property Listing</h2>
            </div>

            <form action="{{ route('list-sell-property.update', $listProperty) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')

                <!-- Property Option -->
                <div class="bg-gray-100 p-4 rounded mb-6">
                    <div class="flex gap-8 items-center justify-center">
                        <div>
                            <input type="radio" id="list" name="property_option" value="list"
                                {{ $listProperty->property_option === 'list' ? 'checked' : '' }}
                                class="form-radio text-primary">
                            <label for="list" class="ml-2 text-gray-700">List Property</label>
                        </div>
                        <div>
                            <input type="radio" id="sell" name="property_option" value="sell"
                                {{ $listProperty->property_option === 'sell' ? 'checked' : '' }}
                                class="form-radio text-primary">
                            <label for="sell" class="ml-2 text-gray-700">Sell Property</label>
                        </div>
                    </div>
                </div>

                <!-- Title and Property Type -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" id="title"
                            value="{{ old('title', $listProperty->title) }}"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Property Type</label>
                        <select name="type" id="type" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            @foreach(['lot', 'house_and_lot', 'townhouse', 'condominium', 'apartment', 'room'] as $type)
                                <option value="{{ $type }}" {{ $listProperty->type === $type ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $type)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Bedrooms and Bathrooms -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="bedrooms" class="block text-sm font-medium text-gray-700 mb-1">Bedrooms</label>
                        <input type="number" name="bedrooms" id="bedrooms"
                            value="{{ old('bedrooms', $listProperty->bedrooms) }}"
                            min="0" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    </div>

                    <div>
                        <label for="bathrooms" class="block text-sm font-medium text-gray-700 mb-1">Bathrooms</label>
                        <input type="number" name="bathrooms" id="bathrooms"
                            value="{{ old('bathrooms', $listProperty->bathrooms) }}"
                            min="0" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    </div>
                </div>

                <!-- Square Meters and Price -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="sqm" class="block text-sm font-medium text-gray-700 mb-1">Square Meters</label>
                        <input type="number" name="sqm" id="sqm"
                            value="{{ old('sqm', $listProperty->sqm) }}"
                            min="1" step="0.01" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                        <input type="number" name="price" id="price"
                            value="{{ old('price', $listProperty->price) }}"
                            min="0" step="0.01" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    </div>
                </div>

                <!-- Address and City -->
                <div class="grid grid-cols-1 gap-4 mb-4">
                    <div>
                        <label for="property_address" class="block text-sm font-medium text-gray-700 mb-1">Property Address</label>
                        <input type="text" name="property_address" id="property_address"
                            value="{{ old('property_address', $listProperty->property_address) }}"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                        <input type="text" name="city" id="city"
                            value="{{ old('city', $listProperty->city) }}"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="4" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">{{ old('description', $listProperty->description) }}</textarea>
                </div>

                <!-- Amenities -->
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-700 mb-2">Amenities</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="swimming_pool" id="swimming_pool"
                                {{ $listProperty->swimming_pool ? 'checked' : '' }}
                                class="form-checkbox text-primary h-4 w-4">
                            <label for="swimming_pool" class="ml-2">Swimming Pool</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="gym_access" id="gym_access"
                                {{ $listProperty->gym_access ? 'checked' : '' }}
                                class="form-checkbox text-primary h-4 w-4">
                            <label for="gym_access" class="ml-2">Gym Access</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="living_room" id="living_room"
                                {{ $listProperty->living_room ? 'checked' : '' }}
                                class="form-checkbox text-primary h-4 w-4">
                            <label for="living_room" class="ml-2">Living Room</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="dining_room" id="dining_room"
                                {{ $listProperty->dining_room ? 'checked' : '' }}
                                class="form-checkbox text-primary h-4 w-4">
                            <label for="dining_room" class="ml-2">Dining Room</label>
                        </div>
                    </div>
                </div>

                <!-- Current Images -->
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-700 mb-2">Current Images</h3>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach($listProperty->images as $image)
                            <div class="relative">
                                <img src="{{ Storage::url($image->image_path) }}"
                                    alt="Property image"
                                    class="w-full h-32 object-cover rounded">
                                <div class="absolute top-2 right-2">
                                    <input type="checkbox" name="delete_images[]"
                                        value="{{ $image->id }}"
                                        class="form-checkbox text-red-500 h-5 w-5 bg-white rounded shadow">
                                    <label class="text-xs text-white bg-red-500 px-2 py-1 rounded ml-1">Delete</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- New Images -->
                <div class="mb-4">
                    <label for="new_images" class="block text-sm font-medium text-gray-700 mb-1">
                        Add New Images (up to {{ 3 - $listProperty->images->count() }})
                    </label>
                    <input type="file" name="new_images[]" id="new_images"
                        multiple accept="image/*"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"
                        {{ $listProperty->images->count() >= 3 ? 'disabled' : '' }}>
                    <p class="text-sm text-gray-500 mt-1">Accepted formats: JPEG, PNG, JPG (max 2MB each)</p>
                </div>

                <!-- Contact Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label for="contact_whatsapp" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp Number</label>
                        <input type="text" name="contact_whatsapp" id="contact_whatsapp"
                            value="{{ old('contact_whatsapp', $listProperty->contact_whatsapp) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"
                            placeholder="WhatsApp number">
                    </div>

                    <div>
                        <label for="contact_messenger" class="block text-sm font-medium text-gray-700 mb-1">Messenger Username</label>
                        <input type="text" name="contact_messenger" id="contact_messenger"
                            value="{{ old('contact_messenger', $listProperty->contact_messenger) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"
                            placeholder="Messenger username">
                    </div>

                    <div class="md:col-span-2">
                        <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="contact_email" id="contact_email"
                            value="{{ old('contact_email', $listProperty->contact_email) }}"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"
                            placeholder="Email address">
                    </div>
                </div>

                <!-- Featured/Exclusive Options (Admin Only) -->
                @if(Auth::user()->user_type === 'admin')
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_featured" id="is_featured"
                            {{ $listProperty->is_featured ? 'checked' : '' }}
                            class="form-checkbox text-primary h-4 w-4">
                        <label for="is_featured" class="ml-2">Feature this property</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="is_exclusive" id="is_exclusive"
                            {{ $listProperty->is_exclusive ? 'checked' : '' }}
                            class="form-checkbox text-primary h-4 w-4">
                        <label for="is_exclusive" class="ml-2">Mark as exclusive</label>
                    </div>
                </div>
                @endif

                <!-- Submit, Cancel, and Back Buttons -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
    <button type="submit"
        class="w-full bg-[#052e16] text-white px-6 py-3 rounded-lg font-semibold
            hover:bg-[#14532d] focus:outline-none focus:ring-2 focus:ring-[#052e16]
            focus:ring-offset-2 transition duration-300 ease-in-out shadow-lg">
        Update Property Listing
    </button>

    <a href="{{ route('list-sell-property.show', $listProperty) }}"
        class="w-full bg-[#1a2e05] text-white px-6 py-3 rounded-lg font-semibold
            hover:bg-[#365314] focus:outline-none focus:ring-2 focus:ring-[#1a2e05]
            focus:ring-offset-2 transition duration-300 ease-in-out shadow-lg text-center">
        Cancel
    </a>

<a href="{{ route('profile.submitted-forms') }}"
        class="w-full bg-[#14532d] text-white px-6 py-3 rounded-lg font-semibold
            hover:bg-[#052e16] focus:outline-none focus:ring-2 focus:ring-[#14532d]
            focus:ring-offset-2 transition duration-300 ease-in-out shadow-lg text-center">
        Back to Submitted Forms
    </a>
</div>
@endsection
