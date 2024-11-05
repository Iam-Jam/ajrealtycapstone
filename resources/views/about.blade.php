@extends('layouts.app')

@section('content')
<div class="relative min-h-screen bg-cover bg-center flex items-center justify-center" style="background-image: url('{{ asset('uploads/uploads/aboutus.jpg') }}');">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="container mx-auto px-4 z-10">
        <div class="flex flex-col items-center justify-center text-center">
            <div class="p-8 bg-white bg-opacity-20 backdrop-filter backdrop-blur-md rounded-lg max-w-2xl">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 text-white">{{ $companyName }}</h1>
                <p class="text-xl md:text-2xl text-white mb-6">With over {{ $yearsOfExperience }} years of experience, we're committed to excellence in real estate services.</p>
            </div>
        </div>
    </div>
</div>

<section class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <div class="bg-white bg-opacity-80 backdrop-filter backdrop-blur-lg rounded-lg shadow-lg p-8 relative overflow-hidden">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('uploads/uploads/aboutbg.jpg') }}');"></div>
            <div class="absolute inset-0 bg-white opacity-70"></div>
            <div class="relative z-10">
                <h2 class="text-4xl font-bold text-[#166534] mb-6">About Us</h2>
                <p class="text-lg text-gray-800 mb-6">
                    {{ $companyName }} has been a trusted name in the property market for over {{ $yearsOfExperience }} years. Our commitment to excellence and personalized service has made us a leader in the industry.
                </p>
                <p class="text-lg text-gray-800 mb-6">
                    We specialize in residential and commercial properties, offering a wide range of services including:
                    <ul class="list-disc list-inside ml-4 mt-2 text-gray-800">
                        @foreach ($services as $service)
                            <li>{{ $service }}</li>
                        @endforeach
                    </ul>
                </p>
                <p class="text-lg text-gray-800 mb-6 mt-5">
                    Our team of experienced professionals is dedicated to helping our clients find their perfect home or investment opportunity. We understand that buying or selling a property is one of the most important decisions you'll make, and we go above and beyond to ensure that our clients receive the highest level of service and support throughout the entire process.
                </p>
                <p class="text-lg text-gray-800">
                    Whether you're a first-time homebuyer, seasoned investor, or looking to sell your property, {{ $companyName }} is here to guide you every step of the way. Let us help you turn your real estate dreams into reality.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
    <div class=" grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-[#052e16] bg-opacity-80 rounded-lg shadow-xl p-8">
            <h2 class="text-3xl font-bold text-white mb-4">Our Mission</h2>
            <p class="text-lg text-white">
                To provide unparalleled real estate services, focusing on integrity, professionalism, and client satisfaction. We aim to make the process of buying, selling, or renting property as smooth and rewarding as possible.
            </p>
        </div>
        <div class="bg-[#052e16] bg-opacity-80 rounded-lg shadow-xl p-8">
            <h2 class="text-3xl font-bold text-white mb-4">Why Choose Us?</h2>
            <ul class="list-disc list-inside text-lg text-white">
                @foreach ($reasonsToChoose as $reason)
                    <li>{{ $reason }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="mt-16 bg-[#052e16] bg-opacity-80 rounded-lg shadow-xl p-8">
        <h2 class="text-3xl font-bold text-white mb-6">How We Can Help You</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach ($helpOptions as $helpOption)
                <div class="bg-white bg-opacity-20 rounded-lg p-6">
                    <h3 class="text-xl font-bold text-white mb-4">{{ $helpOption['title'] }}</h3>
                    <p class="text-lg text-white">{{ $helpOption['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
