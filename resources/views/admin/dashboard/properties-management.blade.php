{{-- resources/views/admin/dashboard/properties-management.blade.php --}}
<div x-data="propertyManagement()" class="space-y-6">
    <!-- Header and Search Section -->
    <div class="bg-white/10 p-6 rounded-xl backdrop-filter backdrop-blur-md border border-gray-700">
        <h2 class="text-2xl font-semibold text-white mb-6">Properties Management</h2>

        <!-- Search Controls -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-white mb-2">Property ID</label>
                <input type="text"
                       x-model="searchId"
                       @keyup.enter="performSearch"
                       class="w-full rounded-lg bg-gray-700 border-gray-600 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500"
                       placeholder="Enter Property ID">
            </div>

            <div>
                <label class="block text-sm font-medium text-white mb-2">Property Type</label>
                <select x-model="searchType"
                        @change="performSearch"
                        class="w-full rounded-lg bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Types</option>
                    <option value="lot">Lot</option>
                    <option value="house_and_lot">House and Lot</option>
                    <option value="townhouse">Townhouse</option>
                    <option value="condominium">Condominium</option>
                    <option value="apartment">Apartment</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-white mb-2">Status</label>
                <select x-model="searchStatus"
                        @change="performSearch"
                        class="w-full rounded-lg bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                </select>
            </div>

            <div class="flex items-end">
                <button @click="performSearch"
                        class="w-full px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors duration-200">
                    Search Properties
                </button>
            </div>
        </div>
    </div>

    <!-- Properties Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-if="loading">
            <div class="col-span-full flex justify-center items-center py-12">
                <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </template>

        <template x-if="!loading && properties.length === 0">
            <div class="col-span-full text-center py-12 text-white">
                No properties found
            </div>
        </template>

        <template x-for="property in properties" :key="property.id">
            <div class="bg-white rounded-lg shadow-lg transition-transform duration-300 hover:scale-[1.02] group">
                <!-- Image Section -->
                <div class="relative">
                    <img :src="property.image || '/images/no-image.jpg'"
                         :alt="property.title"
                         class="w-full h-[200px] sm:h-[300px] object-cover rounded-t-lg">

                    <!-- Admin Action Buttons -->
                    <div class="absolute top-2 right-2 flex flex-wrap gap-2">
                        <button @click="toggleStatus(property)"
                                :class="property.status === 'approved' ? 'bg-green-600' : 'bg-yellow-600'"
                                class="p-2 text-white rounded-lg hover:opacity-90 transition-opacity">
                            <span x-text="property.status === 'approved' ? 'Approved' : 'Pending'"></span>
                        </button>
                    </div>

                    <!-- Tags Container -->
                    <div class="absolute top-2 left-2 flex flex-col gap-1">
                        <button @click="toggleFeatured(property)"
                                :class="property.is_featured ? 'bg-secondary/90' : 'bg-gray-600/90'"
                                class="text-white px-3 py-1 rounded-full text-xs flex items-center gap-1 shadow-lg backdrop-blur-sm hover:opacity-90 transition-opacity">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                            </svg>
                            <span x-text="property.is_featured ? 'Featured' : 'Set Featured'"></span>
                        </button>

                        <button @click="toggleExclusive(property)"
                                :class="property.is_exclusive ? 'bg-accent/90' : 'bg-gray-600/90'"
                                class="text-white px-3 py-1 rounded-full text-xs flex items-center gap-1 shadow-lg backdrop-blur-sm hover:opacity-90 transition-opacity">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 1L3 5V11C3 16.55 6.84 21.74 12 23C17.16 21.74 21 16.55 21 11V5L12 1Z"/>
                            </svg>
                            <span x-text="property.is_exclusive ? 'Exclusive' : 'Set Exclusive'"></span>
                        </button>
                    </div>

                    <!-- Price Tag -->
                    <div class="absolute bottom-2 left-2 bg-primary/95 px-4 py-2 rounded-full shadow-lg backdrop-blur-sm">
                        <span class="text-lg font-bold text-white" x-text="'₱' + Number(property.price).toLocaleString()"></span>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="p-4 sm:p-6 space-y-6">
                    <!-- Title & Location -->
                    <div>
                        <h1 class="text-lg sm:text-xl font-bold text-gray-900 mb-2" x-text="property.title"></h1>

                        <div class="flex items-center text-secondary text-sm mb-4">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span x-text="property.location"></span>
                        </div>

                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-gray-600 text-sm leading-relaxed italic line-clamp-3"
                               x-text="property.description"></p>
                        </div>
                    </div>

                    <!-- Property Details Grid -->
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Bedrooms -->
                        <div class="bg-form/80 p-3 rounded-lg flex items-center gap-2">
                            <div class="p-1 bg-primary/10 rounded-md">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 12h16m-8-6v6m-8 3h16v3H4v-3zm0-6h4v3H4v-3zm12 0h4v3h-4v-3z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Bedrooms</p>
                                <p class="text-sm font-semibold text-primary" x-text="property.bedrooms"></p>
                            </div>
                        </div>

                        <!-- Bathrooms -->
                        <div class="bg-form/80 p-3 rounded-lg flex items-center gap-2">
                            <div class="p-1 bg-primary/10 rounded-md">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M21 10H3m0 0v8a2 2 0 002 2h14a2 2 0 002-2v-8M3 10V6a2 2 0 012-2h2m14 6h-6m-6 0H7m0-4v4"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Bathrooms</p>
                                <p class="text-sm font-semibold text-primary" x-text="property.bathrooms"></p>
                            </div>
                        </div>

                        <!-- Admin Actions -->
                        <div class="col-span-2 flex justify-between gap-2 mt-4">
                            <button @click="editProperty(property.id)"
                                    class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                Edit Property
                            </button>
                            <button @click="deleteProperty(property.id)"
                                    class="flex-1 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                                Delete Property
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
function propertyManagement() {
    return {
        searchId: '',
        searchType: '',
        searchStatus: '',
        properties: @json($properties ?? []),
        loading: false,

        async performSearch() {
            this.loading = true;
            try {
                const response = await fetch('/admin/properties/search', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        property_id: this.searchId,
                        type: this.searchType,
                        status: this.searchStatus
                    })
                });

                if (!response.ok) throw new Error('Search failed');
                this.properties = await response.json();
            } catch (error) {
                console.error('Search error:', error);
                this.showNotification('error', 'Failed to search properties');
            } finally {
                this.loading = false;
            }
        },

        async toggleStatus(property) {
            try {
                const response = await fetch(`/admin/properties/${property.id}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (!response.ok) throw new Error('Failed to update status');
                property.status = property.status === 'pending' ? 'approved' : 'pending';
                this.showNotification('success', 'Status updated successfully');
            } catch (error) {
                console.error('Status toggle error:', error);
                this.showNotification('error', 'Failed to update status');
            }
        },

        async toggleFeatured(property) {
            try {
                const response = await fetch(`/admin/properties/${property.id}/toggle-featured`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (!response.ok) throw new Error('Failed to update featured status');
                property.is_featured = !property.is_featured;
                this.showNotification('success', 'Featured status updated successfully');
            } catch (error) {
                console.error('Featured toggle error:', error);
                this.showNotification('error', 'Failed to update featured status');
            }
        },

        async toggleExclusive(property) {
            try {
                const response = await fetch(`/admin/properties/${property.id}/toggle-exclusive`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (!response.ok) throw new Error('Failed to update exclusive status');
                property.is_exclusive = !property.is_exclusive;
                this.showNotification('success', 'Exclusive status updated successfully');
            } catch (error) {
                console.error('Exclusive toggle error:', error);
                this.showNotification('error', 'Failed to update exclusive status');
            }
        },

        editProperty(id) {
            window.location.href = `/admin/properties/${id}/edit`;
        },

async deleteProperty(id) {
    if (!confirm('Are you sure you want to delete this property?')) return;

    try {
        const response = await fetch(`/admin/properties/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        if (!response.ok) throw new Error('Deletion failed');

        this.properties = this.properties.filter(p => p.id !== id);
        this.showNotification('success', 'Property deleted successfully');
    } catch (error) {
        console.error('Deletion error:', error);
        this.showNotification('error', 'Failed to delete property');
    }
},

showNotification(type, message) {
    window.dispatchEvent(new CustomEvent('notify', {
        detail: {
            id: Date.now(),
            type: type,
            message: message
        }
    }));
},

formatNumber(number) {
    return new Intl.NumberFormat('en-PH').format(number);
},

formatDate(date) {
    return new Date(date).toLocaleDateString('en-PH', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
},

init() {
    // Watch for changes in URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    this.searchId = urlParams.get('property_id') || '';
    this.searchType = urlParams.get('type') || '';
    this.searchStatus = urlParams.get('status') || '';

    // Perform initial search if there are URL parameters
    if (this.searchId || this.searchType || this.searchStatus) {
        this.performSearch();
    }

    // Listen for browser back/forward buttons
    window.addEventListener('popstate', () => {
        const newParams = new URLSearchParams(window.location.search);
        this.searchId = newParams.get('property_id') || '';
        this.searchType = newParams.get('type') || '';
        this.searchStatus = newParams.get('status') || '';
        this.performSearch();
    });
}
}
}
</script>

<!-- Notification Component -->
<div
x-data="{ notifications: [] }"
@notify.window="notifications.push({
id: $event.detail.id,
type: $event.detail.type,
message: $event.detail.message
});
setTimeout(() => {
notifications = notifications.filter(n => n.id !== $event.detail.id);
}, 3000)"
class="fixed bottom-4 right-4 z-50 space-y-2"
>
<template x-for="notification in notifications" :key="notification.id">
<div
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="transform translate-x-full opacity-0"
    x-transition:enter-end="transform translate-x-0 opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="transform translate-x-0 opacity-100"
    x-transition:leave-end="transform translate-x-full opacity-0"
    :class="{
        'bg-green-500': notification.type === 'success',
        'bg-red-500': notification.type === 'error'
    }"
    class="rounded-lg shadow-lg p-4 text-white flex items-center space-x-2"
>
    <span x-text="notification.message"></span>
    <button @click="notifications = notifications.filter(n => n.id !== notification.id)"
            class="text-white hover:text-gray-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>
</template>
</div>
