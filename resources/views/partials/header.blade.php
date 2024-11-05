@php
$navItems = [
    ['route' => 'home', 'name' => 'Home'],
    ['route' => 'about', 'name' => 'About'],
    ['route' => 'properties.index', 'name' => 'Properties'],
    ['route' => 'agents', 'name' => 'Agents'],
    ['route' => 'market-insights', 'name' => 'Market Insights']
];

// Add List/Sell Property nav item only for authorized users
if (auth()->check() && auth()->user()->canListProperty()) {
    $navItems[] = ['route' => 'list-sell-property', 'name' => 'List/Sell Property'];
}

// Add remaining nav items
$navItems = array_merge($navItems, [
    ['route' => 'contact', 'name' => 'Contact'],
    ['route' => 'forms.index', 'name' => 'Forms'],
]);
@endphp

<header x-data="{ isOpen: false }" class="bg-white fixed w-full z-10 shadow-md">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo Section -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center">
                    <svg class="h-6 w-6 lg:h-8 lg:w-8 text-white bg-gradient-to-r from-primary to-secondary p-1 rounded" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                    <span class="text-lg lg:text-xl xl:text-2xl font-bold text-primary ml-2">{{ config('app.name', 'AJ Real Estate') }}</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex lg:items-center lg:justify-center flex-1">
                @foreach ($navItems as $item)
                    <a href="{{ route($item['route']) }}"
                       class="{{ request()->routeIs($item['route']) ? 'text-primary border-b-2 border-primary' : 'text-gray-600 hover:text-primary hover:border-primary border-b-2 border-transparent' }} inline-flex items-center px-1 pt-1 text-sm font-medium transition duration-150 ease-in-out mx-2">
                        {{ $item['name'] }}
                    </a>
                @endforeach
            </div>

            <!-- Desktop Right Section -->
            <div class="hidden lg:flex lg:items-center lg:space-x-4">
                <!-- WhatsApp Button -->
                <a href="https://wa.me/your_whatsapp_number" target="_blank" class="text-[#25D366] hover:text-[#128C7E] flex items-center transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 lg:h-6 lg:w-6 mr-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.1.824zm-3.423-14.416c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm.029 18.88c-1.161 0-2.305-.292-3.318-.844l-3.677.964.984-3.595c-.607-1.052-.927-2.246-.926-3.468.001-3.825 3.113-6.937 6.937-6.937 1.856.001 3.598.723 4.907 2.034 1.31 1.311 2.031 3.054 2.03 4.908-.001 3.825-3.113 6.938-6.937 6.938z"/>
                    </svg>
                    <span class="text-xs lg:text-sm">WhatsApp</span>
                </a>

                <!-- Messenger Button -->
                <a href="https://m.me/your_facebook_page" target="_blank" class="flex items-center transition duration-300">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 mr-1 fill-current" viewBox="0 0 24 24" style="filter: drop-shadow(0 1px 2px rgb(0 0 0 / 0.1));">
                        <defs>
                            <linearGradient id="messengerGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" style="stop-color:#FF4E8D;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#0088FF;stop-opacity:1" />
                            </linearGradient>
                        </defs>
                        <path fill="url(#messengerGradient)" d="M12 0C5.373 0 0 4.974 0 11.111c0 3.498 1.744 6.617 4.472 8.652v4.237l4.086-2.242c1.09.301 2.246.464 3.442.464 6.627 0 12-4.974 12-11.111C24 4.974 18.627 0 12 0zm1.193 14.963l-3.056-3.259-5.963 3.259 6.559-6.963 3.13 3.259 5.889-3.259-6.559 6.963z"/>
                    </svg>
                    <span class="text-xs lg:text-sm">Messenger</span>
                </a>

                <!-- Auth Section -->
                @auth
                    <div class="relative group" x-data="{ open: false }">
                        <button @click="open = !open" class="text-[#052e16] hover:text-[#1a2e05] flex items-center transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 lg:h-6 lg:w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="text-xs lg:text-sm">{{ auth()->user()->name }}</span>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-10">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="{{ route('profile.submitted-forms') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Submitted Forms</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-[#052e16] hover:text-[#1a2e05] flex items-center transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 lg:h-6 lg:w-6 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                            <polyline points="10 17 15 12 10 7"></polyline>
                            <line x1="15" y1="12" x2="3" y2="12"></line>
                        </svg>
                        <span class="text-xs lg:text-sm">Login</span>
                    </a>
                    <a href="{{ route('register') }}" class="text-[#052e16] hover:text-[#1a2e05] flex items-center transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 lg:h-6 lg:w-6 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="8.5" cy="7" r="4"></circle>
                            <line x1="20" y1="8" x2="20" y2="14"></line>
                            <line x1="23" y1="11" x2="17" y2="11"></line>
                        </svg>
                        <span class="text-xs lg:text-sm">Sign Up</span>
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex items-center lg:hidden">
                <button @click="isOpen = !isOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6" x-show="isOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div x-show="isOpen" class="lg:hidden bg-white border-t border-gray-200" id="mobile-menu" style="display: none;">
        <div class="pt-2 pb-3 space-y-1">
            @foreach ($navItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="{{ request()->routeIs($item['route']) ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }} block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs($item['route']) ? 'border-primary' : 'border-transparent' }} text-base font-medium">
                    {{ $item['name'] }}
                </a>
            @endforeach
        </div>

        <!-- Mobile Social Links -->
        <div class="pt-4 pb-3 border-t border-gray-200">
            <div class="flex items-center px-4 space-x-3">
                <a href="https://wa.me/your_whatsapp_number" target="_blank" class="text-[#25D366] hover:text-[#128C7E] flex items-center transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l
-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.1.824zm-3.423-14.416c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm.029 18.88c-1.161 0-2.305-.292-3.318-.844l-3.677.964.984-3.595c-.607-1.052-.927-2.246-.926-3.468.001-3.825 3.113-6.937 6.937-6.937 1.856.001 3.598.723 4.907 2.034 1.31 1.311 2.031 3.054 2.03 4.908-.001 3.825-3.113 6.938-6.937 6.938z"/>
                    </svg>
                    <span class="text-sm">WhatsApp</span>
                </a>
                <a href="https://m.me/your_facebook_page" target="_blank" class="flex items-center transition duration-300">
                    <svg class="w-5 h-5 mr-2 fill-current" viewBox="0 0 24 24" style="filter: drop-shadow(0 1px 2px rgb(0 0 0 / 0.1));">
                        <defs>
                            <linearGradient id="messengerGradientMobile" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" style="stop-color:#FF4E8D;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#0088FF;stop-opacity:1" />
                            </linearGradient>
                        </defs>
                        <path fill="url(#messengerGradientMobile)" d="M12 0C5.373 0 0 4.974 0 11.111c0 3.498 1.744 6.617 4.472 8.652v4.237l4.086-2.242c1.09.301 2.246.464 3.442.464 6.627 0 12-4.974 12-11.111C24 4.974 18.627 0 12 0zm1.193 14.963l-3.056-3.259-5.963 3.259 6.559-6.963 3.13 3.259 5.889-3.259-6.559 6.963z"/>
                    </svg>
                    <span class="text-sm">Messenger</span>
                </a>
            </div>

            <!-- Mobile Auth Menu -->
            @auth
                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        Profile
                    </a>
                    <a href="{{ route('profile.submitted-forms') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        My Submitted Forms
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                            Log Out
                        </button>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        Sign Up
                    </a>
                </div>
            @endauth
        </div>
    </div>
</header>
