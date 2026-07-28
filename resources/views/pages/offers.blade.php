@extends('layouts.app')

@section('title', 'Special Offers — LITUS Connect')
@section('meta_description', 'Shop Mega Tech Sale deals at LITUS Connect. Limited-time discounts on phones, accessories, headsets, and smart watches.')

@section('content')

<div class="bg-[#F7F8FA]" data-offers-page>
    <div class="site-container py-5 md:py-7">
        <div class="flex flex-wrap items-center gap-2 text-sm text-muted-foreground mb-5">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors font-medium">Home</a>
            <x-lucide name="chevron-right" :size="13" class="text-gray-300" />
            <span class="font-bold text-[#011848]">Offers</span>
        </div>

        <div class="flex items-center justify-between mb-5 md:hidden">
            <h1 class="text-xl font-extrabold text-[#011848]">Special Offers</h1>
            <button type="button" data-offers-mobile-filters class="flex items-center gap-2 px-4 py-2.5 rounded-lg border border-border bg-white text-sm font-bold text-gray-700 hover:border-primary hover:text-primary transition-colors">
                <x-lucide name="sliders" :size="15" />
                Filters
            </button>
        </div>

        <div class="flex gap-6 lg:gap-8">
            <aside class="hidden md:block w-[260px] lg:w-[280px] flex-shrink-0 self-start sticky top-28">
                @include('components.offers_page.offers-filters', [
                    'offerCategories' => $offerCategories,
                    'brandMeta' => $brandMeta,
                    'countdownEndsAt' => $countdownEndsAt,
                ])
            </aside>

            <div class="flex-1 min-w-0">
                {{-- Page header --}}
                <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4 mb-5">
                    <div>
                        <h1 class="hidden md:block text-2xl md:text-3xl font-extrabold text-[#011848]">Special Offers</h1>
                        <p class="text-sm text-muted-foreground mt-1 max-w-xl">Grab limited-time deals on authentic electronics — best prices, genuine products, island-wide delivery.</p>
                    </div>
                    <div class="flex flex-wrap gap-3 sm:gap-4">
                        @foreach ($trustHighlights as $item)
                            <div class="flex items-center gap-2 text-xs sm:text-sm font-semibold text-[#011848]">
                                <span class="w-8 h-8 rounded-full bg-white border border-border text-primary flex items-center justify-center shrink-0">
                                    <x-lucide :name="$item['icon']" :size="14" />
                                </span>
                                <span>{{ $item['title'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Hero banner --}}
                <div class="relative overflow-hidden rounded-2xl mb-6 min-h-[200px] md:min-h-[240px] flex items-center" style="background: linear-gradient(120deg, #011848 0%, #0a2a6e 55%, #1464F4 100%)">
                    <div class="relative z-10 px-6 md:px-10 py-8 max-w-lg">
                        <span class="inline-flex text-[10px] font-bold uppercase tracking-wider bg-red-500 text-white px-2.5 py-1 rounded-md mb-3">Limited Time Only!</span>
                        <h2 class="text-2xl md:text-3xl font-extrabold text-white leading-tight mb-2">Mega Tech Sale<br>Up to 50% Off</h2>
                        <p class="text-white/75 text-sm mb-5">Phones, watches, audio & accessories — exclusive LITUS Connect deals this week.</p>
                        <a href="#top-deals" class="inline-flex items-center gap-2 bg-primary hover:bg-[#0d4fc7] text-white text-sm font-bold px-5 py-2.5 rounded-full transition-colors">
                            Shop All Offers
                            <x-lucide name="arrow-right" :size="15" />
                        </a>
                    </div>
                    <div class="absolute right-0 bottom-0 top-0 hidden sm:flex items-end gap-2 pr-4 md:pr-8 opacity-90">
                        <img src="https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=180&h=220&fit=crop&auto=format" alt="" class="h-36 md:h-48 w-auto object-contain drop-shadow-2xl self-end mb-4">
                        <img src="https://images.unsplash.com/photo-1544117519-31a4b719223d?w=140&h=180&fit=crop&auto=format" alt="" class="h-28 md:h-36 w-auto object-contain drop-shadow-2xl self-end mb-8 hidden md:block">
                        <img src="https://images.unsplash.com/photo-1603351154351-5e2d0600bb77?w=140&h=160&fit=crop&auto=format" alt="" class="h-24 md:h-32 w-auto object-contain drop-shadow-2xl self-end mb-6 hidden lg:block">
                    </div>
                </div>

                {{-- Category quick links --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 mb-8">
                    @foreach ($quickCategories as $cat)
                        <a href="{{ $cat['route'] ? route($cat['route']) : '#' }}" class="bg-white rounded-xl border border-border hover:border-primary/40 hover:shadow-sm transition-all p-3 flex items-center gap-3 group">
                            <div class="w-12 h-12 rounded-lg bg-[#F3F5F9] flex items-center justify-center overflow-hidden shrink-0">
                                <img src="{{ $cat['img'] }}" alt="" class="h-9 w-9 object-contain group-hover:scale-110 transition-transform" loading="lazy">
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-[#011848] truncate">{{ $cat['label'] }}</p>
                                <p class="text-[11px] text-muted-foreground">{{ $cat['count'] }} offers</p>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Top Deals --}}
                <section id="top-deals" class="mb-8">
                    <div class="flex items-end justify-between gap-3 mb-4">
                        <h2 class="text-xl font-extrabold text-[#011848]">Top Deals</h2>
                        <a href="{{ route('shop') }}" class="text-sm font-bold text-primary hover:underline">View All Deals</a>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-3 md:gap-4" data-offers-grid="top">
                        @foreach ($topDeals as $deal)
                            @include('components.offers_page.offer-card', ['deal' => $deal])
                        @endforeach
                    </div>
                </section>

                {{-- Mid promos --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    @foreach ($midPromos as $promo)
                        <div class="relative overflow-hidden rounded-2xl min-h-[150px] p-5 flex flex-col justify-between text-white" style="background: {{ $promo['bg'] }}">
                            <div class="relative z-10">
                                <p class="text-lg font-extrabold leading-tight">{{ $promo['title'] }}</p>
                                <p class="text-white/85 text-sm mt-1">{{ $promo['sub'] }}</p>
                            </div>
                            <a href="{{ route($promo['route']) }}" class="relative z-10 inline-flex self-start mt-4 text-xs font-bold bg-white/95 text-[#011848] px-3.5 py-2 rounded-full hover:bg-white transition-colors">
                                Shop Now
                            </a>
                            <img src="{{ $promo['img'] }}" alt="" class="absolute right-2 bottom-2 h-24 w-24 object-contain opacity-90 drop-shadow-lg" loading="lazy">
                        </div>
                    @endforeach
                </div>

                {{-- Hot Offers --}}
                <section class="mb-4">
                    <div class="flex items-end justify-between gap-3 mb-4">
                        <h2 class="text-xl font-extrabold text-[#011848]">Hot Offers</h2>
                        <a href="{{ route('shop') }}" class="text-sm font-bold text-primary hover:underline">View All Offers</a>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-3 md:gap-4" data-offers-grid="hot">
                        @foreach ($hotOffers as $deal)
                            @include('components.offers_page.offer-card', ['deal' => $deal])
                        @endforeach
                    </div>
                    <div data-offers-empty class="hidden flex-col items-center justify-center py-16 bg-white rounded-xl border border-border text-center mt-4">
                        <div class="w-14 h-14 rounded-2xl bg-gray-100 flex items-center justify-center mb-3">
                            <x-lucide name="tag" :size="24" class="text-gray-300" />
                        </div>
                        <h3 class="font-bold text-base text-foreground mb-1">No offers match your filters</h3>
                        <p class="text-sm text-muted-foreground mb-4">Try adjusting discount range, category, or brand.</p>
                        <button type="button" data-offers-reset class="px-5 py-2.5 rounded-lg text-sm font-bold text-white bg-primary hover:bg-[#0d4fc7] transition-colors">
                            Reset Filters
                        </button>
                    </div>
                </section>
            </div>
        </div>
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

    <x-newsletter
        icon="gift"
        title="Don't Miss Any Offers!"
        subtitle="Subscribe for flash deals, exclusive coupons, and weekly LITUS Connect drops."
    />
</div>

{{-- Mobile filters drawer --}}
<div data-offers-drawer class="fixed inset-0 z-50 md:hidden hidden">
    <div data-offers-drawer-overlay class="absolute inset-0 bg-black/50"></div>
    <div class="absolute right-0 top-0 bottom-0 w-80 max-w-[90vw] bg-[#F3F5F9] overflow-y-auto p-4 shadow-2xl">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-extrabold text-base text-[#011848]">Filters</h2>
            <button type="button" data-offers-drawer-close class="w-9 h-9 rounded-lg border border-border bg-white flex items-center justify-center">
                <x-lucide name="x" :size="16" />
            </button>
        </div>
        @include('components.offers_page.offers-filters', [
            'offerCategories' => $offerCategories,
            'brandMeta' => $brandMeta,
            'countdownEndsAt' => $countdownEndsAt,
            'mobile' => true,
        ])
    </div>
</div>

@endsection
