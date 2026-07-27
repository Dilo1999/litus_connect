<?php

namespace App\Http\Controllers;

class BlogController extends Controller
{
    public function index()
    {
        $posts = $this->posts();
        $featured = collect($posts)->firstWhere('featured', true) ?? $posts[0];
        $articles = collect($posts)->where('featured', false)->values()->all();

        return view('pages.blog', [
            'cartCount' => 2,
            'wishCount' => 0,
            'featured' => $featured,
            'articles' => $articles,
            'categories' => [
                ['label' => 'Tech News', 'key' => 'Tech News', 'count' => 10, 'icon' => 'newspaper'],
                ['label' => 'Product Reviews', 'key' => 'Product Reviews', 'count' => 12, 'icon' => 'star'],
                ['label' => 'Buying Guides', 'key' => 'Buying Guides', 'count' => 8, 'icon' => 'book-open'],
                ['label' => 'Comparisons', 'key' => 'Comparisons', 'count' => 6, 'icon' => 'list'],
                ['label' => 'Tips & Tricks', 'key' => 'Tips & Tricks', 'count' => 15, 'icon' => 'lightbulb'],
                ['label' => 'How-To Guides', 'key' => 'How-To Guides', 'count' => 9, 'icon' => 'file-text'],
            ],
            'recentPosts' => array_slice($posts, 0, 4),
            'popularTags' => [
                'iPhone', 'Samsung', 'Review', 'Laptop', 'Audio', 'Gaming',
                'Accessories', 'Budget', '5G', 'Camera', 'Battery', 'Wearables',
            ],
            'serviceFeatures' => [
                ['icon' => 'truck', 'title' => 'Free Delivery', 'sub' => 'For orders over MVR 5,000'],
                ['icon' => 'shield-check', 'title' => '1 Year Warranty', 'sub' => 'Official product warranty'],
                ['icon' => 'headphones', 'title' => '24/7 Support', 'sub' => 'Always here to help'],
                ['icon' => 'refresh', 'title' => 'Easy Returns', 'sub' => '7 days return policy'],
                ['icon' => 'credit-card', 'title' => 'Secure Payments', 'sub' => '100% secure checkout'],
            ],
        ]);
    }

    private function posts(): array
    {
        return [
            [
                'id' => 1,
                'featured' => true,
                'title' => 'Apple Event 2024: All the Big Announcements',
                'excerpt' => 'From the latest iPhone lineup to M-series chip updates and new Wearables — here is everything announced at Apple\'s biggest event of the year.',
                'category' => 'Tech News',
                'categoryColor' => 'blue',
                'date' => 'Jun 12, 2024',
                'readTime' => '8 min read',
                'author' => 'Kasun Perera',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=96&h=96&fit=crop&auto=format',
                'img' => 'https://images.unsplash.com/photo-1496171367470-9ed9a91ea931?w=800&h=520&fit=crop&auto=format',
                'tags' => ['iPhone', 'Apple', '5G'],
            ],
            [
                'id' => 2,
                'featured' => false,
                'title' => 'iPhone 15 Pro Max In-Depth Review',
                'excerpt' => 'Is the titanium redesign and A17 Pro chip worth the upgrade? We put Apple\'s flagship through real-world tests.',
                'category' => 'Product Reviews',
                'categoryColor' => 'purple',
                'date' => 'May 10, 2024',
                'readTime' => '12 min read',
                'author' => 'Nimali Fernando',
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=96&h=96&fit=crop&auto=format',
                'img' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&h=400&fit=crop&auto=format',
                'tags' => ['iPhone', 'Review', 'Camera'],
            ],
            [
                'id' => 3,
                'featured' => false,
                'title' => 'Best Budget Smartphones in Maldives — 2025 Guide',
                'excerpt' => 'Looking for value without compromise? These phones deliver flagship features at mid-range prices.',
                'category' => 'Buying Guides',
                'categoryColor' => 'green',
                'date' => 'Jul 20, 2025',
                'readTime' => '9 min read',
                'author' => 'Dilshan Jay',
                'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=96&h=96&fit=crop&auto=format',
                'img' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600&h=400&fit=crop&auto=format',
                'tags' => ['Budget', 'Samsung', '5G'],
            ],
            [
                'id' => 4,
                'featured' => false,
                'title' => 'iPhone 15 vs Samsung S24: Which Should You Buy?',
                'excerpt' => 'A side-by-side comparison of camera, battery, display, and everyday performance to help you decide.',
                'category' => 'Comparisons',
                'categoryColor' => 'cyan',
                'date' => 'Jul 15, 2025',
                'readTime' => '10 min read',
                'author' => 'Kasun Perera',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=96&h=96&fit=crop&auto=format',
                'img' => 'https://images.unsplash.com/photo-1610945264803-c22b62d2a7b3?w=600&h=400&fit=crop&auto=format',
                'tags' => ['iPhone', 'Samsung', 'Review'],
            ],
            [
                'id' => 5,
                'featured' => false,
                'title' => 'Top Wireless Earbuds Under MVR 50,000',
                'excerpt' => 'From noise cancelling to all-day battery — these earbuds punch above their price tag.',
                'category' => 'Buying Guides',
                'categoryColor' => 'green',
                'date' => 'Jul 10, 2025',
                'readTime' => '7 min read',
                'author' => 'Nimali Fernando',
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=96&h=96&fit=crop&auto=format',
                'img' => 'https://images.unsplash.com/photo-1572536147248-ac59a8abfa4b?w=600&h=400&fit=crop&auto=format',
                'tags' => ['Audio', 'Budget', 'Review'],
            ],
            [
                'id' => 6,
                'featured' => false,
                'title' => '5 Tips to Extend Your Smartphone Battery Life',
                'excerpt' => 'Simple settings tweaks and habits that can add hours of screen time every day.',
                'category' => 'Tips & Tricks',
                'categoryColor' => 'orange',
                'date' => 'Jun 28, 2025',
                'readTime' => '5 min read',
                'author' => 'Dilshan Jay',
                'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=96&h=96&fit=crop&auto=format',
                'img' => 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=600&h=400&fit=crop&auto=format',
                'tags' => ['Battery', 'Tips', 'iPhone'],
            ],
            [
                'id' => 7,
                'featured' => false,
                'title' => 'How to Choose the Right Power Bank',
                'excerpt' => 'Capacity, wattage, ports, and safety — everything you need to pick the perfect portable charger.',
                'category' => 'How-To Guides',
                'categoryColor' => 'amber',
                'date' => 'Jul 5, 2025',
                'readTime' => '6 min read',
                'author' => 'Kasun Perera',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=96&h=96&fit=crop&auto=format',
                'img' => 'https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=600&h=400&fit=crop&auto=format',
                'tags' => ['Accessories', 'Battery', 'How-To'],
            ],
            [
                'id' => 8,
                'featured' => false,
                'title' => 'Samsung Galaxy Watch 6: Fitness Tracker Review',
                'excerpt' => 'We tested sleep tracking, workouts, and battery life to see if this wearable is worth it.',
                'category' => 'Product Reviews',
                'categoryColor' => 'purple',
                'date' => 'Jun 2, 2025',
                'readTime' => '8 min read',
                'author' => 'Nimali Fernando',
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=96&h=96&fit=crop&auto=format',
                'img' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&h=400&fit=crop&auto=format',
                'tags' => ['Wearables', 'Samsung', 'Review'],
            ],
            [
                'id' => 9,
                'featured' => false,
                'title' => 'Gaming Laptops: What Specs Actually Matter',
                'excerpt' => 'GPU, RAM, cooling, and display refresh rates decoded for first-time gaming laptop buyers.',
                'category' => 'Buying Guides',
                'categoryColor' => 'green',
                'date' => 'May 22, 2025',
                'readTime' => '11 min read',
                'author' => 'Dilshan Jay',
                'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=96&h=96&fit=crop&auto=format',
                'img' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=600&h=400&fit=crop&auto=format',
                'tags' => ['Laptop', 'Gaming', 'Budget'],
            ],
        ];
    }
}
