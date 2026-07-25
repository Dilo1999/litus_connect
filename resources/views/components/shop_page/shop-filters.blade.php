@php
    $prefix = !empty($mobile) ? 'm-' : '';
@endphp

<div class="space-y-4" data-shop-sidebar>
    {{-- Categories --}}
    <div class="bg-white rounded-xl border border-border overflow-hidden" data-filter-section>
        <button type="button" data-filter-toggle class="flex items-center justify-between w-full px-4 py-3.5 border-b border-border">
            <span class="text-sm font-bold text-[#0B1426]">Categories</span>
            <x-lucide name="chevron-up" :size="15" class="text-muted-foreground transition-transform" data-filter-chevron />
        </button>
        <div data-filter-body class="px-4 py-3">
            <div class="flex flex-col gap-2.5" data-category-list>
                @foreach ($categoryMeta as $index => $cat)
                    <label @class(['flex items-center justify-between gap-2 cursor-pointer group', 'hidden' => $index >= 6]) data-category-item>
                        <span class="flex items-center gap-2.5 min-w-0">
                            <input type="checkbox" data-filter-cat="{{ $cat['key'] }}" class="w-4 h-4 rounded border-border accent-primary cursor-pointer shrink-0" id="{{ $prefix }}cat-{{ \Illuminate\Support\Str::slug($cat['key']) }}">
                            <span class="text-sm text-gray-700 group-hover:text-primary transition-colors truncate">{{ $cat['label'] }}</span>
                        </span>
                        <span class="text-xs text-muted-foreground shrink-0">({{ $cat['count'] }})</span>
                    </label>
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
            <span class="text-sm font-bold text-[#0B1426]">Filter By Price</span>
            <x-lucide name="chevron-up" :size="15" class="text-muted-foreground transition-transform" data-filter-chevron />
        </button>
        <div data-filter-body class="px-4 py-4 space-y-3">
            <input type="range" data-filter-price-range min="0" max="{{ $maxCatalogPrice }}" value="{{ $maxCatalogPrice }}" step="1000" class="w-full h-1.5 rounded-full appearance-none cursor-pointer accent-primary">
            <p class="text-xs text-muted-foreground text-center" data-filter-price-label>LKR 0 – LKR {{ number_format($maxCatalogPrice) }}</p>
            <div class="flex items-center gap-2">
                <input type="number" data-filter-min-price value="0" min="0" placeholder="Min" class="w-full border border-border rounded-lg px-3 py-2 text-sm outline-none focus:border-primary">
                <span class="text-muted-foreground text-xs">–</span>
                <input type="number" data-filter-max-price value="{{ $maxCatalogPrice }}" min="0" placeholder="Max" class="w-full border border-border rounded-lg px-3 py-2 text-sm outline-none focus:border-primary">
            </div>
            <button type="button" data-filter-price-apply class="w-full py-2.5 rounded-lg text-sm font-bold text-white bg-primary hover:bg-[#0d4fc7] transition-colors">
                Filter
            </button>
        </div>
    </div>

    {{-- Brand --}}
    <div class="bg-white rounded-xl border border-border overflow-hidden" data-filter-section>
        <button type="button" data-filter-toggle class="flex items-center justify-between w-full px-4 py-3.5 border-b border-border">
            <span class="text-sm font-bold text-[#0B1426]">Brand</span>
            <x-lucide name="chevron-up" :size="15" class="text-muted-foreground transition-transform" data-filter-chevron />
        </button>
        <div data-filter-body class="px-4 py-3 flex flex-col gap-2.5">
            @foreach ($brandMeta as $brand)
                <label class="flex items-center justify-between gap-2 cursor-pointer group">
                    <span class="flex items-center gap-2.5">
                        <input type="checkbox" data-filter-brand="{{ $brand['name'] }}" class="w-4 h-4 rounded border-border accent-primary cursor-pointer" id="{{ $prefix }}brand-{{ \Illuminate\Support\Str::slug($brand['name']) }}">
                        <span class="text-sm text-gray-700 group-hover:text-primary transition-colors">{{ $brand['name'] }}</span>
                    </span>
                    <span class="text-xs text-muted-foreground">({{ $brand['count'] }})</span>
                </label>
            @endforeach
        </div>
    </div>

    {{-- Rating --}}
    <div class="bg-white rounded-xl border border-border overflow-hidden" data-filter-section>
        <button type="button" data-filter-toggle class="flex items-center justify-between w-full px-4 py-3.5 border-b border-border">
            <span class="text-sm font-bold text-[#0B1426]">Rating</span>
            <x-lucide name="chevron-up" :size="15" class="text-muted-foreground transition-transform" data-filter-chevron />
        </button>
        <div data-filter-body class="px-4 py-3 flex flex-col gap-1.5">
            @foreach ([5, 4, 3, 2, 1] as $rating)
                <button type="button" data-filter-rating="{{ $rating }}" class="flex items-center gap-2 px-2 py-2 rounded-lg transition-colors hover:bg-gray-50">
                    <x-star-rating :rating="$rating" :size="13" />
                    <span class="text-xs text-gray-600 font-medium">{{ $rating }} Stars{{ $rating < 5 ? ' & Up' : '' }}</span>
                    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-primary opacity-0" data-rating-dot></span>
                </button>
            @endforeach
        </div>
    </div>

    {{-- Availability --}}
    <div class="bg-white rounded-xl border border-border overflow-hidden" data-filter-section>
        <button type="button" data-filter-toggle class="flex items-center justify-between w-full px-4 py-3.5 border-b border-border">
            <span class="text-sm font-bold text-[#0B1426]">Availability</span>
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

    {{-- Daily Deals promo --}}
    <div class="rounded-xl overflow-hidden relative p-5 text-white min-h-[180px] flex flex-col justify-between" style="background: linear-gradient(145deg, #1464F4 0%, #0a3eb8 100%)">
        <div>
            <span class="text-[10px] font-bold uppercase tracking-wider bg-white/20 px-2 py-0.5 rounded">Daily Deals</span>
            <p class="font-extrabold text-lg mt-3 leading-tight">Up to 40% Off</p>
            <p class="text-white/75 text-xs mt-1">On selected headsets & audio</p>
        </div>
        <div class="flex items-end justify-between gap-2 mt-4">
            <a href="{{ route('shop') }}" class="inline-flex text-xs font-bold bg-white text-primary px-3 py-1.5 rounded-full hover:bg-gray-100 transition-colors">
                Shop Now
            </a>
            <img
                src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=120&h=90&fit=crop&auto=format"
                alt="Headphones deal"
                class="w-20 h-16 object-contain drop-shadow-lg"
                loading="lazy"
            >
        </div>
    </div>
</div>
