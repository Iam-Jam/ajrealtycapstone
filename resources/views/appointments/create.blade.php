@extends('layouts.app')

@section('content')
<!-- Hero Section with Appointment Form -->
<div class="min-h-screen flex flex-col bg-center relative" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('uploads/uploads/loginbg.jpg') }}') no-repeat center/cover;">
    <div class="container mx-auto px-4 flex-grow mb-8">
        <!-- Top Section: Real Estate Information -->
        <div class="text-center mb-8 mt-24">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 mt-11">Schedule Your Appointment</h1>
        </div>

        <!-- Appointment Booking Form -->
        <div class="flex justify-center">
            <div class="p-8 bg-white bg-opacity-20 backdrop-filter backdrop-blur-md rounded-lg max-w-md w-full">
                <h2 class="text-2xl font-bold text-white text-center mb-6">Book an Appointment</h2>

                <form class="space-y-4" action="{{ route('appointments.store') }}" method="POST">
                    @csrf
                    <div>
                        <label for="property_id" class="block text-sm font-medium text-white">Property</label>
                        <select id="property_id" name="property_id" required
                                class="w-full px-4 py-2 rounded-md bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-secondary @error('property_id') border-red-500 @enderror">
                            <option value="">Select a property</option>
                            @foreach ($properties as $property)
                                <option value="{{ $property->id }}" {{ old('property_id') == $property->id ? 'selected' : '' }}>
                                    {{ $property->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('property_id')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="name" class="block text-sm font-medium text-white">Full Name</label>
                        <input id="name" name="name" type="text" autocomplete="name" required
                               class="w-full px-4 py-2 rounded-md bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-secondary @error('name') border-red-500 @enderror"
                               placeholder="Full Name" value="{{ old('name') }}">
                        @error('name')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-white">Email Address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required
                               class="w-full px-4 py-2 rounded-md bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-secondary @error('email') border-red-500 @enderror"
                               placeholder="Email Address" value="{{ old('email') }}">
                        @error('email')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-white">Phone Number</label>
                        <input id="phone" name="phone" type="tel" autocomplete="tel"
                               class="w-full px-4 py-2 rounded-md bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-secondary @error('phone') border-red-500 @enderror"
                               placeholder="Phone Number" value="{{ old('phone') }}">
                        @error('phone')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="appointment_date" class="block text-sm font-medium text-white">Appointment Date</label>
                        <input id="appointment_date" name="appointment_date" type="datetime-local" required
                               class="w-full px-4 py-2 rounded-md bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-secondary @error('appointment_date') border-red-500 @enderror"
                               value="{{ old('appointment_date') }}">
                        @error('appointment_date')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="notes" class="block text-sm font-medium text-white">Additional Notes</label>
                        <textarea id="notes" name="notes" rows="3"
                                  class="w-full px-4 py-2 rounded-md bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-secondary @error('notes') border-red-500 @enderror"
                                  placeholder="Additional Notes">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-secondary hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">
                            Book Appointment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Comprehensive Steps Section - Redesigned with consistent colors -->
<div class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-secondary mb-4">Your Journey to Property Viewing</h2>
                <p class="text-lg text-gray-600">Follow these simple steps to schedule and complete your property viewing</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Step 1: Confirmation -->
                <div class="bg-white rounded-xl p-6 shadow-md transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-secondary bg-opacity-10 rounded-full">
                                <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-secondary mb-2">Instant Confirmation</h3>
                            <p class="text-gray-600">Receive an immediate email confirmation with all your appointment details, including a calendar invite for easy scheduling.</p>
                            <ul class="mt-4 text-sm text-gray-500 space-y-2">
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Appointment confirmation
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Digital calendar invite
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Agent Contact -->
                <div class="bg-white rounded-xl p-6 shadow-md transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-secondary bg-opacity-10 rounded-full">
                                <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-secondary mb-2">Personal Agent Contact</h3>
                            <p class="text-gray-600">Connect with your dedicated real estate agent who will guide you through the entire viewing process.</p>
                            <ul class="mt-4 text-sm text-gray-500 space-y-2">
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Property details discussion
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Preference assessment
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Property Tour -->
                <div class="bg-white rounded-xl p-6 shadow-md transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-secondary bg-opacity-10 rounded-full">
                                <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-secondary mb-2">Guided Property Tour</h3>
                            <p class="text-gray-600">Experience a comprehensive property tour with expert insights and detailed information about the neighborhood.</p>
                            <ul class="mt-4 text-sm text-gray-500 space-y-2">
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    In-depth property showcase
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Area highlights tour
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Follow-up -->
                <div class="bg-white rounded-xl p-6 shadow-md transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-secondary bg-opacity-10 rounded-full">
                                <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-secondary mb-2">Personalized Follow-up</h3>
                            <p class="text-gray-600">Receive detailed information and next steps based on your viewing experience and preferences.</p>
                            <ul class="mt-4 text-sm text-gray-500 space-y-2">
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Property report
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Custom recommendations
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="mt-12 text-center">
                <div class="bg-secondary bg-opacity-10 rounded-lg p-6 inline-block">
                    <p class="text-secondary font-medium">Need immediate assistance?</p>
                    <p class="text-secondary mt-2">Contact our support team at (209) 661-9494</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
