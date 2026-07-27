@extends('layouts.app')

@section('title', 'Shopping Cart — LITUS Connect')
@section('meta_description', 'Review your cart and proceed to checkout at LITUS Connect. Free delivery on orders over MVR 5,000.')

@section('content')

<div
    class="bg-[#F7F8FA]"
    data-cart-page
    data-discount="0"
    data-delivery="{{ $delivery }}"
    data-free-threshold="{{ $freeDeliveryThreshold }}"
    data-shop-url="{{ route('shop') }}"
>
    <div class="site-container py-5 md:py-8">
        <div class="flex flex-wrap items-center gap-2 text-sm text-muted-foreground mb-5">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors font-medium">Home</a>
            <x-lucide name="chevron-right" :size="13" class="text-gray-300" />
            <span class="font-bold text-[#011848]">Cart</span>
        </div>

        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-extrabold text-[#011848]">
                Shopping Cart (<span data-cart-count>0</span>)
            </h1>
            <p class="text-sm text-muted-foreground mt-1">Review your items and proceed to checkout</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 items-start">
            {{-- Cart items --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-border overflow-hidden">
                    <div class="hidden md:grid grid-cols-[minmax(0,1fr)_110px_140px_110px_72px] gap-3 px-5 py-3.5 border-b border-border bg-[#F9FAFB] text-[11px] font-bold uppercase tracking-wide text-muted-foreground">
                        <span>Product</span>
                        <span class="text-center">Price</span>
                        <span class="text-center">Quantity</span>
                        <span class="text-right">Total</span>
                        <span></span>
                    </div>

                    <div data-cart-list>
                        <div class="px-5 py-16 text-center" data-cart-empty>
                            <p class="text-base font-bold text-[#011848] mb-1">Your cart is empty</p>
                            <p class="text-sm text-muted-foreground mb-5">Browse our shop and add items you love.</p>
                            <a href="{{ route('shop') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-[#0d4fc7] text-white text-sm font-bold px-5 py-2.5 rounded-lg transition-colors">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 mt-4 hidden" data-cart-actions>
                    <a href="{{ route('shop') }}" class="inline-flex items-center justify-center gap-2 h-11 px-5 rounded-lg border border-border bg-white text-sm font-bold text-[#011848] hover:border-primary hover:text-primary transition-colors">
                        <x-lucide name="arrow-left" :size="15" />
                        Continue Shopping
                    </a>
                    <button type="button" data-update-cart class="inline-flex items-center justify-center gap-2 h-11 px-5 rounded-lg border border-border bg-white text-sm font-bold text-[#011848] hover:border-primary hover:text-primary transition-colors">
                        <x-lucide name="refresh" :size="15" />
                        Update Cart
                    </button>
                </div>
            </div>

            {{-- Order summary --}}
            <aside class="lg:sticky lg:top-28 space-y-4">
                <div class="bg-white rounded-2xl border border-border p-5 md:p-6">
                    <h2 class="text-lg font-extrabold text-[#011848] mb-4">Order Summary</h2>

                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-muted-foreground">Subtotal (<span data-summary-count>0</span> items)</span>
                            <span class="font-bold text-[#011848]" data-summary-subtotal>MVR 0</span>
                        </div>
                        <div class="flex items-center justify-between hidden" data-discount-row>
                            <span class="text-muted-foreground">Discount (<span data-discount-code>{{ $discountCode }}</span>)</span>
                            <span class="font-bold text-emerald-600" data-summary-discount>- MVR 0</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-muted-foreground">Delivery</span>
                            <span class="font-bold text-emerald-600" data-summary-delivery>FREE</span>
                        </div>
                    </div>

                    <div class="border-t border-border mt-4 pt-4 mb-5">
                        <div class="flex items-end justify-between gap-3">
                            <span class="text-base font-extrabold text-[#011848]">Total</span>
                            <div class="text-right">
                                <p class="text-xl font-extrabold text-[#011848]" data-summary-total>MVR 0</p>
                                <p class="text-[11px] text-muted-foreground">Includes VAT</p>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="w-full inline-flex items-center justify-center gap-2 h-12 rounded-lg bg-primary hover:bg-[#0d4fc7] text-white text-sm font-bold transition-colors">
                        <x-lucide name="lock" :size="15" />
                        Proceed to Checkout
                    </button>

                    <div class="mt-5 pt-4 border-t border-border">
                        <p class="text-[11px] font-bold uppercase tracking-wide text-muted-foreground mb-2.5">We Accept</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach (['VISA', 'MC', 'Amex', 'PayPal'] as $card)
                                <span class="px-2.5 py-1.5 rounded-md bg-[#F3F5F9] border border-border text-[10px] font-extrabold text-[#011848]">{{ $card }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-border p-5">
                    <h3 class="text-sm font-extrabold text-[#011848] mb-3">Have a Coupon?</h3>
                    <div class="flex gap-2">
                        <input
                            type="text"
                            data-coupon-input
                            value=""
                            placeholder="Enter coupon code"
                            class="flex-1 min-w-0 h-11 px-3.5 rounded-lg border border-border text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/15"
                        >
                        <button type="button" data-coupon-apply class="h-11 px-4 rounded-lg bg-[#011848] hover:bg-[#0a2258] text-white text-sm font-bold transition-colors shrink-0">
                            Apply
                        </button>
                    </div>
                    <p data-coupon-msg class="hidden text-xs font-semibold mt-2"></p>
                </div>

                <div class="bg-white rounded-2xl border border-border p-5">
                    <div class="flex items-start gap-3 mb-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                            <x-lucide name="truck" :size="18" />
                        </div>
                        <div>
                            <p class="text-sm font-extrabold text-[#011848]" data-delivery-title>
                                Almost there for FREE delivery
                            </p>
                            <p class="text-xs text-muted-foreground mt-0.5" data-delivery-sub>
                                Add MVR {{ number_format($freeDeliveryThreshold) }} more to unlock free delivery.
                            </p>
                        </div>
                    </div>
                    <div class="h-2 rounded-full bg-[#E8EAED] overflow-hidden">
                        <div
                            data-delivery-progress
                            class="h-full rounded-full transition-all duration-300 bg-primary"
                            style="width: 0%"
                        ></div>
                    </div>
                </div>
            </aside>
        </div>

        {{-- You May Also Like --}}
        <section class="mt-10 md:mt-14 relative" data-suggest-slider>
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-xl md:text-2xl font-extrabold text-[#011848]">You May Also Like</h2>
            </div>

            <button
                type="button"
                data-suggest-prev
                class="hidden md:flex absolute left-0 top-1/2 -translate-y-1/2 -ml-3 z-10 w-10 h-10 rounded-full bg-white border border-border shadow-sm items-center justify-center text-gray-500 hover:text-primary hover:border-primary transition-colors"
                aria-label="Previous products"
            >
                <x-lucide name="chevron-left" :size="18" />
            </button>

            <div data-suggest-track class="flex gap-4 overflow-x-auto scroll-smooth scrollbar-hide pb-1" style="scrollbar-width: none;">
                @foreach ($suggested as $product)
                    <div class="min-w-[220px] max-w-[220px] sm:min-w-[240px] sm:max-w-[240px] shrink-0">
                        <x-product-card
                            :id="$product['id']"
                            :name="$product['name']"
                            :img="$product['img']"
                            :price="$product['price']"
                            :original="$product['original'] ?? null"
                            :rating="$product['rating']"
                            :reviews="$product['reviews']"
                        />
                    </div>
                @endforeach
            </div>

            <button
                type="button"
                data-suggest-next
                class="hidden md:flex absolute right-0 top-1/2 -translate-y-1/2 -mr-3 z-10 w-10 h-10 rounded-full bg-white border border-border shadow-sm items-center justify-center text-gray-500 hover:text-primary hover:border-primary transition-colors"
                aria-label="Next products"
            >
                <x-lucide name="chevron-right" :size="18" />
            </button>
        </section>
    </div>

    <section class="bg-white border-y border-border/60">
        <div class="site-container">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-y-6 gap-x-4 py-7 md:py-8">
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

    <section class="w-full bg-[#011848]" data-newsletter>
        <div class="site-container py-8 md:py-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4 text-white text-center md:text-left">
                <x-lucide name="mail" :size="28" class="hidden sm:block text-white shrink-0" />
                <div>
                    <h2 class="text-xl md:text-2xl font-extrabold mb-1">Stay Updated With LITUS Connect</h2>
                    <p class="text-white/70 text-sm">Subscribe to get special offers, free giveaways, and once-in-a-lifetime deals.</p>
                </div>
            </div>
            <div class="w-full md:w-auto md:min-w-[420px] max-w-lg">
                <div data-newsletter-success class="hidden items-center gap-2 text-white font-bold text-sm bg-white/10 px-5 py-3 rounded-full">
                    <x-lucide name="check-circle" :size="18" class="text-emerald-400" />
                    You're subscribed! Welcome to LITUS Connect.
                </div>
                <div data-newsletter-form class="flex w-full overflow-hidden rounded-full bg-white shadow-sm">
                    <input type="email" data-newsletter-email placeholder="Enter your email address" class="flex-1 min-w-0 px-5 py-3.5 text-sm outline-none bg-transparent text-gray-900 placeholder:text-gray-400">
                    <button type="button" data-newsletter-submit class="bg-primary hover:bg-[#0d4fc7] text-white font-bold px-6 py-3.5 text-sm transition-colors whitespace-nowrap rounded-full">
                        Subscribe
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
