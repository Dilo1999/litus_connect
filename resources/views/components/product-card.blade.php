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
    $href = $id ? route('product.show', $id) : null;
@endphp

<div
    {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-[0_4px_20px_rgba(11,20,38,0.08)] hover:shadow-[0_8px_28px_rgba(11,20,38,0.12)] transition-shadow duration-200 group overflow-hidden flex flex-col']) }}
    data-product-card
    data-product-id="{{ $id }}"
    data-product-name="{{ $name }}"
    data-product-price="{{ $price }}"
    data-product-img="{{ $img }}"
>
    {{-- Image --}}
    <div class="relative p-2 sm:p-3 bg-white min-h-[140px] sm:min-h-[200px] flex items-center justify-center">
        @if (!empty($badge))
            <span @class([
                'absolute top-3 left-3 text-white text-[10px] font-bold px-2 py-0.5 rounded z-10 tracking-wide',
                'bg-red-500' => $badge === 'SALE',
                'bg-violet-600' => $badge === 'NEW',
                'bg-primary' => ! in_array($badge, ['SALE', 'NEW'], true),
            ])>{{ $badge }}</span>
        @endif
        @if ($href)
            <a href="{{ $href }}" class="absolute inset-0 z-0" aria-label="{{ $name }}"></a>
        @endif
        <img
            src="{{ $img }}"
            alt="{{ $name }}"
            class="relative z-[1] pointer-events-none h-28 sm:h-44 w-full object-contain group-hover:scale-105 transition-transform duration-300"
            loading="lazy"
        >
    </div>

    {{-- Info --}}
    <div class="bg-[#F7F4ED] px-2.5 sm:px-4 pt-3 sm:pt-4 pb-3 sm:pb-4 flex flex-col flex-1">
        @if ($href)
            <a href="{{ $href }}" class="text-xs sm:text-base font-extrabold text-[#011848] leading-snug line-clamp-2 min-h-8 sm:min-h-0 hover:text-primary transition-colors">
                {{ $name }}
            </a>
        @else
            <h3 class="text-xs sm:text-base font-extrabold text-[#011848] leading-snug line-clamp-2 min-h-8 sm:min-h-0">{{ $name }}</h3>
        @endif

        <div class="mt-1 mb-1.5 sm:mb-2">
            <x-star-rating :rating="$rating" :size="12" />
        </div>

        <div class="mb-2.5 sm:mb-3 flex items-baseline gap-1 flex-wrap">
            <span class="text-xs sm:text-base font-extrabold text-primary">MVR {{ number_format($price) }}</span>
            @if (!empty($original))
                <span class="text-[9px] sm:text-xs text-muted-foreground line-through">MVR {{ number_format($original) }}</span>
            @endif
        </div>

        <div class="mt-auto flex items-stretch gap-2">
            @if ($href)
                <a
                    href="{{ $href }}"
                    class="relative z-10 flex-1 min-w-0 inline-flex items-center justify-center min-h-11 px-1.5 sm:px-3 rounded-md bg-primary hover:bg-[#005266] text-white text-[10px] sm:text-[11px] font-bold uppercase tracking-wide transition-colors text-center"
                >
                    <span class="sm:hidden">Details</span>
                    <span class="hidden sm:inline">View More Details</span>
                </a>
            @else
                <span class="flex-1 min-w-0 inline-flex items-center justify-center min-h-11 px-1.5 sm:px-3 rounded-md bg-primary text-white text-[10px] sm:text-[11px] font-bold uppercase tracking-wide text-center">
                    <span class="sm:hidden">Details</span>
                    <span class="hidden sm:inline">View More Details</span>
                </span>
            @endif

            <button
                type="button"
                data-add-to-cart
                class="relative z-10 w-11 h-11 rounded-md bg-primary hover:bg-[#005266] text-white transition-colors flex items-center justify-center shrink-0"
                aria-label="Add to cart"
            >
                <span data-cart-default class="inline-flex items-center justify-center">
                    <img
                        src="{{ asset('images/home/shopping-cart.png') }}"
                        alt=""
                        class="w-[18px] h-[18px] object-contain brightness-0 invert"
                        aria-hidden="true"
                    >
                </span>
            </button>
        </div>
    </div>
</div>
