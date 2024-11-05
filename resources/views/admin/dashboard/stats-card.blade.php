{{-- resources/views/admin/dashboard/stats-cards.blade.php --}}
<!-- Total Properties -->
<div class="bg-white rounded-lg shadow p-6 border border-gray-200">
    <div class="flex items-center">
        <div class="p-3 rounded-full bg-green-100 text-green-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
        </div>
        <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">Total Properties</p>
            <p class="text-2xl font-semibold text-gray-900" x-text="stats.totalProperties">0</p>
        </div>
    </div>
</div>

<!-- Active Listings -->
<div class="bg-white rounded-lg shadow p-6 border border-gray-200">
    <div class="flex items-center">
        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
        </div>
        <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">Active Listings</p>
            <p class="text-2xl font-semibold text-gray-900" x-text="stats.activeListings">0</p>
        </div>
    </div>
</div>

<!-- Total Users -->
<div class="bg-white rounded-lg shadow p-6 border border-gray-200">
    <div class="flex items-center">
        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </div>
        <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">Total Users</p>
            <p class="text-2xl font-semibold text-gray-900" x-text="stats.totalUsers">0</p>
        </div>
    </div>
</div>

<!-- Pending Inquiries -->
<div class="bg-white rounded-lg shadow p-6 border border-gray-200">
    <div class="flex items-center">
        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
            </svg>
        </div>
        <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">Pending Inquiries</p>
            <p class="text-2xl font-semibold text-gray-900" x-text="stats.pendingInquiries">0</p>
        </div>
    </div>
</div>
