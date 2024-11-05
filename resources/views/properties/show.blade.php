@extends('layouts.app')

@section('content')
<!-- Main Container -->
<div class="min-h-screen bg-gray-50/50">
    <!-- Modal Container -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-16">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-transform duration-300 hover:scale-[1.01]">
            <!-- Image Section -->
            <div class="relative">
                @if(is_object($property) && isset($property->image) && file_exists(public_path($property->image)))
                    <img src="{{ asset($property->image) }}"
                         alt="{{ $property->title }}"
                         class="w-full h-[300px] sm:h-[400px] object-cover"
                         onerror="this.src='{{ asset('images/no-image.jpg') }}'">
                @else
                    <img src="{{ asset('images/no-image.jpg') }}"
                         alt="No image available"
                         class="w-full h-[300px] sm:h-[400px] object-cover">
                @endif

                <!-- Property ID Badge -->
                <div class="absolute top-4 right-16 bg-white/90 px-4 py-2 rounded-full backdrop-blur-sm shadow-lg">
                    <span class="text-sm font-semibold text-primary">
                        Property ID: {{ is_object($property) ? $property->id : $property['id'] }}
                    </span>
                </div>

                <!-- Tags Container -->
                <div class="absolute top-4 left-4 flex flex-col gap-2">
                    @if(is_object($property) ? ($property->is_featured ?? false) : ($property['is_featured'] ?? false))
                        <span class="bg-secondary/90 text-white px-4 py-2 rounded-full text-sm flex items-center gap-2 shadow-lg backdrop-blur-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                            </svg>
                            Featured
                        </span>
                    @endif
                    @if(is_object($property) ? ($property->is_exclusive ?? false) : ($property['is_exclusive'] ?? false))
                        <span class="bg-accent/90 text-white px-4 py-2 rounded-full text-sm flex items-center gap-2 shadow-lg backdrop-blur-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 1L3 5V11C3 16.55 6.84 21.74 12 23C17.16 21.74 21 16.55 21 11V5L12 1Z"/>
                            </svg>
                            Exclusive
                        </span>
                    @endif
                </div>

                <!-- Price Tag -->
                <div class="absolute bottom-4 left-4 bg-primary/95 px-6 py-3 rounded-full shadow-lg backdrop-blur-sm">
                    <span class="text-2xl font-bold text-white">
                        ₱{{ number_format(is_object($property) ? $property->price : $property['price'], 2) }}
                    </span>
                </div>

                <!-- Close Button -->
                <button onclick="window.history.back()"
                        class="absolute top-4 right-4 bg-white/95 text-primary p-3 rounded-full shadow-lg backdrop-blur-sm hover:bg-white transition-all duration-300 hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Content Section -->
            <div class="p-6 sm:p-8 space-y-8">
                <!-- Title & Location -->
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">
                        {{ is_object($property) ? $property->title : $property['title'] }}
                    </h1>

                    <!-- Location Details -->
                    <div class="flex flex-col gap-2 mb-6">
                        <div class="flex items-center text-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <div class="flex flex-col">
                                <span class="text-lg font-medium text-secondary">
                                    {{ is_object($property) ? $property->location : $property['location'] }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    {{ is_object($property) ? $property->property_address : $property['property_address'] }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-gray-600 leading-relaxed italic">
                            {{ is_object($property) ? $property->description : $property['description'] }}
                        </p>
                    </div>
                </div>

<!-- Property Details Grid -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <!-- Bedrooms -->
    <div class="bg-form/80 p-4 rounded-xl">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-primary/10 rounded-lg">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12h16m-8-6v6m-8 3h16v3H4v-3zm0-6h4v3H4v-3zm12 0h4v3h-4v-3z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Bedrooms</p>
                <p class="text-lg font-semibold text-primary">
                    {{ is_object($property) ? ($property->beds ?? $property->bedrooms) : ($property['beds'] ?? $property['bedrooms']) }}
                </p>
            </div>
        </div>
    </div>

    <!-- Bathrooms -->
    <div class="bg-form/80 p-4 rounded-xl">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-primary/10 rounded-lg">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10H3m0 0v8a2 2 0 002 2h14a2 2 0 002-2v-8M3 10V6a2 2 0 012-2h2m14 6h-6m-6 0H7m0-4v4"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Bathrooms</p>
                <p class="text-lg font-semibold text-primary">
                    {{ is_object($property) ? ($property->baths ?? $property->bathrooms) : ($property['baths'] ?? $property['bathrooms']) }}
                </p>
            </div>
        </div>
    </div>

    <!-- Floor Area -->
    <div class="bg-form/80 p-4 rounded-xl">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-primary/10 rounded-lg">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Floor Area</p>
                <p class="text-lg font-semibold text-primary">
                    {{ is_object($property) ? ($property->area_sqm ?? $property->sqm) : ($property['area_sqm'] ?? $property['sqm']) }} sqm
                </p>
            </div>
        </div>
    </div>

    <!-- Property Type -->
    <div class="bg-form/80 p-4 rounded-xl">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-primary/10 rounded-lg">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Property Type</p>
                <p class="text-lg font-semibold text-primary capitalize">
                    {{ is_object($property) ? $property->property_type : $property['property_type'] }}
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Amenities Section -->
<div class="border-t border-gray-100 pt-6 mb-8">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">Property Features</h2>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        @if(is_object($property) ? ($property->swimming_pool ?? false) : ($property['swimming_pool'] ?? false))
            <div class="flex items-center gap-2 bg-form/60 p-3 rounded-xl">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span class="text-sm">Swimming Pool</span>
            </div>
        @endif

        @if(is_object($property) ? ($property->gym_access ?? false) : ($property['gym_access'] ?? false))
            <div class="flex items-center gap-2 bg-form/60 p-3 rounded-xl">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/>
                </svg>
                <span class="text-sm">Gym Access</span>
            </div>
        @endif

        @if(is_object($property) ? ($property->living_room ?? false) : ($property['living_room'] ?? false))
            <div class="flex items-center gap-2 bg-form/60 p-3 rounded-xl">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <span class="text-sm">Living Room</span>
            </div>
        @endif

        @if(is_object($property) ? ($property->dining_room ?? false) : ($property['dining_room'] ?? false))
            <div class="flex items-center gap-2 bg-form/60 p-3 rounded-xl">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M3 6h18M3 18h18"/>
                </svg>
                <span class="text-sm">Dining Room</span>
            </div>
        @endif
    </div>
</div>

<!-- Contact Section -->
<div class="text-center pt-4 border-t border-gray-200">
    <h2 class="text-2xl font-semibold mb-4">Contact Information</h2>
    <div class="flex items-center justify-center gap-8">
        @php
            $whatsapp = is_object($property) ? ($property->contact_whatsapp ?? null) : ($property['contact_whatsapp'] ?? null);
            $messenger = is_object($property) ? ($property->contact_messenger ?? null) : ($property['contact_messenger'] ?? null);
            $email = is_object($property) ? ($property->contact_email ?? null) : ($property['contact_email'] ?? null);
        @endphp

        @if($whatsapp)
        <div class="flex items-center gap-2">
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}"
               target="_blank"
               class="text-[#25D366] hover:text-[#128C7E] transition-colors bg-form/50 p-4 rounded-full">
               <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="currentColor" viewBox="0 0 32 32">
                   <path d="M16.013 3C8.83 3.013 3.014 8.83 3 16.013a12.988 12.988 0 0 0 2.21 7.245L3 29l5.84-2.183a12.99 12.99 0 0 0 7.174 2.196C23.2 29 29 23.2 29 16.013 29 8.822 23.195 3 16.013 3Zm7.541 18.3c-.35.984-1.73 1.807-2.427 1.897-.66.082-1.45.126-2.35-.144a13.888 13.888 0 0 1-3.734-1.795c-2.766-1.492-4.578-4.97-4.715-5.189-.137-.22-1.13-1.51-1.13-2.88s.716-2.05.973-2.33c.258-.285.562-.357.75-.357l.87.016c.277 0 .592-.09.923.66.33.752 1.166 2.143 1.27 2.292.104.149.139.321.027.52-.111.197-.175.318-.348.49l-.522.518c-.175.173-.354.36-.152.717.202.357.895 1.523 1.92 2.47 1.314 1.173 2.422 1.537 2.766 1.708.344.172.641.136.879-.057.238-.193.974-.93 1.232-1.269.257-.34.509-.285.855-.171.347.114 2.35 1.115 2.752 1.325.401.21.67.319.768.496.098.178.098.935-.25 1.92Z"/>
               </svg>
            </a>
            <p class="text-sm">WhatsApp</p>
        </div>
        @endif

        @if($messenger)
        <div class="flex items-center gap-2">
            <a href="{{ $messenger }}"
               target="_blank"
               class="transition-colors">
               <svg class="w-10 h-10 fill-current" viewBox="0 0 24 24" style="filter: drop-shadow(0 1px 2px rgb(0 0 0 / 0.1));">
                    <defs>
                        <linearGradient id="messengerGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#FF4E8D;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#0088FF;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                    <path fill="url(#messengerGradient)"
                          d="M12 0C5.373 0 0 4.974 0 11.111c0 3.498 1.744 6.617 4.472 8.652v4.237l4.086-2.242c1.09.301 2.246.464 3.442.464 6.627 0 12-4.974 12-11.111C24 4.974 18.627 0 12 0zm1.193 14.963l-3.056-3.259-5.963 3.259 6.559-6.963 3.13 3.259 5.889-3.259-6.559 6.963z"/>
                </svg>
            </a>
            <p class="text-sm">Messenger</p>
        </div>
        @endif

        @if($email)
        <div class="flex items-center gap-2">
            <a href="mailto:{{ $email }}"
               class="transition-colors">
               <svg class="w-10 h-10" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="outlookGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#0078D4" />
                            <stop offset="100%" style="stop-color:#1E88E5" />
                        </linearGradient>
                    </defs>
                    <path d="M22 8.608V16.5C22 17.887 20.887 19 19.5 19H4.5C3.113 19 2 17.887 2 16.5V8.608L11.526 13.87C11.827 14.034 12.173 14.034 12.474 13.87L22 8.608ZM19.5 5C20.887 5 22 6.113 22 7.5V7.63L12 13.17L2 7.63V7.5C2 6.113 3.113 5 4.5 5H19.5Z"
                          fill="url(#outlookGradient)"/>
                    <path d="M22 7.63V8.608L12.474 13.87C12.173 14.034 11.827 14.034 11.526 13.87L2 8.608V7.63L12 13.17L22 7.63Z"
                          fill="#0078D4"
                          fill-opacity="0.2"/>
               </svg>
            </a>
            <p class="text-sm">Email</p>
        </div>
        @endif
    </div>
</div>

</div>
</div>
</div>
</div>
@endsection
