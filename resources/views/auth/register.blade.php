@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-cover bg-center" style="background-image: url('{{ asset('uploads/uploads/homepage2.jpg') }}');">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-11 text-center text-5xl font-extrabold text-[#052e16] drop-shadow-lg">
            Create your Account
        </h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-6xl">
        <div class="bg-white bg-opacity-80 py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Registration Form -->
                <div>
                    <form class="space-y-6" action="{{ route('register') }}" method="POST">
                        @csrf
                        <div>
                            <label for="name" class="block text-lg font-medium text-gray-700">Full Name</label>
                            <div class="mt-1">
                                <input id="name" name="name" type="text" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 text-lg">
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-lg font-medium text-gray-700">Email address</label>
                            <div class="mt-1">
                                <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 text-lg">
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-lg font-medium text-gray-700">Password</label>
                            <div class="mt-1">
                                <input id="password" name="password" type="password" autocomplete="new-password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 text-lg">
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-lg font-medium text-gray-700">Confirm Password</label>
                            <div class="mt-1">
                                <input id="password_confirmation" name="password_confirmation" type="password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 text-lg">
                            </div>
                        </div>

                        <div>
                            <label for="user_type" class="block text-lg font-medium text-gray-700">I am a:</label>
                            <select id="user_type" name="user_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-lg border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 rounded-md">
                                <option value="">Select your role</option>
                                <option value="buyer">Buyer</option>
                                <option value="seller">Seller</option>
                                <option value="renter">Renter</option>
                                <option value="viewer">Viewer</option>
                            </select>
                        </div>

                        <div>
                            <label for="security_question" class="block text-lg font-medium text-gray-700">Security Question:</label>
                            <select id="security_question" name="security_question" class="mt-1 block w-full pl-3 pr-10 py-2 text-lg border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 rounded-md">
                                <option value="">Select a security question</option>
                                <option value="pet_name">What was the name of your first pet?</option>
                                <option value="mother_maiden">What is your mother's maiden name?</option>
                                <option value="birth_city">In which city were you born?</option>
                                <option value="school">What was the name of your first school?</option>
                            </select>
                        </div>

                        <div>
                            <label for="security_answer" class="block text-lg font-medium text-gray-700">Security Answer</label>
                            <div class="mt-1">
                                <input id="security_answer" name="security_answer" type="text" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 text-lg">
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-lg font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Register
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Information Section -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-2xl font-medium text-gray-900">Why Register with AJ Real Estate?</h3>
                        <div class="mt-2 text-lg text-gray-600">
                            <ul class="list-disc pl-5 space-y-2">
                                <li>Access to exclusive property listings</li>
                                <li>Personalized property recommendations</li>
                                <li>Save and compare your favorite properties</li>
                                <li>Receive updates on market trends and new listings</li>
                            </ul>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-2xl font-medium text-gray-900">Your Data is Secure</h3>
                        <div class="mt-2 text-lg text-gray-600">
                            <p>At AJ Real Estate, we take your privacy seriously. Your personal information is protected using industry-standard encryption and security measures. We comply with all relevant data protection regulations and will never share your information without your explicit consent.</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-2xl font-medium text-gray-900">What Our Clients Say</h3>
                        <div class="mt-2 text-lg text-gray-600 italic">
                            "AJ Real Estate made finding my dream home a breeze. Their personalized service and attention to detail were outstanding!" - Sarah K.
                        </div>
                    </div>

                    <div class="pt-6">
                        <p class="text-base text-gray-600">
                            By registering, you agree to our <a href="#" class="text-green-600 hover:text-green-500">Terms of Service</a> and <a href="#" class="text-green-600 hover:text-green-500">Privacy Policy</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const passwordInput = document.getElementById('password');
        const usernameInput = document.getElementById('name');

        form.addEventListener('submit', function(event) {
            const password = passwordInput.value;
            const username = usernameInput.value;

            // Check password strength
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            if (!passwordRegex.test(password)) {
                event.preventDefault();
                alert('Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.');
            }

            // Check username uniqueness (this should also be checked server-side)
            if (username.trim() === '') {
                event.preventDefault();
                alert('Please enter your full name.');
            }
        });
    });
</script>
@endsection
