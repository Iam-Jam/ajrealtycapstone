@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col bg-center relative" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('uploads/uploads/loginbg.jpg') }}') no-repeat center/cover;">
    <div class="container mx-auto px-4 flex-grow">
        <!-- Top Section: Real Estate Information -->
        <div class="text-center mb-8 mt-24">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 mt-11">Welcome to your Trusted Partner</h1>
        </div>

        <!-- Password Reset Form -->
        <div class="flex justify-center">
            <div class="p-8 bg-white bg-opacity-20 backdrop-filter backdrop-blur-md rounded-lg max-w-md w-full">
                <h2 class="text-2xl font-bold text-white text-center mb-6">Reset Password</h2>

                @if (session('status'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('status') }}</span>
                    </div>
                @endif

                <form class="space-y-4" method="POST" action="{{ route('password.email') }}">
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
                        <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-secondary hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">
                            Send Password Reset Link
                        </button>
                    </div>
                </form>

                <div class="mt-4 text-center">
                    <a href="{{ route('login') }}" class="text-sm text-white hover:text-secondary">
                        Back to Login
                    </a>
                </div>
            </div>
        </div>

        <!-- Bottom Section: Additional Content or Footer -->
        <div class="mt-12 mb-16">
            <!-- Add your additional content or footer here -->
        </div>
    </div>
</div>
@endsection
