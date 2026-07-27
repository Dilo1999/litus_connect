<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('pages.auth.login', [
            'cartCount' => 2,
            'wishCount' => 0,
        ]);
    }

    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Please enter your password.',
            'password.min' => 'Password must be at least 6 characters.',
        ]);

        $name = strstr($validated['email'], '@', true) ?: 'Customer';
        $name = ucwords(str_replace(['.', '_', '-'], ' ', $name));

        $request->session()->put('customer', [
            'name' => $name,
            'email' => $validated['email'],
            'phone' => '+960 7XXXXXX',
            'joined' => now()->subMonths(3)->format('M Y'),
        ]);

        return redirect()->route('account')->with('auth_success', 'Welcome back! You are now signed in.');
    }

    public function showRegister(): View
    {
        return view('pages.auth.register', [
            'cartCount' => 2,
            'wishCount' => 0,
        ]);
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Please enter your full name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Please create a password.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        $request->session()->put('customer', [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?: '+960 7XXXXXX',
            'joined' => now()->format('M Y'),
        ]);

        return redirect()->route('account')->with('auth_success', 'Account created successfully. Welcome to LITUS Connect!');
    }

    public function showForgotPassword(): View
    {
        return view('pages.auth.forgot-password', [
            'cartCount' => 2,
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

        return redirect()->route('password.request')->with('reset_sent', true);
    }

    public function account(Request $request): View|RedirectResponse
    {
        $customer = $request->session()->get('customer');

        if (! $customer) {
            return redirect()->route('login');
        }

        return view('pages.auth.account', [
            'cartCount' => 2,
            'wishCount' => 0,
            'customer' => $customer,
            'orders' => [
                [
                    'id' => 'LC-10482',
                    'date' => 'Jul 18, 2026',
                    'status' => 'Delivered',
                    'statusColor' => 'emerald',
                    'total' => 132880,
                    'items' => 2,
                ],
                [
                    'id' => 'LC-10391',
                    'date' => 'Jun 02, 2026',
                    'status' => 'Processing',
                    'statusColor' => 'amber',
                    'total' => 499990,
                    'items' => 1,
                ],
                [
                    'id' => 'LC-10244',
                    'date' => 'May 14, 2026',
                    'status' => 'Cancelled',
                    'statusColor' => 'red',
                    'total' => 18990,
                    'items' => 1,
                ],
            ],
            'addresses' => [
                [
                    'label' => 'Home',
                    'line' => 'Ma. Elyzium, Buruzu Magu',
                    'city' => 'Malé, Maldives',
                    'phone' => $customer['phone'] ?? '+960 332 2295',
                    'default' => true,
                ],
                [
                    'label' => 'Office',
                    'line' => 'H. Azum, Boduthakurufaanu Magu',
                    'city' => 'Malé, Maldives',
                    'phone' => $customer['phone'] ?? '+960 332 2295',
                    'default' => false,
                ],
            ],
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
        $customer = $request->session()->get('customer');
        if (! $customer) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
        ]);

        $request->session()->put('customer', array_merge($customer, $validated));

        return redirect()->route('account', ['tab' => 'profile'])->with('auth_success', 'Profile updated successfully.');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('customer');

        return redirect()->route('login')->with('auth_success', 'You have been signed out.');
    }
}
