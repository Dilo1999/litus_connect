@props([
    'id' => null,
    'name',
    'img',
    'price',
    'original' => null,
    'rating' => 0,
    'reviews' => 0,
    'badge' => null,
    'category' => null,
])

@php
    $discount = $original ? (int) round((($original - $price) / $original) * 100) : null;
    $href = $id ? route('product.show', $id) : null;
@endphp

<div
    {{ $attributes->merge(['class' => 'bg-white rounded-xl border border-border hover:shadow-md hover:border-primary/30 transition-all duration-200 group overflow-hidden flex flex-col']) }}
    data-product-card
>
    <div class="relative p-5 bg-[#f7f9fc] min-h-[190px] flex items-center justify-center">
        @if ($badge)
            <span class="absolute top-3 left-3 text-white text-[10px] font-bold px-2 py-0.5 rounded bg-primary tracking-wide z-10">
                {{ $badge }}
            </span>
        @endif

        @if ($discount)
            <span class="absolute top-3 right-3 text-primary bg-white text-[10px] font-bold px-2 py-0.5 rounded border border-blue-100 z-10">
                -{{ $discount }}%
            </span>
        @endif

        @if ($href)
            <a href="{{ $href }}" class="absolute inset-0 z-0" aria-label="{{ $name }}"></a>
        @endif

        <img
            src="{{ $img }}"
            alt="{{ $name }}"
            class="relative z-[1] pointer-events-none h-36 w-full object-contain group-hover:scale-105 transition-transform duration-300"
            loading="lazy"
        >
    </div>

    <div class="p-4 flex flex-col flex-1">
        @if ($href)
            <a href="{{ $href }}" class="text-sm font-semibold text-[#0B1426] line-clamp-2 mb-2 leading-snug min-h-[2.5rem] hover:text-primary transition-colors">{{ $name }}</a>
        @else
            <h3 class="text-sm font-semibold text-[#0B1426] line-clamp-2 mb-2 leading-snug min-h-[2.5rem]">{{ $name }}</h3>
        @endif

        <div class="flex items-baseline gap-2 mb-2">
            <span class="text-base font-extrabold text-[#0B1426]">MVR {{ number_format($price) }}</span>
            @if ($original)
                <span class="text-xs text-muted-foreground line-through">MVR {{ number_format($original) }}</span>
            @endif
        </div>

        <div class="flex items-center justify-between mt-auto pt-1">
            <div class="flex items-center gap-1.5">
                <x-star-rating :rating="$rating" :size="12" />
                <span class="text-[11px] text-muted-foreground">({{ number_format($reviews) }})</span>
            </div>

            <button
                type="button"
                data-add-to-cart
                class="relative z-10 w-9 h-9 rounded-lg bg-primary/10 hover:bg-primary text-primary hover:text-white transition-colors flex items-center justify-center"
                aria-label="Add to cart"
            >
                <span data-cart-default>
                    <x-lucide name="shopping-cart" :size="16" />
                </span>
                <span data-cart-added class="hidden">
                    <x-lucide name="check-circle" :size="16" />
                </span>
            </button>
        </div>
    </div>
</div>
