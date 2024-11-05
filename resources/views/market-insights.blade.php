@extends('layouts.app')

@section('content')
<!-- Market Insights Section -->
<div class="min-h-screen bg-cover bg-center bg-fixed" style="background-image: url('{{ asset('uploads/uploads/homepage.jpg') }}');">
    <div class="min-h-screen bg-black bg-opacity-50 backdrop-filter backdrop-blur-sm flex flex-col">
        <!-- Hero Section -->
        <div class="py-24">
            <div class="container mx-auto px-4">
                <h1 class="text-5xl font-bold text-white mb-4 text-center">Market Insights</h1>
                <p class="text-xl text-white text-center">Stay informed with the latest real estate trends</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-grow container mx-auto px-4 flex flex-col">
            <!-- Key Metrics Widgets -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                <x-metric-widget title="Average Property Price" :value="'₱' . number_format(end($propertyPriceData)['price'])" icon="currency-peso" color="bg-[#8fc79a]" />
                <x-metric-widget title="Total Sales" :value="number_format(array_sum(array_column($propertySalesData, 'sales')))" icon="chart-bar" color="bg-green-500" />
                <x-metric-widget title="Active Listings" :value="number_format(end($propertySalesData)['listings'])" icon="home" color="bg-[#5E9387]" />
            </div>

            <!-- Market Overview and Future Projections -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-white mb-4">Market Overview</h2>
                    <p class="text-gray-200 mb-4">The real estate market has shown resilience and adaptability in recent times. Despite global economic challenges, property values have remained stable in many regions, with some areas experiencing significant growth.</p>
                    <p class="text-gray-200">Factors such as low interest rates, changing work patterns, and evolving lifestyle preferences continue to shape the market dynamics, creating both opportunities and challenges for buyers, sellers, and investors alike.</p>
                </div>
                <div class="bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-white mb-4">Future Projections</h2>
                    <p class="text-gray-200 mb-4">Experts predict a continued trend towards suburbanization and increased demand for properties with home office spaces. The rental market is expected to remain strong in urban centers, while rural areas may see increased interest from remote workers.</p>
                    <p class="text-gray-200">Sustainability and energy efficiency are becoming increasingly important factors in property valuation, with eco-friendly homes expected to command premium prices in the coming years.</p>
                </div>
            </div>

            <!-- Market Trends -->
            <div class="mb-8">
                <h2 class="text-3xl font-bold mb-6 text-center text-white">Current Market Trends</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($marketTrends as $trend)
                        <x-trend-widget :trend="$trend" />
                    @endforeach
                </div>
            </div>

            <!-- Regional Insights -->
            <div class="mb-8">
                <h2 class="text-3xl font-bold mb-6 text-center text-white">Regional Insights</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($regionalInsights as $insight)
                        <x-insight-widget :insight="$insight" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-white">
    <div class="container mx-auto px-4 py-24">
        <div class="text-center max-w-4xl mx-auto">
            <h2 class="text-5xl font-bold text-[#052e16] mb-6">Ready to Make Your Move?</h2>
            <p class="text-xl text-gray-600 mb-12">Our expert real estate agents are here to guide you through the current market conditions and help you make informed decisions.</p>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="bg-[#052e16] bg-opacity-5 rounded-lg p-8 shadow-lg hover:shadow-xl transition duration-300">
                    <div class="text-[#052e16] mb-4">
                        <i class="fas fa-chart-line text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-[#052e16] mb-3">Market Expertise</h3>
                    <p class="text-gray-600">Access in-depth local market insights and property valuations</p>
                </div>
                <div class="bg-[#052e16] bg-opacity-5 rounded-lg p-8 shadow-lg hover:shadow-xl transition duration-300">
                    <div class="text-[#052e16] mb-4">
                        <i class="fas fa-home text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-[#052e16] mb-3">Dedicated Support</h3>
                    <p class="text-gray-600">Personal guidance throughout your real estate journey</p>
                </div>
                <div class="bg-[#052e16] bg-opacity-5 rounded-lg p-8 shadow-lg hover:shadow-xl transition duration-300">
                    <div class="text-[#052e16] mb-4">
                        <i class="fas fa-clock text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-[#052e16] mb-3">Fast Response</h3>
                    <p class="text-gray-600">Quick response times and flexible scheduling</p>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="{{ route('contact') }}" class="bg-[#052e16] text-white px-8 py-4 rounded-lg font-semibold hover:bg-opacity-90 transition duration-300 text-lg inline-flex items-center">
                    <i class="fas fa-user-tie mr-2"></i>
                    Contact an Agent
                </a>
            </div>

            <!-- Additional Info -->
            <p class="text-gray-500 mt-8">
                Free consultation • Fast response within 24 hours • Personalized service
            </p>
        </div>
    </div>
</div>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
