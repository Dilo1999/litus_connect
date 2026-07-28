<?php

namespace App\Http\Controllers;

class OffersController extends Controller
{
    public function index()
    {
        $topDeals = $this->withSavings([
            ['id' => 1, 'name' => 'iPhone 15 Pro Max 256GB', 'price' => 499990, 'original' => 529990, 'discount' => 5, 'img' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=320&h=320&fit=crop&auto=format', 'cat' => 'Mobile Phones', 'brand' => 'Apple'],
            ['id' => 2, 'name' => 'Samsung Galaxy S24 Ultra', 'price' => 389900, 'original' => 419900, 'discount' => 7, 'img' => 'https://images.unsplash.com/photo-1610945264803-c22b62d2a7b3?w=320&h=320&fit=crop&auto=format', 'cat' => 'Mobile Phones', 'brand' => 'Samsung'],
            ['id' => 101, 'name' => 'Sony WH-1000XM5 Headphones', 'price' => 119900, 'original' => 149900, 'discount' => 20, 'img' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=320&h=320&fit=crop&auto=format', 'cat' => 'Headsets', 'brand' => 'Sony'],
            ['id' => 102, 'name' => 'Apple Watch Series 9 GPS', 'price' => 129900, 'original' => 149900, 'discount' => 13, 'img' => 'https://images.unsplash.com/photo-1544117519-31a4b719223d?w=320&h=320&fit=crop&auto=format', 'cat' => 'Smart Watches', 'brand' => 'Apple'],
            ['id' => 103, 'name' => 'Apple AirPods Pro (2nd Gen)', 'price' => 74900, 'original' => 89900, 'discount' => 16, 'img' => 'https://images.unsplash.com/photo-1603351154351-5e2d0600bb77?w=320&h=320&fit=crop&auto=format', 'cat' => 'Headsets', 'brand' => 'Apple'],
        ]);

        $hotOffers = $this->withSavings([
            ['id' => 106, 'name' => 'Anker 65W USB-C Fast Charger', 'price' => 12990, 'original' => 15990, 'discount' => 18, 'img' => 'https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=320&h=320&fit=crop&auto=format', 'cat' => 'Accessories', 'brand' => 'Anker'],
            ['id' => 112, 'name' => 'Anker PowerCore 20000mAh', 'price' => 18990, 'original' => 22990, 'discount' => 17, 'img' => 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=320&h=320&fit=crop&auto=format', 'cat' => 'Accessories', 'brand' => 'Anker'],
            ['id' => 110, 'name' => 'Bose QuietComfort 45', 'price' => 99900, 'original' => 119900, 'discount' => 16, 'img' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=320&h=320&fit=crop&auto=format', 'cat' => 'Headsets', 'brand' => 'Bose'],
            ['id' => 12, 'name' => 'Xiaomi Redmi Note 13 Pro', 'price' => 69900, 'original' => 79900, 'discount' => 12, 'img' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=320&h=320&fit=crop&auto=format', 'cat' => 'Mobile Phones', 'brand' => 'Xiaomi'],
            ['id' => 104, 'name' => 'Samsung Galaxy Watch 6', 'price' => 89900, 'original' => 109900, 'discount' => 18, 'img' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=320&h=320&fit=crop&auto=format', 'cat' => 'Smart Watches', 'brand' => 'Samsung'],
            ['id' => 105, 'name' => 'JBL Charge 5 Portable Speaker', 'price' => 45900, 'original' => 55900, 'discount' => 17, 'img' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=320&h=320&fit=crop&auto=format', 'cat' => 'Speakers', 'brand' => 'JBL'],
        ]);

        return view('pages.offers', [
            'cartCount' => 2,
            'wishCount' => 0,
            'topDeals' => $topDeals,
            'hotOffers' => $hotOffers,
            'offerCategories' => [
                ['label' => 'All Offers', 'key' => 'all', 'count' => 86, 'route' => null],
                ['label' => 'Mobile Phones', 'key' => 'Mobile Phones', 'count' => 24, 'route' => 'mobile-phones'],
                ['label' => 'Accessories', 'key' => 'Accessories', 'count' => 18, 'route' => 'accessories'],
                ['label' => 'Headsets', 'key' => 'Headsets', 'count' => 16, 'route' => 'headsets'],
                ['label' => 'Smart Watches', 'key' => 'Smart Watches', 'count' => 12, 'route' => 'smart-watches'],
                ['label' => 'Speakers', 'key' => 'Speakers', 'count' => 8, 'route' => null],
                ['label' => 'Laptops', 'key' => 'Laptops', 'count' => 8, 'route' => null],
            ],
            'quickCategories' => [
                ['label' => 'Mobile Phones', 'count' => 24, 'icon' => 'smartphone', 'route' => 'mobile-phones', 'img' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=120&h=120&fit=crop&auto=format'],
                ['label' => 'Accessories', 'count' => 18, 'icon' => 'package', 'route' => 'accessories', 'img' => 'https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=120&h=120&fit=crop&auto=format'],
                ['label' => 'Headsets', 'count' => 16, 'icon' => 'headphones', 'route' => 'headsets', 'img' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=120&h=120&fit=crop&auto=format'],
                ['label' => 'Smart Watches', 'count' => 12, 'icon' => 'watch', 'route' => 'smart-watches', 'img' => 'https://images.unsplash.com/photo-1544117519-31a4b719223d?w=120&h=120&fit=crop&auto=format'],
                ['label' => 'Speakers', 'count' => 8, 'icon' => 'speaker', 'route' => 'shop', 'img' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=120&h=120&fit=crop&auto=format'],
            ],
            'brandMeta' => [
                ['name' => 'Apple', 'count' => 18],
                ['name' => 'Samsung', 'count' => 16],
                ['name' => 'Anker', 'count' => 12],
                ['name' => 'Sony', 'count' => 10],
                ['name' => 'JBL', 'count' => 8],
                ['name' => 'Xiaomi', 'count' => 9],
                ['name' => 'Bose', 'count' => 6],
            ],
            'midPromos' => [
                [
                    'title' => 'Accessories Sale',
                    'sub' => 'Up to 40% Off',
                    'route' => 'accessories',
                    'bg' => 'linear-gradient(135deg, #059669 0%, #047857 100%)',
                    'img' => 'https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=200&h=160&fit=crop&auto=format',
                ],
                [
                    'title' => 'Smart Watch Deals',
                    'sub' => 'Up to 20% Off',
                    'route' => 'smart-watches',
                    'bg' => 'linear-gradient(135deg, #006786 0%, #006786 100%)',
                    'img' => 'https://images.unsplash.com/photo-1544117519-31a4b719223d?w=200&h=160&fit=crop&auto=format',
                ],
                [
                    'title' => 'Audio Bonanza',
                    'sub' => 'Up to 30% Off',
                    'route' => 'headsets',
                    'bg' => 'linear-gradient(135deg, #7C3AED 0%, #5B21B6 100%)',
                    'img' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=200&h=160&fit=crop&auto=format',
                ],
            ],
            'trustHighlights' => [
                ['icon' => 'tag', 'title' => 'Best Prices Guaranteed'],
                ['icon' => 'clock', 'title' => 'Limited Time Offers'],
                ['icon' => 'shield-check', 'title' => '100% Original Products'],
            ],
            'serviceFeatures' => [
                ['icon' => 'truck', 'title' => 'Free Delivery', 'sub' => 'For orders over MVR 5,000'],
                ['icon' => 'shield-check', 'title' => '1 Year Warranty', 'sub' => 'Official product warranty'],
                ['icon' => 'headphones', 'title' => '24/7 Support', 'sub' => 'Always here to help'],
                ['icon' => 'refresh', 'title' => 'Easy Returns', 'sub' => '7 days return policy'],
                ['icon' => 'credit-card', 'title' => 'Secure Payments', 'sub' => '100% secure checkout'],
            ],
            'countdownEndsAt' => now()->addDays(3)->addHours(14)->addMinutes(22)->addSeconds(45)->timestamp * 1000,
        ]);
    }

    private function withSavings(array $items): array
    {
        return array_map(function (array $item) {
            $item['save'] = max(0, ($item['original'] ?? $item['price']) - $item['price']);
            if (empty($item['discount']) && ! empty($item['original'])) {
                $item['discount'] = (int) round((($item['original'] - $item['price']) / $item['original']) * 100);
            }

            return $item;
        }, $items);
    }
}
