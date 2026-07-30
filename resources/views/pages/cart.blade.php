@extends('layouts.app')

@section('title', 'Shopping Cart — LITUS Connect')
@section('meta_description', 'Review your cart and proceed to checkout at LITUS Connect. Free delivery on orders over MVR 5,000.')

@section('content')

<div
    class="bg-white"
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
                            <a href="{{ route('shop') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-[#005266] text-white text-sm font-bold px-5 py-2.5 rounded-lg transition-colors">
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
                {{-- 1. Order Summary --}}
                <div class="bg-white rounded-2xl border border-border p-5 md:p-6">
                    <h2 class="text-lg font-extrabold text-[#011848] mb-4">Order Summary</h2>

                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-muted-foreground">Subtotal (<span data-summary-count>0</span> items)</span>
                            <span class="font-bold text-[#011848]" data-summary-subtotal>MVR 0</span>
                        </div>
                        <div class="flex items-center justify-between hidden" data-discount-row>
                            <span class="font-medium text-emerald-600">Discount (<span data-discount-code>{{ $discountCode }}</span>)</span>
                            <span class="font-bold text-emerald-600" data-summary-discount>- MVR 0</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-muted-foreground">Delivery</span>
                            <span class="font-bold text-emerald-600" data-summary-delivery>FREE</span>
                        </div>
                    </div>

                    <div class="border-t border-border mt-4 pt-4 mb-5">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-base font-extrabold text-[#011848]">Total</p>
                                <p class="text-[11px] text-muted-foreground mt-0.5">(Includes VAT)</p>
                            </div>
                            <p class="text-xl font-extrabold text-[#011848] text-right break-words" data-summary-total>MVR 0</p>
                        </div>
                    </div>

                    <button type="button" data-checkout-btn class="w-full inline-flex items-center justify-center gap-2 h-12 rounded-lg bg-primary hover:bg-[#005266] text-white text-sm font-bold transition-colors">
                        <x-lucide name="lock" :size="15" />
                        Proceed to Checkout
                    </button>
                </div>

                {{-- 2. We Accept --}}
                <div class="bg-white rounded-2xl border border-border p-5">
                    <h3 class="text-sm font-extrabold text-[#011848] mb-3">We Accept</h3>
                    <div class="flex flex-wrap items-center gap-3">
                        {{-- Visa --}}
                        <span class="inline-flex items-center justify-center h-9 px-2.5 rounded-md bg-white border border-border" title="Visa" aria-label="Visa">
                            <svg width="38" height="14" viewBox="0 0 48 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M18.3 1.2h-3.7l-2.3 13.6h3.7L18.3 1.2zm12.2 8.8l1.9-5.3.9 5.3h-2.8zm3.8 4.8h3.4L35.4 1.2h-3.1c-.7 0-1.2.4-1.5 1L26 14.8h3.8l.6-1.6h4.6l.3 1.6zm-8.9-4.4c0-3.5-4.9-3.7-4.8-5.3.1-.5.5-.9 1.5-.9 1.3 0 2.5.3 3.4.8l.6-2.9c-1-.4-2.3-.7-3.8-.7-4 0-6.8 2.1-6.9 5.2-.1 2.2 2 3.5 3.5 4.2 1.5.8 2.1 1.3 2 2-.1 1.1-1.3 1.5-2.5 1.5-1.5 0-2.9-.4-3.8-.8l-.7 3c1 .4 2.7.8 4.5.8 4.3.1 7.1-2.1 7.2-5.4zM11.2 1.2L7.6 10.4l-.4-1.9C6.5 5.7 4.3 2.8 1.8 1.4l3.3 13.4h3.8L15 1.2h-3.8z" fill="#1A1F71"/>
                                <path d="M5.7 1.2H.1L0 1.5C4.3 2.6 7.2 5.2 8.3 8.5L7 1.8c-.1-.4-.5-.6-1.3-.6z" fill="#F7B600"/>
                            </svg>
                        </span>
                        {{-- Mastercard --}}
                        <span class="inline-flex items-center justify-center h-9 px-2 rounded-md bg-white border border-border" title="Mastercard" aria-label="Mastercard">
                            <svg width="32" height="20" viewBox="0 0 32 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <circle cx="12" cy="10" r="7.5" fill="#EB001B"/>
                                <circle cx="20" cy="10" r="7.5" fill="#F79E1B"/>
                                <path d="M16 4.4a7.5 7.5 0 0 1 0 11.2 7.5 7.5 0 0 1 0-11.2z" fill="#FF5F00"/>
                            </svg>
                        </span>
                        {{-- American Express --}}
                        <span class="inline-flex items-center justify-center h-9 px-2 rounded-md bg-[#016FD0]" title="American Express" aria-label="American Express">
                            <svg width="34" height="12" viewBox="0 0 34 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <text x="0" y="10" fill="white" font-size="9" font-family="Arial, Helvetica, sans-serif" font-weight="700">AMEX</text>
                            </svg>
                        </span>
                        {{-- PayPal --}}
                        <span class="inline-flex items-center justify-center h-9 px-2.5 rounded-md bg-white border border-border" title="PayPal" aria-label="PayPal">
                            <svg width="52" height="14" viewBox="0 0 52 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <text x="0" y="11" font-size="11" font-family="Arial, Helvetica, sans-serif" font-weight="700">
                                    <tspan fill="#003087">Pay</tspan><tspan fill="#009CDE">Pal</tspan>
                                </text>
                            </svg>
                        </span>
                    </div>
                </div>

                {{-- 3. Coupon --}}
                <div class="bg-white rounded-2xl border border-border p-5">
                    <h3 class="text-sm font-extrabold text-[#011848] mb-3">Have a Coupon?</h3>
                    <div class="flex flex-col min-[380px]:flex-row gap-2">
                        <input
                            type="text"
                            data-coupon-input
                            value=""
                            placeholder="Enter coupon code"
                            class="flex-1 min-w-0 h-11 px-3.5 rounded-lg border border-border text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/15"
                        >
                        <button type="button" data-coupon-apply class="h-11 px-4 rounded-lg border border-border bg-white text-primary hover:border-primary hover:bg-blue-light text-sm font-bold transition-colors shrink-0">
                            Apply
                        </button>
                    </div>
                    <p data-coupon-msg class="hidden text-xs font-semibold mt-2"></p>
                </div>

                {{-- 4. Free delivery progress --}}
                <div class="rounded-2xl border border-border bg-[#F3F5F9] p-5">
                    <div class="flex items-start gap-3 mb-4">
                        <div class="text-[#011848] shrink-0 mt-0.5">
                            <x-lucide name="truck" :size="22" />
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm text-[#011848]" data-delivery-lead>Almost there for</p>
                            <p class="text-base font-extrabold tracking-wide text-primary" data-delivery-highlight>FREE DELIVERY!</p>
                            <p class="text-xs text-muted-foreground mt-1" data-delivery-sub>
                                Add MVR {{ number_format($freeDeliveryThreshold) }} more to get free delivery.
                            </p>
                        </div>
                    </div>
                    <div>
                        <div class="h-2.5 rounded-full bg-white overflow-hidden border border-border/60">
                            <div
                                data-delivery-progress
                                class="h-full rounded-full transition-all duration-300 bg-primary"
                                style="width: 0%"
                            ></div>
                        </div>
                        <div class="flex justify-end mt-1.5">
                            <span class="text-xs font-bold text-emerald-600" data-delivery-threshold>MVR {{ number_format($freeDeliveryThreshold) }}</span>
                        </div>
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

    <x-newsletter />

    <div data-mobile-checkout class="lg:hidden fixed inset-x-0 bottom-0 z-40 hidden border-t border-border bg-white/95 backdrop-blur px-4 py-3 pb-[max(0.75rem,env(safe-area-inset-bottom))] shadow-[0_-8px_24px_rgba(11,20,38,0.12)]">
        <div class="flex items-center gap-3">
            <div class="min-w-0 flex-1">
                <p class="text-[11px] text-muted-foreground font-semibold">Total</p>
                <p class="text-base font-extrabold text-[#011848] truncate" data-mobile-checkout-total>MVR 0</p>
            </div>
            <button type="button" data-checkout-btn class="inline-flex items-center justify-center gap-2 min-h-11 px-4 rounded-lg bg-primary hover:bg-[#005266] text-white text-sm font-bold transition-colors shrink-0">
                <x-lucide name="lock" :size="15" />
                Checkout
            </button>
        </div>
    </div>
</div>

@endsection
