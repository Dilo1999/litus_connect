@extends('layouts.app')

@section('title', 'TechZone Technology Store — Premium Electronics')
@section('meta_description', 'Shop authentic electronics, mobile phones, headsets, accessories and more at TechZone. Free delivery on orders over LKR 5,000.')

@section('content')

    {{-- Hero --}}
    <section class="w-full">
        <div
            class="relative w-full overflow-hidden min-h-[360px] md:min-h-[480px] lg:min-h-[520px]"
            data-hero-slider
            style="background: {{ $heroSlides[0]['bg'] }}"
        >
            @foreach ($heroSlides as $index => $slide)
                <div
                    data-hero-slide="{{ $index }}"
                    class="{{ $index === 0 ? 'flex' : 'hidden' }} items-center w-full h-full min-h-[360px] md:min-h-[480px] lg:min-h-[520px]"
                >
                    <div class="site-container flex items-center w-full gap-8 py-12 md:py-16">
                        <div class="flex-1 text-white z-10 max-w-xl">
                            <span class="inline-block text-[11px] font-bold tracking-[0.2em] text-primary bg-white/10 border border-white/15 px-3 py-1 rounded mb-4">
                                {{ $slide['eyebrow'] }}
                            </span>
                            <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold leading-[1.1] mb-4 whitespace-pre-line tracking-tight">
                                {{ $slide['headline'] }}
                            </h1>
                            <p class="text-white/70 text-sm md:text-base leading-relaxed mb-7 max-w-md">{{ $slide['sub'] }}</p>
                            <a href="#" class="inline-flex items-center gap-2 bg-white text-[#0B1426] font-bold px-6 py-3 rounded-full text-sm hover:bg-gray-100 transition-all">
                                {{ $slide['cta'] }}
                                <x-lucide name="arrow-right" :size="15" />
                            </a>
                        </div>
                        <div class="hidden sm:flex flex-1 justify-center items-center">
                            <img
                                src="{{ $slide['img'] }}"
                                alt="{{ $slide['eyebrow'] }}"
                                class="max-h-[300px] md:max-h-[400px] lg:max-h-[440px] object-contain drop-shadow-2xl animate-fade-slide"
                                data-hero-image
                            >
                        </div>
                    </div>
                </div>
            @endforeach

            <button type="button" data-hero-prev class="absolute left-3 md:left-6 top-1/2 -translate-y-1/2 w-10 h-10 md:w-12 md:h-12 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur flex items-center justify-center text-white transition-colors border border-white/15 z-20" aria-label="Previous slide">
                <x-lucide name="chevron-left" :size="18" />
            </button>
            <button type="button" data-hero-next class="absolute right-3 md:right-6 top-1/2 -translate-y-1/2 w-10 h-10 md:w-12 md:h-12 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur flex items-center justify-center text-white transition-colors border border-white/15 z-20" aria-label="Next slide">
                <x-lucide name="chevron-right" :size="18" />
            </button>

            <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex gap-2 z-20">
                @foreach ($heroSlides as $index => $slide)
                    <button
                        type="button"
                        data-hero-dot="{{ $index }}"
                        class="h-1.5 rounded-full transition-all duration-300 {{ $index === 0 ? 'w-7 bg-white' : 'w-1.5 bg-white/35 hover:bg-white/50' }}"
                        aria-label="Go to slide {{ $index + 1 }}"
                    ></button>
                @endforeach
            </div>
        </div>
    </section>

    @php
        $heroBgJson = collect($heroSlides)->pluck('bg')->values();
    @endphp
    <script type="application/json" id="hero-slide-bgs">@json($heroBgJson)</script>

    {{-- Service Features --}}
    <section class="bg-[#F7F8FA] border-y border-border/60">
        <div class="site-container">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-y-6 gap-x-4 py-7 md:py-8">
                @foreach ($serviceFeatures as $feature)
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-full bg-white shadow-[0_2px_10px_rgba(11,20,38,0.08)] flex items-center justify-center flex-shrink-0 text-[#0B1426]">
                            <x-lucide :name="$feature['icon']" :size="18" />
                        </div>
                        <div>
                            <p class="text-sm font-bold text-[#0B1426]">{{ $feature['title'] }}</p>
                            <p class="text-[11px] text-muted-foreground leading-tight">{{ $feature['sub'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Quick Categories --}}
    <section class="site-container py-10">
        <div class="grid grid-cols-4 sm:grid-cols-8 gap-4 md:gap-6">
            @foreach ($quickCategories as $item)
                <a href="#" class="flex flex-col items-center gap-2.5 group">
                    <div class="w-16 h-16 md:w-[72px] md:h-[72px] rounded-full bg-[#F3F5F9] border border-border group-hover:border-primary group-hover:bg-blue-light transition-all flex items-center justify-center overflow-hidden shadow-sm">
                        @if (!empty($item['img']))
                            <img src="{{ $item['img'] }}" alt="{{ $item['label'] }}" class="w-10 h-10 md:w-12 md:h-12 object-contain" loading="lazy">
                        @else
                            <x-lucide :name="$item['icon'] ?? 'arrow-right'" :size="22" class="text-primary" />
                        @endif
                    </div>
                    <span class="text-[11px] md:text-xs font-semibold text-center text-gray-700 group-hover:text-primary transition-colors leading-tight">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Promo Banners --}}
    <section class="site-container pb-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($promoBanners as $banner)
                <div class="rounded-2xl p-6 flex items-center justify-between gap-4 overflow-hidden" style="background: {{ $banner['bg'] }}">
                    <div class="min-w-0">
                        <h3 class="font-extrabold text-lg text-[#0B1426] leading-tight">{{ $banner['title'] }}</h3>
                        <p class="text-sm text-gray-600 mt-1 mb-4">{{ $banner['sub'] }}</p>
                        <a
                            href="#"
                            class="inline-flex items-center gap-1.5 text-white text-xs font-bold px-4 py-2 rounded-full transition-opacity hover:opacity-90"
                            style="background: {{ $banner['btn'] }}"
                        >
                            {{ $banner['cta'] }}
                            <x-lucide name="arrow-right" :size="12" />
                        </a>
                    </div>
                    <img src="{{ $banner['img'] }}" alt="{{ $banner['title'] }}" class="w-24 h-24 md:w-28 md:h-28 object-contain shrink-0" loading="lazy">
                </div>
            @endforeach
        </div>
    </section>

    {{-- Popular Categories --}}
    <section class="site-container py-10">
        <x-section-heading title="Popular Categories" />

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach ($categories as $cat)
                <a
                    href="#"
                    class="flex flex-col items-center text-center p-5 bg-white rounded-xl border border-border hover:border-primary hover:shadow-md transition-all group"
                >
                    <div class="w-20 h-20 mb-3 rounded-xl bg-[#F7F9FC] flex items-center justify-center overflow-hidden">
                        <img src="{{ $cat['img'] }}" alt="{{ $cat['name'] }}" class="w-16 h-16 object-contain group-hover:scale-105 transition-transform" loading="lazy">
                    </div>
                    <span class="text-sm font-bold text-[#0B1426] group-hover:text-primary transition-colors">{{ $cat['name'] }}</span>
                    <span class="text-[11px] font-semibold text-primary mt-1">{{ $cat['discount'] }}</span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Best Selling Products --}}
    <section class="site-container pb-10">
        <x-section-heading title="Best Selling Products" />

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach ($products as $product)
                <x-product-card
                    :name="$product['name']"
                    :img="$product['img']"
                    :price="$product['price']"
                    :original="$product['original']"
                    :rating="$product['rating']"
                    :reviews="$product['reviews']"
                    :badge="$product['badge']"
                />
            @endforeach
        </div>
    </section>

    {{-- Brands --}}
    <section class="site-container pb-10">
        <x-section-heading title="Shop by Brand" :show-link="false" />

        <div class="bg-white rounded-xl border border-border px-4 py-6">
            <div class="grid grid-cols-4 sm:grid-cols-8 gap-3">
                @foreach ($brands as $brand)
                    <a
                        href="#"
                        class="flex items-center justify-center h-16 px-2 rounded-lg border border-border hover:border-primary hover:bg-blue-light transition-all group"
                        title="{{ $brand['name'] }}"
                    >
                        <span class="text-sm md:text-base font-extrabold tracking-wide text-gray-500 group-hover:text-primary transition-colors">{{ $brand['logo'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Why Shop With TechZone --}}
    <section class="site-container pb-10">
        <x-section-heading title="Why Shop With TechZone?" :show-link="false" />

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($whyUs as $item)
                <div class="bg-white rounded-2xl border border-border px-6 py-8 flex flex-col items-center text-center hover:shadow-md hover:border-primary/30 transition-all">
                    <div class="w-14 h-14 rounded-full bg-blue-light text-primary flex items-center justify-center mb-4">
                        <x-lucide :name="$item['icon']" :size="24" />
                    </div>
                    <h3 class="font-extrabold text-sm md:text-base text-[#0B1426] mb-1.5">{{ $item['title'] }}</h3>
                    <p class="text-xs text-muted-foreground leading-relaxed">{{ $item['sub'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Testimonials --}}
    <section class="site-container pb-10">
        <x-section-heading title="What Our Customers Say" :show-link="false" />

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach ($testimonials as $testimonial)
                <div class="bg-white rounded-xl border border-border p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-3 mb-4">
                        <img
                            src="{{ $testimonial['avatar'] }}"
                            alt="{{ $testimonial['name'] }}"
                            class="w-11 h-11 rounded-full object-cover ring-2 ring-border"
                            loading="lazy"
                        >
                        <div>
                            <div class="flex items-center gap-1.5">
                                <p class="font-bold text-sm text-[#0B1426]">{{ $testimonial['name'] }}</p>
                                <span class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-emerald-500 text-white" title="Verified">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6 9 17l-5-5"/></svg>
                                </span>
                            </div>
                            <x-star-rating :rating="$testimonial['rating']" :size="12" class="mt-1" />
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed">"{{ $testimonial['text'] }}"</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Blog --}}
    <section class="site-container pb-10">
        <x-section-heading title="Latest From Our Blog" link-text="View All" />

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach ($blogPosts as $post)
                <a
                    href="#"
                    class="bg-white rounded-xl border border-border overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition-all group"
                >
                    <div class="overflow-hidden h-40 bg-gray-100">
                        <img src="{{ $post['img'] }}" alt="{{ $post['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                    </div>
                    <div class="p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-[10px] font-bold text-primary bg-blue-light px-2 py-0.5 rounded">{{ $post['category'] }}</span>
                            <span class="text-[11px] text-muted-foreground">{{ $post['date'] }}</span>
                        </div>
                        <h3 class="font-bold text-sm text-[#0B1426] leading-snug mb-3 group-hover:text-primary transition-colors line-clamp-2">{{ $post['title'] }}</h3>
                        <span class="text-xs font-bold text-primary inline-flex items-center gap-1">
                            Read More
                            <x-lucide name="arrow-right" :size="12" />
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Newsletter --}}
    <section class="w-full bg-[#011848]" data-newsletter>
        <div class="site-container py-8 md:py-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4 text-white text-center md:text-left">
                <x-lucide name="mail" :size="28" class="hidden sm:block text-white shrink-0" />
                <div>
                    <h2 class="text-xl md:text-2xl font-extrabold mb-1">Stay Updated With TechZone</h2>
                    <p class="text-white/70 text-sm">Subscribe to get special offers, free giveaways, and once-in-a-lifetime deals.</p>
                </div>
            </div>

            <div class="w-full md:w-auto md:min-w-[420px] max-w-lg">
                <div data-newsletter-success class="hidden items-center gap-2 text-white font-bold text-sm bg-white/10 px-5 py-3 rounded-full">
                    <x-lucide name="check-circle" :size="18" class="text-emerald-400" />
                    You're subscribed! Welcome to TechZone.
                </div>

                <div data-newsletter-form class="flex w-full overflow-hidden rounded-full bg-white shadow-sm">
                    <input
                        type="email"
                        data-newsletter-email
                        placeholder="Enter your email address"
                        class="flex-1 min-w-0 px-5 py-3.5 text-sm outline-none bg-transparent text-gray-900 placeholder:text-gray-400"
                    >
                    <button
                        type="button"
                        data-newsletter-submit
                        class="bg-primary hover:bg-[#0d4fc7] text-white font-bold px-6 py-3.5 text-sm transition-colors whitespace-nowrap rounded-full"
                    >
                        Subscribe
                    </button>
                </div>
            </div>
        </div>
    </section>

@endsection
