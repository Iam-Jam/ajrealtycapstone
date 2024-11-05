<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        Log::info('Registration attempt', $request->except('password', 'password_confirmation'));

        try {
            DB::beginTransaction();

            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
                ],
                'user_type' => ['required', 'in:buyer,seller,renter,viewer'],
                'security_question' => ['required', 'string'],
                'security_answer' => ['required', 'string'],
            ], [
                'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            ]);

            Log::info('Validation passed');

            // Create User
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'user_type' => $validatedData['user_type'],
            ]);

            Log::info('User created', ['user_id' => $user->id]);

            // Create Registration
            $registration = Registration::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'user_type' => $validatedData['user_type'],
                'security_question' => $validatedData['security_question'],
                'security_answer' => Hash::make($validatedData['security_answer']),
                'verification_token' => Str::random(60),
                'expires_at' => now()->addDays(1),
            ]);

            Log::info('Registration created', ['registration_id' => $registration->id]);

            event(new Registered($user));

            // Send email verification notification
            $user->sendEmailVerificationNotification();

            DB::commit();

            Log::info('Registration successful', ['user_id' => $user->id, 'registration_id' => $registration->id]);

            return redirect()->route('login')
                ->with('success', 'Congratulations! Your account was successfully created. Please check your email to verify your account.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Registration error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'An error occurred during registration. Please try again.'])->withInput();
        }
    }
}
