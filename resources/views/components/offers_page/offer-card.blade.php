@php
    $save = $deal['save'] ?? max(0, ($deal['original'] ?? $deal['price']) - $deal['price']);
@endphp

<div
    class="bg-white rounded-xl border border-border hover:shadow-md transition-all group overflow-hidden flex flex-col"
    data-offer-card
    data-cat="{{ $deal['cat'] }}"
    data-brand="{{ $deal['brand'] }}"
    data-discount="{{ $deal['discount'] }}"
>
    <div class="relative p-4 min-h-[150px] flex items-center justify-center">
        <span class="absolute top-3 left-3 text-white text-[10px] font-bold px-2 py-0.5 rounded bg-red-500 tracking-wide z-10">
            {{ $deal['discount'] }}% OFF
        </span>
        <a href="{{ route('product.show', $deal['id']) }}" class="absolute inset-0 z-0" aria-label="{{ $deal['name'] }}"></a>
        <img
            src="{{ $deal['img'] }}"
            alt="{{ $deal['name'] }}"
            class="relative z-[1] pointer-events-none h-28 w-full object-contain group-hover:scale-105 transition-transform duration-300"
            loading="lazy"
        >
    </div>
    <div class="px-3.5 pb-3.5 flex flex-col flex-1">
        <a href="{{ route('product.show', $deal['id']) }}" class="text-sm font-bold text-[#011848] line-clamp-2 mb-2 min-h-[2.5rem] hover:text-primary transition-colors">
            {{ $deal['name'] }}
        </a>
        <div class="mt-auto flex items-end justify-between gap-2">
            <div>
                <div class="flex items-baseline gap-1.5 flex-wrap">
                    <span class="text-sm font-extrabold text-primary">MVR {{ number_format($deal['price']) }}</span>
                    @if (!empty($deal['original']))
                        <span class="text-[11px] text-gray-400 line-through">MVR {{ number_format($deal['original']) }}</span>
                    @endif
                </div>
                @if ($save > 0)
                    <p class="text-[11px] font-semibold text-emerald-600 mt-0.5">You Save MVR {{ number_format($save) }}</p>
                @endif
            </div>
            <button type="button" data-add-to-cart class="relative z-10 w-8 h-8 rounded-lg border border-border text-primary hover:bg-primary hover:text-white hover:border-primary transition-colors flex items-center justify-center shrink-0" aria-label="Add to cart">
                <span data-cart-default><x-lucide name="shopping-cart" :size="14" /></span>
                <span data-cart-added class="hidden text-xs font-bold">✓</span>
            </button>
        </div>
    </div>
</div>
