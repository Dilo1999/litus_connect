@props([
    'eyebrow' => null,
    'title',
    'href' => '#',
    'linkText' => 'View All',
    'showLink' => true,
])

<div {{ $attributes->merge(['class' => 'flex items-center justify-between mb-6']) }}>
    <div>
        @if ($eyebrow)
            <p class="text-xs font-bold text-primary uppercase tracking-widest mb-1">{{ $eyebrow }}</p>
        @endif
        <h2 class="text-xl md:text-2xl font-extrabold text-[#0B1426]">{{ $title }}</h2>
    </div>
    @if ($showLink)
        <a href="{{ $href }}" class="flex items-center gap-1 text-sm font-semibold text-primary hover:underline">
            {{ $linkText }}
            <x-lucide name="chevron-right" :size="15" />
        </a>
    @endif
</div>
