@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col bg-center relative" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('uploads/uploads/loginbg.jpg') }}') no-repeat center/cover;">
    <div class="container mx-auto px-4 flex-grow">
        <!-- Top Section: Header -->
        <div class="text-center mb-8 mt-24">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 mt-11">Edit Your Profile</h1>
            <p class="text-white text-xl">Manage your account settings and preferences</p>
        </div>

        <!-- Edit Profile Form -->
        <div class="flex justify-center mb-11">
            <div class="p-8 bg-white bg-opacity-20 backdrop-filter backdrop-blur-md rounded-lg max-w-md w-full">
                <h2 class="text-2xl font-bold text-white text-center mb-6">Update Profile Information</h2>

                @if (session('status') === 'profile-updated')
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">Profile updated successfully.</span>
                    </div>
                @endif

                <form class="space-y-4" action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-white text-sm font-bold mb-2">Full Name</label>
                        <input id="name" name="name" type="text" required
                               class="w-full px-4 py-2 rounded-md bg-white bg-opacity-20 text-white focus:outline-none focus:ring-2 focus:ring-secondary @error('name') border-red-500 @enderror"
                               value="{{ old('name', $user->name) }}">
                        @error('name')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-white text-sm font-bold mb-2">Email Address</label>
                        <input id="email" name="email" type="email" required
                               class="w-full px-4 py-2 rounded-md bg-white bg-opacity-20 text-white focus:outline-none focus:ring-2 focus:ring-secondary @error('email') border-red-500 @enderror"
                               value="{{ old('email', $user->email) }}">
                        @error('email')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Only show user type selection for regular users -->
@if($user->hasAnyUserType('seller', 'buyer', 'renter', 'viewer'))
<div>
    <label for="user_type" class="block text-white text-sm font-bold mb-2">User Type</label>
    <select id="user_type" name="user_type" required
            class="w-full px-4 py-2 rounded-md bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-secondary @error('user_type') border-red-500 @enderror">
        <option value="" disabled {{ old('user_type', $user->user_type) ? '' : 'selected' }}>Select User Type</option>
        <option value="seller" {{ old('user_type', $user->user_type) === 'seller' ? 'selected' : '' }}>Seller</option>
        <option value="buyer" {{ old('user_type', $user->user_type) === 'buyer' ? 'selected' : '' }}>Buyer</option>
        <option value="renter" {{ old('user_type', $user->user_type) === 'renter' ? 'selected' : '' }}>Renter</option>
        <option value="viewer" {{ old('user_type', $user->user_type) === 'viewer' ? 'selected' : '' }}>Viewer</option>
    </select>
    @error('user_type')
        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
    @enderror
</div>
@endif
                    <div class="pt-4">
                        <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-secondary hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Profile Steps and Information Section -->
<div class="bg-white py-16">
    <div class="container mx-auto px-4">
        <!-- Profile Steps -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Complete Your Profile in 4 Steps</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div class="bg-gray-50 rounded-lg p-6 text-center shadow-lg">
                    <div class="w-12 h-12 bg-secondary text-white rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">1</div>
                    <h3 class="text-xl font-semibold mb-2">Basic Information</h3>
                    <p class="text-gray-600">Update your personal details and contact information</p>
                </div>

                <!-- Step 2 -->
                <div class="bg-gray-50 rounded-lg p-6 text-center shadow-lg">
                    <div class="w-12 h-12 bg-secondary text-white rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">2</div>
                    <h3 class="text-xl font-semibold mb-2">Verify Email</h3>
                    <p class="text-gray-600">Confirm your email address to secure your account</p>
                </div>

                <!-- Step 3 -->
                <div class="bg-gray-50 rounded-lg p-6 text-center shadow-lg">
                    <div class="w-12 h-12 bg-secondary text-white rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">3</div>
                    <h3 class="text-xl font-semibold mb-2">Select Preferences</h3>
                    <p class="text-gray-600">Choose your role and property preferences</p>
                </div>

                <!-- Step 4 -->
                <div class="bg-gray-50 rounded-lg p-6 text-center shadow-lg">
                    <div class="w-12 h-12 bg-secondary text-white rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">4</div>
                    <h3 class="text-xl font-semibold mb-2">Complete Profile</h3>
                    <p class="text-gray-600">Add additional details specific to your user type</p>
                </div>
            </div>
        </div>

        <!-- Profile Stats -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Your Profile Overview</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Properties -->
                <div class="bg-white rounded-lg p-6 shadow-lg border border-gray-200">
                    <h3 class="text-xl font-semibold mb-4">Properties</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Listed Properties</span>
                            <span class="font-bold">{{ $user->listingAgreements->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Property Disclosures</span>
                            <span class="font-bold">{{ $user->propertyDisclosures->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Purchase Agreements</span>
                            <span class="font-bold">{{ $user->purchaseAgreements->count() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Account Status -->
                <div class="bg-white rounded-lg p-6 shadow-lg border border-gray-200">
                    <h3 class="text-xl font-semibold mb-4">Account Status</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">User Type</span>
                            <span class="font-bold capitalize">{{ $user->user_type }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Email Verified</span>
                            <span class="font-bold text-green-500">
                                @if($user->email_verified_at)
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @else
                                    <span class="text-red-500">Pending</span>
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Member Since</span>
                            <span class="font-bold">{{ $user->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg p-6 shadow-lg border border-gray-200">
                    <h3 class="text-xl font-semibold mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('profile.edit') }}"
                           class="block w-full text-center py-2 px-4 rounded-md bg-secondary text-white hover:bg-opacity-90 transition duration-300">
                            Edit Profile
                        </a>
                        <a href="#"
                           class="block w-full text-center py-2 px-4 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200 transition duration-300">
                            Manage Preferences
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
