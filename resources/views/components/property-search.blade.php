<div class="w-full" x-data="propertySearch()">
    <!-- Search Section -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search Input -->
            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <div class="relative">
                    <input type="text"
                           x-model="searchQuery"
                           @input.debounce.300ms="search"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                           placeholder="Search by location, property type, or features...">
                    <svg class="absolute right-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Price Range -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Price Range</label>
                <select x-model="priceRange" @change="search" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <option value="">Any Price</option>
                    <option value="0-1000000">Under ₱1M</option>
                    <option value="1000000-5000000">₱1M - ₱5M</option>
                    <option value="5000000-10000000">₱5M - ₱10M</option>
                    <option value="10000000-50000000">₱10M - ₱50M</option>
                    <option value="50000000+">Above ₱50M</option>
                </select>
            </div>

            <!-- Property Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Property Type</label>
                <select x-model="propertyType" @change="search" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <option value="">All Types</option>
                    <option value="apartment">Apartment</option>
                    <option value="house">House</option>
                    <option value="condo">Condo</option>
                    <option value="townhouse">Townhouse</option>
                    <option value="lot">Lot</option>
                </select>
            </div>
        </div>

        <!-- Advanced Filters -->
        <div class="mt-4">
            <button @click="showFilters = !showFilters"
                    class="text-green-600 hover:text-green-800 text-sm font-medium flex items-center">
                <span x-text="showFilters ? 'Hide Filters' : 'Show More Filters'"></span>
                <svg :class="{'rotate-180': showFilters}" class="ml-1 h-4 w-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="showFilters"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                 class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">

                <!-- Bedrooms -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bedrooms</label>
                    <select x-model="beds" @change="search" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">Any</option>
                        <option value="1">1+</option>
                        <option value="2">2+</option>
                        <option value="3">3+</option>
                        <option value="4">4+</option>
                        <option value="5">5+</option>
                    </select>
                </div>

                <!-- Bathrooms -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bathrooms</label>
                    <select x-model="baths" @change="search" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">Any</option>
                        <option value="1">1+</option>
                        <option value="2">2+</option>
                        <option value="3">3+</option>
                        <option value="4">4+</option>
                    </select>
                </div>

                <!-- Amenities -->
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Amenities</label>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" x-model="amenities" value="swimming_pool" @change="search" class="rounded text-green-600 focus:ring-green-500">
                            <span class="text-sm text-gray-700">Swimming Pool</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" x-model="amenities" value="gym_access" @change="search" class="rounded text-green-600 focus:ring-green-500">
                            <span class="text-sm text-gray-700">Gym Access</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" x-model="amenities" value="living_room" @change="search" class="rounded text-green-600 focus:ring-green-500">
                            <span class="text-sm text-gray-700">Living Room</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" x-model="amenities" value="dining_room" @change="search" class="rounded text-green-600 focus:ring-green-500">
                            <span class="text-sm text-gray-700">Dining Room</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Count -->
    <div class="mb-4 text-gray-600" x-show="hasSearched">
        <span x-text="resultsCount"></span> properties found
    </div>

    <!-- Results Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" x-show="hasSearched">
        <template x-for="property in searchResults" :key="property.id">
            <x-property-card :property="property" />
        </template>
    </div>

    <!-- No Results Message -->
    <div x-show="hasSearched && searchResults.length === 0" class="text-center py-8">
        <p class="text-gray-500 text-lg">No properties found matching your criteria</p>
    </div>
</div>

<!-- Alpine.js Script -->
<script>
function propertySearch() {
    return {
        searchQuery: '',
        priceRange: '',
        propertyType: '',
        beds: '',
        baths: '',
        amenities: [],
        showFilters: false,
        searchResults: [],
        hasSearched: false,
        resultsCount: 0,

        async search() {
            const params = new URLSearchParams({
                query: this.searchQuery,
                price_range: this.priceRange,
                property_type: this.propertyType,
                beds: this.beds,
                baths: this.baths,
                amenities: JSON.stringify(this.amenities)
            });

            try {
                const response = await fetch(`/api/properties/search?${params}`);
                const data = await response.json();
                this.searchResults = data.properties;
                this.resultsCount = data.total;
                this.hasSearched = true;
            } catch (error) {
                console.error('Search failed:', error);
            }
        }
    }
}
</script>
