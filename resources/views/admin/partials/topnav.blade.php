{{-- resources/views/admin/partials/topnav.blade.php --}}
<nav class="bg-white shadow-md">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Mobile menu button -->
            <div class="flex items-center lg:hidden">
                <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-600">
                    <x-icon name="bars-3" class="w-6 h-6" />
                </button>
            </div>

            <!-- User Menu -->
            <div class="flex items-center">
                <x-admin.user-menu />
            </div>
        </div>
    </div>
</nav>

{{-- resources/views/admin/partials/sidebar.blade.php --}}
<aside class="fixed inset-y-0 left-0 bg-green-900 w-64 transform transition-transform duration-200 ease-in-out z-30"
       :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
    <!-- Logo -->
    <div class="flex items-center justify-between h-16 px-6 bg-green-800">
        <span class="text-xl font-semibold text-white">Admin Panel</span>
        <button @click="sidebarOpen = false" class="lg:hidden text-white">
            <x-icon name="x" class="w-6 h-6" />
        </button>
    </div>

    <!-- Navigation -->
    <nav class="mt-5 px-4 space-y-2">
        <x-admin.nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
            <x-icon name="home" class="w-5 h-5 mr-3" />
            <span>{{ __('Dashboard') }}</span>
        </x-admin.nav-link>

        <x-admin.nav-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.*')">
            <x-icon name="users" class="w-5 h-5 mr-3" />
            <span>{{ __('Users') }}</span>
        </x-admin.nav-link>

        <x-admin.nav-link href="{{ route('admin.properties.index') }}" :active="request()->routeIs('admin.properties.*')">
            <x-icon name="building-office-2" class="w-5 h-5 mr-3" />
            <span>{{ __('Properties') }}</span>
        </x-admin.nav-link>

        <div x-data="{ open: false }">
            <button @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-2 text-white hover:bg-green-800 rounded-lg">
                <div class="flex items-center">
                    <x-icon name="document-text" class="w-5 h-5 mr-3" />
                    <span>{{ __('Forms') }}</span>
                </div>
                <x-icon name="chevron-down" class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" />
            </button>

            <div x-show="open" class="mt-2 pl-11 space-y-2">
                <a href="{{ route('admin.forms.inquiries.index') }}"
                   class="block text-white hover:text-gray-300">{{ __('Contact Inquiries') }}</a>
                <a href="{{ route('admin.forms.listings.index') }}"
                   class="block text-white hover:text-gray-300">{{ __('Listing Agreements') }}</a>
                <a href="{{ route('admin.forms.disclosures.index') }}"
                   class="block text-white hover:text-gray-300">{{ __('Property Disclosures') }}</a>
                <a href="{{ route('admin.forms.purchases.index') }}"
                   class="block text-white hover:text-gray-300">{{ __('Purchase Agreements') }}</a>
            </div>
        </div>

        <x-admin.nav-link href="{{ route('admin.reports.index') }}" :active="request()->routeIs('admin.reports.*')">
            <x-icon name="chart-bar" class="w-5 h-5 mr-3" />
            <span>{{ __('Reports') }}</span>
        </x-admin.nav-link>
    </nav>
</aside>
