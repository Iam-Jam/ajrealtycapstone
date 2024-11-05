<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;



class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials, $request->filled('remember'))) {
                $request->session()->regenerate();

                $user = Auth::user();
                Log::info('User logged in', ['user_id' => $user->id, 'user_type' => $user->user_type]);

                return $this->redirectBasedOnRole($user);
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        } catch (\Exception $e) {
            Log::error('Login error', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'An error occurred during login. Please try again.']);
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        Log::info('User logged out', ['user_id' => $user->id, 'user_type' => $user->user_type]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
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

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $validatedData = $validator->validated();

            $user = User::create([
                'name' => $validatedData['name'],
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'user_type' => $validatedData['user_type'],
                'security_question' => $validatedData['security_question'],
                'security_answer' => Hash::make($validatedData['security_answer']),
            ]);

            event(new Registered($user));

            Auth::login($user);

            Log::info('New user registered', ['user_id' => $user->id, 'user_type' => $user->user_type]);

            return $this->redirectBasedOnRole($user);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Registration error', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'An error occurred during registration. Please try again.']);
        }
    }

    protected function redirectBasedOnRole(User $user)
    {
        Log::info('Redirecting user', ['user_id' => $user->id, 'user_type' => $user->user_type]);

        return redirect()->route('home')->with('user_type', $user->user_type);
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
        }

        if ($user->security_question) {
            return redirect()->route('password.security_question', ['email' => $request->email]);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    public function showSecurityQuestion(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->first();

        if (!$user || !$user->security_question) {
            return redirect()->route('password.request')->withErrors(['email' => 'Invalid request.']);
        }

        return view('auth.security-question', compact('email', 'user'));
    }

    public function verifySecurityAnswer(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'security_answer' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->security_answer, $user->security_answer)) {
            return back()->withErrors(['security_answer' => 'The security answer is incorrect.']);
        }

        $token = Password::createToken($user);
        return redirect()->route('password.reset', ['token' => $token, 'email' => $request->email]);
    }

    public function showResetForm(Request $request)
    {
        return view('auth.reset-password', ['token' => $request->route('token')]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

    public function updateSecurityQuestion(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'string'],
            'security_question' => ['required', 'string'],
            'security_answer' => ['required', 'string'],
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The provided password does not match our records.']);
        }

        $user->security_question = $request->security_question;
        $user->security_answer = Hash::make($request->security_answer);
        $user->save();

        return back()->with('status', 'Security question updated successfully.');
    }

    public function sendResetLinkEmail(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        // If no user is found, return an error
        if (!$user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
        }

        // Generate and send the password reset link
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Check if the reset link was sent successfully
        if ($status === Password::RESET_LINK_SENT) {
            // If successful, redirect back with a success message
            return back()->with(['status' => __($status)]);
        } else {
            // If there was an error, redirect back with an error message
            return back()->withErrors(['email' => __($status)]);
        }
    }
}
