@extends('layouts.app')

@section('title', 'Create Account — LITUS Connect')
@section('meta_description', 'Create a LITUS Connect account to track orders, manage delivery addresses, and enjoy faster checkout.')

@section('content')
<div class="bg-[#F7F8FA] min-h-[70vh]" data-auth-page>
    <div class="site-container py-8 md:py-12">
        <div class="flex flex-wrap items-center gap-2 text-sm text-muted-foreground mb-6">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors font-medium">Home</a>
            <x-lucide name="chevron-right" :size="13" class="text-gray-300" />
            <span class="font-bold text-[#011848]">Register</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-10 max-w-5xl mx-auto items-stretch">
            <div class="hidden lg:flex relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#011848] via-[#0a2a6e] to-primary p-8 text-white flex-col justify-between min-h-[560px]">
                <div>
                    <div class="w-12 h-12 rounded-full bg-white/15 flex items-center justify-center mb-6">
                        <x-lucide name="user" :size="22" class="text-white" />
                    </div>
                    <h2 class="text-3xl font-extrabold leading-tight mb-3">Join LITUS Connect</h2>
                    <p class="text-white/75 text-sm leading-relaxed max-w-sm">Create your account and shop mobile phones, accessories, and gadgets with trusted service across the Maldives.</p>
                </div>
                <ul class="space-y-3 text-sm text-white/85">
                    @foreach ([
                        'Order history & delivery tracking',
                        'Saved addresses for quick checkout',
                        'Member-only deals and updates',
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

            <div class="bg-white rounded-2xl border border-border p-6 md:p-8 shadow-sm">
                <div class="mb-6">
                    <h1 class="text-2xl md:text-3xl font-extrabold text-[#011848]">Create Account</h1>
                    <p class="text-sm text-muted-foreground mt-1">Fill in your details to get started.</p>
                </div>

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

                <form action="{{ route('register.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-xs font-bold text-[#011848] mb-1.5">Full Name <span class="text-red-500">*</span></label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required placeholder="Enter your full name" class="w-full h-11 px-3.5 rounded-lg border border-border bg-white text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 transition-all">
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-[#011848] mb-1.5">Email Address <span class="text-red-500">*</span></label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com" class="w-full h-11 px-3.5 rounded-lg border border-border bg-white text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 transition-all">
                    </div>

                    <div>
                        <label for="phone" class="block text-xs font-bold text-[#011848] mb-1.5">Phone Number</label>
                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" placeholder="+960 XXX XXXX" class="w-full h-11 px-3.5 rounded-lg border border-border bg-white text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 transition-all">
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-[#011848] mb-1.5">Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required placeholder="At least 6 characters" data-password-input class="w-full h-11 px-3.5 pr-11 rounded-lg border border-border bg-white text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 transition-all">
                            <button type="button" data-password-toggle class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary transition-colors" aria-label="Show password">
                                <span data-eye-show><x-lucide name="eye" :size="16" /></span>
                                <span data-eye-hide class="hidden"><x-lucide name="eye-off" :size="16" /></span>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-[#011848] mb-1.5">Confirm Password <span class="text-red-500">*</span></label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Re-enter your password" class="w-full h-11 px-3.5 rounded-lg border border-border bg-white text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 transition-all">
                    </div>

                    <label class="flex items-start gap-2.5 text-sm text-[#011848] select-none">
                        <input type="checkbox" name="terms" required class="mt-0.5 w-4 h-4 rounded border-border text-primary focus:ring-primary/20">
                        <span class="font-medium leading-snug">I agree to the <a href="#" class="text-primary hover:underline">Terms of Service</a> and <a href="#" class="text-primary hover:underline">Privacy Policy</a></span>
                    </label>

                    <button type="submit" class="w-full h-12 rounded-lg bg-primary hover:bg-[#0d4fc7] text-white text-sm font-bold transition-colors inline-flex items-center justify-center gap-2">
                        <x-lucide name="user" :size="15" />
                        Create Account
                    </button>
                </form>

                <p class="text-sm text-center text-muted-foreground mt-6">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-bold text-primary hover:underline">Sign In</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
