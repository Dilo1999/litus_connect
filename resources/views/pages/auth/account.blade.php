@extends('layouts.app')

@section('title', 'My Account — LITUS Connect')
@section('meta_description', 'Manage your LITUS Connect account, orders, profile, and delivery addresses.')

@section('content')
@php
    $tab = request('tab', 'overview');
    $statusColors = [
        'emerald' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'amber' => 'bg-amber-50 text-amber-700 border-amber-200',
        'red' => 'bg-red-50 text-red-700 border-red-200',
        'blue' => 'bg-blue-50 text-primary border-blue-200',
    ];
    $navItems = [
        ['key' => 'overview', 'label' => 'Overview', 'icon' => 'layout-grid'],
        ['key' => 'orders', 'label' => 'Order History', 'icon' => 'package-check'],
        ['key' => 'profile', 'label' => 'Profile Details', 'icon' => 'user'],
        ['key' => 'addresses', 'label' => 'Addresses', 'icon' => 'map-pin'],
    ];
@endphp

<div class="bg-white" data-account-page>
    <div class="site-container py-6 md:py-10">
        <div class="flex flex-wrap items-center gap-2 text-sm text-muted-foreground mb-5">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors font-medium">Home</a>
            <x-lucide name="chevron-right" :size="13" class="text-gray-300" />
            <span class="font-bold text-[#011848]">My Account</span>
        </div>

        @if (session('auth_success'))
            <div class="mb-5 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                <x-lucide name="check-circle" :size="18" class="text-emerald-600 mt-0.5 shrink-0" />
                <p class="font-semibold">{{ session('auth_success') }}</p>
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-[#011848]">Hello, {{ $customer['name'] }}</h1>
                <p class="text-sm text-muted-foreground mt-1">Manage your orders, profile, and delivery addresses.</p>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="w-full md:w-auto">
                @csrf
                <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center gap-2 min-h-11 px-4 rounded-lg border border-border bg-white text-sm font-bold text-[#011848] hover:border-red-300 hover:text-red-500 transition-colors">
                    <x-lucide name="log-out" :size="15" />
                    Sign Out
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
            {{-- Sidebar --}}
            <aside class="lg:col-span-1 bg-white rounded-2xl border border-border p-3 md:p-4 lg:sticky lg:top-28">
                <div class="flex items-center gap-3 px-2 py-3 mb-2 border-b border-border">
                    <div class="w-11 h-11 rounded-full bg-primary/10 text-primary flex items-center justify-center font-extrabold">
                        {{ strtoupper(substr($customer['name'], 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-extrabold text-[#011848] truncate">{{ $customer['name'] }}</p>
                        <p class="text-[11px] text-muted-foreground truncate">{{ $customer['email'] }}</p>
                    </div>
                </div>

                <nav class="flex lg:flex-col gap-1 overflow-x-auto scrollbar-hide pb-1 lg:pb-0">
                    @foreach ($navItems as $item)
                        <a
                            href="{{ route('account', ['tab' => $item['key']]) }}"
                            @class([
                                'flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-semibold whitespace-nowrap transition-colors',
                                'bg-blue-light text-primary' => $tab === $item['key'],
                                'text-gray-700 hover:bg-[#F7F8FA] hover:text-primary' => $tab !== $item['key'],
                            ])
                        >
                            <x-lucide :name="$item['icon']" :size="15" />
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>
            </aside>

            {{-- Content --}}
            <div class="lg:col-span-3 space-y-5">
                @if ($tab === 'overview')
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="bg-white rounded-2xl border border-border p-5">
                            <p class="text-xs font-bold uppercase tracking-wide text-muted-foreground mb-1">Orders</p>
                            <p class="text-2xl font-extrabold text-[#011848]">{{ count($orders) }}</p>
                        </div>
                        <div class="bg-white rounded-2xl border border-border p-5">
                            <p class="text-xs font-bold uppercase tracking-wide text-muted-foreground mb-1">Addresses</p>
                            <p class="text-2xl font-extrabold text-[#011848]">{{ count($addresses) }}</p>
                        </div>
                        <div class="bg-white rounded-2xl border border-border p-5">
                            <p class="text-xs font-bold uppercase tracking-wide text-muted-foreground mb-1">Member Since</p>
                            <p class="text-2xl font-extrabold text-[#011848]">{{ $customer['joined'] }}</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-border p-5 md:p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-extrabold text-[#011848]">Recent Orders</h2>
                            <a href="{{ route('account', ['tab' => 'orders']) }}" class="text-sm font-bold text-primary hover:underline">View all</a>
                        </div>
                        <div class="space-y-3">
                            @forelse (array_slice($orders, 0, 2) as $order)
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 rounded-xl border border-border px-4 py-3.5">
                                    <div>
                                        <p class="text-sm font-extrabold text-[#011848]">#{{ $order['id'] }}</p>
                                        <p class="text-xs text-muted-foreground mt-0.5">{{ $order['date'] }} · {{ $order['items'] }} item{{ $order['items'] > 1 ? 's' : '' }}</p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="text-[11px] font-bold px-2.5 py-1 rounded-full border {{ $statusColors[$order['statusColor']] ?? $statusColors['blue'] }}">{{ $order['status'] }}</span>
                                        <span class="text-sm font-extrabold text-[#011848]">MVR {{ number_format($order['total']) }}</span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-muted-foreground py-2">No orders yet. Start shopping to see them here.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ route('shop') }}" class="bg-gradient-to-br from-[#E8F0FE] to-white rounded-2xl border border-border p-5 hover:border-primary/40 transition-colors">
                            <h3 class="text-base font-extrabold text-[#011848] mb-1">Continue Shopping</h3>
                            <p class="text-sm text-muted-foreground mb-3">Browse phones, accessories, and more.</p>
                            <span class="inline-flex items-center gap-1 text-sm font-bold text-primary">Go to Shop <x-lucide name="arrow-right" :size="14" /></span>
                        </a>
                        <a href="{{ route('cart') }}" class="bg-white rounded-2xl border border-border p-5 hover:border-primary/40 transition-colors">
                            <h3 class="text-base font-extrabold text-[#011848] mb-1">View Cart</h3>
                            <p class="text-sm text-muted-foreground mb-3">Review items and proceed to checkout.</p>
                            <span class="inline-flex items-center gap-1 text-sm font-bold text-primary">Open Cart <x-lucide name="arrow-right" :size="14" /></span>
                        </a>
                    </div>
                @endif

                @if ($tab === 'orders')
                    <div class="bg-white rounded-2xl border border-border overflow-hidden">
                        <div class="px-5 md:px-6 py-4 border-b border-border">
                            <h2 class="text-lg font-extrabold text-[#011848]">Order History</h2>
                            <p class="text-sm text-muted-foreground mt-0.5">Track and review your past purchases.</p>
                        </div>
                        <div class="divide-y divide-border">
                            @forelse ($orders as $order)
                                <div class="px-5 md:px-6 py-4 flex flex-col md:flex-row md:items-center justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-extrabold text-[#011848]">Order #{{ $order['id'] }}</p>
                                        <p class="text-xs text-muted-foreground mt-0.5">Placed on {{ $order['date'] }} · {{ $order['items'] }} item{{ $order['items'] > 1 ? 's' : '' }}</p>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <span class="text-[11px] font-bold px-2.5 py-1 rounded-full border {{ $statusColors[$order['statusColor']] ?? $statusColors['blue'] }}">{{ $order['status'] }}</span>
                                        <span class="text-sm font-extrabold text-[#011848]">MVR {{ number_format($order['total']) }}</span>
                                        <button type="button" class="h-9 px-3.5 rounded-lg border border-border text-xs font-bold text-[#011848] hover:border-primary hover:text-primary transition-colors">View Details</button>
                                    </div>
                                </div>
                            @empty
                                <div class="px-5 md:px-6 py-10 text-center">
                                    <p class="text-sm font-bold text-[#011848] mb-1">No orders yet</p>
                                    <p class="text-sm text-muted-foreground mb-4">When you place an order, it will appear here.</p>
                                    <a href="{{ route('shop') }}" class="inline-flex items-center gap-2 h-10 px-4 rounded-lg bg-primary hover:bg-[#005266] text-white text-sm font-bold transition-colors">Browse Shop</a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endif

                @if ($tab === 'profile')
                    <div class="bg-white rounded-2xl border border-border p-5 md:p-6">
                        <h2 class="text-lg font-extrabold text-[#011848] mb-1">Profile Details</h2>
                        <p class="text-sm text-muted-foreground mb-5">Update your personal information.</p>

                        @if ($errors->any())
                            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                                <ul class="list-disc pl-4 space-y-0.5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('account.profile') }}" method="POST" class="space-y-4 max-w-xl">
                            @csrf
                            <div>
                                <label for="name" class="block text-xs font-bold text-[#011848] mb-1.5">Full Name</label>
                                <input id="name" type="text" name="name" value="{{ old('name', $customer['name']) }}" required class="w-full h-11 px-3.5 rounded-lg border border-border text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/15">
                            </div>
                            <div>
                                <label for="email" class="block text-xs font-bold text-[#011848] mb-1.5">Email Address</label>
                                <input id="email" type="email" name="email" value="{{ old('email', $customer['email']) }}" required class="w-full h-11 px-3.5 rounded-lg border border-border text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/15">
                            </div>
                            <div>
                                <label for="phone" class="block text-xs font-bold text-[#011848] mb-1.5">Phone Number</label>
                                <input id="phone" type="tel" name="phone" value="{{ old('phone', $customer['phone'] ?? '') }}" class="w-full h-11 px-3.5 rounded-lg border border-border text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/15">
                            </div>
                            <button type="submit" class="w-full sm:w-auto min-h-11 px-5 rounded-lg bg-primary hover:bg-[#005266] text-white text-sm font-bold transition-colors">
                                Save Changes
                            </button>
                        </form>
                    </div>
                @endif

                @if ($tab === 'addresses')
                    <div class="bg-white rounded-2xl border border-border p-5 md:p-6">
                        <div class="flex flex-col min-[420px]:flex-row min-[420px]:items-center justify-between gap-3 mb-5">
                            <div>
                                <h2 class="text-lg font-extrabold text-[#011848]">Saved Addresses</h2>
                                <p class="text-sm text-muted-foreground mt-0.5">Manage where we deliver your orders.</p>
                            </div>
                            <button type="button" class="min-h-11 px-4 rounded-lg bg-primary hover:bg-[#005266] text-white text-sm font-bold transition-colors">
                                Add Address
                            </button>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @forelse ($addresses as $address)
                                <div class="rounded-xl border border-border p-4 relative">
                                    @if ($address['default'])
                                        <span class="absolute top-3 right-3 text-[10px] font-bold uppercase tracking-wide bg-blue-light text-primary px-2 py-0.5 rounded">Default</span>
                                    @endif
                                    <p class="text-sm font-extrabold text-[#011848] mb-1">{{ $address['label'] }}</p>
                                    <p class="text-sm text-muted-foreground leading-relaxed">{{ $address['line'] }}</p>
                                    <p class="text-sm text-muted-foreground">{{ $address['city'] }}</p>
                                    <p class="text-sm text-muted-foreground mt-1">{{ $address['phone'] }}</p>
                                    <div class="flex gap-2 mt-4">
                                        <button type="button" class="h-9 px-3 rounded-lg border border-border text-xs font-bold text-[#011848] hover:border-primary hover:text-primary transition-colors">Edit</button>
                                        <button type="button" class="h-9 px-3 rounded-lg border border-border text-xs font-bold text-red-500 hover:bg-red-50 transition-colors">Remove</button>
                                    </div>
                                </div>
                            @empty
                                <div class="sm:col-span-2 rounded-xl border border-dashed border-border p-8 text-center">
                                    <p class="text-sm font-bold text-[#011848] mb-1">No saved addresses</p>
                                    <p class="text-sm text-muted-foreground">Add a delivery address for faster checkout.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <section class="bg-white border-y border-border/60">
        <div class="site-container">
            <div class="grid grid-cols-1 min-[420px]:grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-y-5 md:gap-y-6 gap-x-4 py-7 md:py-8">
                @foreach ($serviceFeatures as $feature)
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-full bg-[#F3F5F9] flex items-center justify-center flex-shrink-0 text-[#011848]">
                            <x-lucide :name="$feature['icon']" :size="18" />
                        </div>
                        <div>
                            <p class="text-sm font-bold text-[#011848]">{{ $feature['title'] }}</p>
                            <p class="text-[11px] text-muted-foreground leading-tight">{{ $feature['sub'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
@endsection
