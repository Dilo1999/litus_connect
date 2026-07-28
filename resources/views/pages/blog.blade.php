@extends('layouts.app')

@section('title', 'Blog — LITUS Connect')
@section('meta_description', 'Stay updated with the latest tech news, product reviews, buying guides and tips from LITUS Connect.')

@section('content')

@php
    $featuredColorMap = [
        'blue' => 'text-primary',
        'green' => 'text-emerald-600',
        'orange' => 'text-orange-500',
        'purple' => 'text-violet-600',
        'cyan' => 'text-cyan-600',
        'amber' => 'text-amber-600',
    ];
    $featuredCatClass = $featuredColorMap[$featured['categoryColor'] ?? 'blue'] ?? 'text-primary';
@endphp

<div class="bg-white" data-blog-page>
    <div class="site-container py-5 md:py-7">
        <div class="flex flex-wrap items-center gap-2 text-sm text-muted-foreground mb-5">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors font-medium">Home</a>
            <x-lucide name="chevron-right" :size="13" class="text-gray-300" />
            <span class="font-bold text-[#011848]">Blog</span>
        </div>

        <div class="flex items-center justify-between mb-5 md:hidden">
            <h1 class="text-xl font-extrabold text-[#011848]">Our Blog</h1>
            <button type="button" data-blog-mobile-filters class="flex items-center gap-2 px-4 py-2.5 rounded-lg border border-border bg-white text-sm font-bold text-gray-700 hover:border-primary hover:text-primary transition-colors">
                <x-lucide name="sliders" :size="15" />
                Filters
            </button>
        </div>

        <div class="flex gap-6 lg:gap-8">
            <aside class="hidden md:block w-[260px] lg:w-[280px] flex-shrink-0 self-start sticky top-28">
                @include('components.blog_page.blog-sidebar', [
                    'categories' => $categories,
                    'recentPosts' => $recentPosts,
                    'popularTags' => $popularTags,
                ])
            </aside>

            <div class="flex-1 min-w-0">
                {{-- Page header --}}
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-6">
                    <div>
                        <h1 class="hidden md:block text-2xl md:text-3xl font-extrabold text-[#011848]">Our Blog</h1>
                        <p class="text-sm text-muted-foreground mt-1 max-w-xl">Stay updated with the latest tech news, product reviews, guides and tips.</p>
                    </div>
                    <div class="relative w-full sm:w-64 shrink-0">
                        <x-lucide name="search" :size="15" class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" />
                        <input
                            type="search"
                            data-blog-search
                            placeholder="Search blog posts..."
                            class="w-full h-11 pl-10 pr-4 rounded-lg border border-border bg-white text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 transition-all"
                        >
                    </div>
                </div>

                {{-- Featured post --}}
                <article class="bg-white rounded-2xl border border-border overflow-hidden mb-8 hover:shadow-md transition-shadow" data-blog-featured data-category="{{ $featured['category'] }}" data-title="{{ strtolower($featured['title']) }}" data-tags="{{ strtolower(implode(' ', $featured['tags'] ?? [])) }}">
                    <div class="grid grid-cols-1 lg:grid-cols-2">
                        <div class="relative aspect-[16/11] lg:aspect-auto lg:min-h-[280px] overflow-hidden">
                            <img src="{{ $featured['img'] }}" alt="{{ $featured['title'] }}" class="w-full h-full object-cover">
                            <span class="absolute top-4 left-4 inline-flex items-center px-2.5 py-1 rounded-md bg-primary text-white text-[10px] font-bold uppercase tracking-wider">Featured</span>
                        </div>
                        <div class="p-5 md:p-7 lg:p-8 flex flex-col justify-center">
                            <span class="text-[11px] font-bold uppercase tracking-wide {{ $featuredCatClass }} mb-2">{{ $featured['category'] }}</span>
                            <h2 class="text-xl md:text-2xl font-extrabold text-[#011848] leading-tight mb-3">
                                <a href="#" class="hover:text-primary transition-colors">{{ $featured['title'] }}</a>
                            </h2>
                            <p class="text-sm text-muted-foreground leading-relaxed mb-5 line-clamp-3">{{ $featured['excerpt'] }}</p>
                            <div class="flex flex-wrap items-center gap-3 mb-5">
                                <img src="{{ $featured['avatar'] }}" alt="" class="w-9 h-9 rounded-full object-cover">
                                <span class="text-sm font-bold text-[#011848]">{{ $featured['author'] }}</span>
                                <span class="text-gray-300">·</span>
                                <span class="text-xs text-muted-foreground font-medium">{{ $featured['date'] }}</span>
                                <span class="text-gray-300">·</span>
                                <span class="text-xs text-muted-foreground font-medium">{{ $featured['readTime'] }}</span>
                            </div>
                            <a href="#" class="inline-flex items-center gap-2 self-start bg-primary hover:bg-[#005266] text-white text-sm font-bold px-5 py-2.5 rounded-lg transition-colors">
                                Read More
                                <x-lucide name="arrow-right" :size="15" />
                            </a>
                        </div>
                    </div>
                </article>

                {{-- Latest Articles --}}
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg md:text-xl font-extrabold text-[#011848]">Latest Articles</h2>
                    <p class="text-xs text-muted-foreground font-medium" data-blog-count>{{ count($articles) }} articles</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-5 mb-8" data-blog-grid>
                    @foreach ($articles as $post)
                        @include('components.blog_page.blog-card', ['post' => $post])
                    @endforeach
                </div>

                <p data-blog-empty class="hidden text-center text-sm text-muted-foreground py-12">No articles match your search.</p>

                {{-- Pagination --}}
                <nav class="flex items-center justify-center gap-1.5" data-blog-pagination aria-label="Blog pagination">
                    <button type="button" data-blog-page-btn="prev" class="w-9 h-9 rounded-lg border border-border bg-white text-gray-500 hover:border-primary hover:text-primary flex items-center justify-center transition-colors disabled:opacity-40" disabled>
                        <x-lucide name="chevron-left" :size="15" />
                    </button>
                    <button type="button" data-blog-page-btn="1" class="w-9 h-9 rounded-lg bg-primary text-white text-sm font-bold">1</button>
                    <button type="button" data-blog-page-btn="2" class="w-9 h-9 rounded-lg border border-border bg-white text-sm font-bold text-gray-700 hover:border-primary hover:text-primary transition-colors">2</button>
                    <button type="button" data-blog-page-btn="3" class="w-9 h-9 rounded-lg border border-border bg-white text-sm font-bold text-gray-700 hover:border-primary hover:text-primary transition-colors">3</button>
                    <span class="px-1 text-muted-foreground text-sm">…</span>
                    <button type="button" data-blog-page-btn="8" class="w-9 h-9 rounded-lg border border-border bg-white text-sm font-bold text-gray-700 hover:border-primary hover:text-primary transition-colors">8</button>
                    <button type="button" data-blog-page-btn="next" class="w-9 h-9 rounded-lg border border-border bg-white text-gray-500 hover:border-primary hover:text-primary flex items-center justify-center transition-colors">
                        <x-lucide name="chevron-right" :size="15" />
                    </button>
                </nav>
            </div>
        </div>
    </div>

    <section class="bg-white border-y border-border/60">
        <div class="site-container">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-y-6 gap-x-4 py-7 md:py-8">
                @foreach ($serviceFeatures as $feature)
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-full bg-[#F3F5F9] flex items-center justify-center flex-shrink-0 text-[#011848]">
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

    <x-newsletter
        icon="mail"
        title="Subscribe to Our Newsletter"
        subtitle="Get tech news, reviews, and exclusive LITUS Connect updates."
    />
</div>

{{-- Mobile sidebar drawer --}}
<div data-blog-drawer class="fixed inset-0 z-50 md:hidden hidden">
    <div data-blog-drawer-overlay class="absolute inset-0 bg-black/50"></div>
    <div class="absolute right-0 top-0 bottom-0 w-80 max-w-[90vw] bg-[#F3F5F9] overflow-y-auto p-4 shadow-2xl">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-extrabold text-base text-[#011848]">Blog Filters</h2>
            <button type="button" data-blog-drawer-close class="w-9 h-9 rounded-lg border border-border bg-white flex items-center justify-center">
                <x-lucide name="x" :size="16" />
            </button>
        </div>
        @include('components.blog_page.blog-sidebar', [
            'categories' => $categories,
            'recentPosts' => $recentPosts,
            'popularTags' => $popularTags,
            'mobile' => true,
        ])
    </div>
</div>

@endsection
