@extends('layouts.app')

@section('content')
<main class="relative bg-gray-900 text-white py-32" style="background-image: url('{{ asset('uploads/uploads/formsbg1.jpg') }}'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative container mx-auto px-4 z-10">
        <h1 class="text-4xl lg:text-5xl font-bold mb-12 text-center">
            @if(Auth::user()->user_type === 'admin')
                Manage Property Listings
            @else
                My Submitted Forms
            @endif
        </h1>

        <!-- List/Sell Properties -->
        <div class="bg-primary bg-opacity-50 backdrop-filter backdrop-blur-md p-8 rounded-lg shadow-xl mb-10">
            <h2 class="text-3xl font-semibold mb-6">
                @if(Auth::user()->user_type === 'admin')
                    All Listed Properties
                @else
                    List/Sell Properties
                @endif
            </h2>

            @if(Auth::user()->user_type === 'admin')
                <!-- Admin View -->
                <!-- Pending Listings -->
                @if($pendingListings && $pendingListings->count() > 0)
                    <div class="mb-8">
                        <h3 class="text-2xl font-semibold mb-4 text-yellow-400">Pending Approval ({{ $pendingListings->count() }})</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($pendingListings as $listing)
                                <div class="bg-white bg-opacity-25 rounded-lg shadow-lg p-6 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                    @if($listing->images->count() > 0)
                                        <img src="{{ Storage::url($listing->images->first()->image_path) }}"
                                             alt="{{ $listing->title }}"
                                             class="w-full h-48 object-cover rounded-lg mb-4">
                                    @endif
                                    <h3 class="text-xl font-semibold mb-2">{{ $listing->title }}</h3>
                                    <p class="text-sm mb-2">Submitted by: {{ $listing->user->name }}</p>
                                    <p class="text-sm mb-2">User Type: {{ ucfirst($listing->user->user_type) }}</p>
                                    <p class="text-sm mb-2">{{ $listing->city }}</p>
                                    <p class="text-lg font-bold mb-4">₱{{ number_format($listing->price, 2) }}</p>

                                    <!-- Status Badge -->
                                    <div class="flex items-center justify-between mb-4">
                                        <span class="px-3 py-1 text-xs font-semibold bg-[#052e16] text-white rounded-full">
                                            Pending
                                        </span>
                                        <span class="text-sm">
                                            {{ $listing->created_at->format('M d, Y') }}
                                        </span>
                                    </div>

                                    <!-- Admin Actions -->
                                    <div class="grid grid-cols-2 gap-2">
                                        <form action="{{ route('list-sell-property.toggle-status', $listing) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="w-full px-4 py-2 bg-[#14532d] text-white rounded-lg hover:bg-[#052e16]
                                                       transition duration-300 ease-in-out text-sm font-semibold">
                                                Approve
                                            </button>
                                        </form>

                                        <a href="{{ route('list-sell-property.show', $listing) }}"
                                           class="inline-flex justify-center items-center px-4 py-2 bg-[#1a2e05] text-white
                                                  rounded-lg hover:bg-[#365314] transition duration-300 ease-in-out text-sm font-semibold">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Approved Listings -->
                @if($approvedListings && $approvedListings->count() > 0)
                    <div>
                        <h3 class="text-2xl font-semibold mb-4 text-green-400">Approved Listings ({{ $approvedListings->count() }})</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($approvedListings as $listing)
                                <div class="bg-white bg-opacity-25 rounded-lg shadow-lg p-6 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                    @if($listing->images->count() > 0)
                                        <img src="{{ Storage::url($listing->images->first()->image_path) }}"
                                             alt="{{ $listing->title }}"
                                             class="w-full h-48 object-cover rounded-lg mb-4">
                                    @endif

                                    <h3 class="text-xl font-semibold mb-2">{{ $listing->title }}</h3>
                                    <p class="text-sm mb-2">Submitted by: {{ $listing->user->name }}</p>
                                    <p class="text-sm mb-2">{{ $listing->city }}</p>
                                    <p class="text-lg font-bold mb-4">₱{{ number_format($listing->price, 2) }}</p>

                                    <!-- Status and Features -->
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        <span class="px-3 py-1 text-xs font-semibold bg-[#14532d] text-white rounded-full">
                                            Approved
                                        </span>
                                        @if($listing->is_featured)
                                            <span class="px-3 py-1 text-xs font-semibold bg-yellow-500 text-white rounded-full">
                                                Featured
                                            </span>
                                        @endif
                                        @if($listing->is_exclusive)
                                            <span class="px-3 py-1 text-xs font-semibold bg-purple-500 text-white rounded-full">
                                                Exclusive
                                            </span>
                                        @endif
                                    </div>

                                    <a href="{{ route('list-sell-property.show', $listing) }}"
                                       class="w-full inline-flex justify-center items-center px-4 py-2 bg-[#14532d] text-white
                                              rounded-lg hover:bg-[#052e16] transition duration-300 ease-in-out text-sm font-semibold">
                                        View Details
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if((!$pendingListings || $pendingListings->count() === 0) && (!$approvedListings || $approvedListings->count() === 0))
                    <p class="text-lg text-center">No property listings submitted yet.</p>
                @endif

            @else
                <!-- Regular User View -->
                @if(isset($userListings) && $userListings->count() > 0)
                    <p class="text-lg mb-6">Number of property listings: {{ $userListings->count() }}</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($userListings as $listing)
                            <!-- Keep your existing regular user listing card code -->
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
            @endif
        </div>



        @if(Auth::user()->user_type !== 'admin')
            <!-- Purchase Agreements -->
            <div class="bg-primary bg-opacity-50 backdrop-filter backdrop-blur-md p-8 rounded-lg shadow-xl mb-10">
                <!-- Keep your existing Purchase Agreements section -->
                @include('user.partials.purchase-agreements')
            </div>

            <!-- Listing Agreements -->
            <div class="bg-primary bg-opacity-50 backdrop-filter backdrop-blur-md p-8 rounded-lg shadow-xl mb-10">
                <!-- Keep your existing Listing Agreements section -->
                @include('user.partials.listing-agreements')
            </div>


<!-- Contact Inquiries Section -->
<div class="bg-primary bg-opacity-50 backdrop-filter backdrop-blur-md p-8 rounded-lg shadow-xl mb-10">
    <h2 class="text-3xl font-semibold mb-6">
        @if(Auth::user()->user_type === 'admin')
            All Contact Inquiries
        @else
            My Contact Inquiries
        @endif
    </h2>

    @if(isset($contactInquiries) && $contactInquiries->count() > 0)
        <div class="overflow-x-auto bg-white bg-opacity-10 rounded-lg">
            <table class="min-w-full divide-y divide-gray-700">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                            Date Submitted
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                            Full Name
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                            Contact Info
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                            Inquiry Type
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($contactInquiries as $inquiry)
                        <tr class="hover:bg-white hover:bg-opacity-10">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                {{ $inquiry->created_at->format('M d, Y g:i A') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                {{ $inquiry->full_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                <div>{{ $inquiry->email }}</div>
                                <div class="text-gray-400">{{ $inquiry->phone ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if($inquiry->inquiry_type === 'selling') bg-yellow-100 text-yellow-800
                                    @elseif($inquiry->inquiry_type === 'showing') bg-blue-100 text-blue-800
                                    @elseif($inquiry->inquiry_type === 'property') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($inquiry->inquiry_type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if($inquiry->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($inquiry->status === 'in_progress') bg-blue-100 text-blue-800
                                    @elseif($inquiry->status === 'completed') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($inquiry->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-3">
                                    <!-- View Details -->
                                    <a href="{{ route('profile.contact-inquiries.show', $inquiry) }}"
                                       class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-md transition duration-300 inline-flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                        </svg>
                                        View
                                    </a>

                                    <!-- Status Update Dropdown - Show for Admin and Agents -->
                                    @if(Auth::user()->isAdmin() || Auth::user()->isAgent())
                                        <form action="{{ route('profile.contact-inquiries.update', $inquiry) }}"
                                              method="POST"
                                              class="inline-flex items-center"
                                              id="statusForm{{ $inquiry->id }}">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status"
                                                    onchange="document.getElementById('statusForm{{ $inquiry->id }}').submit()"
                                                    class="bg-white text-gray-800 rounded-md border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <option value="pending" {{ $inquiry->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="in_progress" {{ $inquiry->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="completed" {{ $inquiry->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="archived" {{ $inquiry->status === 'archived' ? 'selected' : '' }}>Archived</option>
                                            </select>
                                        </form>
                                    @else
                                        <!-- Status Badge for non-admin/agent users -->
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($inquiry->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($inquiry->status === 'in_progress') bg-blue-100 text-blue-800
                                            @elseif($inquiry->status === 'completed') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($inquiry->status) }}
                                        </span>
                                    @endif

                                    <!-- Edit Button - Show for Admin and Owner -->
                                    @if(Auth::user()->isAdmin() || Auth::user()->id === $inquiry->user_id)
                                        <a href="{{ route('profile.contact-inquiries.edit', $inquiry) }}"
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md transition duration-300 inline-flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                            </svg>
                                            Edit
                                        </a>
                                    @endif

                                    <!-- Delete Button - Show only for Admin -->
                                    @if(Auth::user()->isAdmin())
                                        <form action="{{ route('profile.contact-inquiries.destroy', $inquiry) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this inquiry? This action cannot be undone.')"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md transition duration-300 inline-flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if(method_exists($contactInquiries, 'links'))
            <div class="mt-4">
                {{ $contactInquiries->links() }}
            </div>
        @endif
    @else
        <p class="text-lg text-white">No contact inquiries found.</p>
    @endif
</div>


<!-- Appointments Section -->
<div class="bg-primary bg-opacity-50 backdrop-filter backdrop-blur-md p-8 rounded-lg shadow-xl mb-10">
    <h2 class="text-3xl font-semibold mb-6">
        @if(in_array(Auth::user()->user_type, ['admin', 'agent1', 'agent2']))
            All Appointments
        @else
            My Appointments
        @endif
    </h2>

    @if(isset($appointments) && $appointments->count() > 0)
        <div class="overflow-x-auto bg-white bg-opacity-10 rounded-lg">
            <table class="min-w-full divide-y divide-gray-700">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                            Date & Time
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                            Property
                        </th>
                        @if(in_array(Auth::user()->user_type, ['admin', 'agent1', 'agent2']))
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                                Client Details
                            </th>
                        @endif
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($appointments as $appointment)
                        <tr class="hover:bg-white hover:bg-opacity-10">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                {{ $appointment->appointment_date->format('M d, Y g:i A') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                {{ $appointment->property->title ?? 'N/A' }}
                            </td>
                            @if(in_array(Auth::user()->user_type, ['admin', 'agent1', 'agent2']))
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                    <div>{{ $appointment->name }}</div>
                                    <div class="text-gray-400">{{ $appointment->email }}</div>
                                    <div class="text-gray-400">{{ $appointment->phone }}</div>
                                </td>
                            @endif
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($appointment->status === 'confirmed') bg-green-100 text-green-800
                                    @elseif($appointment->status === 'cancelled') bg-red-100 text-red-800
                                    @elseif($appointment->status === 'completed') bg-blue-100 text-blue-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if(in_array(Auth::user()->user_type, ['admin', 'agent1', 'agent2']))
                                    <form action="{{ route('appointments.update-status', $appointment) }}" method="POST" class="inline-flex items-center space-x-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()"
                                                class="bg-white bg-opacity-10 text-white text-sm rounded-md border-gray-600 focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50">
                                            <option value="pending" {{ $appointment->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="confirmed" {{ $appointment->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                            <option value="cancelled" {{ $appointment->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            <option value="completed" {{ $appointment->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                    </form>

                                    @if(Auth::user()->user_type === 'admin')
                                        <form action="{{ route('appointments.delete', $appointment) }}" method="POST" class="inline-flex ml-2"
                                              onsubmit="return confirm('Are you sure you want to delete this appointment?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <span class="text-gray-200">{{ ucfirst($appointment->status) }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if(method_exists($appointments, 'links'))
            <div class="mt-4">
                {{ $appointments->links() }}
            </div>
        @endif
    @else
        <p class="text-lg text-white">No appointments found.</p>
    @endif
</div>
            <!-- Property Disclosures -->
            <div class="bg-primary bg-opacity-50 backdrop-filter backdrop-blur-md p-8 rounded-lg shadow-xl">
                <!-- Keep your existing Property Disclosures section -->
                @include('user.partials.property-disclosures')
            </div>
        @endif
    </div>
</main>
@endsection

