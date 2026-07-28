<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::guard('member')->check()) {
            return redirect()->route('account');
        }

        return view('pages.auth.login', [
            'cartCount' => 0,
            'wishCount' => 0,
        ]);
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Please enter your password.',
            'password.min' => 'Password must be at least 6 characters.',
        ]);

        if (! Auth::guard('member')->attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('account'))->with('auth_success', 'Welcome back! You are now signed in.');
    }

    public function showRegister(): View|RedirectResponse
    {
        if (Auth::guard('member')->check()) {
            return redirect()->route('account');
        }

        return view('pages.auth.register', [
            'cartCount' => 0,
            'wishCount' => 0,
        ]);
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:members,email'],
            'phone' => ['nullable', 'string', 'max:40'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'terms' => ['accepted'],
        ], [
            'name.required' => 'Please enter your full name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'An account with this email already exists.',
            'password.required' => 'Please create a password.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'terms.accepted' => 'Please agree to the Terms of Service and Privacy Policy.',
        ]);

        $member = Member::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?: null,
            'password' => $validated['password'],
        ]);

        Auth::guard('member')->login($member);
        $request->session()->regenerate();

        return redirect()->route('account')->with('auth_success', 'Account created successfully. Welcome to LITUS Connect!');
    }

    public function showForgotPassword(): View|RedirectResponse
    {
        if (Auth::guard('member')->check()) {
            return redirect()->route('account');
        }

        return view('pages.auth.forgot-password', [
            'cartCount' => 0,
            'wishCount' => 0,
        ]);
    }

    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
        ]);

        try {
            Password::broker('members')->sendResetLink(
                $request->only('email')
            );
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('password.request')
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Unable to send the reset email. Please try again shortly.']);
        }

        return redirect()->route('password.request')->with('reset_sent', true);
    }

    public function showResetPassword(Request $request, string $token): View
    {
        return view('pages.auth.reset-password', [
            'cartCount' => 0,
            'wishCount' => 0,
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Please create a password.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        $status = Password::broker('members')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Member $member, string $password) {
                $member->forceFill([
                    'password' => $password,
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($member));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return redirect()->route('login')->with('auth_success', 'Your password has been reset. You can sign in now.');
    }

    public function account(Request $request): View|RedirectResponse
    {
        $member = Auth::guard('member')->user();

        if (! $member) {
            return redirect()->route('login');
        }

        $customer = $member->toAccountArray();

        return view('pages.auth.account', [
            'cartCount' => 0,
            'wishCount' => 0,
            'customer' => $customer,
            'orders' => [],
            'addresses' => [],
            'serviceFeatures' => [
                ['icon' => 'truck', 'title' => 'Free Delivery', 'sub' => 'For orders over MVR 5,000'],
                ['icon' => 'shield-check', 'title' => '1 Year Warranty', 'sub' => 'Official product warranty'],
                ['icon' => 'headphones', 'title' => '24/7 Support', 'sub' => 'Always here to help'],
                ['icon' => 'refresh', 'title' => 'Easy Returns', 'sub' => '7 days return policy'],
                ['icon' => 'credit-card', 'title' => 'Secure Payments', 'sub' => '100% secure checkout'],
            ],
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        /** @var Member|null $member */
        $member = Auth::guard('member')->user();

        if (! $member) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:members,email,'.$member->id],
            'phone' => ['nullable', 'string', 'max:40'],
        ], [
            'name.required' => 'Please enter your full name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'An account with this email already exists.',
        ]);

        $member->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?: null,
        ]);

        return redirect()->route('account', ['tab' => 'profile'])->with('auth_success', 'Profile updated successfully.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('member')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('auth_success', 'You have been signed out.');
    }
}
