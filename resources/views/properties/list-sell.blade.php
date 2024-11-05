@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-100 pt-16">
    <!-- Hero Section with Background Image -->
    <div class="bg-primary py-12 mb-8 relative">
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('uploads/uploads/bg1.jpg') }}');">
            <div class="absolute inset-0 bg-black opacity-50"></div>
        </div>
        <div class="container mx-auto px-4 relative">
            <div class="max-w-4xl mx-auto text-center text-white">
                <h1 class="text-4xl font-bold mb-4">List Your Property With Us</h1>
                <p class="text-xl mb-6">Join hundreds of successful property owners who trust us with their listings</p>
                <div class="flex justify-center space-x-4">
                    <div class="text-center">
                        <div class="text-3xl font-bold mb-2">More</div>
                        <div class="text-sm">Active Listings</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold mb-2">1K+</div>
                        <div class="text-sm">Happy Clients</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold mb-2">95%</div>
                        <div class="text-sm">Success Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Benefits Section -->
        <div class="max-w-5xl mx-auto mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-primary mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Fast Listing Process</h3>
                    <p class="text-gray-600">List your property in minutes with our streamlined process</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-primary mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Secure Platform</h3>
                    <p class="text-gray-600">Your property details are safe with our secure listing platform</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-primary mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Wide Reach</h3>
                    <p class="text-gray-600">Connect with thousands of potential buyers and renters</p>
                </div>
            </div>
        </div>

        <!-- Main Form Card -->
        <div class="max-w-5xl mx-auto bg-white shadow-xl rounded-lg overflow-hidden">
            <!-- Guidelines Section -->
            <div class="bg-gray-50 p-6 border-b">
                <h3 class="text-lg font-semibold mb-4">Important Guidelines</h3>
                <ul class="list-disc list-inside text-gray-600 space-y-2">
                    <li>Ensure all property details are accurate and up-to-date</li>
                    <li>Upload high-quality images for better visibility</li>
                    <li>Provide complete contact information for faster responses</li>
                    <li>Review all details before submission</li>
                </ul>
            </div>

            <div class="bg-primary p-4">
                <h2 class="text-2xl font-bold text-white">List Your Property</h2>
                <p class="text-sm text-white">Showcase your property to thousands of potential buyers</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 p-4 mb-6">
                    <div class="font-medium text-red-600">Please correct the following errors:</div>
                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(auth()->check())
                <form action="{{ route('list-sell-property.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf

                    <div class="bg-gray-100 p-4 rounded mb-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <input type="radio" id="list" name="property_option" value="list" class="form-radio text-primary" {{ old('property_option', 'list') === 'list' ? 'checked' : '' }}>
                                <label for="list" class="ml-2 text-gray-700">List Property</label>
                            </div>
                            <div>
                                <input type="radio" id="sell" name="property_option" value="sell" class="form-radio text-primary" {{ old('property_option') === 'sell' ? 'checked' : '' }}>
                                <label for="sell" class="ml-2 text-gray-700">Sell Property</label>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Property Type</label>
                            <select name="type" id="type" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                                <option value="lot" {{ old('type') === 'lot' ? 'selected' : '' }}>Lot</option>
                                <option value="house_and_lot" {{ old('type') === 'house_and_lot' ? 'selected' : '' }}>House and Lot</option>
                                <option value="townhouse" {{ old('type') === 'townhouse' ? 'selected' : '' }}>Townhouse</option>
                                <option value="condominium" {{ old('type') === 'condominium' ? 'selected' : '' }}>Condominium Unit</option>
                                <option value="apartment" {{ old('type') === 'apartment' ? 'selected' : '' }}>Apartment</option>
                                <option value="room" {{ old('type') === 'room' ? 'selected' : '' }}>Room</option>
                            </select>
                        </div>

<div>
                            <label for="bedrooms" class="block text-sm font-medium text-gray-700 mb-1">Bedrooms</label>
                            <input type="number" name="bedrooms" id="bedrooms" value="{{ old('bedrooms', 0) }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>

                        <div>
                            <label for="bathrooms" class="block text-sm font-medium text-gray-700 mb-1">Bathrooms</label>
                            <input type="number" name="bathrooms" id="bathrooms" value="{{ old('bathrooms', 0) }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>

                        <div>
                            <label for="sqm" class="block text-sm font-medium text-gray-700 mb-1">Square Meters</label>
                            <input type="number" name="sqm" id="sqm" value="{{ old('sqm') }}" required step="0.01"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                            <input type="number" name="price" id="price" value="{{ old('price') }}" required step="0.01"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="property_address" class="block text-sm font-medium text-gray-700 mb-1">Property Address</label>
                        <input type="text" name="property_address" id="property_address" value="{{ old('property_address') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    </div>

                    <div class="mb-4">
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="description" rows="3" required
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="flex items-center">
                            <input type="hidden" name="swimming_pool" value="0">
                            <input type="checkbox" name="swimming_pool" id="swimming_pool" value="1"
                                   class="form-checkbox text-primary" {{ old('swimming_pool') ? 'checked' : '' }}>
                            <label for="swimming_pool" class="ml-2 text-sm text-gray-700">Swimming Pool</label>
                        </div>
                        <div class="flex items-center">
                            <input type="hidden" name="gym_access" value="0">
                            <input type="checkbox" name="gym_access" id="gym_access" value="1"
                                   class="form-checkbox text-primary" {{ old('gym_access') ? 'checked' : '' }}>
                            <label for="gym_access" class="ml-2 text-sm text-gray-700">Gym Access</label>
                        </div>
                        <div class="flex items-center">
                            <input type="hidden" name="living_room" value="0">
                            <input type="checkbox" name="living_room" id="living_room" value="1"
                                   class="form-checkbox text-primary" {{ old('living_room') ? 'checked' : '' }}>
                            <label for="living_room" class="ml-2 text-sm text-gray-700">Living Room</label>
                        </div>
                        <div class="flex items-center">
                            <input type="hidden" name="dining_room" value="0">
                            <input type="checkbox" name="dining_room" id="dining_room" value="1"
                                   class="form-checkbox text-primary" {{ old('dining_room') ? 'checked' : '' }}>
                            <label for="dining_room" class="ml-2 text-sm text-gray-700">Dining Room</label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Upload Images (up to 3)</label>
                        <input type="file" name="images[]" id="images" multiple accept="image/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        <p class="mt-1 text-sm text-gray-500">Accepted formats: JPEG, PNG, JPG (max 2MB each)</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="contact_whatsapp" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                            <input type="text" name="contact_whatsapp" id="contact_whatsapp" value="{{ old('contact_whatsapp') }}"
                                   placeholder="WhatsApp number"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label for="contact_messenger" class="block text-sm font-medium text-gray-700 mb-1">Messenger</label>
                            <input type="text" name="contact_messenger" id="contact_messenger" value="{{ old('contact_messenger') }}"
                                   placeholder="Messenger username"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email') }}" required
                               placeholder="Email address"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    </div>

                    @if(auth()->user()->user_type === 'admin')
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_featured" id="is_featured"
                                   class="form-checkbox text-primary" {{ old('is_featured') ? 'checked' : '' }}>
                            <label for="is_featured" class="ml-2 text-sm text-gray-700">Feature this property</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="is_exclusive" id="is_exclusive"
                                   class="form-checkbox text-primary" {{ old('is_exclusive') ? 'checked' : '' }}>
                            <label for="is_exclusive" class="ml-2 text-sm text-gray-700">Mark as exclusive</label>
                        </div>
                    </div>
                    @endif

                    <!-- Submit Button -->
                    <div class="text-right">
                        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark">Submit Property</button>
                    </div>
                </form>
            @else
                <div class="p-8 text-center">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Authorization Required</h3>
                    <p class="text-gray-600 mb-6">You need to be an authorized user to list properties.</p>
                    <a href="{{ route('forms.index') }}"
                       class="inline-block bg-primary text-white px-6 py-2 rounded-md hover:bg-primary-dark transition duration-300">
                        Go to Forms
                    </a>
                </div>
            @endif
        </div>

        <!-- Tips and Help Section (Moved outside the form) -->
        <div class="max-w-5xl mx-auto mt-8 bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                <!-- Tips Section -->
                <div>
                    <h3 class="text-xl font-semibold mb-4 text-gray-800">Tips for Better Listings</h3>
                    <ul class="space-y-3 text-gray-600">
                        <li>• Write detailed, accurate descriptions</li>
                        <li>• Include all relevant amenities and features</li>
                        <li>• Set competitive, market-appropriate prices</li>
                    </ul>
                </div>

                <!-- Help Section -->
                <div>
                    <h3 class="text-xl font-semibold mb-4 text-gray-800">Need Help?</h3>
                    <div class="space-y-3 text-gray-600">
                        <p>Our support team is available to assist you with your listing:</p>
                        <p>Support Hotline: +1234567890</p>
                        <p>Send us: Contact Inquiry Form in our Forms section page</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('info'))
        <div class="fixed bottom-4 right-4 bg-blue-50 border-l-4 border-blue-400 p-4 rounded shadow-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">{{ session('info') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <button class="text-blue-400 hover:text-blue-500" onclick="this.parentElement.parentElement.parentElement.remove()">
                        <span class="sr-only">Dismiss</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
