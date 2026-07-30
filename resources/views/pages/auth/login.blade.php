@extends('layouts.app')

@section('title', 'Login — LITUS Connect')
@section('meta_description', 'Sign in to your LITUS Connect account to track orders, manage addresses, and checkout faster.')

@section('content')
<div class="bg-white min-h-[70vh]" data-auth-page>
    <div class="site-container py-8 md:py-12">
        <div class="flex flex-wrap items-center gap-2 text-sm text-muted-foreground mb-6">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors font-medium">Home</a>
            <x-lucide name="chevron-right" :size="13" class="text-gray-300" />
            <span class="font-bold text-[#011848]">Login</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-10 max-w-5xl mx-auto items-stretch">
            {{-- Brand panel --}}
            <div class="hidden lg:flex relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#011848] via-[#0a2a6e] to-primary p-8 text-white flex-col justify-between min-h-[520px]">
                <div>
                    <div class="w-12 h-12 rounded-full bg-white/15 flex items-center justify-center mb-6">
                        <x-lucide name="lightbulb" :size="22" class="text-white" />
                    </div>
                    <h2 class="text-3xl font-extrabold leading-tight mb-3">Welcome back to LITUS Connect</h2>
                    <p class="text-white/75 text-sm leading-relaxed max-w-sm">Sign in to track orders, save addresses, and enjoy a faster checkout experience.</p>
                </div>
                <ul class="space-y-3 text-sm text-white/85">
                    @foreach ([
                        'Track your orders in real time',
                        'Faster checkout with saved details',
                        'Exclusive member offers & updates',
                    ] as $benefit)
                        <li class="flex items-center gap-2.5">
                            <span class="w-6 h-6 rounded-full bg-white/15 flex items-center justify-center shrink-0">
                                <x-lucide name="check" :size="13" />
                            </span>
                            {{ $benefit }}
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Form card --}}
            <div class="bg-white rounded-2xl border border-border p-4 sm:p-6 md:p-8 shadow-sm">
                <div class="mb-6">
                    <h1 class="text-2xl md:text-3xl font-extrabold text-[#011848]">Sign In</h1>
                    <p class="text-sm text-muted-foreground mt-1">Enter your details to access your account.</p>
                </div>

                @if (session('auth_success'))
                    <div class="mb-5 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        <x-lucide name="check-circle" :size="18" class="text-emerald-600 mt-0.5 shrink-0" />
                        <p class="font-semibold">{{ session('auth_success') }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <p class="font-bold mb-1">Please fix the following:</p>
                        <ul class="list-disc pl-4 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="block text-xs font-bold text-[#011848] mb-1.5">Email Address <span class="text-red-500">*</span></label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com" class="w-full h-11 px-3.5 rounded-lg border border-border bg-white text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 transition-all">
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-bold text-[#011848]">Password <span class="text-red-500">*</span></label>
                            <a href="{{ route('password.request') }}" class="text-xs font-bold text-primary hover:underline">Forgot password?</a>
                        </div>
                        <div class="relative">
                            <input id="password" type="password" name="password" required placeholder="Enter your password" data-password-input class="w-full h-11 px-3.5 pr-11 rounded-lg border border-border bg-white text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 transition-all">
                            <button type="button" data-password-toggle class="absolute right-1 top-1/2 -translate-y-1/2 w-11 h-11 inline-flex items-center justify-center text-gray-400 hover:text-primary transition-colors" aria-label="Show password">
                                <span data-eye-show><x-lucide name="eye" :size="16" /></span>
                                <span data-eye-hide class="hidden"><x-lucide name="eye-off" :size="16" /></span>
                            </button>
                        </div>
                    </div>

                    <label class="flex items-center gap-2.5 text-sm text-[#011848] select-none">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-border text-primary focus:ring-primary/20">
                        <span class="font-medium">Remember me</span>
                    </label>

                    <button type="submit" class="w-full h-12 rounded-lg bg-primary hover:bg-[#005266] text-white text-sm font-bold transition-colors inline-flex items-center justify-center gap-2">
                        <x-lucide name="lock" :size="15" />
                        Sign In
                    </button>
                </form>

                <p class="text-sm text-center text-muted-foreground mt-6">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="font-bold text-primary hover:underline">Create Account</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
