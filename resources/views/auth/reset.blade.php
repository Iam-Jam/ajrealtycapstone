@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col bg-center relative" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('uploads/uploads/loginbg.jpg') }}') no-repeat center/cover;">
    <div class="container mx-auto px-4 flex-grow flex items-center justify-center">
        <div class="p-8 bg-white bg-opacity-20 backdrop-filter backdrop-blur-md rounded-lg max-w-md w-full">
            <h2 class="text-2xl font-bold text-white text-center mb-6">{{ __('Reset Password') }}</h2>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email" class="sr-only">{{ __('E-Mail Address') }}</label>
                    <input id="email" type="email" class="w-full px-4 py-2 rounded-md bg-white bg-opacity-20 text-white focus:outline-none focus:ring-2 focus:ring-secondary @error('email') border-red-500 @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('E-Mail Address') }}">
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="sr-only">{{ __('Password') }}</label>
                    <input id="password" type="password" class="w-full px-4 py-2 rounded-md bg-white bg-opacity-20 text-white focus:outline-none focus:ring-2 focus:ring-secondary @error('password') border-red-500 @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('Password') }}">
                    @error('password')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password-confirm" class="sr-only">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="w-full px-4 py-2 rounded-md bg-white bg-opacity-20 text-white focus:outline-none focus:ring-2 focus:ring-secondary" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}">
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-secondary hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
