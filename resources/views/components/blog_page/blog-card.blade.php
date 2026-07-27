@php
    $colorMap = [
        'blue' => 'text-primary',
        'green' => 'text-emerald-600',
        'orange' => 'text-orange-500',
        'purple' => 'text-violet-600',
        'cyan' => 'text-cyan-600',
        'amber' => 'text-amber-600',
    ];
    $catClass = $colorMap[$post['categoryColor'] ?? 'blue'] ?? 'text-primary';
@endphp

<article
    class="bg-white rounded-2xl border border-border overflow-hidden hover:shadow-md hover:border-primary/25 transition-all group flex flex-col h-full"
    data-blog-card
    data-category="{{ $post['category'] }}"
    data-title="{{ strtolower($post['title']) }}"
    data-tags="{{ strtolower(implode(' ', $post['tags'] ?? [])) }}"
>
    <a href="#" class="block relative overflow-hidden aspect-[16/10]">
        <img
            src="{{ $post['img'] }}"
            alt="{{ $post['title'] }}"
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
            loading="lazy"
        >
    </a>
    <div class="p-4 md:p-5 flex flex-col flex-1">
        <div class="flex items-center gap-2.5 mb-2.5">
            <span class="text-[11px] font-bold uppercase tracking-wide {{ $catClass }}">{{ $post['category'] }}</span>
            <span class="text-gray-300">·</span>
            <span class="text-[11px] text-muted-foreground font-medium">{{ $post['date'] }}</span>
        </div>
        <h3 class="text-base font-extrabold text-[#011848] leading-snug mb-2 line-clamp-2 group-hover:text-primary transition-colors">
            <a href="#">{{ $post['title'] }}</a>
        </h3>
        <p class="text-sm text-muted-foreground leading-relaxed line-clamp-2 mb-4 flex-1">{{ $post['excerpt'] }}</p>
        <div class="flex items-center gap-2.5 pt-3 border-t border-border/70 mt-auto">
            <img src="{{ $post['avatar'] }}" alt="" class="w-8 h-8 rounded-full object-cover" loading="lazy">
            <span class="text-xs font-bold text-[#011848]">{{ $post['author'] }}</span>
            <span class="text-gray-300 mx-0.5">·</span>
            <span class="text-[11px] text-muted-foreground font-medium">{{ $post['readTime'] }}</span>
        </div>
    </div>
</article>
