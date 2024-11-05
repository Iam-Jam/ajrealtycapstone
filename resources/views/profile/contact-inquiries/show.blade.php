@extends('layouts.app')

@section('content')
<main class="relative bg-gray-900 text-white py-32" style="background-image: url('{{ asset('uploads/uploads/formsbg1.jpg') }}'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative container mx-auto px-4 z-10">
        @include('partials.alerts')
        
        <div class="bg-primary bg-opacity-50 backdrop-filter backdrop-blur-md p-8 rounded-lg shadow-xl">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Contact Inquiry Details</h1>
                <div class="flex space-x-4">
                    <a href="{{ route('profile.submitted-forms') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md transition duration-300">
                        Back to List
                    </a>

                    @if(Auth::user()->isAdmin() || (Auth::user()->isAgent() && Auth::user()->id === $contactInquiry->assigned_to))
                        <a href="{{ route('profile.contact-inquiries.edit', $contactInquiry) }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-300">
                            Edit Inquiry
                        </a>
                    @endif
                </div>
            </div>

            <div class="bg-white bg-opacity-10 rounded-lg p-6 space-y-6">
                <!-- Status Badge -->
                <div class="flex justify-between items-center">
                    <span class="text-lg font-semibold">Current Status:</span>
                    <span class="px-4 py-2 rounded-full text-sm font-semibold
                        @if($contactInquiry->status === 'pending') bg-yellow-500 text-yellow-100
                        @elseif($contactInquiry->status === 'in_progress') bg-blue-500 text-blue-100
                        @elseif($contactInquiry->status === 'completed') bg-green-500 text-green-100
                        @else bg-gray-500 text-gray-100
                        @endif">
                        {{ ucfirst($contactInquiry->status) }}
                    </span>
                </div>

                <!-- Contact Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <h2 class="text-lg font-semibold mb-2">Contact Information</h2>
                            <p><span class="font-medium">Full Name:</span> {{ $contactInquiry->full_name }}</p>
                            <p><span class="font-medium">Email:</span> {{ $contactInquiry->email }}</p>
                            <p><span class="font-medium">Phone:</span> {{ $contactInquiry->phone ?? 'Not provided' }}</p>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold mb-2">Inquiry Type</h2>
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                @if($contactInquiry->inquiry_type === 'selling') bg-yellow-500 text-yellow-100
                                @elseif($contactInquiry->inquiry_type === 'showing') bg-blue-500 text-blue-100
                                @elseif($contactInquiry->inquiry_type === 'property') bg-green-500 text-green-100
                                @else bg-gray-500 text-gray-100
                                @endif">
                                {{ ucfirst($contactInquiry->inquiry_type) }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <h2 class="text-lg font-semibold mb-2">Submission Details</h2>
                            <p><span class="font-medium">Submitted On:</span> {{ $contactInquiry->created_at->format('M d, Y g:i A') }}</p>
                            @if($contactInquiry->property_address)
                                <p><span class="font-medium">Property Address:</span> {{ $contactInquiry->property_address }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Message -->
                <div>
                    <h2 class="text-lg font-semibold mb-2">Message</h2>
                    <div class="bg-white bg-opacity-5 rounded-lg p-4">
                        {{ $contactInquiry->message }}
                    </div>
                </div>

                <!-- Internal Notes (Admin/Agent Only) -->
                @if(Auth::user()->isAdmin() || Auth::user()->isAgent())
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Internal Notes</h2>
                        <div class="bg-white bg-opacity-5 rounded-lg p-4">
                            {{ $contactInquiry->internal_notes ?? 'No internal notes' }}
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 mt-6">
                    @if(Auth::user()->isAdmin())
                        <form action="{{ route('profile.contact-inquiries.destroy', $contactInquiry) }}" 
                              method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this inquiry? This action cannot be undone.')"
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md transition duration-300">
                                Delete Inquiry
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection