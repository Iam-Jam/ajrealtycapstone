@extends('layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl md:text-5xl font-bold text-primary mb-12 text-center mt-11">Contact Us</h1>

        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div class="space-y-8">
                <!-- Get in Touch Widget -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-primary text-white p-6">
                        <h2 class="text-3xl font-semibold mb-2">Get in Touch</h2>
                        <p class="text-lg">We're here to help and answer any question you might have.</p>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-3 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Cagayan de Oro City, Misamis Oriental Philippines</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-3 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>(209) 661-9494</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-3 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>info@ajrealestate.com</span>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-3xl font-semibold mb-6 text-primary">Send Us a Message</h2>
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                            <input type="text" id="name" name="name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                            <input type="email" id="email" name="email" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone</label>
                            <input type="tel" id="phone" name="phone" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-6">
                            <label for="message" class="block text-gray-700 text-sm font-bold mb-2">Message</label>
                            <textarea id="message" name="message" rows="4" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('message') border-red-500 @enderror"></textarea>
                            @error('message')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-primary hover:bg-opacity-90 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="space-y-8">
                <!-- Image Section with Text Overlay -->
                <div class="relative rounded-lg overflow-hidden shadow-lg">
                    <img src="{{ asset('uploads/uploads/contactphp.jpg') }}" alt="Contact Us" class="w-full h-auto">
                    <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-70 text-white p-4">
                        <p class="text-sm">Our friendly team is ready to assist you with any real estate inquiries.</p>
                    </div>
                </div>

                <!-- Why Choose Us Section -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-4 mt-9 text-primary">Why Choose Us?</h3>
                    <ul class="list-disc list-inside text-gray-700 space-y-2 mt-7 mb-8">
                        <li>Expert local market knowledge</li>
                        <li>Personalized service tailored to your needs</li>
                        <li>Transparent and ethical business practices</li>
                        <li>Comprehensive property listings</li>
                        <li>Dedicated support throughout the buying or selling process</li>
                        <li>Innovative marketing strategies to showcase your property</li>
                        <li>Strong network of industry professionals and resources</li>
                        <li>Proven track record of successful transactions</li>
                        <li>Continuous market research and trend analysis</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
