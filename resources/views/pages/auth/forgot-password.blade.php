@extends('layouts.app')

@section('title', 'Forgot Password — LITUS Connect')
@section('meta_description', 'Reset your LITUS Connect account password.')

@section('content')
<div class="bg-white min-h-[60vh]" data-auth-page>
    <div class="site-container py-8 md:py-12">
        <div class="flex flex-wrap items-center gap-2 text-sm text-muted-foreground mb-6">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors font-medium">Home</a>
            <x-lucide name="chevron-right" :size="13" class="text-gray-300" />
            <a href="{{ route('login') }}" class="hover:text-primary transition-colors font-medium">Login</a>
            <x-lucide name="chevron-right" :size="13" class="text-gray-300" />
            <span class="font-bold text-[#011848]">Forgot Password</span>
        </div>

        <div class="max-w-lg mx-auto bg-white rounded-2xl border border-border p-4 sm:p-6 md:p-8 shadow-sm">
            <div class="w-12 h-12 rounded-full bg-primary/10 text-primary flex items-center justify-center mb-4">
                <x-lucide name="lock" :size="22" />
            </div>
            <h1 class="text-2xl font-extrabold text-[#011848] mb-1">Forgot Password?</h1>
            <p class="text-sm text-muted-foreground mb-6">Enter your email and we'll send you a reset link.</p>

            @if (session('reset_sent'))
                <div class="mb-5 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    <x-lucide name="check-circle" :size="18" class="text-emerald-600 mt-0.5 shrink-0" />
                    <div>
                        <p class="font-bold">Reset link sent</p>
                        <p class="text-emerald-700/90">If an account exists for that email, you'll receive reset instructions shortly.</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc pl-4 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-xs font-bold text-[#011848] mb-1.5">Email Address <span class="text-red-500">*</span></label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com" class="w-full h-11 px-3.5 rounded-lg border border-border bg-white text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 transition-all">
                </div>
                <button type="submit" class="w-full h-12 rounded-lg bg-primary hover:bg-[#005266] text-white text-sm font-bold transition-colors">
                    Send Reset Link
                </button>
            </form>

            <p class="text-sm text-center text-muted-foreground mt-6">
                Remember your password?
                <a href="{{ route('login') }}" class="font-bold text-primary hover:underline">Back to Sign In</a>
            </p>
        </div>
    </div>
</div>
@endsection
