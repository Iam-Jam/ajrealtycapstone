@extends('layouts.app')

@section('content')
<main>
    <!-- Hero Section -->
    <section class="relative bg-gray-900 text-white py-32">
        <div class="absolute inset-0">
            <img src="{{ asset('uploads/uploads/contactphp.jpg') }}" alt="Real Estate Agents" class="w-full h-full object-cover opacity-50 ">
        </div>
        <div class="relative container mx-auto px-4 z-10 flex flex-col lg:flex-row justify-between items-center space-y-8 lg:space-y-0">
            <div class="lg:w-1/2 mb-8 lg:mb-0 text-center lg:text-left">
                <h1 class="text-4xl lg:text-5xl font-bold mb-4">Our Expert Agents</h1>
                <p class="text-lg lg:text-xl mb-8">Dedicated professionals committed to finding your perfect home</p>
                <a href="#meet-our-agents" class="bg-primary hover:bg-secondary text-white font-bold py-3 px-6 rounded-lg transition duration-300">Meet Our Team</a>
            </div>
            <div class="lg:w-1/2 bg-primary bg-opacity-50 backdrop-filter backdrop-blur-md p-8 rounded-lg">
                <h2 class="text-3xl lg:text-4xl font-bold mb-4 text-center lg:text-left">Ready to Find Your Dream Home?</h2>
                <a href="{{ route('contact') }}" class="block bg-white text-primary hover:bg-secondary hover:text-white font-bold py-3 px-6 rounded-lg transition duration-300 text-center">Contact Us Today</a>
            </div>
        </div>
    </section>

    <!-- Meet Our Agents Section -->
    <section id="meet-our-agents" class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12 text-primary">Meet Our Agents</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Agent 1 -->
                <div class="relative">
                    <img src="{{ asset('uploads/uploads/contactagent2.jpg') }}" alt="Agent 1" class="w-full h-auto object-cover rounded-lg shadow-lg">
                    <div class="absolute bottom-0 right-0 mb-8 mr-8 w-full md:w-1/2">
                        <div class="bg-black bg-opacity-50 p-4 rounded-lg">
                            <h3 class="text-xl font-semibold mb-2 text-white">Jammie Torayno</h3>
                            <p class="text-sm text-white mb-2">Residential Specialist</p>
                            <p class="text-xs text-white mb-4">With over 10 years of experience, Jammie specializes in finding the perfect family homes.</p>
                            <div class="flex justify-end space-x-2">
                                <div class="relative group">
                                    <svg class="w-6 h-6 text-white cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <span class="absolute bottom-full right-0 mb-2 hidden group-hover:block bg-white text-primary text-xs py-1 px-2 rounded whitespace-nowrap">jammiet@ajrealestate.com</span>
                                </div>
                                <div class="relative group">
                                    <svg class="w-6 h-6 text-white cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    <span class="absolute bottom-full right-0 mb-2 hidden group-hover:block bg-white text-primary text-xs py-1 px-2 rounded whitespace-nowrap">(+63) 912-345-6789</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Agent 2 -->
                <div class="relative">
                    <img src="{{ asset('uploads/uploads/agentcontact.jpg') }}" alt="Agent 2" class="w-full h-auto object-cover rounded-lg shadow-lg">
                    <div class="absolute bottom-0 right-0 mb-8 mr-8 w-full md:w-1/2 text-right">
                        <div class="bg-black bg-opacity-50 p-4 rounded-lg">
                            <h3 class="text-xl font-semibold mb-2 text-white">Alexa Holmina</h3>
                            <p class="text-sm text-white mb-2">Luxury Property Expert</p>
                            <p class="text-xs text-white mb-4">Alexa's expertise lies in high-end properties and exclusive listings.</p>
                            <div class="flex justify-end space-x-2">
                                <div class="relative group">
                                    <svg class="w-6 h-6 text-white cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <span class="absolute bottom-full right-0 mb-2 hidden group-hover:block bg-white text-primary text-xs py-1 px-2 rounded whitespace-nowrap">alexaholmina@ajrealestate.com</span>
                                </div>
                                <div class="relative group">
                                    <svg class="w-6 h-6 text-white cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    <span class="absolute bottom-full right-0 mb-2 hidden group-hover:block bg-white text-primary text-xs py-1 px-2 rounded whitespace-nowrap">(+63) 917-876-5432</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Our Agents Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12 text-primary">Why Choose Our Agents?</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m-1 4v-4a1 1 0 011-1h1m4 4h-1v-4h-1m-1 4v-4a1 1 0 011-1h1m4 4h-1v-4h-1m-1 4v-4a1 1 0 011-1h1m4 4h-1v-4h-1m-1 4v-4a1 1 0 011-1h1"></path></svg>
                    <h3 class="text-xl font-semibold mb-2">Expert Knowledge</h3>
                    <p class="text-sm text-gray-600">Our agents have extensive experience in the real estate market, ensuring the best deals for our clients.</p>
                </div>
                <div class="text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 10V5a2 2 0 012-2h6a2 2 0 012 2v5m-7 0h6m-6 0v10"></path></svg>
                    <h3 class="text-xl font-semibold mb-2">Personalized Service</h3>
                    <p class="text-sm text-gray-600">We provide tailored services to fit each client’s unique preferences and needs.</p>
                </div>
                <div class="text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <h3 class="text-xl font-semibold mb-2">Proven Results</h3>
                    <p class="text-sm text-gray-600">We have a track record of successful sales and satisfied clients, making us a trusted name in real estate.</p>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
