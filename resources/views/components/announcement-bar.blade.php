<div class="bg-[#0B1426] text-white text-[12px] py-2.5">
    <div class="site-container flex items-center justify-between gap-3">
        <div class="flex flex-wrap items-center gap-x-5 gap-y-1 text-gray-300 min-w-0">
            <span class="inline-flex items-center gap-1.5 min-w-0">
                <x-lucide name="truck" :size="13" class="text-primary shrink-0" />
                <span class="sm:hidden truncate">Free delivery over MVR 5,000</span>
                <span class="hidden sm:inline">Free Delivery on orders over MVR 5,000</span>
            </span>
            <span class="hidden sm:inline-flex items-center gap-1.5">
                <x-lucide name="shield" :size="13" class="text-primary" />
                1 Year Official Warranty
            </span>
        </div>
        <div class="hidden min-[420px]:flex items-center gap-1 shrink-0">
            <a href="#" class="w-9 h-9 inline-flex items-center justify-center text-gray-400 hover:text-white transition-colors" aria-label="Facebook">
                <x-lucide name="facebook" :size="14" />
            </a>
            <a href="#" class="w-9 h-9 inline-flex items-center justify-center text-gray-400 hover:text-white transition-colors" aria-label="Instagram">
                <x-lucide name="instagram" :size="14" />
            </a>
            <a href="#" class="w-9 h-9 inline-flex items-center justify-center text-gray-400 hover:text-white transition-colors" aria-label="TikTok">
                <x-lucide name="tiktok" :size="14" />
            </a>
        </div>
    </div>
</div>
