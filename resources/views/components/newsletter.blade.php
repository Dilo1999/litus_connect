@props([
    'title' => 'Stay Updated With LITUS Connect',
    'subtitle' => 'Subscribe to get special offers, free giveaways, and once-in-a-lifetime deals.',
    'icon' => 'mail',
])

<section {{ $attributes->merge(['class' => 'w-full bg-[#011848]', 'data-newsletter' => true]) }}>
    <div class="site-container py-8 md:py-10 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-4 text-white text-center md:text-left">
            <x-lucide :name="$icon" :size="28" class="hidden sm:block text-white shrink-0" />
            <div>
                <h2 class="text-xl md:text-2xl font-extrabold mb-1">{{ $title }}</h2>
                <p class="text-white/70 text-sm">{{ $subtitle }}</p>
            </div>
        </div>
        <div class="w-full md:w-auto md:min-w-[420px] max-w-lg">
            <div data-newsletter-success class="hidden items-center gap-2 text-white font-bold text-sm bg-white/10 px-5 py-3 rounded-full">
                <x-lucide name="check-circle" :size="18" class="text-emerald-400" />
                You're subscribed! Welcome to LITUS Connect.
            </div>
            <div data-newsletter-form class="flex w-full overflow-hidden rounded-full bg-white shadow-sm">
                <input
                    type="email"
                    data-newsletter-email
                    placeholder="Enter your email address"
                    class="flex-1 min-w-0 px-5 py-3.5 text-sm outline-none bg-transparent text-gray-900 placeholder:text-gray-400"
                >
                <button
                    type="button"
                    data-newsletter-submit
                    class="bg-primary hover:bg-[#005266] text-white font-bold px-6 py-3.5 text-sm transition-colors whitespace-nowrap rounded-full"
                >
                    Subscribe
                </button>
            </div>
        </div>
    </div>
</section>
