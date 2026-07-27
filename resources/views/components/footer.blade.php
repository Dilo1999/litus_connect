<footer class="bg-[#0B1426] text-gray-400 mt-0">
    <div class="site-container pt-14 pb-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-10 mb-10">
            {{-- Brand --}}
            <div class="sm:col-span-2 lg:col-span-1">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 mb-4">
                    <div class="w-9 h-9 rounded-full bg-primary/20 flex items-center justify-center">
                        <x-lucide name="lightbulb" :size="18" class="text-primary" />
                    </div>
                    <div class="leading-tight">
                        <span class="block text-lg font-extrabold text-white">LITUS Connect</span>
                        <span class="block text-[9px] font-semibold tracking-[0.16em] text-gray-400 uppercase">Connecting you to the future</span>
                    </div>
                </a>
                <p class="text-sm leading-relaxed text-gray-400 mb-5">
                    Your trusted destination for mobile phones, computers, accessories, and gadgets across the Maldives.
                </p>
                <div class="flex gap-2.5">
                    @foreach (['facebook', 'instagram', 'tiktok', 'youtube'] as $icon)
                        <a href="#" class="w-9 h-9 rounded-lg bg-white/5 hover:bg-primary flex items-center justify-center transition-colors border border-white/10" aria-label="{{ ucfirst($icon) }}">
                            <x-lucide :name="$icon" :size="14" class="text-white" />
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Shop --}}
            <div>
                <h4 class="text-white font-bold mb-4 text-sm tracking-wide">Shop</h4>
                <ul class="flex flex-col gap-2.5">
                    @foreach ([
                        ['label' => 'Mobile Phones', 'route' => 'mobile-phones'],
                        ['label' => 'Headsets', 'route' => 'headsets'],
                        ['label' => 'Smart Watches', 'route' => 'smart-watches'],
                        ['label' => 'Accessories', 'route' => 'accessories'],
                        ['label' => 'Laptops', 'route' => null],
                        ['label' => 'Speakers', 'route' => null],
                    ] as $link)
                        <li>
                            <a href="{{ $link['route'] ? route($link['route']) : '#' }}" class="text-sm hover:text-white transition-colors">{{ $link['label'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Customer Service --}}
            <div>
                <h4 class="text-white font-bold mb-4 text-sm tracking-wide">Customer Service</h4>
                <ul class="flex flex-col gap-2.5">
                    @foreach (['Contact Us' => 'contact', 'Order Tracking' => null, 'Returns & Exchanges' => null, 'Shipping Info' => null, 'FAQs' => null, 'Store Locator' => null] as $label => $routeName)
                        <li>
                            <a href="{{ $routeName ? route($routeName) : '#' }}" class="text-sm hover:text-white transition-colors">{{ $label }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- My Account --}}
            <div>
                <h4 class="text-white font-bold mb-4 text-sm tracking-wide">My Account</h4>
                <ul class="flex flex-col gap-2.5">
                    @foreach (['Login / Register', 'Order History', 'Compare Products', 'Loyalty Rewards'] as $link)
                        <li><a href="#" class="text-sm hover:text-white transition-colors">{{ $link }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="text-white font-bold mb-4 text-sm tracking-wide">Contact Us</h4>
                <ul class="flex flex-col gap-3 text-sm">
                    <li class="flex items-start gap-2.5">
                        <x-lucide name="phone" :size="14" class="text-primary mt-0.5 shrink-0" />
                        <a href="tel:+9603322295" class="hover:text-white transition-colors">+960 332 2295</a>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <x-lucide name="mail" :size="14" class="text-primary mt-0.5 shrink-0" />
                        <a href="mailto:sales@litusgroup.mv" class="hover:text-white transition-colors">sales@litusgroup.mv</a>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <x-lucide name="clock" :size="14" class="text-primary mt-0.5 shrink-0" />
                        <span>Sun – Thu: 8:00 AM – 5:00 PM · Sat: 9:00 AM – 1:00 PM</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <x-lucide name="map-pin" :size="14" class="text-primary mt-0.5 shrink-0" />
                        <span>Ma. Elyzium, Buruzu Magu, Malé, Maldives</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 pt-6 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-gray-500">
            <span>© {{ date('Y') }} LITUS Connect. All rights reserved.</span>
            <div class="flex items-center gap-2">
                <span class="text-gray-500 text-[11px] mr-1">We accept:</span>
                @foreach (['VISA', 'MC', 'Amex', 'PayPal'] as $card)
                    <span class="bg-white/10 text-white/80 text-[10px] px-2.5 py-1 rounded font-bold">{{ $card }}</span>
                @endforeach
            </div>
        </div>
    </div>
</footer>
