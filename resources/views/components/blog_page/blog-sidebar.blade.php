@props([
    'categories' => [],
    'recentPosts' => [],
    'popularTags' => [],
    'mobile' => false,
])

<div class="flex flex-col gap-5" data-blog-sidebar>
    {{-- Categories --}}
    <div class="bg-white rounded-2xl border border-border p-5">
        <h3 class="text-sm font-extrabold text-[#011848] mb-4">Categories</h3>
        <ul class="flex flex-col gap-1">
            <li>
                <button
                    type="button"
                    data-blog-category="all"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-colors bg-blue-light text-primary"
                >
                    <x-lucide name="layout-grid" :size="15" class="text-primary" />
                    <span class="flex-1 text-left">All Posts</span>
                </button>
            </li>
            @foreach ($categories as $cat)
                <li>
                    <button
                        type="button"
                        data-blog-category="{{ $cat['key'] }}"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-[#F7F8FA] hover:text-primary transition-colors"
                    >
                        <x-lucide :name="$cat['icon']" :size="15" class="text-gray-400" />
                        <span class="flex-1 text-left">{{ $cat['label'] }}</span>
                        <span class="text-xs text-muted-foreground font-semibold">({{ $cat['count'] }})</span>
                    </button>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Recent Posts --}}
    <div class="bg-white rounded-2xl border border-border p-5">
        <h3 class="text-sm font-extrabold text-[#011848] mb-4">Recent Posts</h3>
        <ul class="flex flex-col gap-4">
            @foreach ($recentPosts as $post)
                <li>
                    <a href="#" class="flex gap-3 group">
                        <div class="w-16 h-16 rounded-lg overflow-hidden shrink-0 bg-[#F3F5F9]">
                            <img src="{{ $post['img'] }}" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform" loading="lazy">
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-[#011848] leading-snug line-clamp-2 group-hover:text-primary transition-colors">{{ $post['title'] }}</p>
                            <p class="text-[11px] text-muted-foreground mt-1 font-medium">{{ $post['date'] }}</p>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Popular Tags --}}
    <div class="bg-white rounded-2xl border border-border p-5">
        <h3 class="text-sm font-extrabold text-[#011848] mb-4">Popular Tags</h3>
        <div class="flex flex-wrap gap-2">
            @foreach ($popularTags as $tag)
                <button
                    type="button"
                    data-blog-tag="{{ $tag }}"
                    class="px-3 py-1.5 rounded-full bg-[#F3F5F9] text-xs font-semibold text-gray-600 hover:bg-primary hover:text-white transition-colors"
                >
                    {{ $tag }}
                </button>
            @endforeach
        </div>
    </div>

</div>
