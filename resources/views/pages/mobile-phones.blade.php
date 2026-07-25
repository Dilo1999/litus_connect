@extends('layouts.app')

@section('title', 'Mobile Phones — TechZone Technology Store')
@section('meta_description', 'Shop the latest smartphones at TechZone. iPhone, Samsung, Xiaomi and more with official warranty and island-wide delivery.')

@section('content')

    {{-- Breadcrumb --}}
    <div class="bg-white border-b border-border">
        <div class="site-container py-3 flex items-center gap-2 text-sm text-muted-foreground">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors font-medium">Home</a>
            <x-lucide name="chevron-right" :size="13" />
            <span class="font-bold text-[#011848]">Mobile Phones</span>
        </div>
    </div>

    <div class="site-container py-6 pb-10" data-shop-page data-shop-mode="mobile-phones">
        <div class="flex items-center justify-between mb-5 md:hidden">
            <h1 class="text-xl font-extrabold text-[#011848]">Mobile Phones</h1>
            <button type="button" data-shop-mobile-filters class="flex items-center gap-2 px-4 py-2.5 rounded-lg border border-border text-sm font-bold text-gray-700 hover:border-primary hover:text-primary transition-colors">
                <x-lucide name="sliders" :size="15" />
                Filters
            </button>
        </div>

        <div class="flex gap-6 lg:gap-8">
            <aside class="hidden md:block w-[260px] lg:w-[280px] flex-shrink-0 self-start sticky top-28">
                @include('components.mobile_phone_page.mobile-phones-filters', [
                    'categoryMeta' => $categoryMeta,
                    'brandMeta' => $brandMeta,
                    'maxCatalogPrice' => $maxCatalogPrice,
                    'minCatalogPrice' => $minCatalogPrice,
                ])
            </aside>

            <div class="flex-1 min-w-0">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
                    <div>
                        <h1 class="hidden md:block text-2xl font-extrabold text-[#011848]">Mobile Phones</h1>
                        <p class="text-sm text-muted-foreground mt-0.5">
                            Showing <span data-shop-range>1–{{ min($perPage, count($products)) }}</span> of <span data-shop-total>{{ $totalCatalogCount }}</span> products
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-2">
                            <label class="text-sm text-muted-foreground font-medium whitespace-nowrap hidden sm:block">Sort by:</label>
                            <div class="relative">
                                <select data-shop-sort class="appearance-none bg-white border border-border rounded-lg pl-3 pr-8 py-2 text-sm font-semibold text-foreground outline-none cursor-pointer focus:border-primary">
                                    @foreach ($sortOptions as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                                <x-lucide name="chevron-down" :size="13" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-muted-foreground pointer-events-none" />
                            </div>
                        </div>
                        <div class="flex items-center gap-1 p-1 bg-white rounded-lg border border-border">
                            <button type="button" data-shop-view="grid" class="p-1.5 rounded-md transition-colors bg-primary text-white" aria-label="Grid view">
                                <x-lucide name="layout-grid" :size="16" />
                            </button>
                            <button type="button" data-shop-view="list" class="p-1.5 rounded-md transition-colors text-gray-500 hover:text-gray-700" aria-label="List view">
                                <x-lucide name="list" :size="16" />
                            </button>
                        </div>
                    </div>
                </div>

                <div data-shop-chips class="flex flex-wrap gap-2 mb-4 hidden"></div>
                <div data-shop-grid class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4"></div>
                <div data-shop-list class="hidden flex-col gap-4"></div>

                <div data-shop-empty class="hidden flex-col items-center justify-center py-24 bg-white rounded-xl border border-border text-center">
                    <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                        <x-lucide name="smartphone" :size="28" class="text-gray-300" />
                    </div>
                    <h3 class="font-bold text-lg text-foreground mb-2">No phones found</h3>
                    <p class="text-sm text-muted-foreground mb-5">Try adjusting your filters to find what you are looking for.</p>
                    <button type="button" data-shop-reset class="px-6 py-2.5 rounded-lg text-sm font-bold text-white bg-primary hover:bg-[#0d4fc7] transition-colors">
                        Reset Filters
                    </button>
                </div>

                <div data-shop-pagination class="flex items-center justify-center gap-1.5 mt-8"></div>
            </div>
        </div>
    </div>

    <div data-shop-drawer class="fixed inset-0 z-50 md:hidden hidden">
        <div data-shop-drawer-overlay class="absolute inset-0 bg-black/50"></div>
        <div class="absolute right-0 top-0 bottom-0 w-80 max-w-[90vw] bg-[#F3F5F9] overflow-y-auto p-4 shadow-2xl">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-extrabold text-base text-[#011848]">Filters</h2>
                <button type="button" data-shop-drawer-close class="w-9 h-9 rounded-lg border border-border bg-white flex items-center justify-center">
                    <x-lucide name="x" :size="16" />
                </button>
            </div>
            @include('components.mobile_phone_page.mobile-phones-filters', [
                'categoryMeta' => $categoryMeta,
                'brandMeta' => $brandMeta,
                'maxCatalogPrice' => $maxCatalogPrice,
                'minCatalogPrice' => $minCatalogPrice,
                'mobile' => true,
            ])
        </div>
    </div>

    <section class="bg-[#F7F8FA] border-y border-border/60">
        <div class="site-container">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-y-6 gap-x-4 py-7 md:py-8">
                @foreach ($serviceFeatures as $feature)
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-full bg-white shadow-[0_2px_10px_rgba(11,20,38,0.08)] flex items-center justify-center flex-shrink-0 text-[#011848]">
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
                    <input type="email" data-newsletter-email placeholder="Enter your email address" class="flex-1 min-w-0 px-5 py-3.5 text-sm outline-none bg-transparent text-gray-900 placeholder:text-gray-400">
                    <button type="button" data-newsletter-submit class="bg-primary hover:bg-[#0d4fc7] text-white font-bold px-6 py-3.5 text-sm transition-colors whitespace-nowrap rounded-full">
                        Subscribe
                    </button>
                </div>
            </div>
        </div>
    </section>

    <script type="application/json" id="shop-catalog">@json($products)</script>
    <script type="application/json" id="shop-config">@json($shopConfig)</script>

@endsection
