@extends('layouts.app')

@section('title', 'LITUS Connect — Connecting you to the future')
@section('meta_description', 'Shop authentic electronics, mobile phones, headsets, accessories and more at LITUS Connect. Free delivery on orders over MVR 5,000.')

@section('content')

    {{-- Hero --}}
    <section class="w-full">
        <div
            class="relative w-full overflow-hidden h-[430px] md:h-[560px] lg:h-[620px]"
            data-hero-slider
            style="background: {{ $heroSlides[0]['bg'] }}"
        >
            @foreach ($heroSlides as $index => $slide)
                <div
                    data-hero-slide="{{ $index }}"
                    class="{{ $index === 0 ? 'flex' : 'hidden' }} absolute inset-0 items-center w-full h-full"
                >
                    @if (!empty($slide['fullBleed']))
                        <img
                            src="{{ $slide['img'] }}"
                            alt="{{ $slide['eyebrow'] }}"
                            class="absolute inset-0 w-full h-full object-cover object-center md:object-right"
                            data-hero-image
                        >
                        <div class="absolute inset-0 bg-gradient-to-r from-[#0b1426]/90 via-[#0b1426]/55 to-transparent"></div>
                    @endif

                    <div class="site-container relative z-10 flex items-center w-full h-full gap-8 py-10 md:py-14">
                        <div class="flex-1 text-white z-10 max-w-xl">
                            <span class="inline-block text-[11px] font-bold tracking-[0.2em] text-primary bg-white/10 border border-white/15 px-3 py-1 rounded mb-4">
                                {{ $slide['eyebrow'] }}
                            </span>
                            <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold leading-[1.1] mb-4 whitespace-pre-line tracking-tight">
                                {{ $slide['headline'] }}
                            </h1>
                            <p class="text-white/70 text-sm md:text-base leading-relaxed mb-7 max-w-md">{{ $slide['sub'] }}</p>
                            <a href="{{ route('mobile-phones') }}" class="inline-flex items-center gap-2 bg-white text-[#0B1426] font-bold px-6 py-3 rounded-full text-sm hover:bg-gray-100 transition-all">
                                {{ $slide['cta'] }}
                                <x-lucide name="arrow-right" :size="15" />
                            </a>
                        </div>
                        @if (empty($slide['fullBleed']))
                            <div class="hidden sm:flex flex-1 justify-center items-center h-full">
                                <img
                                    src="{{ $slide['img'] }}"
                                    alt="{{ $slide['eyebrow'] }}"
                                    class="max-h-[72%] w-auto object-contain drop-shadow-2xl animate-fade-slide"
                                    data-hero-image
                                >
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            <button type="button" data-hero-prev class="hidden sm:flex absolute left-3 md:left-6 top-1/2 -translate-y-1/2 w-10 h-10 md:w-12 md:h-12 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur items-center justify-center text-white transition-colors border border-white/15 z-20" aria-label="Previous slide">
                <x-lucide name="chevron-left" :size="18" />
            </button>
            <button type="button" data-hero-next class="hidden sm:flex absolute right-3 md:right-6 top-1/2 -translate-y-1/2 w-10 h-10 md:w-12 md:h-12 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur items-center justify-center text-white transition-colors border border-white/15 z-20" aria-label="Next slide">
                <x-lucide name="chevron-right" :size="18" />
            </button>

            <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex gap-2 z-20">
                @foreach ($heroSlides as $index => $slide)
                    <button
                        type="button"
                        data-hero-dot="{{ $index }}"
                        class="h-1.5 rounded-full transition-all duration-300 {{ $index === 0 ? 'w-7 bg-white' : 'w-1.5 bg-white/35 hover:bg-white/50' }}"
                        aria-label="Go to slide {{ $index + 1 }}"
                    ></button>
                @endforeach
            </div>
        </div>
    </section>

    @php
        $heroBgJson = collect($heroSlides)->pluck('bg')->values();
    @endphp
    <script type="application/json" id="hero-slide-bgs">@json($heroBgJson)</script>

    {{-- Service Features --}}
    <section class="bg-[#F7F8FA] border-y border-border/60">
        <div class="site-container">
            <div class="grid grid-cols-1 min-[420px]:grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-y-5 md:gap-y-6 gap-x-4 py-7 md:py-8">
                @foreach ($serviceFeatures as $feature)
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-full bg-white shadow-[0_2px_10px_rgba(11,20,38,0.08)] flex items-center justify-center flex-shrink-0 text-[#0B1426]">
                            <x-lucide :name="$feature['icon']" :size="18" />
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-[#0B1426]">{{ $feature['title'] }}</p>
                            <p class="text-[11px] text-muted-foreground leading-tight">{{ $feature['sub'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Quick Categories --}}
    <section class="site-container py-10">
        <div class="grid grid-cols-4 sm:grid-cols-8 gap-4 md:gap-6">
            @foreach ($quickCategories as $item)
                <a href="#" class="flex flex-col items-center gap-2.5 group">
                    <div class="w-16 h-16 md:w-[72px] md:h-[72px] rounded-full bg-[#F3F5F9] border border-border group-hover:border-primary group-hover:bg-blue-light transition-all flex items-center justify-center overflow-hidden shadow-sm">
                        @if (!empty($item['img']))
                            <img src="{{ $item['img'] }}" alt="{{ $item['label'] }}" class="w-10 h-10 md:w-12 md:h-12 object-contain" loading="lazy">
                        @else
                            <x-lucide :name="$item['icon'] ?? 'arrow-right'" :size="22" class="text-primary" />
                        @endif
                    </div>
                    <span class="text-[11px] md:text-xs font-semibold text-center text-gray-700 group-hover:text-primary transition-colors leading-tight">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Promo Banners --}}
    <section class="site-container pb-4" data-promo-slider>
        <div
            data-promo-track
            class="flex md:grid md:grid-cols-3 gap-4 overflow-x-auto md:overflow-visible scroll-smooth snap-x snap-mandatory md:snap-none scrollbar-hide"
        >
            @foreach ($promoBanners as $banner)
                <div
                    data-promo-slide
                    class="min-w-full md:min-w-0 snap-start rounded-2xl p-5 sm:p-6 flex items-center justify-between gap-4 overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-lg cursor-pointer group"
                    style="background: {{ $banner['bg'] }}"
                >
                    <div class="min-w-0">
                        <h3 class="font-extrabold text-lg text-[#0B1426] leading-tight">{{ $banner['title'] }}</h3>
                        <p class="text-sm text-gray-600 mt-1 mb-4">{{ $banner['sub'] }}</p>
                        <a
                            href="#"
                            class="inline-flex items-center gap-1.5 text-white text-xs font-bold px-4 py-2 rounded-full transition-all hover:opacity-90 group-hover:gap-2.5"
                            style="background: {{ $banner['btn'] }}"
                        >
                            {{ $banner['cta'] }}
                            <x-lucide name="arrow-right" :size="12" />
                        </a>
                    </div>
                    <img src="{{ $banner['img'] }}" alt="{{ $banner['title'] }}" class="w-24 h-24 md:w-28 md:h-28 object-contain shrink-0 transition-transform duration-300 group-hover:scale-105" loading="lazy">
                </div>
            @endforeach
        </div>

        <div class="flex md:hidden items-center justify-center gap-2 pt-3" aria-label="Promotion slides">
            @foreach ($promoBanners as $index => $banner)
                <button
                    type="button"
                    data-promo-dot="{{ $index }}"
                    class="h-2 rounded-full transition-all {{ $index === 0 ? 'w-6 bg-primary' : 'w-2 bg-gray-300' }}"
                    aria-label="Show promotion {{ $index + 1 }}"
                    aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                ></button>
            @endforeach
        </div>
    </section>

    {{-- Best Selling Products --}}
    <section class="site-container py-10">
        <x-section-heading title="Best Selling Products" link-text="View All" :href="route('shop')" />

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach ($products as $product)
                <a
                    href="{{ route('product.show', $product['id']) }}"
                    class="flex flex-col items-center text-center p-3 sm:p-5 bg-white rounded-xl border border-border hover:border-primary hover:shadow-md transition-all group"
                    data-product-card
                    data-product-id="{{ $product['id'] }}"
                    data-product-name="{{ $product['name'] }}"
                    data-product-price="{{ $product['price'] }}"
                    data-product-img="{{ $product['img'] }}"
                >
                    <div class="relative w-20 h-20 mb-3 rounded-xl bg-[#F7F9FC] flex items-center justify-center">
                        @if (!empty($product['badge']))
                            <span @class([
                                'absolute top-1 left-1 text-white text-[9px] font-bold px-1.5 py-0.5 rounded z-10',
                                'bg-red-500' => $product['badge'] === 'SALE',
                                'bg-violet-600' => $product['badge'] === 'NEW',
                                'bg-primary' => ! in_array($product['badge'], ['SALE', 'NEW'], true),
                            ])>{{ $product['badge'] }}</span>
                        @endif
                        <img
                            src="{{ $product['img'] }}"
                            alt="{{ $product['name'] }}"
                            class="w-20 h-20 object-contain scale-[1.3] group-hover:scale-[1.38] transition-transform duration-300"
                            loading="lazy"
                        >
                    </div>
                    <span class="text-sm font-bold text-[#0B1426] group-hover:text-primary transition-colors line-clamp-2 min-h-[2.5rem]">{{ $product['name'] }}</span>
                    <span class="text-[11px] font-semibold text-primary mt-1">MVR {{ number_format($product['price']) }}</span>
                    @if (!empty($product['original']))
                        <span class="text-[10px] text-muted-foreground line-through">MVR {{ number_format($product['original']) }}</span>
                    @endif
                </a>
            @endforeach
        </div>
    </section>

    {{-- Featured Products (random) --}}
    <section class="site-container pb-10">
        <x-section-heading title="Featured Products" link-text="View All" :href="route('shop')" />

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4">
            @foreach ($randomProducts as $product)
                <x-product-card
                    :id="$product['id']"
                    :name="$product['name']"
                    :img="$product['img']"
                    :price="$product['price']"
                    :original="$product['original']"
                    :rating="$product['rating']"
                    :reviews="$product['reviews']"
                    :badge="$product['badge']"
                />
            @endforeach
        </div>
    </section>

    {{-- Brands --}}
    <section class="site-container pb-10">
        <x-section-heading title="Top Brands You Trust" link-text="View All Reviews" :href="route('shop')" />

        <div class="relative" data-brands-slider>
            <div class="bg-[#F7F8FA] rounded-2xl overflow-hidden">
                <div
                    data-brands-track
                    class="flex items-stretch overflow-x-auto scroll-smooth scrollbar-hide divide-x divide-[#E4E9F2]"
                    style="scrollbar-width: none; -ms-overflow-style: none;"
                >
                    @foreach ($brands as $brand)
                        <a
                            href="{{ route('shop') }}"
                            class="flex flex-1 items-center justify-center h-[72px] md:h-[80px] min-w-[140px] md:min-w-[160px] shrink-0 px-4 md:px-6 group"
                            title="{{ $brand['name'] }}"
                        >
                            <span class="flex items-center justify-center w-full h-14 md:h-16">
                                <img
                                    src="{{ asset($brand['logo']) }}"
                                    alt="{{ $brand['name'] }}"
                                    class="max-h-full max-w-[130px] md:max-w-[150px] w-auto h-auto object-contain opacity-90 group-hover:opacity-100 transition-opacity"
                                    loading="lazy"
                                >
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>

            <button
                type="button"
                data-brands-prev
                class="hidden md:flex absolute left-0 top-1/2 -translate-y-1/2 -translate-x-1/2 z-10 w-9 h-9 md:w-10 md:h-10 rounded-full bg-white border border-border text-gray-500 hover:text-primary hover:border-primary items-center justify-center transition-colors shadow-sm"
                aria-label="Previous brands"
            >
                <x-lucide name="chevron-left" :size="18" />
            </button>

            <button
                type="button"
                data-brands-next
                class="hidden md:flex absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/2 z-10 w-9 h-9 md:w-10 md:h-10 rounded-full bg-white border border-border text-gray-500 hover:text-primary hover:border-primary items-center justify-center transition-colors shadow-sm"
                aria-label="Next brands"
            >
                <x-lucide name="chevron-right" :size="18" />
            </button>
        </div>
    </section>

    {{-- Store Experience Video --}}
    <section class="w-full pb-10">
        <div class="relative w-full aspect-video md:aspect-auto md:h-[480px] lg:h-[560px] overflow-hidden bg-[#011848]">
            <iframe
                src="https://www.youtube-nocookie.com/embed/t-j3dXD2vA8?autoplay=1&mute=1&loop=1&playlist=t-j3dXD2vA8&controls=0&disablekb=1&fs=0&playsinline=1&rel=0&modestbranding=1"
                title="LITUS Connect store experience"
                class="absolute left-1/2 top-1/2 w-full min-w-full min-h-full aspect-video -translate-x-1/2 -translate-y-1/2 pointer-events-none"
                allow="autoplay; encrypted-media; picture-in-picture"
                referrerpolicy="strict-origin-when-cross-origin"
                loading="lazy"
            ></iframe>

            <div class="absolute inset-0 bg-black/45"></div>
            <div class="absolute inset-0 flex items-center justify-center px-5 text-center">
                <div class="text-white drop-shadow-lg">
                    <p class="text-[11px] sm:text-xs font-bold uppercase tracking-[0.2em] text-white/80 mb-2">
                        Discover LITUS Connect
                    </p>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold leading-tight">
                        Experience Our Flagship Store
                    </h2>
                    <p class="mt-2 text-xs sm:text-sm md:text-base text-white/85">
                        Connecting you to the future
                    </p>
                </div>
            </div>

            <a
                href="https://youtu.be/t-j3dXD2vA8?si=0r798sWQuZI-F3gk"
                target="_blank"
                rel="noopener noreferrer"
                class="absolute bottom-3 right-3 z-10 inline-flex min-h-10 items-center gap-2 rounded-full bg-black/40 px-3 text-xs font-semibold text-white backdrop-blur hover:bg-black/60 transition-colors"
                aria-label="Watch the store video on YouTube"
            >
                <x-lucide name="youtube" :size="15" />
                <span class="hidden sm:inline">Watch on YouTube</span>
            </a>
        </div>
    </section>

    {{-- Why Shop With LITUS Connect --}}
    <section class="site-container pb-10">
        <x-section-heading title="Why Shop With LITUS Connect?" :show-link="false" />

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            @foreach ($whyUs as $item)
                <div class="bg-white rounded-xl sm:rounded-2xl border border-border px-3 py-5 sm:px-6 sm:py-8 flex flex-col items-center justify-center text-center hover:shadow-md hover:border-primary/30 transition-all min-h-[170px] sm:min-h-0">
                    <div class="w-11 h-11 sm:w-14 sm:h-14 rounded-full bg-blue-light text-primary flex items-center justify-center mb-3 sm:mb-4">
                        <x-lucide :name="$item['icon']" :size="20" />
                    </div>
                    <h3 class="font-extrabold text-xs sm:text-sm md:text-base text-[#0B1426] leading-snug mb-1.5">{{ $item['title'] }}</h3>
                    <p class="text-[10px] sm:text-xs text-muted-foreground leading-relaxed">{{ $item['sub'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Instagram Gallery --}}
    @php
        $instagramProfileUrl = config('services.instagram.profile_url', 'https://www.instagram.com/litusconnect/');
        $hasLiveInstagramMedia = !empty($instagramMedia);
        $instagramTiles = $hasLiveInstagramMedia
            ? array_slice($instagramMedia, 0, 12)
            : collect(array_slice($products, 0, 12))->map(fn ($product) => [
                'caption' => $product['name'],
                'image' => $product['img'],
                'permalink' => $instagramProfileUrl,
                'is_video' => false,
            ])->all();
        $instagramBackgrounds = [
            'linear-gradient(145deg, #E8F1FF, #F7FBFF)',
            'linear-gradient(145deg, #F3E8FF, #FBF7FF)',
            'linear-gradient(145deg, #E6F8F1, #F5FFFB)',
            'linear-gradient(145deg, #FFF0E6, #FFF9F5)',
            'linear-gradient(145deg, #E8F7FA, #F5FCFE)',
        ];
    @endphp
    <section class="bg-[#F7F7F7] py-9 md:py-12">
        <div class="site-container">
            <div class="text-center mb-6 md:mb-8">
                <h2 class="text-2xl md:text-3xl font-extrabold text-[#0B1426]">
                    Follow Us on Instagram!
                </h2>
                <a
                    href="{{ $instagramProfileUrl }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex min-h-10 items-center gap-2 mt-2 text-sm font-bold text-primary hover:underline"
                >
                    <x-lucide name="instagram" :size="17" />
                    @litusconnect
                </a>
            </div>

            <div class="flex sm:grid sm:grid-cols-6 gap-2 overflow-x-auto sm:overflow-visible snap-x snap-mandatory sm:snap-none scrollbar-hide pb-2 sm:pb-0">
                @foreach ($instagramTiles as $index => $media)
                    <a
                        href="{{ $media['permalink'] }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="relative min-w-[42%] sm:min-w-0 aspect-square snap-start overflow-hidden rounded-lg group border border-black/5"
                        style="background: {{ $hasLiveInstagramMedia ? '#E9EDF3' : $instagramBackgrounds[$index % count($instagramBackgrounds)] }}"
                        aria-label="View {{ \Illuminate\Support\Str::limit(strip_tags($media['caption']), 60) }} on Instagram"
                    >
                        <img
                            src="{{ $media['image'] }}"
                            alt="{{ \Illuminate\Support\Str::limit(strip_tags($media['caption']), 100) }}"
                            @class([
                                'w-full h-full group-hover:scale-110 transition-transform duration-500',
                                'object-cover' => $hasLiveInstagramMedia,
                                'object-contain p-4 md:p-5' => ! $hasLiveInstagramMedia,
                            ])
                            loading="lazy"
                        >
                        <span class="absolute inset-0 bg-black/0 group-hover:bg-black/25 transition-colors"></span>
                        <span class="absolute top-2 right-2 w-8 h-8 rounded-full bg-white/90 text-[#0B1426] flex items-center justify-center shadow-sm">
                            <x-lucide name="instagram" :size="15" />
                        </span>
                        @if ($media['is_video'])
                            <span class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                <span class="w-11 h-11 rounded-full bg-black/55 text-white flex items-center justify-center backdrop-blur-sm">
                                    <x-lucide name="play" :size="18" class="fill-current ml-0.5" />
                                </span>
                            </span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    <section class="site-container pt-10 md:pt-12 pb-10" data-testimonials-slider>
        <x-section-heading title="What Our Customers Say" :show-link="false" />

        <div
            data-testimonials-track
            class="flex md:grid md:grid-cols-3 gap-4 md:gap-5 overflow-x-auto md:overflow-visible scroll-smooth snap-x snap-mandatory md:snap-none scrollbar-hide"
        >
            @foreach ($testimonials as $testimonial)
                <div
                    data-testimonial-slide
                    class="min-w-[88%] sm:min-w-[70%] md:min-w-0 snap-start bg-white rounded-xl border border-border p-5 sm:p-6 hover:shadow-md transition-shadow"
                >
                    <div class="flex items-center gap-3 mb-4">
                        <img
                            src="{{ $testimonial['avatar'] }}"
                            alt="{{ $testimonial['name'] }}"
                            class="w-11 h-11 rounded-full object-cover ring-2 ring-border"
                            loading="lazy"
                        >
                        <div>
                            <div class="flex items-center gap-1.5">
                                <p class="font-bold text-sm text-[#0B1426]">{{ $testimonial['name'] }}</p>
                                <span class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-emerald-500 text-white" title="Verified">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6 9 17l-5-5"/></svg>
                                </span>
                            </div>
                            <x-star-rating :rating="$testimonial['rating']" :size="12" class="mt-1" />
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed">"{{ $testimonial['text'] }}"</p>
                </div>
            @endforeach
        </div>

        <div class="flex md:hidden items-center justify-center gap-2 pt-4" aria-label="Testimonial slides">
            @foreach ($testimonials as $index => $testimonial)
                <button
                    type="button"
                    data-testimonial-dot="{{ $index }}"
                    class="h-2 rounded-full transition-all {{ $index === 0 ? 'w-6 bg-primary' : 'w-2 bg-gray-300' }}"
                    aria-label="Show testimonial {{ $index + 1 }}"
                    aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                ></button>
            @endforeach
        </div>
    </section>

    {{-- Blog --}}
    <section class="site-container pb-10">
        <x-section-heading title="Latest From Our Blog" link-text="View All" :href="route('blog')" />

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach ($blogPosts as $post)
                <a
                    href="{{ route('blog') }}"
                    class="bg-white rounded-xl border border-border overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition-all group"
                >
                    <div class="overflow-hidden h-40 bg-gray-100">
                        <img src="{{ $post['img'] }}" alt="{{ $post['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                    </div>
                    <div class="p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-[10px] font-bold text-primary bg-blue-light px-2 py-0.5 rounded">{{ $post['category'] }}</span>
                            <span class="text-[11px] text-muted-foreground">{{ $post['date'] }}</span>
                        </div>
                        <h3 class="font-bold text-sm text-[#0B1426] leading-snug mb-3 group-hover:text-primary transition-colors line-clamp-2">{{ $post['title'] }}</h3>
                        <span class="text-xs font-bold text-primary inline-flex items-center gap-1">
                            Read More
                            <x-lucide name="arrow-right" :size="12" />
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <x-newsletter />

@endsection
