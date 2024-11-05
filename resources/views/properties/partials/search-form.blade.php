<form action="{{ route('properties.search') }}" method="GET" class="max-w-3xl mx-auto">
    <div class="relative">
        <input type="text"
               name="search"
               placeholder="Search properties by location, type, or features..."
               value="{{ request('search') }}"
               class="w-full px-6 py-4 pl-12 text-lg rounded-full border-2 border-[#052e16] focus:outline-none focus:border-[#1a4731] text-gray-800 shadow-lg">
        <button type="submit" class="absolute left-4 top-1/2 transform -translate-y-1/2">
            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </button>
    </div>
</form>
