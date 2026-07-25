@extends('layouts.app')

@section('title', $product['name'] . ' — TechZone Technology Store')
@section('meta_description', $product['shortDescription'])

@section('content')

    {{-- Breadcrumb --}}
    <div class="bg-white border-b border-border">
        <div class="site-container py-3 flex flex-wrap items-center gap-2 text-sm text-muted-foreground">
            @foreach ($product['breadcrumb'] as $index => $crumb)
                @if ($index > 0)
                    <x-lucide name="chevron-right" :size="13" class="text-gray-300" />
                @endif
                @if (!empty($crumb['route']))
                    <a href="{{ route($crumb['route']) }}" class="hover:text-primary transition-colors font-medium">{{ $crumb['label'] }}</a>
                @else
                    <span class="font-bold text-[#011848] line-clamp-1">{{ $crumb['label'] }}</span>
                @endif
            @endforeach
        </div>
    </div>

    <div class="site-container py-6 md:py-8" data-product-page>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
            {{-- Gallery --}}
            <div class="space-y-4">
                <div class="relative bg-white rounded-2xl border border-border p-6 md:p-10 min-h-[360px] md:min-h-[460px] flex items-center justify-center overflow-hidden">
                    @if (!empty($product['badge']))
                        @php
                            $badgeColor = $product['badge'] === 'SALE' ? 'bg-red-500' : ($product['badge'] === 'NEW' ? 'bg-violet-600' : 'bg-primary');
                        @endphp
                        <span class="absolute top-4 left-4 text-white text-[10px] font-bold px-2.5 py-1 rounded-md {{ $badgeColor }} tracking-wide uppercase z-10">
                            {{ $product['badge'] }}
                        </span>
                    @endif
                    @if (!empty($product['discount']))
                        <span class="absolute top-4 right-4 text-primary bg-blue-light text-[11px] font-bold px-2.5 py-1 rounded-md z-10">
                            -{{ $product['discount'] }}%
                        </span>
                    @endif
                    <img
                        src="{{ $product['images'][0] }}"
                        alt="{{ $product['name'] }}"
                        data-product-main-image
                        class="max-h-[320px] md:max-h-[400px] w-full object-contain transition-opacity duration-200"
                    >
                </div>
                <div class="grid grid-cols-4 gap-3">
                    @foreach ($product['images'] as $index => $image)
                        <button
                            type="button"
                            data-product-thumb
                            data-image="{{ $image }}"
                            @class([
                                'aspect-square rounded-xl border bg-white p-2 flex items-center justify-center transition-all',
                                'border-primary ring-2 ring-primary/20' => $index === 0,
                                'border-border hover:border-primary/50' => $index !== 0,
                            ])
                        >
                            <img src="{{ $image }}" alt="" class="h-full w-full object-contain" loading="lazy">
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Buy box --}}
            <div class="flex flex-col">
                <div class="flex items-start justify-between gap-3 mb-2">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-primary mb-2">{{ $product['brand'] ?? 'TechZone' }}</p>
                        <h1 class="text-2xl md:text-3xl font-extrabold text-[#011848] leading-tight">{{ $product['name'] }}</h1>
                    </div>
                    <button type="button" data-product-share class="w-10 h-10 rounded-xl border border-border bg-white flex items-center justify-center text-gray-500 hover:text-primary hover:border-primary transition-colors" aria-label="Share">
                        <x-lucide name="share" :size="16" />
                    </button>
                </div>

                <div class="flex flex-wrap items-center gap-3 mb-4">
                    <div class="flex items-center gap-1.5">
                        <x-star-rating :rating="$product['rating']" :size="15" />
                        <span class="text-sm font-bold text-[#011848]">{{ number_format($product['rating'], 1) }}</span>
                    </div>
                    <span class="text-sm text-muted-foreground">({{ number_format($product['reviews']) }} reviews)</span>
                    <span class="text-border">|</span>
                    <span class="text-sm text-muted-foreground">SKU: <span class="font-semibold text-[#011848]">{{ $product['sku'] }}</span></span>
                </div>

                <p class="text-sm text-muted-foreground leading-relaxed mb-5">{{ $product['shortDescription'] }}</p>

                <div class="flex items-baseline gap-3 mb-2">
                    <span class="text-3xl font-extrabold text-primary">LKR {{ number_format($product['price']) }}</span>
                    @if (!empty($product['original']))
                        <span class="text-base text-muted-foreground line-through">LKR {{ number_format($product['original']) }}</span>
                    @endif
                </div>
                @if ($product['inStock'])
                    <p class="inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-600 mb-6">
                        <x-lucide name="check" :size="14" />
                        In Stock — ready to ship
                    </p>
                @else
                    <p class="text-sm font-semibold text-red-500 mb-6">Currently out of stock</p>
                @endif

                @if (!empty($product['colors']))
                    <div class="mb-5">
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
                                        'border-primary ring-2 ring-primary/20 scale-105' => $index === 0,
                                        'border-white shadow-[0_0_0_1px_#E4E9F2] hover:border-primary/40' => $index !== 0,
                                    ])
                                    style="background-color: {{ $color['hex'] }}"
                                ></button>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if (!empty($product['storageOptions']))
                    <div class="mb-6">
                        <p class="text-sm font-bold text-[#011848] mb-2.5">Storage</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($product['storageOptions'] as $storage)
                                <button
                                    type="button"
                                    data-product-storage="{{ $storage }}"
                                    @class([
                                        'px-4 py-2 rounded-lg border text-sm font-semibold transition-all',
                                        'border-primary bg-blue-light text-primary' => $storage === ($product['selectedStorage'] ?? $product['storageOptions'][0]),
                                        'border-border text-gray-700 hover:border-primary hover:text-primary' => $storage !== ($product['selectedStorage'] ?? $product['storageOptions'][0]),
                                    ])
                                >
                                    {{ $storage }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="flex flex-col sm:flex-row gap-3 mb-4">
                    <div class="inline-flex items-center border border-border rounded-xl overflow-hidden bg-white h-12">
                        <button type="button" data-qty-minus class="w-11 h-full flex items-center justify-center text-gray-500 hover:text-primary hover:bg-blue-light transition-colors" aria-label="Decrease quantity">
                            <x-lucide name="minus" :size="16" />
                        </button>
                        <input type="number" data-product-qty value="1" min="1" max="10" class="w-12 text-center text-sm font-bold text-[#011848] outline-none border-x border-border h-full [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                        <button type="button" data-qty-plus class="w-11 h-full flex items-center justify-center text-gray-500 hover:text-primary hover:bg-blue-light transition-colors" aria-label="Increase quantity">
                            <x-lucide name="plus" :size="16" />
                        </button>
                    </div>

                    <button
                        type="button"
                        data-product-add-cart
                        @disabled(! $product['inStock'])
                        @class([
                            'flex-1 h-12 rounded-xl text-sm font-bold transition-colors inline-flex items-center justify-center gap-2',
                            'bg-primary text-white hover:bg-[#0d4fc7]' => $product['inStock'],
                            'bg-gray-200 text-gray-500 cursor-not-allowed' => ! $product['inStock'],
                        ])
                    >
                        <x-lucide name="shopping-cart" :size="17" />
                        <span data-add-label>{{ $product['inStock'] ? 'Add to Cart' : 'Out of Stock' }}</span>
                    </button>

                    <button type="button" data-product-wishlist class="h-12 w-12 rounded-xl border border-border bg-white text-gray-400 hover:text-red-500 hover:border-red-200 transition-colors flex items-center justify-center" aria-label="Add to wishlist">
                        <x-lucide name="heart" :size="18" data-wishlist-icon />
                    </button>
                </div>

                <button
                    type="button"
                    data-product-buy-now
                    @disabled(! $product['inStock'])
                    @class([
                        'w-full h-12 rounded-xl text-sm font-bold border transition-colors mb-6',
                        'border-primary text-primary hover:bg-blue-light' => $product['inStock'],
                        'border-border text-gray-400 cursor-not-allowed' => ! $product['inStock'],
                    ])
                >
                    Buy Now
                </button>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
                    @foreach (array_slice($serviceFeatures, 0, 4) as $feature)
                        <div class="flex items-center gap-3 rounded-xl border border-border bg-white px-3.5 py-3">
                            <div class="w-9 h-9 rounded-full bg-blue-light text-primary flex items-center justify-center shrink-0">
                                <x-lucide :name="$feature['icon']" :size="15" />
                            </div>
                            <div>
                                <p class="text-xs font-bold text-[#011848]">{{ $feature['title'] }}</p>
                                <p class="text-[11px] text-muted-foreground leading-tight">{{ $feature['sub'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <ul class="space-y-2">
                    @foreach ($product['highlights'] as $highlight)
                        <li class="flex items-start gap-2 text-sm text-gray-700">
                            <x-lucide name="check-circle" :size="16" class="text-primary mt-0.5 shrink-0" />
                            <span>{{ $highlight }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="mt-10 md:mt-14 bg-white rounded-2xl border border-border overflow-hidden" data-product-tabs>
            <div class="flex flex-wrap border-b border-border">
                <button type="button" data-tab="description" class="px-5 py-3.5 text-sm font-bold text-primary border-b-2 border-primary -mb-px">Description</button>
                <button type="button" data-tab="specs" class="px-5 py-3.5 text-sm font-bold text-muted-foreground hover:text-[#011848] border-b-2 border-transparent -mb-px">Specifications</button>
                <button type="button" data-tab="reviews" class="px-5 py-3.5 text-sm font-bold text-muted-foreground hover:text-[#011848] border-b-2 border-transparent -mb-px">Reviews ({{ $product['reviews'] }})</button>
            </div>

            <div data-tab-panel="description" class="p-5 md:p-8">
                <h2 class="text-lg font-extrabold text-[#011848] mb-3">Product Description</h2>
                <p class="text-sm text-muted-foreground leading-relaxed max-w-3xl">{{ $product['description'] }}</p>
            </div>

            <div data-tab-panel="specs" class="p-5 md:p-8 hidden">
                <h2 class="text-lg font-extrabold text-[#011848] mb-4">Specifications</h2>
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
                        @foreach ([5, 4, 3, 2, 1] as $star)
                            @php
                                $pct = $star === 5 ? 72 : ($star === 4 ? 18 : ($star === 3 ? 6 : ($star === 2 ? 3 : 1)));
                            @endphp
                            <div class="flex items-center gap-2 text-xs">
                                <span class="w-10 font-semibold text-[#011848]">{{ $star }} star</span>
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
                        ['name' => 'Dilshan P.', 'rating' => 5, 'text' => 'Excellent product quality and fast delivery from TechZone. Packaging was perfect.'],
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
        </div>

        {{-- Related --}}
        @if (count($related))
            <section class="mt-10 md:mt-14 mb-4">
                <div class="flex items-end justify-between gap-4 mb-5">
                    <div>
                        <h2 class="text-xl md:text-2xl font-extrabold text-[#011848]">Related Products</h2>
                        <p class="text-sm text-muted-foreground mt-1">You may also like these picks</p>
                    </div>
                    <a href="{{ route('shop') }}" class="hidden sm:inline-flex text-sm font-bold text-primary hover:underline">View All</a>
                </div>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach ($related as $item)
                        <a href="{{ route('product.show', $item['id']) }}" class="bg-white rounded-xl border border-border hover:shadow-md hover:border-primary/30 transition-all group overflow-hidden flex flex-col">
                            <div class="relative p-5 min-h-[170px] flex items-center justify-center">
                                @if (!empty($item['badge']))
                                    <span @class([
                                        'absolute top-3 left-3 text-white text-[10px] font-bold px-2 py-0.5 rounded tracking-wide',
                                        'bg-red-500' => $item['badge'] === 'SALE',
                                        'bg-violet-600' => $item['badge'] === 'NEW',
                                        'bg-primary' => ! in_array($item['badge'], ['SALE', 'NEW'], true),
                                    ])>{{ $item['badge'] }}</span>
                                @endif
                                <img src="{{ $item['img'] }}" alt="{{ $item['name'] }}" class="h-32 w-full object-contain group-hover:scale-105 transition-transform duration-300" loading="lazy">
                            </div>
                            <div class="px-4 pb-4 flex flex-col flex-1">
                                <h3 class="text-sm font-bold text-[#011848] line-clamp-2 mb-2 min-h-[2.5rem]">{{ $item['name'] }}</h3>
                                <div class="flex items-center gap-1.5 mb-2">
                                    <x-star-rating :rating="$item['rating']" :size="12" />
                                    <span class="text-[11px] text-gray-400">({{ $item['reviews'] }})</span>
                                </div>
                                <div class="mt-auto flex items-baseline gap-2">
                                    <span class="text-base font-extrabold text-primary">LKR {{ number_format($item['price']) }}</span>
                                    @if (!empty($item['original']))
                                        <span class="text-xs text-gray-400 line-through">LKR {{ number_format($item['original']) }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    <section class="bg-[#F7F8FA] border-y border-border/60 mt-6">
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

@endsection
