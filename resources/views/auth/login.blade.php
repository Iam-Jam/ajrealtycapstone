@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col bg-center relative" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('uploads/uploads/loginbg.jpg') }}') no-repeat center/cover;">
    <div class="container mx-auto px-4 flex-grow">
        <!-- Top Section: Real Estate Information -->
        <div class="text-center mb-8 mt-24">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 mt-11">Welcome to your Trusted Partner</h1>
        </div>

        <!-- Login Form -->
        <div class="flex justify-center">
            <div class="p-8 bg-white bg-opacity-20 backdrop-filter backdrop-blur-md rounded-lg max-w-md w-full">
                <h2 class="text-2xl font-bold text-white text-center mb-6">Sign in to your account</h2>

               
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <form class="space-y-4" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div>
                        <input id="email" name="email" type="email" autocomplete="email" required
                               class="w-full px-4 py-2 rounded-md bg-white bg-opacity-20 text-white focus:outline-none focus:ring-2 focus:ring-secondary @error('email') border-red-500 @enderror"
                               placeholder="Email address" value="{{ old('email') }}">
                        @error('email')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <div class="relative">
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                   class="w-full px-4 py-2 rounded-md bg-white bg-opacity-20 text-white focus:outline-none focus:ring-2 focus:ring-secondary @error('password') border-red-500 @enderror"
                                   placeholder="Password">
                            <button type="button" class="absolute right-0 top-0 mt-3 mr-4 text-white" onclick="togglePasswordVisibility()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path id="password-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox"
                                   class="h-4 w-4 text-secondary focus:ring-secondary border-transparent rounded">
                            <label for="remember" class="ml-2 block text-sm text-white">Remember me</label>
                        </div>
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="font-medium text-white hover:text-secondary">
                                Forgot password?
                            </a>
                        </div>
                    </div>
                    <div>
                        <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-secondary hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">
                            Sign in
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Second Section -->
<div class="py-16">
    <div class="container mx-auto px-4">
        <!-- Why Choose Us Section -->
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">At AJ Real Estate</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Your trusted partner in finding the perfect property. We combine expertise, technology, and personalized service to deliver exceptional real estate solutions.</p>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Expertise Card -->
            <div class="bg-white shadow-lg rounded-lg p-6 transform hover:scale-105 transition duration-300">
                <div class="text-secondary mb-4">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Trusted Expertise</h3>
                <p class="text-gray-600">Years of experience in the real estate market, ensuring you get the best advice and service.</p>
            </div>

            <!-- Wide Selection Card -->
            <div class="bg-white shadow-lg rounded-lg p-6 transform hover:scale-105 transition duration-300">
                <div class="text-secondary mb-4">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Wide Selection</h3>
                <p class="text-gray-600">Extensive portfolio of properties to match every requirement and budget.</p>
            </div>

            <!-- Personalized Service Card -->
            <div class="bg-white shadow-lg rounded-lg p-6 transform hover:scale-105 transition duration-300">
                <div class="text-secondary mb-4">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Personal Approach</h3>
                <p class="text-gray-600">Dedicated agents providing personalized attention to your unique needs.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('password-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.setAttribute('d', 'M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21');
        } else {
            passwordInput.type = 'password';
            passwordIcon.setAttribute('d', 'M15 12a3 3 0 11-6 0 3 3 0 016 0z');
        }
    }
</script>
@endsection
