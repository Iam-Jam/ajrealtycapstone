@extends('layouts.app')

@section('content')
<main class="relative bg-gray-900 text-white py-32" style="background-image: url('{{ asset('uploads/uploads/formsbg1.jpg') }}'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative container mx-auto px-4 z-10">
        @include('partials.alerts')

        <div class="bg-primary bg-opacity-50 backdrop-filter backdrop-blur-md p-8 rounded-lg shadow-xl">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Edit Contact Inquiry</h1>
                <a href="{{ route('profile.contact-inquiries.show', $contactInquiry) }}"
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md transition duration-300">
                    Back to Details
                </a>
            </div>

            <form action="{{ route('profile.contact-inquiries.update', $contactInquiry) }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="bg-white bg-opacity-10 rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium mb-2">Status</label>
                            <select id="status" name="status" required
                                    class="w-full bg-white bg-opacity-10 rounded-md border border-gray-600 px-3 py-2">
                                <option value="pending" {{ old('status', $contactInquiry->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ old('status', $contactInquiry->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ old('status', $contactInquiry->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="archived" {{ old('status', $contactInquiry->status) === 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Full Name -->
                        <div>
                            <label for="full_name" class="block text-sm font-medium mb-2">Full Name</label>
                            <input type="text" id="full_name" name="full_name"
                                   value="{{ old('full_name', $contactInquiry->full_name) }}"
                                   class="w-full bg-white bg-opacity-10 rounded-md border border-gray-600 px-3 py-2">
                            @error('full_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium mb-2">Email</label>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email', $contactInquiry->email) }}"
                                   class="w-full bg-white bg-opacity-10 rounded-md border border-gray-600 px-3 py-2">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium mb-2">Phone</label>
                            <input type="text" id="phone" name="phone"
                                   value="{{ old('phone', $contactInquiry->phone) }}"
                                   class="w-full bg-white bg-opacity-10 rounded-md border border-gray-600 px-3 py-2">
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Property Address -->
                        <div class="md:col-span-2">
                            <label for="property_address" class="block text-sm font-medium mb-2">Property Address</label>
                            <input type="text" id="property_address" name="property_address"
                                   value="{{ old('property_address', $contactInquiry->property_address) }}"
                                   class="w-full bg-white bg-opacity-10 rounded-md border border-gray-600 px-3 py-2">
                            @error('property_address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Message -->
                        <div class="md:col-span-2">
                            <label for="message" class="block text-sm font-medium mb-2">Message</label>
                            <textarea id="message" name="message" rows="4"
                                      class="w-full bg-white bg-opacity-10 rounded-md border border-gray-600 px-3 py-2">{{ old('message', $contactInquiry->message) }}</textarea>
                            @error('message')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Internal Notes -->
                        @if(Auth::user()->isAdmin() || Auth::user()->isAgent())
                            <div class="md:col-span-2">
                                <label for="internal_notes" class="block text-sm font-medium mb-2">Internal Notes</label>
                                <textarea id="internal_notes" name="internal_notes" rows="4"
                                          class="w-full bg-white bg-opacity-10 rounded-md border border-gray-600 px-3 py-2">{{ old('internal_notes', $contactInquiry->internal_notes) }}</textarea>
                                @error('internal_notes')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end mt-6">
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition duration-300">
                            Update Inquiry
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
