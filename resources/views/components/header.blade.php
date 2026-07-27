@props([
    'cartCount' => 2,
    'wishCount' => 0,
])

@php
    $navCategories = [
        ['label' => 'Mobile Phones', 'icon' => 'smartphone', 'route' => 'mobile-phones'],
        ['label' => 'Headsets', 'icon' => 'headphones', 'route' => 'headsets'],
        ['label' => 'Smart Watches', 'icon' => 'watch', 'route' => 'smart-watches'],
        ['label' => 'Accessories', 'icon' => 'package', 'route' => 'accessories'],
        ['label' => 'Speakers', 'icon' => 'speaker'],
        ['label' => 'Laptops', 'icon' => 'laptop'],
        ['label' => 'Cables', 'icon' => 'battery'],
        ['label' => 'Tablets', 'icon' => 'monitor'],
        ['label' => 'Power Banks', 'icon' => 'zap'],
        ['label' => 'Gaming', 'icon' => 'gamepad'],
    ];

    $navLinks = [
        ['label' => 'Home', 'route' => 'home'],
        ['label' => 'Shop', 'route' => 'shop'],
        ['label' => 'Mobile Phones', 'route' => 'mobile-phones'],
        ['label' => 'Headsets', 'route' => 'headsets'],
        ['label' => 'Accessories', 'route' => 'accessories'],
        ['label' => 'Smart Watches', 'route' => 'smart-watches'],
        ['label' => 'Offers', 'route' => 'offers'],
        ['label' => 'Blog', 'route' => 'blog'],
        ['label' => 'Contact Us', 'route' => 'contact'],
    ];
@endphp

<header
    id="site-header"
    class="bg-white sticky top-0 z-50 transition-shadow duration-300 border-b border-border"
    data-header
>
    {{-- Main header row --}}
    <div class="site-container py-4 flex items-center gap-4 lg:gap-8">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 flex-shrink-0">
            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                <x-lucide name="lightbulb" :size="20" class="text-primary" />
            </div>
            <div class="leading-tight">
                <span class="block text-xl font-extrabold text-[#0B1426] tracking-tight">LITUS Connect</span>
                <span class="block text-[10px] font-semibold tracking-[0.18em] text-gray-500 uppercase">Connecting you to the future</span>
            </div>
        </a>

        <form action="#" method="get" class="flex-1 max-w-2xl hidden md:flex">
            <div class="flex w-full h-11 rounded-lg border border-border bg-white overflow-hidden focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/15 transition-all">
                <input
                    type="search"
                    name="q"
                    placeholder="Search for products, brands and more..."
                    class="flex-1 px-4 text-sm outline-none bg-transparent text-foreground placeholder:text-muted-foreground"
                >
                <button type="submit" class="w-12 flex items-center justify-center bg-primary hover:bg-[#0d4fc7] text-white transition-colors" aria-label="Search">
                    <x-lucide name="search" :size="18" />
                </button>
            </div>
        </form>

        <div class="flex items-center gap-1 sm:gap-3 ml-auto">
            <a href="#" class="hidden sm:flex items-center gap-2.5 px-2 py-1.5 rounded-lg hover:bg-blue-light transition-colors group">
                <x-lucide name="user" :size="22" class="text-gray-600 group-hover:text-primary transition-colors" />
                <span class="hidden lg:block leading-tight">
                    <span class="block text-[11px] text-gray-500">My Account</span>
                    <span class="block text-xs font-semibold text-[#0B1426]">
                        <span class="hover:text-primary">Login</span>
                        <span class="text-gray-400 font-normal"> / </span>
                        <span class="hover:text-primary">Register</span>
                    </span>
                </span>
            </a>

            <a href="#" class="relative flex flex-col items-center gap-0.5 px-2 py-1.5 rounded-lg hover:bg-blue-light group transition-colors">
                <x-lucide name="heart" :size="22" class="text-gray-600 group-hover:text-primary transition-colors" />
                <span class="hidden sm:block text-[10px] font-medium text-gray-500 group-hover:text-primary">Wishlist</span>
            </a>

            <a href="#" class="relative flex flex-col items-center gap-0.5 px-2 py-1.5 rounded-lg hover:bg-blue-light group transition-colors">
                <x-lucide name="shopping-cart" :size="22" class="text-gray-600 group-hover:text-primary transition-colors" />
                <span class="hidden sm:block text-[10px] font-medium text-gray-500 group-hover:text-primary">Cart</span>
                @if ($cartCount > 0)
                    <span class="absolute -top-0.5 right-0.5 min-w-[18px] h-[18px] px-1 bg-primary text-white text-[10px] font-bold rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                @endif
            </a>

            <button
                type="button"
                class="md:hidden ml-1 p-2 rounded-lg hover:bg-gray-100"
                data-mobile-menu-toggle
                aria-expanded="false"
                aria-label="Toggle menu"
            >
                <span data-mobile-menu-icon="open"><x-lucide name="menu" :size="22" /></span>
                <span data-mobile-menu-icon="close" class="hidden"><x-lucide name="x" :size="22" /></span>
            </button>
        </div>
    </div>

    {{-- Primary nav --}}
    <nav class="hidden md:block border-t border-border bg-white">
        <div class="site-container flex items-center gap-1">
            <div class="relative" data-categories-dropdown>
                <button
                    type="button"
                    class="flex items-center gap-2 text-white text-sm font-semibold px-4 py-3 my-2 rounded-md bg-primary hover:bg-[#0d4fc7] transition-colors"
                    data-categories-toggle
                    aria-expanded="false"
                >
                    <x-lucide name="menu" :size="15" />
                    All Categories
                    <x-lucide name="chevron-right" :size="14" data-categories-chevron class="transition-transform duration-200" />
                </button>
                <div
                    data-categories-panel
                    class="hidden absolute top-full left-0 mt-0 bg-white rounded-b-xl shadow-[0_16px_48px_rgba(7,22,46,0.15)] border border-border z-50 w-64 py-2 overflow-hidden"
                >
                    @foreach ($navCategories as $cat)
                        <a href="{{ !empty($cat['route']) ? route($cat['route']) : '#' }}" class="flex items-center gap-3 px-5 py-2.5 text-sm text-gray-700 hover:bg-blue-light hover:text-primary transition-colors font-medium group">
                            <x-lucide :name="$cat['icon']" :size="16" class="text-gray-400 group-hover:text-primary transition-colors" />
                            {{ $cat['label'] }}
                            <x-lucide name="chevron-right" :size="13" class="ml-auto text-gray-300 group-hover:text-primary transition-colors" />
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center overflow-x-auto">
                @foreach ($navLinks as $link)
                    @php
                        $href = $link['route'] ? route($link['route']) : '#';
                        $active = $link['route'] ? request()->routeIs($link['route']) : false;
                    @endphp
                    <a
                        href="{{ $href }}"
                        @class([
                            'relative px-3.5 py-3.5 text-sm font-semibold whitespace-nowrap transition-colors',
                            'text-primary' => $active,
                            'text-gray-700 hover:text-primary' => ! $active,
                        ])
                    >
                        {{ $link['label'] }}
                        @if ($active)
                            <span class="absolute bottom-0 left-3.5 right-3.5 h-0.5 bg-primary rounded-full"></span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </nav>

    {{-- Mobile menu --}}
    <div data-mobile-menu class="hidden md:hidden border-t border-border bg-white px-4 py-4">
        <form action="#" method="get" class="flex w-full border border-border rounded-lg overflow-hidden mb-4 focus-within:border-primary">
            <input type="search" name="q" placeholder="Search products..." class="flex-1 px-4 py-2.5 text-sm outline-none">
            <button type="submit" class="bg-primary px-4 text-white" aria-label="Search">
                <x-lucide name="search" :size="16" />
            </button>
        </form>
        @foreach ($navLinks as $link)
            @php
                $href = $link['route'] ? route($link['route']) : '#';
                $active = $link['route'] ? request()->routeIs($link['route']) : false;
            @endphp
            <a
                href="{{ $href }}"
                @class([
                    'block py-2.5 text-sm font-semibold border-b border-gray-100 last:border-0',
                    'text-primary' => $active,
                    'text-gray-700' => ! $active,
                ])
            >
                {{ $link['label'] }}
            </a>
        @endforeach
    </div>
</header>
