<?php

namespace App\Http\Controllers;

class MobilePhonesController extends Controller
{
    public function index()
    {
        $products = $this->products();

        return view('pages.mobile-phones', [
            'cartCount' => 2,
            'wishCount' => 0,
            'pageTitle' => 'Mobile Phones',
            'products' => $products,
            'categoryMeta' => [
                ['label' => 'All Mobile Phones', 'key' => 'all', 'count' => 96],
                ['label' => 'iPhone', 'key' => 'iPhone', 'count' => 24],
                ['label' => 'Samsung', 'key' => 'Samsung', 'count' => 28],
                ['label' => 'Xiaomi', 'key' => 'Xiaomi', 'count' => 18],
                ['label' => 'Google Pixel', 'key' => 'Google', 'count' => 8],
                ['label' => 'OnePlus', 'key' => 'OnePlus', 'count' => 10],
                ['label' => 'Nothing', 'key' => 'Nothing', 'count' => 4],
                ['label' => 'OPPO', 'key' => 'OPPO', 'count' => 12],
                ['label' => 'Vivo', 'key' => 'Vivo', 'count' => 9],
                ['label' => 'Realme', 'key' => 'Realme', 'count' => 7],
            ],
            'brandMeta' => [
                ['name' => 'Apple', 'count' => 24],
                ['name' => 'Samsung', 'count' => 28],
                ['name' => 'Xiaomi', 'count' => 18],
                ['name' => 'Google', 'count' => 8],
                ['name' => 'OnePlus', 'count' => 10],
                ['name' => 'Nothing', 'count' => 4],
                ['name' => 'OPPO', 'count' => 12],
                ['name' => 'Vivo', 'count' => 9],
            ],
            'sortOptions' => [
                'Popularity',
                'Price: Low to High',
                'Price: High to Low',
                'Top Rated',
                'Newest',
            ],
            'maxCatalogPrice' => 600000,
            'minCatalogPrice' => 25000,
            'perPage' => 16,
            'totalCatalogCount' => 96,
            'shopConfig' => [
                'perPage' => 16,
                'maxPrice' => 600000,
                'minPrice' => 25000,
                'totalCount' => 96,
                'mode' => 'mobile-phones',
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

    private function products(): array
    {
        $base = [
            ['name' => 'iPhone 15 Pro Max 256GB', 'series' => 'iPhone', 'brand' => 'Apple', 'price' => 499990, 'original' => 520990, 'rating' => 4.9, 'reviews' => 128, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
            ['name' => 'Samsung Galaxy S24 Ultra 256GB', 'series' => 'Samsung', 'brand' => 'Samsung', 'price' => 389900, 'original' => 419900, 'rating' => 4.8, 'reviews' => 94, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1610945264803-c22b62d2a7b3?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
            ['name' => 'iPhone 15 128GB', 'series' => 'iPhone', 'brand' => 'Apple', 'price' => 289900, 'original' => null, 'rating' => 4.8, 'reviews' => 156, 'badge' => 'NEW', 'img' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
            ['name' => 'Xiaomi 14 Ultra 512GB', 'series' => 'Xiaomi', 'brand' => 'Xiaomi', 'price' => 259900, 'original' => 289900, 'rating' => 4.7, 'reviews' => 67, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
            ['name' => 'Google Pixel 8 Pro 256GB', 'series' => 'Google', 'brand' => 'Google', 'price' => 299900, 'original' => null, 'rating' => 4.8, 'reviews' => 82, 'badge' => 'NEW', 'img' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
            ['name' => 'Samsung Galaxy A55 5G 128GB', 'series' => 'Samsung', 'brand' => 'Samsung', 'price' => 89900, 'original' => 99900, 'rating' => 4.5, 'reviews' => 143, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1610945264803-c22b62d2a7b3?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
            ['name' => 'OnePlus 12 256GB', 'series' => 'OnePlus', 'brand' => 'OnePlus', 'price' => 189900, 'original' => 209900, 'rating' => 4.6, 'reviews' => 58, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
            ['name' => 'iPhone 14 Pro 128GB', 'series' => 'iPhone', 'brand' => 'Apple', 'price' => 349900, 'original' => 379900, 'rating' => 4.8, 'reviews' => 211, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1663499482523-1c0c1bae4ce1?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
            ['name' => 'Nothing Phone (2) 256GB', 'series' => 'Nothing', 'brand' => 'Nothing', 'price' => 149900, 'original' => null, 'rating' => 4.4, 'reviews' => 39, 'badge' => 'NEW', 'img' => 'https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
            ['name' => 'OPPO Find X7 Pro 512GB', 'series' => 'OPPO', 'brand' => 'OPPO', 'price' => 229900, 'original' => 249900, 'rating' => 4.5, 'reviews' => 44, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
            ['name' => 'Samsung Galaxy Z Flip5', 'series' => 'Samsung', 'brand' => 'Samsung', 'price' => 279900, 'original' => null, 'rating' => 4.6, 'reviews' => 71, 'badge' => null, 'img' => 'https://images.unsplash.com/photo-1610945264803-c22b62d2a7b3?w=320&h=320&fit=crop&auto=format', 'inStock' => false],
            ['name' => 'Xiaomi Redmi Note 13 Pro', 'series' => 'Xiaomi', 'brand' => 'Xiaomi', 'price' => 69900, 'original' => 79900, 'rating' => 4.4, 'reviews' => 188, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
            ['name' => 'iPhone 13 128GB', 'series' => 'iPhone', 'brand' => 'Apple', 'price' => 199900, 'original' => 219900, 'rating' => 4.7, 'reviews' => 302, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1632661674596-df8be070a5c9?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
            ['name' => 'Google Pixel 8a 128GB', 'series' => 'Google', 'brand' => 'Google', 'price' => 129900, 'original' => null, 'rating' => 4.6, 'reviews' => 55, 'badge' => 'NEW', 'img' => 'https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
            ['name' => 'Vivo V30 Pro 256GB', 'series' => 'Vivo', 'brand' => 'Vivo', 'price' => 119900, 'original' => 134900, 'rating' => 4.3, 'reviews' => 36, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
            ['name' => 'OnePlus Nord 4 256GB', 'series' => 'OnePlus', 'brand' => 'OnePlus', 'price' => 99900, 'original' => 109900, 'rating' => 4.5, 'reviews' => 49, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
        ];

        $products = [];
        $id = 1;
        while (count($products) < 96) {
            foreach ($base as $item) {
                if (count($products) >= 96) {
                    break;
                }
                $copy = $item;
                $copy['id'] = $id;
                if ($id > 16) {
                    $copy['reviews'] = max(10, $item['reviews'] - (($id % 7) * 3));
                    $copy['price'] = $item['price'] + (($id % 5) * 1000);
                    if ($copy['original']) {
                        $copy['original'] = $copy['price'] + 20000;
                    }
                }
                $products[] = $copy;
                $id++;
            }
        }

        return $products;
    }
}
