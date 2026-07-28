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
    <div class="relative p-6 bg-white min-h-[200px] flex items-center justify-center">
        @if ($href)
            <a href="{{ $href }}" class="absolute inset-0 z-0" aria-label="{{ $name }}"></a>
        @endif
        <img
            src="{{ $img }}"
            alt="{{ $name }}"
            class="relative z-[1] pointer-events-none h-40 w-full object-contain group-hover:scale-105 transition-transform duration-300"
            loading="lazy"
        >
    </div>

    {{-- Info --}}
    <div class="bg-[#EDEDED] px-4 pt-4 pb-4 flex flex-col flex-1">
        @if ($href)
            <a href="{{ $href }}" class="text-base font-extrabold text-[#011848] leading-snug line-clamp-2 hover:text-primary transition-colors">
                {{ $name }}
            </a>
        @else
            <h3 class="text-base font-extrabold text-[#011848] leading-snug line-clamp-2">{{ $name }}</h3>
        @endif

        <div class="mt-1 mb-3">
            <x-star-rating :rating="$rating" :size="14" />
        </div>

        <div class="mt-auto flex items-stretch gap-2">
            @if ($href)
                <a
                    href="{{ $href }}"
                    class="relative z-10 flex-1 inline-flex items-center justify-center h-10 px-3 rounded-md bg-primary hover:bg-[#005266] text-white text-[11px] font-bold uppercase tracking-wide transition-colors text-center"
                >
                    View More Details
                </a>
            @else
                <span class="flex-1 inline-flex items-center justify-center h-10 px-3 rounded-md bg-primary text-white text-[11px] font-bold uppercase tracking-wide text-center">
                    View More Details
                </span>
            @endif

            <button
                type="button"
                data-add-to-cart
                class="relative z-10 w-10 h-10 rounded-md bg-primary hover:bg-[#005266] text-white transition-colors flex items-center justify-center shrink-0"
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
