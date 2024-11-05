{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div x-data="{
    activeTab: 'dashboard',
    stats: {
        totalProperties: {{ $totalProperties }},
        activeListings: {{ $activeListings }},
        totalUsers: {{ $totalUsers }},
        pendingInquiries: {{ $pendingInquiries }},
        formStats: {
            purchaseAgreements: {{ $formStats['purchaseAgreements'] }},
            propertyDisclosures: {{ $formStats['propertyDisclosures'] }},
            contactInquiries: {{ $formStats['contactInquiries'] }}
        }
    },
    init() {
        this.pollStats();
    },
    async pollStats() {
        setInterval(async () => {
            try {
                const response = await fetch('/api/admin/dashboard-stats');
                const data = await response.json();
                this.stats = data;
            } catch (error) {
                console.error('Failed to fetch dashboard stats:', error);
            }
        }, 5000);
    }
}" class="min-h-screen bg-cover bg-center mt-16 sm:mt-20 md:mt-24 lg:mt-28 mb-auto" style="background-image: url('{{ asset('uploads/uploads/propertiescover.jpg') }}');">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>

    <div class="container relative mx-auto px-4 py-6 z-10">
        <div class="bg-[#052e16] bg-opacity-90 backdrop-filter backdrop-blur-xl rounded-xl shadow-2xl p-8 border border-green-700">
            <!-- Navigation Tabs -->
            <div class="mb-8 bg-white/10 rounded-lg p-2">
                <nav class="flex flex-wrap gap-2" aria-label="Tabs">
                    <button @click="activeTab = 'dashboard'"
                            :class="{'bg-green-700 text-white shadow-lg': activeTab === 'dashboard',
                                    'bg-white/10 text-white hover:bg-white/20': activeTab !== 'dashboard'}"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300">
                        Dashboard Overview
                    </button>
                    <button @click="activeTab = 'properties'"
                            :class="{'bg-green-700 text-white shadow-lg': activeTab === 'properties',
                                    'bg-white/10 text-white hover:bg-white/20': activeTab !== 'properties'}"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300">
                        Properties Management
                    </button>
                    <button @click="activeTab = 'list-sell'"
                            :class="{'bg-green-700 text-white shadow-lg': activeTab === 'list-sell',
                                    'bg-white/10 text-white hover:bg-white/20': activeTab !== 'list-sell'}"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300">
                        List/Sell Properties
                    </button>
                    <button @click="activeTab = 'users'"
                            :class="{'bg-green-700 text-white shadow-lg': activeTab === 'users',
                                    'bg-white/10 text-white hover:bg-white/20': activeTab !== 'users'}"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300">
                        Users Management
                    </button>
                    <button @click="activeTab = 'forms'"
                            :class="{'bg-green-700 text-white shadow-lg': activeTab === 'forms',
                                    'bg-white/10 text-white hover:bg-white/20': activeTab !== 'forms'}"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300">
                        Forms
                    </button>
                </nav>
            </div>

            <!-- Content Area -->
            <div class="space-y-8">
                <!-- Dashboard Overview Tab -->
                <div x-show="activeTab === 'dashboard'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     class="space-y-8">

                    <!-- Welcome Message -->
                    <div class="bg-white bg-opacity-95 rounded-lg p-6 backdrop-filter backdrop-blur-md">
                        <p class="text-gray-800 text-lg leading-relaxed">
                            Welcome to your dashboard. Monitor your real estate activities, manage properties, and track form submissions all in one place. Here's an overview of your current statistics.
                        </p>
                    </div>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Total Properties -->
                        <div class="bg-white/10 border border-green-700 rounded-lg p-6 backdrop-filter backdrop-blur-md">
                            <div class="flex items-center">
                                <span class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-full bg-white/20">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </span>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-white/80">Total Properties</p>
                                    <p class="text-2xl font-semibold text-white" x-text="stats.totalProperties"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Active Listings -->
                        <div class="bg-white/10 border border-green-700 rounded-lg p-6 backdrop-filter backdrop-blur-md">
                            <div class="flex items-center">
                                <span class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-full bg-white/20">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                </span>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-white/80">Active Listings</p>
                                    <p class="text-2xl font-semibold text-white" x-text="stats.activeListings"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Total Users -->
                        <div class="bg-white/10 border border-green-700 rounded-lg p-6 backdrop-filter backdrop-blur-md">
                            <div class="flex items-center">
                                <span class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-full bg-white/20">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </span>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-white/80">Total Users</p>
                                    <p class="text-2xl font-semibold text-white" x-text="stats.totalUsers"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Inquiries -->
                        <div class="bg-white/10 border border-green-700 rounded-lg p-6 backdrop-filter backdrop-blur-md">
                            <div class="flex items-center">
                                <span class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-full bg-white/20">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                    </svg>
                                </span>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-white/80">Pending Inquiries</p>
                                    <p class="text-2xl font-semibold text-white" x-text="stats.pendingInquiries"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Submission Stats -->
                    <div class="bg-white/10 border border-green-700 rounded-lg p-6 backdrop-filter backdrop-blur-md">
                        <h2 class="text-lg font-medium text-white mb-6">Form Submissions Overview</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Purchase Agreements -->
                            <div class="bg-white/10 rounded-lg p-4 border border-green-600">
                                <div class="flex items-center">
                                    <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-white/20">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </span>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-white/80">Purchase Agreements</h3>
                                        <p class="text-xl font-semibold text-white" x-text="stats.formStats.purchaseAgreements"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Property Disclosures -->
                            <div class="bg-white/10 rounded-lg p-4 border border-green-600">
                                <div class="flex items-center">
                                    <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-white/20">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                                        </svg>
                                    </span>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-white/80">Property Disclosures</h3>
                                        <p class="text-xl font-semibold text-white" x-text="stats.formStats.propertyDisclosures"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Inquiries -->
                            <div class="bg-white/10 rounded-lg p-4 border border-green-600">
                                <div class="flex items-center">
                                    <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-white/20">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                        </svg>
                                    </span>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-white/80">Contact Inquiries</h3>
                                        <p class="text-xl font-semibold text-white" x-text="stats.formStats.contactInquiries"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- Properties Management Tab -->
            <div x-show="activeTab === 'properties'"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 class="space-y-6">
                @include('admin.dashboard.properties-management')
            </div>

            <!-- List/Sell Properties Tab -->
            <div x-show="activeTab === 'list-sell'"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 class="space-y-6">
                @include('admin.dashboard.list-sell-properties')
            </div>

            <!-- Users Management Tab -->
            <div x-show="activeTab === 'users'"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 class="space-y-6">
                @include('admin.dashboard.users-management')
            </div>

            <!-- Forms Tab -->
            <div x-show="activeTab === 'forms'"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 class="space-y-6">
                @include('admin.dashboard.forms-management')
            </div>
        </div>
    </div>
</div>
</div>
@push('scripts')
<script>
    // Initialize Alpine.js store for modals
    document.addEventListener('alpine:init', () => {
        Alpine.store('modal', {
            current: null,
            data: {},

            init() {
                this.handleModalEvents();
            },

            handleModalEvents() {
                window.addEventListener('open-modal', (event) => {
                    if (typeof event.detail === 'object') {
                        this.current = event.detail.name;
                        this.data = event.detail;
                    } else {
                        this.current = event.detail;
                        this.data = {};
                    }
                });
            },

            close() {
                this.current = null;
                this.data = {};
            }
        });
    });
</script>
@endpush
@endsection
