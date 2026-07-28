@php
    $prefix = !empty($mobile) ? 'm-' : '';
    $promoTitle = $promoTitle ?? 'Up to 20% Off';
    $promoSub = $promoSub ?? 'On selected products';
    $promoRoute = $promoRoute ?? 'shop';
    $promoImage = $promoImage ?? 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=120&h=100&fit=crop&auto=format';
    $promoAlt = $promoAlt ?? 'Offer';
@endphp

<div class="space-y-4" data-shop-sidebar>
    {{-- Categories --}}
    <div class="bg-white rounded-xl border border-border overflow-hidden" data-filter-section>
        <button type="button" data-filter-toggle class="flex items-center justify-between w-full px-4 py-3.5 border-b border-border">
            <span class="text-sm font-bold text-[#011848]">Categories</span>
            <x-lucide name="chevron-up" :size="15" class="text-muted-foreground transition-transform" data-filter-chevron />
        </button>
        <div data-filter-body class="px-4 py-3">
            <div class="flex flex-col gap-1" data-category-list>
                @foreach ($categoryMeta as $index => $cat)
                    <button
                        type="button"
                        data-filter-series="{{ $cat['key'] }}"
                        @class([
                            'flex items-center justify-between gap-2 px-3 py-2 rounded-lg text-sm transition-colors text-left',
                            'bg-blue-light text-primary font-bold' => $cat['key'] === 'all',
                            'text-gray-700 hover:bg-gray-50 font-medium' => $cat['key'] !== 'all',
                            'hidden' => $index >= 6,
                        ])
                        data-category-item
                    >
                        <span>{{ $cat['label'] }}</span>
                        <span class="text-xs opacity-70">({{ $cat['count'] }})</span>
                    </button>
                @endforeach
            </div>
            @if (count($categoryMeta) > 6)
                <button type="button" data-categories-more class="mt-3 text-xs font-bold text-primary hover:underline">View More</button>
            @endif
        </div>
    </div>

    {{-- Price --}}
    <div class="bg-white rounded-xl border border-border overflow-hidden" data-filter-section>
        <button type="button" data-filter-toggle class="flex items-center justify-between w-full px-4 py-3.5 border-b border-border">
            <span class="text-sm font-bold text-[#011848]">Price Range</span>
            <x-lucide name="minus" :size="15" class="text-muted-foreground" data-filter-chevron />
        </button>
        <div data-filter-body class="px-4 py-4 space-y-4">
            <p class="text-sm font-bold text-[#011848]" data-filter-price-label>MVR {{ number_format($minCatalogPrice ?? 0) }} – MVR {{ number_format($maxCatalogPrice) }}</p>

            <div
                class="price-dual-slider relative h-6 flex items-center"
                data-price-dual-slider
                style="--range-min: 0%; --range-max: 100%;"
            >
                <div class="absolute left-0 right-0 h-1.5 rounded-full bg-[#E4E9F2]"></div>
                <div class="absolute h-1.5 rounded-full bg-primary pointer-events-none" data-price-range-fill style="left: var(--range-min); right: calc(100% - var(--range-max));"></div>
                <input type="range" data-filter-price-min-range min="{{ $minCatalogPrice ?? 0 }}" max="{{ $maxCatalogPrice }}" value="{{ $minCatalogPrice ?? 0 }}" step="1000" class="price-dual-thumb" aria-label="Minimum price">
                <input type="range" data-filter-price-max-range min="{{ $minCatalogPrice ?? 0 }}" max="{{ $maxCatalogPrice }}" value="{{ $maxCatalogPrice }}" step="1000" class="price-dual-thumb" aria-label="Maximum price">
            </div>

            <div class="flex items-center gap-2.5">
                <div class="flex flex-1 min-w-0 items-stretch rounded-lg border border-border overflow-hidden bg-white focus-within:border-primary">
                    <span class="inline-flex items-center px-2.5 text-xs font-semibold text-muted-foreground bg-[#F7F8FA] border-r border-border">MVR</span>
                    <input type="text" inputmode="numeric" data-filter-min-price value="{{ number_format($minCatalogPrice ?? 0) }}" class="w-full min-w-0 px-2.5 py-2.5 text-sm font-medium text-[#011848] outline-none">
                </div>
                <div class="flex flex-1 min-w-0 items-stretch rounded-lg border border-border overflow-hidden bg-white focus-within:border-primary">
                    <span class="inline-flex items-center px-2.5 text-xs font-semibold text-muted-foreground bg-[#F7F8FA] border-r border-border">MVR</span>
                    <input type="text" inputmode="numeric" data-filter-max-price value="{{ number_format($maxCatalogPrice) }}" class="w-full min-w-0 px-2.5 py-2.5 text-sm font-medium text-[#011848] outline-none">
                </div>
            </div>

            <button type="button" data-filter-price-apply class="w-full py-2.5 rounded-lg text-sm font-bold text-white bg-primary hover:bg-[#005266] transition-colors">
                Apply Filter
            </button>
        </div>
    </div>

    {{-- Brand --}}
    <div class="bg-white rounded-xl border border-border overflow-hidden" data-filter-section>
        <button type="button" data-filter-toggle class="flex items-center justify-between w-full px-4 py-3.5 border-b border-border">
            <span class="text-sm font-bold text-[#011848]">Brand</span>
            <x-lucide name="chevron-up" :size="15" class="text-muted-foreground transition-transform" data-filter-chevron />
        </button>
        <div data-filter-body class="px-4 py-3 flex flex-col gap-2.5">
            @foreach ($brandMeta as $index => $brand)
                <label @class(['flex items-center justify-between gap-2 cursor-pointer group', 'hidden' => $index >= 6]) data-brand-item>
                    <span class="flex items-center gap-2.5">
                        <input type="checkbox" data-filter-brand="{{ $brand['name'] }}" class="w-4 h-4 rounded border-border accent-primary cursor-pointer" id="{{ $prefix }}brand-{{ \Illuminate\Support\Str::slug($brand['name']) }}">
                        <span class="text-sm text-gray-700 group-hover:text-primary transition-colors">{{ $brand['name'] }}</span>
                    </span>
                    <span class="text-xs text-muted-foreground">({{ $brand['count'] }})</span>
                </label>
            @endforeach
            @if (count($brandMeta) > 6)
                <button type="button" data-brands-more class="text-xs font-bold text-primary hover:underline text-left">View More</button>
            @endif
        </div>
    </div>

    {{-- Rating --}}
    <div class="bg-white rounded-xl border border-border overflow-hidden" data-filter-section>
        <button type="button" data-filter-toggle class="flex items-center justify-between w-full px-4 py-3.5 border-b border-border">
            <span class="text-sm font-bold text-[#011848]">Rating</span>
            <x-lucide name="chevron-up" :size="15" class="text-muted-foreground transition-transform" data-filter-chevron />
        </button>
        <div data-filter-body class="px-4 py-3 flex flex-col gap-1.5">
            @foreach ([5, 4, 3, 2, 1] as $rating)
                <button type="button" data-filter-rating="{{ $rating }}" class="flex items-center gap-2 px-2 py-2 rounded-lg transition-colors hover:bg-gray-50">
                    <x-star-rating :rating="$rating" :size="13" />
                    <span class="text-xs text-gray-600 font-medium">{{ $rating === 5 ? '5 stars' : $rating . ' stars & Up' }}</span>
                    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-primary opacity-0" data-rating-dot></span>
                </button>
            @endforeach
        </div>
    </div>

    {{-- Availability --}}
    <div class="bg-white rounded-xl border border-border overflow-hidden" data-filter-section>
        <button type="button" data-filter-toggle class="flex items-center justify-between w-full px-4 py-3.5 border-b border-border">
            <span class="text-sm font-bold text-[#011848]">Availability</span>
            <x-lucide name="chevron-up" :size="15" class="text-muted-foreground transition-transform" data-filter-chevron />
        </button>
        <div data-filter-body class="px-4 py-3 flex flex-col gap-2.5">
            <label class="flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" data-filter-instock class="w-4 h-4 rounded border-border accent-primary cursor-pointer" id="{{ $prefix }}instock">
                <span class="text-sm text-gray-700 font-medium">In Stock</span>
            </label>
            <label class="flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" data-filter-outofstock class="w-4 h-4 rounded border-border accent-primary cursor-pointer" id="{{ $prefix }}outofstock">
                <span class="text-sm text-gray-700 font-medium">Out of Stock</span>
            </label>
        </div>
    </div>

    {{-- Promo --}}
    <div class="rounded-xl overflow-hidden relative p-5 text-white min-h-[190px] flex flex-col justify-between" style="background: linear-gradient(145deg, #011848 0%, #0a2a6e 100%)">
        <div>
            <span class="text-[10px] font-bold uppercase tracking-wider bg-white/15 px-2 py-0.5 rounded">Limited Time Offer</span>
            <p class="font-extrabold text-xl mt-3 leading-tight">{{ $promoTitle }}</p>
            <p class="text-white/70 text-xs mt-1">{{ $promoSub }}</p>
        </div>
        <div class="flex items-end justify-between gap-2 mt-4">
            <a href="{{ route($promoRoute) }}" class="inline-flex text-xs font-bold bg-primary text-white px-3.5 py-2 rounded-full hover:bg-[#005266] transition-colors">
                Shop Now
            </a>
            <img src="{{ $promoImage }}" alt="{{ $promoAlt }}" class="w-20 h-16 object-contain drop-shadow-lg" loading="lazy">
        </div>
    </div>
</div>
