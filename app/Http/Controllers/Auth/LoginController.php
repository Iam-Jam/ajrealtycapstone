<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Registration;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';
    protected $maxAttempts = 10;
    protected $decayMinutes = 5;
    protected $username = 'email';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function showLogoutConfirmation()
    {
        return view('auth.logout-confirmation');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = Registration::where('email', $credentials['email'])->first();

        if ($user) {
            \Log::info('User found: ' . $user->email);
            \Log::info('Password check: ' . \Hash::check($credentials['password'], $user->password));
        } else {
            \Log::info('User not found for email: ' . $credentials['email']);
        }

        return Auth::guard('web')->attempt($credentials, $request->filled('remember'));
    }

    protected function sendLoginResponse(Request $request)
{
    $request->session()->regenerate();

    $this->clearLoginAttempts($request);

    return $this->authenticated($request, $this->guard()->user())
        ?: redirect()->intended($this->redirectPath())
            ->with('success', 'Welcome back! You have been successfully logged in.');
}

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out successfully.');
    }

    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended($this->redirectPath())->with('success', 'Welcome, ' . $user->name . '! You are logged in as a ' . ucfirst($user->user_type) . '.');
    }
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'Too many login attempts. Please try again in ' . ceil($seconds / 60) . ' minutes.']);
    }
}
