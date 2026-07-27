<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.home', [
            'cartCount' => 2,
            'wishCount' => 0,
            'navCategories' => $this->navCategories(),
            'navLinks' => $this->navLinks(),
            'heroSlides' => $this->heroSlides(),
            'serviceFeatures' => $this->serviceFeatures(),
            'quickCategories' => $this->quickCategories(),
            'promoBanners' => $this->promoBanners(),
            'categories' => $this->categories(),
            'products' => $this->products(),
            'brands' => $this->brands(),
            'whyUs' => $this->whyUs(),
            'testimonials' => $this->testimonials(),
            'blogPosts' => $this->blogPosts(),
        ]);
    }

    private function navCategories(): array
    {
        return [
            ['label' => 'Mobile Phones', 'icon' => 'smartphone'],
            ['label' => 'Headsets', 'icon' => 'headphones'],
            ['label' => 'Smart Watches', 'icon' => 'watch'],
            ['label' => 'Accessories', 'icon' => 'package'],
            ['label' => 'Speakers', 'icon' => 'speaker'],
            ['label' => 'Laptops', 'icon' => 'laptop'],
            ['label' => 'Cables', 'icon' => 'battery'],
            ['label' => 'Tablets', 'icon' => 'monitor'],
            ['label' => 'Power Banks', 'icon' => 'zap'],
            ['label' => 'Gaming', 'icon' => 'gamepad'],
        ];
    }

    private function navLinks(): array
    {
        return [
            ['label' => 'Home', 'active' => true, 'route' => 'home'],
            ['label' => 'Shop', 'active' => false, 'route' => null],
            ['label' => 'Mobile Phones', 'active' => false, 'route' => null],
            ['label' => 'Headsets', 'active' => false, 'route' => null],
            ['label' => 'Accessories', 'active' => false, 'route' => null],
            ['label' => 'Smart Watches', 'active' => false, 'route' => null],
            ['label' => 'Offers', 'active' => false, 'route' => null],
            ['label' => 'Blog', 'active' => false, 'route' => null],
            ['label' => 'Contact Us', 'active' => false, 'route' => null],
        ];
    }

    private function heroSlides(): array
    {
        return [
            [
                'eyebrow' => 'NEW ARRIVAL',
                'headline' => "iPhone 15 Pro\nTitanium. So strong.\nSo light. So Pro.",
                'sub' => 'The ultimate iPhone experience. Now available at LITUS Connect.',
                'cta' => 'Shop Now',
                'bg' => 'linear-gradient(105deg, #0b1426 0%, #152a4a 45%, #1a3358 100%)',
                'img' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=720&h=520&fit=crop&auto=format',
            ],
            [
                'eyebrow' => 'HOT DEAL',
                'headline' => "Samsung Galaxy S24\nBoldly\nIntelligent.",
                'sub' => 'AI-powered features that help you do more every day.',
                'cta' => 'Shop Now',
                'bg' => 'linear-gradient(105deg, #0a1628 0%, #122848 50%, #163058 100%)',
                'img' => 'https://images.unsplash.com/photo-1610945264803-c22b62d2a7b3?w=720&h=520&fit=crop&auto=format',
            ],
            [
                'eyebrow' => 'TOP RATED',
                'headline' => "Sony WH-1000XM5\nHear What\nMatters.",
                'sub' => 'Industry-leading noise cancellation. Now in store.',
                'cta' => 'Shop Now',
                'bg' => 'linear-gradient(105deg, #0c0c14 0%, #16162a 50%, #1a1a32 100%)',
                'img' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=720&h=520&fit=crop&auto=format',
            ],
        ];
    }

    private function serviceFeatures(): array
    {
        return [
            ['icon' => 'truck', 'title' => 'Free Delivery', 'sub' => 'For orders over MVR 5,000'],
            ['icon' => 'shield-check', 'title' => '1 Year Warranty', 'sub' => 'Official product warranty'],
            ['icon' => 'headphones', 'title' => '24/7 Support', 'sub' => 'Always here to help'],
            ['icon' => 'refresh', 'title' => 'Easy Returns', 'sub' => '7 days return policy'],
            ['icon' => 'credit-card', 'title' => 'Secure Payments', 'sub' => '100% secure checkout'],
        ];
    }

    private function quickCategories(): array
    {
        return [
            ['label' => 'Mobile Phones', 'img' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=120&h=120&fit=crop&auto=format'],
            ['label' => 'Headsets', 'img' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=120&h=120&fit=crop&auto=format'],
            ['label' => 'Smart Watches', 'img' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=120&h=120&fit=crop&auto=format'],
            ['label' => 'Accessories', 'img' => 'https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=120&h=120&fit=crop&auto=format'],
            ['label' => 'Speakers', 'img' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=120&h=120&fit=crop&auto=format'],
            ['label' => 'Laptops', 'img' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=120&h=120&fit=crop&auto=format'],
            ['label' => 'Cables', 'img' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=120&h=120&fit=crop&auto=format'],
            ['label' => 'View All', 'img' => null, 'icon' => 'arrow-right'],
        ];
    }

    private function promoBanners(): array
    {
        return [
            [
                'title' => 'Up to 30% Off',
                'sub' => 'On Selected Headsets',
                'cta' => 'Shop Now',
                'bg' => '#E8F1FF',
                'btn' => '#1464F4',
                'img' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=220&h=160&fit=crop&auto=format',
            ],
            [
                'title' => 'Power Banks',
                'sub' => 'From MVR 2,990',
                'cta' => 'Shop Now',
                'bg' => '#F0E8FF',
                'btn' => '#7C3AED',
                'img' => 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=220&h=160&fit=crop&auto=format',
            ],
            [
                'title' => 'Up to 25% Off',
                'sub' => 'Premium Chargers & Cables',
                'cta' => 'Shop Now',
                'bg' => '#E6F7EF',
                'btn' => '#059669',
                'img' => 'https://images.unsplash.com/photo-1583863788434-e58a36330cf0?w=220&h=160&fit=crop&auto=format',
            ],
        ];
    }

    private function categories(): array
    {
        return [
            ['name' => 'Smartphones', 'discount' => 'Up to 30% OFF', 'img' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=200&h=200&fit=crop&auto=format'],
            ['name' => 'Laptops', 'discount' => 'Up to 20% OFF', 'img' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=200&h=200&fit=crop&auto=format'],
            ['name' => 'Headsets', 'discount' => 'Up to 35% OFF', 'img' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=200&h=200&fit=crop&auto=format'],
            ['name' => 'Smart Watches', 'discount' => 'Up to 25% OFF', 'img' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=200&h=200&fit=crop&auto=format'],
            ['name' => 'Accessories', 'discount' => 'Up to 40% OFF', 'img' => 'https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=200&h=200&fit=crop&auto=format'],
            ['name' => 'Speakers', 'discount' => 'Up to 15% OFF', 'img' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=200&h=200&fit=crop&auto=format'],
        ];
    }

    private function products(): array
    {
        return [
            ['id' => 8, 'name' => 'iPhone 14 Pro 128GB', 'price' => 349900, 'original' => 379900, 'rating' => 4.9, 'reviews' => 128, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=280&h=280&fit=crop&auto=format'],
            ['id' => 103, 'name' => 'AirPods Pro (2nd Gen)', 'price' => 74900, 'original' => 89900, 'rating' => 4.8, 'reviews' => 256, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1603351154351-5e2d0600bb77?w=280&h=280&fit=crop&auto=format'],
            ['id' => 104, 'name' => 'Samsung Galaxy Watch 6', 'price' => 89900, 'original' => 109900, 'rating' => 4.7, 'reviews' => 94, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1544117519-31a4b719223d?w=280&h=280&fit=crop&auto=format'],
            ['id' => 101, 'name' => 'Sony WH-1000XM5', 'price' => 119900, 'original' => 149900, 'rating' => 4.9, 'reviews' => 312, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=280&h=280&fit=crop&auto=format'],
            ['id' => 112, 'name' => 'Anker PowerCore 20K', 'price' => 18990, 'original' => 22990, 'rating' => 4.6, 'reviews' => 187, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=280&h=280&fit=crop&auto=format'],
        ];
    }

    private function brands(): array
    {
        return [
            ['name' => 'Apple', 'logo' => 'images/logo/apple.png'],
            ['name' => 'Samsung', 'logo' => 'images/logo/samsung.png'],
            ['name' => 'Sony', 'logo' => 'images/logo/sony.png'],
            ['name' => 'JBL', 'logo' => 'images/logo/JBL-Logo.svg.webp', 'compact' => true],
            ['name' => 'Anker', 'logo' => 'images/logo/anker.png'],
            ['name' => 'Xiaomi', 'logo' => 'images/logo/mi.png', 'compact' => true],
            ['name' => 'Bose', 'logo' => 'images/logo/bose.png'],
        ];
    }

    private function whyUs(): array
    {
        return [
            ['icon' => 'shield-check', 'title' => '100% Original Products', 'sub' => 'Sourced directly from brands'],
            ['icon' => 'award', 'title' => 'Best Prices Guaranteed', 'sub' => 'Unbeatable prices every day'],
            ['icon' => 'lock', 'title' => 'Safe & Secure Checkout', 'sub' => 'Multiple secure payment options'],
            ['icon' => 'users', 'title' => 'Trusted by Thousands', 'sub' => '10,000+ happy customers'],
        ];
    }

    private function testimonials(): array
    {
        return [
            [
                'name' => 'Kasun Perera',
                'role' => 'Verified Buyer',
                'rating' => 5,
                'text' => 'Ordered an iPhone 15 Pro and it arrived the next day. Packaging was perfect and the price was better than other stores.',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=96&h=96&fit=crop&auto=format',
            ],
            [
                'name' => 'Nimali Fernando',
                'role' => 'Verified Buyer',
                'rating' => 5,
                'text' => 'Great selection of accessories and very helpful support. My AirPods were authentic and came with full warranty.',
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=96&h=96&fit=crop&auto=format',
            ],
            [
                'name' => 'Dilshan Jay',
                'role' => 'Verified Buyer',
                'rating' => 5,
                'text' => 'LITUS Connect is my go-to for gadgets. Fast delivery, genuine products, and excellent after-sales service.',
                'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=96&h=96&fit=crop&auto=format',
            ],
        ];
    }

    private function blogPosts(): array
    {
        return [
            [
                'title' => 'Best Budget Smartphones in Maldives — 2025 Guide',
                'date' => 'Jul 20, 2025',
                'category' => 'TECH GUIDES',
                'img' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&h=240&fit=crop&auto=format',
            ],
            [
                'title' => 'iPhone 15 vs Samsung S24: Which Should You Buy?',
                'date' => 'Jul 15, 2025',
                'category' => 'COMPARISONS',
                'img' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=400&h=240&fit=crop&auto=format',
            ],
            [
                'title' => 'Top Wireless Earbuds Under MVR 50,000',
                'date' => 'Jul 10, 2025',
                'category' => 'AUDIO',
                'img' => 'https://images.unsplash.com/photo-1572536147248-ac59a8abfa4b?w=400&h=240&fit=crop&auto=format',
            ],
            [
                'title' => 'How to Choose the Right Power Bank',
                'date' => 'Jul 5, 2025',
                'category' => 'ACCESSORIES',
                'img' => 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=400&h=240&fit=crop&auto=format',
            ],
        ];
    }
}
