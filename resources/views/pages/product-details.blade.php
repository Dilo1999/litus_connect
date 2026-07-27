@extends('layouts.app')

@section('title', $product['name'] . ' — LITUS Connect')
@section('meta_description', $product['shortDescription'])

@php
    $installment = (int) round($product['price'] / 3);
    $selectedStorage = $product['selectedStorage'] ?? ($product['storageOptions'][0] ?? null);
@endphp

@section('content')

<div class="bg-[#F7F8FA]" data-product-page>
    <div class="site-container py-5 md:py-8">
        {{-- Breadcrumb --}}
        <div class="flex flex-wrap items-center gap-2 text-sm text-muted-foreground mb-5">
            @foreach ($product['breadcrumb'] as $index => $crumb)
                @if ($index > 0)
                    <x-lucide name="chevron-right" :size="13" class="text-gray-300" />
                @endif
                @if (!empty($crumb['route']))
                    <a href="{{ route($crumb['route']) }}" class="hover:text-primary transition-colors font-medium">{{ $crumb['label'] }}</a>
                @else
                    <span class="font-semibold text-[#011848] line-clamp-1">{{ $crumb['label'] }}</span>
                @endif
            @endforeach
        </div>

        {{-- Main product --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 mb-8">
            {{-- Gallery --}}
            <div class="lg:col-span-6 xl:col-span-7">
                <div class="flex gap-3 md:gap-4">
                    <div class="hidden sm:flex flex-col gap-2.5 w-[72px] shrink-0">
                        @foreach ($product['images'] as $index => $image)
                            <button
                                type="button"
                                data-product-thumb
                                data-image="{{ $image }}"
                                @class([
                                    'aspect-square rounded-lg border bg-white p-1.5 flex items-center justify-center transition-all overflow-hidden',
                                    'border-primary ring-2 ring-primary/15' => $index === 0,
                                    'border-border hover:border-primary/40' => $index !== 0,
                                ])
                            >
                                <img src="{{ $image }}" alt="" class="h-full w-full object-contain" loading="lazy">
                            </button>
                        @endforeach
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="relative bg-white rounded-2xl border border-border p-6 md:p-12 min-h-[420px] md:min-h-[580px] lg:min-h-[640px] flex items-center justify-center overflow-hidden">
                            @if (!empty($product['badge']))
                                <span @class([
                                    'absolute top-4 left-4 text-white text-[10px] font-bold px-2.5 py-1 rounded-md tracking-wide uppercase z-10',
                                    'bg-red-500' => $product['badge'] === 'SALE',
                                    'bg-violet-600' => $product['badge'] === 'NEW',
                                    'bg-primary' => ! in_array($product['badge'], ['SALE', 'NEW'], true),
                                ])>{{ $product['badge'] }}</span>
                            @endif

                            <img
                                src="{{ $product['images'][0] }}"
                                alt="{{ $product['name'] }}"
                                data-product-main-image
                                class="max-h-[340px] md:max-h-[480px] lg:max-h-[520px] w-full object-contain transition-opacity duration-200 cursor-zoom-in"
                                data-product-zoom-trigger
                            >
                        </div>

                        <div class="sm:hidden grid grid-cols-4 gap-2 mt-3">
                            @foreach ($product['images'] as $index => $image)
                                <button
                                    type="button"
                                    data-product-thumb
                                    data-image="{{ $image }}"
                                    @class([
                                        'aspect-square rounded-lg border bg-white p-1.5 flex items-center justify-center transition-all',
                                        'border-primary ring-2 ring-primary/15' => $index === 0,
                                        'border-border' => $index !== 0,
                                    ])
                                >
                                    <img src="{{ $image }}" alt="" class="h-full w-full object-contain" loading="lazy">
                                </button>
                            @endforeach
                        </div>

                        <button type="button" data-product-zoom-trigger class="mt-3 mx-auto flex items-center gap-2 text-xs font-semibold text-muted-foreground hover:text-primary transition-colors">
                            <x-lucide name="search" :size="14" />
                            Click to Zoom
                        </button>
                    </div>
                </div>
            </div>

            {{-- Buy box --}}
            <div class="lg:col-span-6 xl:col-span-5">
                <div class="bg-white rounded-2xl border border-border p-5 md:p-6">
                    <div class="flex flex-wrap items-center gap-2 mb-3">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-blue-light text-primary text-xs font-bold">{{ $product['brand'] ?? 'LITUS Connect' }}</span>
                        @if (!empty($product['bestSeller']))
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-700 text-xs font-bold">Best Seller</span>
                        @endif
                    </div>

                    <h1 class="text-2xl md:text-[1.75rem] font-extrabold text-[#011848] leading-tight mb-3">{{ $product['name'] }}</h1>

                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mb-4 text-sm">
                        <div class="flex items-center gap-1.5">
                            <x-star-rating :rating="$product['rating']" :size="14" />
                            <span class="font-bold text-[#011848]">{{ number_format($product['rating'], 1) }}</span>
                        </div>
                        <button type="button" data-tab-jump="reviews" class="text-primary hover:underline font-medium">({{ number_format($product['reviews']) }} customer reviews)</button>
                        <span class="text-gray-300 hidden sm:inline">|</span>
                        <button type="button" data-tab-jump="qa" class="text-primary hover:underline font-medium">{{ $product['qaCount'] }} answered questions</button>
                    </div>

                    <div class="flex flex-wrap items-center gap-2.5 mb-1.5">
                        <span class="text-3xl font-extrabold text-primary">MVR {{ number_format($product['price']) }}</span>
                        @if (!empty($product['original']))
                            <span class="text-base text-muted-foreground line-through">MVR {{ number_format($product['original']) }}</span>
                        @endif
                        @if (!empty($product['discount']))
                            <span class="inline-flex text-[11px] font-bold text-white bg-red-500 px-2 py-0.5 rounded">{{ $product['discount'] }}% OFF</span>
                        @endif
                    </div>

                    <p class="flex items-center gap-1.5 text-xs text-muted-foreground mb-4">
                        or 3 interest-free payments of <span class="font-bold text-[#011848]">MVR {{ number_format($installment) }}</span> with
                        <span class="font-extrabold text-[#011848]">KOKO</span>
                        <x-lucide name="info" :size="13" class="text-gray-400" />
                    </p>

                    <p class="text-sm text-muted-foreground leading-relaxed mb-5">{{ $product['shortDescription'] }}</p>

                    @if (!empty($product['storageOptions']))
                        <div class="mb-5">
                            <p class="text-sm font-bold text-[#011848] mb-2.5">
                                Storage: <span class="font-semibold text-muted-foreground" data-selected-storage>{{ $selectedStorage }}</span>
                            </p>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($product['storageOptions'] as $storage)
                                    <button
                                        type="button"
                                        data-product-storage="{{ $storage }}"
                                        @class([
                                            'min-w-[84px] px-4 py-2.5 rounded-full border text-sm font-semibold transition-all',
                                            'border-primary text-primary bg-white ring-1 ring-primary/20' => $storage === $selectedStorage,
                                            'border-border text-gray-700 hover:border-primary hover:text-primary bg-white' => $storage !== $selectedStorage,
                                        ])
                                    >
                                        {{ $storage }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if (!empty($product['colors']))
                        <div class="mb-6">
                            <p class="text-sm font-bold text-[#011848] mb-2.5">
                                Color: <span class="font-semibold text-muted-foreground" data-selected-color>{{ $product['colors'][0]['name'] }}</span>
                            </p>
                            <div class="flex flex-wrap gap-2.5">
                                @foreach ($product['colors'] as $index => $color)
                                    <button
                                        type="button"
                                        data-product-color="{{ $color['name'] }}"
                                        title="{{ $color['name'] }}"
                                        @class([
                                            'w-9 h-9 rounded-full border-2 transition-all',
                                            'border-primary ring-2 ring-primary/20' => $index === 0,
                                            'border-white shadow-[0_0_0_1px_#E4E9F2] hover:border-primary/40' => $index !== 0,
                                        ])
                                        style="background-color: {{ $color['hex'] }}"
                                    ></button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center gap-3 mb-3">
                        <div class="inline-flex items-center border border-border rounded-lg overflow-hidden bg-white h-12 shrink-0">
                            <button type="button" data-qty-minus class="w-10 h-full flex items-center justify-center text-gray-500 hover:text-primary hover:bg-blue-light transition-colors" aria-label="Decrease quantity">
                                <x-lucide name="minus" :size="15" />
                            </button>
                            <input type="number" data-product-qty value="1" min="1" max="10" class="w-10 text-center text-sm font-bold text-[#011848] outline-none border-x border-border h-full [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            <button type="button" data-qty-plus class="w-10 h-full flex items-center justify-center text-gray-500 hover:text-primary hover:bg-blue-light transition-colors" aria-label="Increase quantity">
                                <x-lucide name="plus" :size="15" />
                            </button>
                        </div>

                        <button
                            type="button"
                            data-product-add-cart
                            @disabled(! $product['inStock'])
                            @class([
                                'flex-1 h-12 rounded-lg text-sm font-bold transition-colors inline-flex items-center justify-center gap-2',
                                'bg-primary text-white hover:bg-[#0d4fc7]' => $product['inStock'],
                                'bg-gray-200 text-gray-500 cursor-not-allowed' => ! $product['inStock'],
                            ])
                        >
                            <x-lucide name="shopping-cart" :size="17" />
                            <span data-add-label>{{ $product['inStock'] ? 'Add to Cart' : 'Out of Stock' }}</span>
                        </button>
                    </div>

                    <button
                        type="button"
                        data-product-buy-now
                        @disabled(! $product['inStock'])
                        @class([
                            'w-full h-12 rounded-lg text-sm font-bold transition-colors mb-5',
                            'bg-[#011848] text-white hover:bg-[#0a2258]' => $product['inStock'],
                            'bg-gray-200 text-gray-400 cursor-not-allowed' => ! $product['inStock'],
                        ])
                    >
                        Buy Now
                    </button>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 pt-4 border-t border-border">
                        @foreach ($trustBar as $item)
                            <div class="flex flex-col items-center text-center gap-1.5 px-1 py-1">
                                <div class="w-8 h-8 rounded-full bg-[#F3F5F9] text-[#011848] flex items-center justify-center">
                                    <x-lucide :name="$item['icon']" :size="14" />
                                </div>
                                <span class="text-[11px] font-semibold text-[#011848] leading-tight">{{ $item['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Key features --}}
        <div class="bg-white rounded-2xl border border-border px-4 py-5 md:px-6 md:py-6 mb-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 md:gap-6">
                @foreach ($product['keyFeatures'] as $feature)
                    <div class="flex items-start gap-3">
                        <div class="w-11 h-11 rounded-xl bg-blue-light text-primary flex items-center justify-center shrink-0">
                            <x-lucide :name="$feature['icon']" :size="18" />
                        </div>
                        <div>
                            <p class="text-sm font-extrabold text-[#011848]">{{ $feature['title'] }}</p>
                            <p class="text-xs text-muted-foreground mt-0.5">{{ $feature['sub'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Tabs --}}
        <div class="bg-white rounded-2xl border border-border overflow-hidden mb-10" data-product-tabs>
            <div class="flex flex-wrap gap-1 border-b border-border px-2 md:px-4 overflow-x-auto">
                @foreach ([
                    ['id' => 'description', 'label' => 'Description'],
                    ['id' => 'specs', 'label' => 'Specifications'],
                    ['id' => 'reviews', 'label' => 'Reviews (' . $product['reviews'] . ')'],
                    ['id' => 'qa', 'label' => 'Q&A (' . $product['qaCount'] . ')'],
                    ['id' => 'shipping', 'label' => 'Shipping & Returns'],
                ] as $tab)
                    <button
                        type="button"
                        data-tab="{{ $tab['id'] }}"
                        @class([
                            'px-4 py-3.5 text-sm font-bold whitespace-nowrap border-b-2 -mb-px transition-colors',
                            'text-primary border-primary' => $tab['id'] === 'description',
                            'text-muted-foreground border-transparent hover:text-[#011848]' => $tab['id'] !== 'description',
                        ])
                    >
                        {{ $tab['label'] }}
                    </button>
                @endforeach
            </div>

            {{-- Description overview (3 columns like image) --}}
            <div data-tab-panel="description" class="p-5 md:p-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                    <div>
                        <h2 class="text-base font-extrabold text-[#011848] mb-3">Overview</h2>
                        <div class="text-sm text-muted-foreground leading-relaxed space-y-3">
                            <p data-desc-preview>{{ \Illuminate\Support\Str::limit($product['description'], 180) }}</p>
                            <div data-desc-full class="hidden space-y-3">
                                <p>{{ $product['description'] }}</p>
                                <ul class="space-y-2">
                                    @foreach ($product['descriptionBullets'] as $bullet)
                                        <li class="flex items-start gap-2">
                                            <x-lucide name="check" :size="14" class="text-primary mt-0.5 shrink-0" />
                                            <span>{{ $bullet }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="button" data-show-more-desc class="text-primary text-sm font-bold hover:underline">Show More</button>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-base font-extrabold text-[#011848] mb-3">Specifications</h2>
                        <div class="space-y-3">
                            @foreach (array_slice($product['specList'], 0, 5) as $spec)
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-[#F3F5F9] text-[#011848] flex items-center justify-center shrink-0">
                                        <x-lucide :name="$spec['icon']" :size="14" />
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-muted-foreground uppercase tracking-wide">{{ $spec['label'] }}</p>
                                        <p class="text-sm font-semibold text-[#011848]">{{ $spec['value'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" data-tab-jump="specs" class="mt-4 text-primary text-sm font-bold hover:underline">View More Specifications</button>
                    </div>

                    <div class="space-y-4">
                        <div class="rounded-xl border border-border p-4">
                            <h3 class="text-sm font-extrabold text-[#011848] mb-3">Delivery Options</h3>
                            <div class="space-y-3 text-sm">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex items-start gap-2.5">
                                        <x-lucide name="truck" :size="16" class="text-primary mt-0.5" />
                                        <div>
                                            <p class="font-bold text-[#011848]">Standard Delivery</p>
                                            <p class="text-xs text-muted-foreground">3–5 business days</p>
                                        </div>
                                    </div>
                                    <span class="text-emerald-600 font-bold text-xs">Free</span>
                                </div>
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex items-start gap-2.5">
                                        <x-lucide name="zap" :size="16" class="text-primary mt-0.5" />
                                        <div>
                                            <p class="font-bold text-[#011848]">Express Delivery</p>
                                            <p class="text-xs text-muted-foreground">1–2 business days</p>
                                        </div>
                                    </div>
                                    <span class="font-bold text-xs text-[#011848]">MVR 490</span>
                                </div>
                            </div>
                        </div>
                        <div class="rounded-xl border border-border p-4">
                            <h3 class="text-sm font-extrabold text-[#011848] mb-2">Return Policy</h3>
                            <p class="text-xs text-muted-foreground leading-relaxed">
                                Unused products can be returned within 7 days of delivery in original sealed packaging. Official warranty remains valid after purchase.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div data-tab-panel="specs" class="p-5 md:p-8 hidden">
                <h2 class="text-lg font-extrabold text-[#011848] mb-5">Full Specifications</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    @foreach ($product['specList'] as $spec)
                        <div class="flex items-start gap-3 rounded-xl border border-border p-4">
                            <div class="w-10 h-10 rounded-xl bg-blue-light text-primary flex items-center justify-center shrink-0">
                                <x-lucide :name="$spec['icon']" :size="16" />
                            </div>
                            <div>
                                <p class="text-xs font-bold text-muted-foreground uppercase tracking-wide">{{ $spec['label'] }}</p>
                                <p class="text-sm font-semibold text-[#011848] mt-0.5">{{ $spec['value'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="overflow-hidden rounded-xl border border-border">
                    <table class="w-full text-sm">
                        <tbody>
                            @foreach ($product['specs'] as $label => $value)
                                <tr class="border-b border-border last:border-0 odd:bg-[#F7F8FA]">
                                    <th class="text-left font-bold text-[#011848] px-4 py-3 w-40 md:w-56">{{ $label }}</th>
                                    <td class="px-4 py-3 text-muted-foreground">{{ $value }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div data-tab-panel="reviews" class="p-5 md:p-8 hidden">
                <div class="flex flex-col md:flex-row md:items-center gap-6 mb-6">
                    <div class="text-center md:text-left">
                        <p class="text-4xl font-extrabold text-[#011848]">{{ number_format($product['rating'], 1) }}</p>
                        <div class="flex justify-center md:justify-start my-2">
                            <x-star-rating :rating="$product['rating']" :size="16" />
                        </div>
                        <p class="text-sm text-muted-foreground">Based on {{ number_format($product['reviews']) }} reviews</p>
                    </div>
                    <div class="flex-1 space-y-2 max-w-md">
                        @foreach ([5 => 72, 4 => 18, 3 => 6, 2 => 3, 1 => 1] as $star => $pct)
                            <div class="flex items-center gap-2 text-xs">
                                <span class="w-12 font-semibold text-[#011848]">{{ $star }} star</span>
                                <div class="flex-1 h-2 rounded-full bg-gray-100 overflow-hidden">
                                    <div class="h-full bg-amber-400 rounded-full" style="width: {{ $pct }}%"></div>
                                </div>
                                <span class="w-8 text-muted-foreground">{{ $pct }}%</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="space-y-4">
                    @foreach ([
                        ['name' => 'Dilshan P.', 'rating' => 5, 'text' => 'Excellent product quality and fast delivery from LITUS Connect. Packaging was perfect.'],
                        ['name' => 'Nimali S.', 'rating' => 5, 'text' => 'Genuine item with official warranty. Support team helped me choose the right storage option.'],
                        ['name' => 'Kasun R.', 'rating' => 4, 'text' => 'Great value for money. Would buy again. Delivery took one extra day but worth it.'],
                    ] as $review)
                        <div class="rounded-xl border border-border p-4">
                            <div class="flex items-center justify-between gap-3 mb-2">
                                <p class="font-bold text-sm text-[#011848]">{{ $review['name'] }}</p>
                                <x-star-rating :rating="$review['rating']" :size="13" />
                            </div>
                            <p class="text-sm text-muted-foreground leading-relaxed">{{ $review['text'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div data-tab-panel="qa" class="p-5 md:p-8 hidden">
                <h2 class="text-lg font-extrabold text-[#011848] mb-5">Questions & Answers</h2>
                <div class="space-y-4">
                    @foreach ([
                        ['q' => 'Does this include official Apple warranty in Maldives?', 'a' => 'Yes. Every unit sold by LITUS Connect includes 1 year official warranty with authorized service support.'],
                        ['q' => 'Is the box sealed and brand new?', 'a' => 'Yes. All products are brand new, factory sealed, and sourced from authorized distributors.'],
                        ['q' => 'Can I pay in installments?', 'a' => 'Yes. You can use KOKO for 3 interest-free payments at checkout.'],
                    ] as $item)
                        <div class="rounded-xl border border-border p-4">
                            <p class="flex items-start gap-2 text-sm font-bold text-[#011848] mb-2">
                                <x-lucide name="message-circle" :size="15" class="text-primary mt-0.5 shrink-0" />
                                {{ $item['q'] }}
                            </p>
                            <p class="text-sm text-muted-foreground pl-6">{{ $item['a'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div data-tab-panel="shipping" class="p-5 md:p-8 hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 max-w-4xl">
                    <div class="rounded-xl border border-border p-5">
                        <h3 class="text-base font-extrabold text-[#011848] mb-3">Shipping</h3>
                        <ul class="space-y-2 text-sm text-muted-foreground">
                            <li class="flex gap-2"><x-lucide name="check" :size="14" class="text-primary mt-0.5" /> Free standard delivery for orders over MVR 5,000</li>
                            <li class="flex gap-2"><x-lucide name="check" :size="14" class="text-primary mt-0.5" /> Express delivery available island-wide</li>
                            <li class="flex gap-2"><x-lucide name="check" :size="14" class="text-primary mt-0.5" /> Order tracking shared via SMS & email</li>
                        </ul>
                    </div>
                    <div class="rounded-xl border border-border p-5">
                        <h3 class="text-base font-extrabold text-[#011848] mb-3">Returns</h3>
                        <ul class="space-y-2 text-sm text-muted-foreground">
                            <li class="flex gap-2"><x-lucide name="check" :size="14" class="text-primary mt-0.5" /> 7-day easy returns on unused sealed products</li>
                            <li class="flex gap-2"><x-lucide name="check" :size="14" class="text-primary mt-0.5" /> Free return pickup in selected cities</li>
                            <li class="flex gap-2"><x-lucide name="check" :size="14" class="text-primary mt-0.5" /> Refund processed within 3–5 business days</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- You May Also Like --}}
        @if (count($related))
            <section class="mb-4">
                <div class="flex items-end justify-between gap-4 mb-5">
                    <h2 class="text-xl md:text-2xl font-extrabold text-[#011848]">You May Also Like</h2>
                    <a href="{{ route('shop') }}" class="text-sm font-bold text-primary hover:underline">View All</a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-4">
                    @foreach ($related as $item)
                        <div class="bg-white rounded-xl border border-border hover:shadow-md transition-all group overflow-hidden flex flex-col" data-product-card>
                            <div class="relative p-4 min-h-[160px] flex items-center justify-center">
                                @if (!empty($item['badge']))
                                    <span @class([
                                        'absolute top-3 left-3 text-white text-[10px] font-bold px-2 py-0.5 rounded tracking-wide z-10',
                                        'bg-red-500' => $item['badge'] === 'SALE',
                                        'bg-violet-600' => $item['badge'] === 'NEW',
                                        'bg-primary' => ! in_array($item['badge'], ['SALE', 'NEW'], true),
                                    ])>{{ $item['badge'] === 'SALE' ? 'Sale' : $item['badge'] }}</span>
                                @endif
                                <a href="{{ route('product.show', $item['id']) }}" class="absolute inset-0 z-0" aria-label="{{ $item['name'] }}"></a>
                                <img src="{{ $item['img'] }}" alt="{{ $item['name'] }}" class="relative z-[1] pointer-events-none h-28 w-full object-contain group-hover:scale-105 transition-transform duration-300" loading="lazy">
                            </div>
                            <div class="px-3.5 pb-3.5 flex flex-col flex-1">
                                <a href="{{ route('product.show', $item['id']) }}" class="text-sm font-bold text-[#011848] line-clamp-2 mb-2 min-h-[2.5rem] hover:text-primary transition-colors">{{ $item['name'] }}</a>
                                <div class="flex items-center gap-1.5 mb-2">
                                    <x-star-rating :rating="$item['rating']" :size="11" />
                                    <span class="text-[11px] text-gray-400">({{ $item['reviews'] }})</span>
                                </div>
                                <div class="mt-auto flex items-end justify-between gap-2">
                                    <div class="flex items-baseline gap-1.5 flex-wrap">
                                        <span class="text-sm font-extrabold text-primary">MVR {{ number_format($item['price']) }}</span>
                                        @if (!empty($item['original']))
                                            <span class="text-[11px] text-gray-400 line-through">MVR {{ number_format($item['original']) }}</span>
                                        @endif
                                    </div>
                                    <button type="button" data-add-to-cart class="w-8 h-8 rounded-lg border border-border text-primary hover:bg-primary hover:text-white hover:border-primary transition-colors flex items-center justify-center shrink-0" aria-label="Add to cart">
                                        <span data-cart-default><x-lucide name="shopping-cart" :size="14" /></span>
                                        <span data-cart-added class="hidden text-xs font-bold">✓</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    {{-- Newsletter --}}
    <section class="w-full bg-[#011848]" data-newsletter>
        <div class="site-container py-8 md:py-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4 text-white text-center md:text-left">
                <x-lucide name="mail" :size="28" class="hidden sm:block text-white shrink-0" />
                <div>
                    <h2 class="text-xl md:text-2xl font-extrabold mb-1">Stay Updated With LITUS Connect</h2>
                    <p class="text-white/70 text-sm">Subscribe to get special offers, free giveaways, and once-in-a-lifetime deals.</p>
                </div>
            </div>
            <div class="w-full md:w-auto md:min-w-[420px] max-w-lg">
                <div data-newsletter-success class="hidden items-center gap-2 text-white font-bold text-sm bg-white/10 px-5 py-3 rounded-full">
                    <x-lucide name="check-circle" :size="18" class="text-emerald-400" />
                    You're subscribed! Welcome to LITUS Connect.
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
</div>

{{-- Zoom modal --}}
<div data-zoom-modal class="fixed inset-0 z-[80] hidden items-center justify-center bg-black/70 p-4">
    <button type="button" data-zoom-close class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white text-[#011848] flex items-center justify-center" aria-label="Close">
        <x-lucide name="x" :size="18" />
    </button>
    <img data-zoom-image src="{{ $product['images'][0] }}" alt="{{ $product['name'] }}" class="max-h-[90vh] max-w-full object-contain rounded-lg">
</div>

@endsection
