@php
    $prefix = ! empty($mobile) ? 'm-' : '';
@endphp

<div class="space-y-4" data-offers-sidebar>
    <div class="bg-white rounded-xl border border-border overflow-hidden">
        <div class="px-4 py-3.5 border-b border-border">
            <h2 class="text-sm font-bold text-[#011848]">Shop by Category</h2>
        </div>
        <div class="px-3 py-3 flex flex-col gap-1">
            @foreach ($offerCategories as $index => $cat)
                <button
                    type="button"
                    data-offer-cat="{{ $cat['key'] }}"
                    @class([
                        'flex items-center justify-between gap-2 px-3 py-2.5 rounded-lg text-sm transition-colors text-left',
                        'bg-blue-light text-primary font-bold' => $cat['key'] === 'all',
                        'text-gray-700 hover:bg-gray-50 font-medium' => $cat['key'] !== 'all',
                    ])
                >
                    <span>{{ $cat['label'] }}</span>
                    <span class="text-xs opacity-70">({{ $cat['count'] }})</span>
                </button>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-xl border border-border overflow-hidden">
        <div class="px-4 py-3.5 border-b border-border">
            <h2 class="text-sm font-bold text-[#011848]">Filter By Discount</h2>
        </div>
        <div class="px-4 py-4 space-y-4">
            <p class="text-sm font-bold text-[#011848] text-center" data-discount-label>0% – 60%</p>
            <div class="price-dual-slider relative h-6 flex items-center" data-discount-dual-slider style="--range-min: 0%; --range-max: 100%;">
                <div class="absolute left-0 right-0 h-1.5 rounded-full bg-[#E4E9F2]"></div>
                <div class="absolute h-1.5 rounded-full bg-primary pointer-events-none" style="left: var(--range-min); right: calc(100% - var(--range-max));"></div>
                <input type="range" data-discount-min-range min="0" max="60" value="0" step="5" class="price-dual-thumb" aria-label="Minimum discount">
                <input type="range" data-discount-max-range min="0" max="60" value="60" step="5" class="price-dual-thumb" aria-label="Maximum discount">
            </div>
            <div class="flex items-center gap-2.5">
                <div class="flex flex-1 min-w-0 items-stretch rounded-lg border border-border overflow-hidden bg-white focus-within:border-primary">
                    <input type="number" data-discount-min value="0" min="0" max="60" class="w-full min-w-0 px-2.5 py-2.5 text-sm font-medium text-[#011848] outline-none">
                    <span class="inline-flex items-center px-2.5 text-xs font-semibold text-muted-foreground bg-[#F7F8FA] border-l border-border">%</span>
                </div>
                <div class="flex flex-1 min-w-0 items-stretch rounded-lg border border-border overflow-hidden bg-white focus-within:border-primary">
                    <input type="number" data-discount-max value="60" min="0" max="60" class="w-full min-w-0 px-2.5 py-2.5 text-sm font-medium text-[#011848] outline-none">
                    <span class="inline-flex items-center px-2.5 text-xs font-semibold text-muted-foreground bg-[#F7F8FA] border-l border-border">%</span>
                </div>
            </div>
            <button type="button" data-discount-apply class="w-full py-2.5 rounded-lg text-sm font-bold text-white bg-primary hover:bg-[#0d4fc7] transition-colors">
                Apply Filter
            </button>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-border overflow-hidden">
        <div class="px-4 py-3.5 border-b border-border">
            <h2 class="text-sm font-bold text-[#011848]">Popular Brands</h2>
        </div>
        <div class="px-4 py-3 flex flex-col gap-2.5">
            @foreach ($brandMeta as $brand)
                <label class="flex items-center justify-between gap-2 cursor-pointer group">
                    <span class="flex items-center gap-2.5">
                        <input type="checkbox" data-offer-brand="{{ $brand['name'] }}" class="w-4 h-4 rounded border-border accent-primary cursor-pointer" id="{{ $prefix }}offer-brand-{{ \Illuminate\Support\Str::slug($brand['name']) }}">
                        <span class="text-sm text-gray-700 group-hover:text-primary transition-colors">{{ $brand['name'] }}</span>
                    </span>
                    <span class="text-xs text-muted-foreground">({{ $brand['count'] }})</span>
                </label>
            @endforeach
        </div>
    </div>

    <div class="rounded-xl overflow-hidden relative p-5 text-white min-h-[240px] flex flex-col justify-between" style="background: linear-gradient(145deg, #6D28D9 0%, #4C1D95 100%)">
        <div>
            <span class="text-[10px] font-bold uppercase tracking-wider bg-white/15 px-2 py-0.5 rounded">Offer of the Week</span>
            <p class="font-extrabold text-xl mt-3 leading-tight">Sony WH-1000XM5</p>
            <p class="text-white/80 text-sm mt-1">Save up to MVR 30,000</p>
        </div>
        <div class="grid grid-cols-4 gap-1.5 my-4" data-offer-countdown data-ends-at="{{ $countdownEndsAt }}">
            @foreach (['days', 'hours', 'mins', 'secs'] as $unit)
                <div class="rounded-lg bg-white/15 text-center py-2 px-1">
                    <p class="text-base font-extrabold leading-none" data-countdown-{{ $unit }}>00</p>
                    <p class="text-[9px] uppercase tracking-wide text-white/70 mt-1">{{ $unit }}</p>
                </div>
            @endforeach
        </div>
        <div class="flex items-end justify-between gap-2">
            <a href="{{ route('product.show', 101) }}" class="inline-flex text-xs font-bold bg-white text-[#4C1D95] px-3.5 py-2 rounded-full hover:bg-blue-light transition-colors">
                Shop Now
            </a>
            <img
                src="https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=120&h=100&fit=crop&auto=format"
                alt="Offer of the week"
                class="w-20 h-16 object-contain drop-shadow-lg"
                loading="lazy"
            >
        </div>
    </div>
</div>
