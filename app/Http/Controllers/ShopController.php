<?php

namespace App\Http\Controllers;

class ShopController extends Controller
{
    public function index()
    {
        $products = $this->products();

        $categoryMeta = [
            ['label' => 'Mobile Phones', 'key' => 'Smartphones', 'count' => 48],
            ['label' => 'Headsets', 'key' => 'Audio', 'count' => 36],
            ['label' => 'Smart Watches', 'key' => 'Smartwatches', 'count' => 22],
            ['label' => 'Accessories', 'key' => 'Accessories', 'count' => 64],
            ['label' => 'Speakers', 'key' => 'Speakers', 'count' => 18],
            ['label' => 'Laptops', 'key' => 'Laptops', 'count' => 29],
            ['label' => 'Tablets', 'key' => 'Tablets', 'count' => 14],
            ['label' => 'Gaming', 'key' => 'Gaming', 'count' => 21],
            ['label' => 'Chargers', 'key' => 'Chargers', 'count' => 33],
            ['label' => 'Power Banks', 'key' => 'Power Banks', 'count' => 19],
        ];

        $brandMeta = [
            ['name' => 'Apple', 'count' => 42],
            ['name' => 'Samsung', 'count' => 38],
            ['name' => 'Sony', 'count' => 24],
            ['name' => 'JBL', 'count' => 16],
            ['name' => 'Anker', 'count' => 28],
            ['name' => 'Bose', 'count' => 12],
            ['name' => 'ASUS', 'count' => 15],
            ['name' => 'Xiaomi', 'count' => 20],
        ];

        return view('pages.shop', [
            'cartCount' => 2,
            'wishCount' => 0,
            'products' => $products,
            'categoryMeta' => $categoryMeta,
            'brandMeta' => $brandMeta,
            'brands' => array_column($brandMeta, 'name'),
            'categories' => array_column($categoryMeta, 'key'),
            'sortOptions' => [
                'Popularity',
                'Price: Low to High',
                'Price: High to Low',
                'Top Rated',
                'Newest',
            ],
            'maxCatalogPrice' => 600000,
            'perPage' => 12,
            'totalCatalogCount' => 240,
            'shopConfig' => [
                'perPage' => 12,
                'maxPrice' => 600000,
                'totalCount' => 240,
            ],
            'serviceFeatures' => [
                ['icon' => 'truck', 'title' => 'Free Delivery', 'sub' => 'For orders over LKR 5,000'],
                ['icon' => 'shield-check', 'title' => '1 Year Warranty', 'sub' => 'Official product warranty'],
                ['icon' => 'headphones', 'title' => '24/7 Support', 'sub' => 'Always here to help'],
                ['icon' => 'refresh', 'title' => 'Easy Returns', 'sub' => '7 days return policy'],
                ['icon' => 'credit-card', 'title' => 'Secure Payments', 'sub' => '100% secure checkout'],
            ],
        ]);
    }

    private function products(): array
    {
        return [
            ['id' => 1, 'name' => 'iPhone 15 Pro Max 256GB', 'cat' => 'Smartphones', 'brand' => 'Apple', 'price' => 499990, 'original' => 520990, 'rating' => 4.9, 'reviews' => 128, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=320&h=320&fit=crop&auto=format', 'inStock' => true, 'featured' => true],
            ['id' => 2, 'name' => 'Samsung Galaxy S24 Ultra', 'cat' => 'Smartphones', 'brand' => 'Samsung', 'price' => 389900, 'original' => 419900, 'rating' => 4.8, 'reviews' => 94, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1610945264803-c22b62d2a7b3?w=320&h=320&fit=crop&auto=format', 'inStock' => true, 'featured' => true],
            ['id' => 3, 'name' => 'Sony WH-1000XM5 Headphones', 'cat' => 'Audio', 'brand' => 'Sony', 'price' => 119900, 'original' => 149900, 'rating' => 4.9, 'reviews' => 312, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=320&h=320&fit=crop&auto=format', 'inStock' => true, 'featured' => false],
            ['id' => 4, 'name' => 'Apple AirPods Pro (2nd Gen)', 'cat' => 'Audio', 'brand' => 'Apple', 'price' => 74900, 'original' => 89900, 'rating' => 4.8, 'reviews' => 256, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1603351154351-5e2d0600bb77?w=320&h=320&fit=crop&auto=format', 'inStock' => true, 'featured' => false],
            ['id' => 5, 'name' => 'Apple Watch Series 9 GPS', 'cat' => 'Smartwatches', 'brand' => 'Apple', 'price' => 129900, 'original' => 149900, 'rating' => 4.7, 'reviews' => 87, 'badge' => null, 'img' => 'https://images.unsplash.com/photo-1544117519-31a4b719223d?w=320&h=320&fit=crop&auto=format', 'inStock' => true, 'featured' => false],
            ['id' => 6, 'name' => 'Samsung Galaxy Watch 6', 'cat' => 'Smartwatches', 'brand' => 'Samsung', 'price' => 89900, 'original' => null, 'rating' => 4.6, 'reviews' => 64, 'badge' => null, 'img' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=320&h=320&fit=crop&auto=format', 'inStock' => true, 'featured' => false],
            ['id' => 7, 'name' => 'JBL Charge 5 Portable Speaker', 'cat' => 'Speakers', 'brand' => 'JBL', 'price' => 45900, 'original' => 55900, 'rating' => 4.7, 'reviews' => 143, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=320&h=320&fit=crop&auto=format', 'inStock' => true, 'featured' => false],
            ['id' => 8, 'name' => 'Anker 65W USB-C Fast Charger', 'cat' => 'Chargers', 'brand' => 'Anker', 'price' => 12990, 'original' => 15990, 'rating' => 4.8, 'reviews' => 412, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=320&h=320&fit=crop&auto=format', 'inStock' => true, 'featured' => false],
            ['id' => 9, 'name' => 'iPad Pro 12.9" M2 Chip', 'cat' => 'Tablets', 'brand' => 'Apple', 'price' => 349900, 'original' => null, 'rating' => 4.8, 'reviews' => 76, 'badge' => null, 'img' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=320&h=320&fit=crop&auto=format', 'inStock' => true, 'featured' => false],
            ['id' => 10, 'name' => 'ASUS ROG Zephyrus G16', 'cat' => 'Laptops', 'brand' => 'ASUS', 'price' => 549900, 'original' => 599900, 'rating' => 4.5, 'reviews' => 52, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=320&h=320&fit=crop&auto=format', 'inStock' => true, 'featured' => false],
            ['id' => 11, 'name' => 'Sony PlayStation 5 Console', 'cat' => 'Gaming', 'brand' => 'Sony', 'price' => 189900, 'original' => null, 'rating' => 4.9, 'reviews' => 521, 'badge' => null, 'img' => 'https://images.unsplash.com/photo-1606144042614-b2417e99c4e3?w=320&h=320&fit=crop&auto=format', 'inStock' => false, 'featured' => false],
            ['id' => 12, 'name' => 'Bose QuietComfort 45', 'cat' => 'Audio', 'brand' => 'Bose', 'price' => 99900, 'original' => 119900, 'rating' => 4.7, 'reviews' => 198, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=320&h=320&fit=crop&auto=format', 'inStock' => true, 'featured' => false],
            ['id' => 13, 'name' => 'Logitech MX Master 3S Mouse', 'cat' => 'Accessories', 'brand' => 'Logitech', 'price' => 28900, 'original' => 34900, 'rating' => 4.7, 'reviews' => 267, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=320&h=320&fit=crop&auto=format', 'inStock' => true, 'featured' => false],
            ['id' => 14, 'name' => 'Anker PowerCore 20000mAh', 'cat' => 'Power Banks', 'brand' => 'Anker', 'price' => 18990, 'original' => 22990, 'rating' => 4.6, 'reviews' => 334, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=320&h=320&fit=crop&auto=format', 'inStock' => true, 'featured' => false],
            ['id' => 15, 'name' => 'Xiaomi Redmi Note 13 Pro', 'cat' => 'Smartphones', 'brand' => 'Xiaomi', 'price' => 89900, 'original' => 99900, 'rating' => 4.5, 'reviews' => 156, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=320&h=320&fit=crop&auto=format', 'inStock' => true, 'featured' => false],
            ['id' => 16, 'name' => 'MacBook Air 13" M3', 'cat' => 'Laptops', 'brand' => 'Apple', 'price' => 389900, 'original' => null, 'rating' => 4.9, 'reviews' => 89, 'badge' => null, 'img' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=320&h=320&fit=crop&auto=format', 'inStock' => true, 'featured' => true],
        ];
    }
}
