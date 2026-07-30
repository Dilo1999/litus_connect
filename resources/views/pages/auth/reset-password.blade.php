@extends('layouts.app')

@section('title', 'Reset Password — LITUS Connect')
@section('meta_description', 'Choose a new password for your LITUS Connect account.')

@section('content')
<div class="bg-white min-h-[60vh]" data-auth-page>
    <div class="site-container py-8 md:py-12">
        <div class="flex flex-wrap items-center gap-2 text-sm text-muted-foreground mb-6">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors font-medium">Home</a>
            <x-lucide name="chevron-right" :size="13" class="text-gray-300" />
            <a href="{{ route('login') }}" class="hover:text-primary transition-colors font-medium">Login</a>
            <x-lucide name="chevron-right" :size="13" class="text-gray-300" />
            <span class="font-bold text-[#011848]">Reset Password</span>
        </div>

        <div class="max-w-lg mx-auto bg-white rounded-2xl border border-border p-4 sm:p-6 md:p-8 shadow-sm">
            <div class="w-12 h-12 rounded-full bg-primary/10 text-primary flex items-center justify-center mb-4">
                <x-lucide name="lock" :size="22" />
            </div>
            <h1 class="text-2xl font-extrabold text-[#011848] mb-1">Reset Password</h1>
            <p class="text-sm text-muted-foreground mb-6">Enter your email and choose a new password.</p>

            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc pl-4 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email" class="block text-xs font-bold text-[#011848] mb-1.5">Email Address <span class="text-red-500">*</span></label>
                    <input id="email" type="email" name="email" value="{{ old('email', $email) }}" required placeholder="you@example.com" class="w-full h-11 px-3.5 rounded-lg border border-border bg-white text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 transition-all">
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-[#011848] mb-1.5">New Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required placeholder="At least 6 characters" data-password-input class="w-full h-11 px-3.5 pr-11 rounded-lg border border-border bg-white text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 transition-all">
                        <button type="button" data-password-toggle class="absolute right-1 top-1/2 -translate-y-1/2 w-11 h-11 inline-flex items-center justify-center text-gray-400 hover:text-primary transition-colors" aria-label="Show password">
                            <span data-eye-show><x-lucide name="eye" :size="16" /></span>
                            <span data-eye-hide class="hidden"><x-lucide name="eye-off" :size="16" /></span>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-[#011848] mb-1.5">Confirm Password <span class="text-red-500">*</span></label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Re-enter your password" class="w-full h-11 px-3.5 rounded-lg border border-border bg-white text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 transition-all">
                </div>

                <button type="submit" class="w-full h-12 rounded-lg bg-primary hover:bg-[#005266] text-white text-sm font-bold transition-colors">
                    Update Password
                </button>
            </form>

            <p class="text-sm text-center text-muted-foreground mt-6">
                <a href="{{ route('login') }}" class="font-bold text-primary hover:underline">Back to Sign In</a>
            </p>
        </div>
    </div>
</div>
@endsection
