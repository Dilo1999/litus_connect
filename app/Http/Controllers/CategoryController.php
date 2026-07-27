<?php

namespace App\Http\Controllers;

class CategoryController extends Controller
{
    public function headsets()
    {
        return $this->render('headsets');
    }

    public function accessories()
    {
        return $this->render('accessories');
    }

    public function smartWatches()
    {
        return $this->render('smart-watches');
    }

    private function render(string $key)
    {
        $config = $this->configs()[$key];
        $products = $this->expandProducts($config['baseProducts'], $config['totalCatalogCount'], $config['idStart']);

        return view('pages.category-listing', [
            'cartCount' => 2,
            'wishCount' => 0,
            'pageTitle' => $config['pageTitle'],
            'metaDescription' => $config['metaDescription'],
            'products' => $products,
            'categoryMeta' => $config['categoryMeta'],
            'brandMeta' => $config['brandMeta'],
            'sortOptions' => [
                'Popularity',
                'Price: Low to High',
                'Price: High to Low',
                'Top Rated',
                'Newest',
            ],
            'maxCatalogPrice' => $config['maxCatalogPrice'],
            'minCatalogPrice' => $config['minCatalogPrice'],
            'perPage' => 16,
            'totalCatalogCount' => $config['totalCatalogCount'],
            'shopConfig' => [
                'perPage' => 16,
                'maxPrice' => $config['maxCatalogPrice'],
                'minPrice' => $config['minCatalogPrice'],
                'totalCount' => $config['totalCatalogCount'],
                'mode' => 'category',
            ],
            'emptyIcon' => $config['emptyIcon'],
            'emptyTitle' => $config['emptyTitle'],
            'promoTitle' => $config['promoTitle'],
            'promoSub' => $config['promoSub'],
            'promoRoute' => $config['promoRoute'],
            'promoImage' => $config['promoImage'],
            'promoAlt' => $config['promoAlt'],
            'serviceFeatures' => [
                ['icon' => 'truck', 'title' => 'Free Delivery', 'sub' => 'For orders over MVR 5,000'],
                ['icon' => 'shield-check', 'title' => '1 Year Warranty', 'sub' => 'Official product warranty'],
                ['icon' => 'headphones', 'title' => '24/7 Support', 'sub' => 'Always here to help'],
                ['icon' => 'refresh', 'title' => 'Easy Returns', 'sub' => '7 days return policy'],
                ['icon' => 'credit-card', 'title' => 'Secure Payments', 'sub' => '100% secure checkout'],
            ],
        ]);
    }

    private function expandProducts(array $base, int $total, int $idStart): array
    {
        $products = [];
        $id = $idStart;
        $index = 0;

        while (count($products) < $total) {
            $item = $base[$index % count($base)];
            $copy = $item;
            $copy['id'] = $id;
            if ($id > $idStart + count($base) - 1) {
                $copy['reviews'] = max(10, $item['reviews'] - (($id % 7) * 3));
                $copy['price'] = $item['price'] + (($id % 5) * 500);
                if (! empty($copy['original'])) {
                    $copy['original'] = $copy['price'] + 10000;
                }
            }
            $products[] = $copy;
            $id++;
            $index++;
        }

        return $products;
    }

    private function configs(): array
    {
        return [
            'headsets' => [
                'pageTitle' => 'Headsets',
                'metaDescription' => 'Shop premium headphones and earbuds at LITUS Connect. Sony, Apple, Bose, JBL and more with official warranty.',
                'emptyIcon' => 'headphones',
                'emptyTitle' => 'No headsets found',
                'promoTitle' => 'Up to 25% Off',
                'promoSub' => 'On selected headsets',
                'promoRoute' => 'headsets',
                'promoImage' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=120&h=100&fit=crop&auto=format',
                'promoAlt' => 'Headset offer',
                'minCatalogPrice' => 5000,
                'maxCatalogPrice' => 200000,
                'totalCatalogCount' => 48,
                'idStart' => 201,
                'categoryMeta' => [
                    ['label' => 'All Headsets', 'key' => 'all', 'count' => 48],
                    ['label' => 'Over-Ear', 'key' => 'Over-Ear', 'count' => 16],
                    ['label' => 'On-Ear', 'key' => 'On-Ear', 'count' => 8],
                    ['label' => 'In-Ear', 'key' => 'In-Ear', 'count' => 12],
                    ['label' => 'True Wireless', 'key' => 'True Wireless', 'count' => 10],
                    ['label' => 'Gaming', 'key' => 'Gaming', 'count' => 6],
                    ['label' => 'Noise Cancelling', 'key' => 'Noise Cancelling', 'count' => 14],
                    ['label' => 'Sports', 'key' => 'Sports', 'count' => 5],
                ],
                'brandMeta' => [
                    ['name' => 'Sony', 'count' => 12],
                    ['name' => 'Apple', 'count' => 8],
                    ['name' => 'Bose', 'count' => 7],
                    ['name' => 'JBL', 'count' => 9],
                    ['name' => 'Samsung', 'count' => 5],
                    ['name' => 'Anker', 'count' => 4],
                    ['name' => 'Logitech', 'count' => 3],
                ],
                'baseProducts' => [
                    ['name' => 'Sony WH-1000XM5 Headphones', 'series' => 'Over-Ear', 'brand' => 'Sony', 'price' => 119900, 'original' => 149900, 'rating' => 4.9, 'reviews' => 312, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
                    ['name' => 'Apple AirPods Pro (2nd Gen)', 'series' => 'True Wireless', 'brand' => 'Apple', 'price' => 74900, 'original' => 89900, 'rating' => 4.8, 'reviews' => 256, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1603351154351-5e2d0600bb77?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
                    ['name' => 'Bose QuietComfort 45', 'series' => 'Noise Cancelling', 'brand' => 'Bose', 'price' => 99900, 'original' => 119900, 'rating' => 4.7, 'reviews' => 198, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
                    ['name' => 'JBL Tune 760NC', 'series' => 'On-Ear', 'brand' => 'JBL', 'price' => 32900, 'original' => 39900, 'rating' => 4.5, 'reviews' => 144, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1484704849700-f032a568e944?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
                    ['name' => 'Samsung Galaxy Buds2 Pro', 'series' => 'True Wireless', 'brand' => 'Samsung', 'price' => 54900, 'original' => null, 'rating' => 4.6, 'reviews' => 87, 'badge' => 'NEW', 'img' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
                    ['name' => 'Anker Soundcore Life Q30', 'series' => 'Over-Ear', 'brand' => 'Anker', 'price' => 24900, 'original' => 29900, 'rating' => 4.4, 'reviews' => 221, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
                    ['name' => 'Logitech G Pro X Gaming Headset', 'series' => 'Gaming', 'brand' => 'Logitech', 'price' => 42900, 'original' => 49900, 'rating' => 4.5, 'reviews' => 96, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
                    ['name' => 'JBL Endurance Peak 3', 'series' => 'Sports', 'brand' => 'JBL', 'price' => 28900, 'original' => null, 'rating' => 4.3, 'reviews' => 64, 'badge' => 'NEW', 'img' => 'https://images.unsplash.com/photo-1603351154351-5e2d0600bb77?w=320&h=320&fit=crop&auto=format', 'inStock' => false],
                ],
            ],
            'accessories' => [
                'pageTitle' => 'Accessories',
                'metaDescription' => 'Shop phone accessories, chargers, cables, cases and more at LITUS Connect with island-wide delivery.',
                'emptyIcon' => 'package',
                'emptyTitle' => 'No accessories found',
                'promoTitle' => 'Up to 40% Off',
                'promoSub' => 'On selected accessories',
                'promoRoute' => 'accessories',
                'promoImage' => 'https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=120&h=100&fit=crop&auto=format',
                'promoAlt' => 'Accessories offer',
                'minCatalogPrice' => 990,
                'maxCatalogPrice' => 80000,
                'totalCatalogCount' => 64,
                'idStart' => 401,
                'categoryMeta' => [
                    ['label' => 'All Accessories', 'key' => 'all', 'count' => 64],
                    ['label' => 'Chargers', 'key' => 'Chargers', 'count' => 14],
                    ['label' => 'Cables', 'key' => 'Cables', 'count' => 12],
                    ['label' => 'Cases', 'key' => 'Cases', 'count' => 16],
                    ['label' => 'Power Banks', 'key' => 'Power Banks', 'count' => 10],
                    ['label' => 'Screen Protectors', 'key' => 'Screen Protectors', 'count' => 8],
                    ['label' => 'Stands & Mounts', 'key' => 'Stands', 'count' => 6],
                    ['label' => 'Adapters', 'key' => 'Adapters', 'count' => 5],
                ],
                'brandMeta' => [
                    ['name' => 'Anker', 'count' => 18],
                    ['name' => 'Apple', 'count' => 10],
                    ['name' => 'Samsung', 'count' => 9],
                    ['name' => 'Baseus', 'count' => 8],
                    ['name' => 'Spigen', 'count' => 7],
                    ['name' => 'Belkin', 'count' => 6],
                    ['name' => 'Xiaomi', 'count' => 5],
                ],
                'baseProducts' => [
                    ['name' => 'Anker 65W USB-C Fast Charger', 'series' => 'Chargers', 'brand' => 'Anker', 'price' => 12990, 'original' => 15990, 'rating' => 4.8, 'reviews' => 412, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
                    ['name' => 'Anker PowerCore 20000mAh', 'series' => 'Power Banks', 'brand' => 'Anker', 'price' => 18990, 'original' => 22990, 'rating' => 4.6, 'reviews' => 334, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
                    ['name' => 'Apple USB-C to Lightning Cable 1m', 'series' => 'Cables', 'brand' => 'Apple', 'price' => 8900, 'original' => null, 'rating' => 4.7, 'reviews' => 198, 'badge' => null, 'img' => 'https://images.unsplash.com/photo-1583394838330-e3289c0f7b4c?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
                    ['name' => 'Spigen Ultra Hybrid iPhone Case', 'series' => 'Cases', 'brand' => 'Spigen', 'price' => 5900, 'original' => 7900, 'rating' => 4.5, 'reviews' => 156, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1601784551446-20c9e07cdbdb?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
                    ['name' => 'Samsung 25W Super Fast Charger', 'series' => 'Chargers', 'brand' => 'Samsung', 'price' => 7990, 'original' => 9990, 'rating' => 4.6, 'reviews' => 221, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1583863788434-e58a36330cf0?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
                    ['name' => 'Baseus Magnetic Car Mount', 'series' => 'Stands', 'brand' => 'Baseus', 'price' => 3990, 'original' => 4990, 'rating' => 4.4, 'reviews' => 89, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
                    ['name' => 'Belkin ScreenForce Tempered Glass', 'series' => 'Screen Protectors', 'brand' => 'Belkin', 'price' => 4500, 'original' => null, 'rating' => 4.5, 'reviews' => 112, 'badge' => 'NEW', 'img' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
                    ['name' => 'Xiaomi 33W Dual Port Adapter', 'series' => 'Adapters', 'brand' => 'Xiaomi', 'price' => 3490, 'original' => 4490, 'rating' => 4.3, 'reviews' => 76, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=320&h=320&fit=crop&auto=format', 'inStock' => false],
                ],
            ],
            'smart-watches' => [
                'pageTitle' => 'Smart Watches',
                'metaDescription' => 'Shop Apple Watch, Samsung Galaxy Watch and more smartwatches at LITUS Connect with official warranty.',
                'emptyIcon' => 'watch',
                'emptyTitle' => 'No smart watches found',
                'promoTitle' => 'Up to 15% Off',
                'promoSub' => 'On selected smart watches',
                'promoRoute' => 'smart-watches',
                'promoImage' => 'https://images.unsplash.com/photo-1544117519-31a4b719223d?w=120&h=100&fit=crop&auto=format',
                'promoAlt' => 'Smart watch offer',
                'minCatalogPrice' => 15000,
                'maxCatalogPrice' => 250000,
                'totalCatalogCount' => 40,
                'idStart' => 301,
                'categoryMeta' => [
                    ['label' => 'All Smart Watches', 'key' => 'all', 'count' => 40],
                    ['label' => 'Apple Watch', 'key' => 'Apple Watch', 'count' => 12],
                    ['label' => 'Galaxy Watch', 'key' => 'Galaxy Watch', 'count' => 10],
                    ['label' => 'Fitness Bands', 'key' => 'Fitness', 'count' => 8],
                    ['label' => 'GPS Models', 'key' => 'GPS', 'count' => 9],
                    ['label' => 'Cellular', 'key' => 'Cellular', 'count' => 5],
                    ['label' => 'Kids', 'key' => 'Kids', 'count' => 4],
                    ['label' => 'Luxury', 'key' => 'Luxury', 'count' => 3],
                ],
                'brandMeta' => [
                    ['name' => 'Apple', 'count' => 12],
                    ['name' => 'Samsung', 'count' => 10],
                    ['name' => 'Xiaomi', 'count' => 6],
                    ['name' => 'Huawei', 'count' => 4],
                    ['name' => 'Garmin', 'count' => 3],
                    ['name' => 'Amazfit', 'count' => 3],
                    ['name' => 'Fitbit', 'count' => 2],
                ],
                'baseProducts' => [
                    ['name' => 'Apple Watch Series 9 GPS', 'series' => 'Apple Watch', 'brand' => 'Apple', 'price' => 129900, 'original' => 149900, 'rating' => 4.7, 'reviews' => 87, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1544117519-31a4b719223d?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
                    ['name' => 'Samsung Galaxy Watch 6', 'series' => 'Galaxy Watch', 'brand' => 'Samsung', 'price' => 89900, 'original' => null, 'rating' => 4.6, 'reviews' => 64, 'badge' => 'NEW', 'img' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
                    ['name' => 'Apple Watch SE (2nd Gen)', 'series' => 'Apple Watch', 'brand' => 'Apple', 'price' => 79900, 'original' => 89900, 'rating' => 4.6, 'reviews' => 142, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1434493789847-2f02dc6ca35d?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
                    ['name' => 'Samsung Galaxy Watch 6 Classic', 'series' => 'Galaxy Watch', 'brand' => 'Samsung', 'price' => 109900, 'original' => 119900, 'rating' => 4.7, 'reviews' => 58, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
                    ['name' => 'Xiaomi Redmi Watch 4', 'series' => 'Fitness', 'brand' => 'Xiaomi', 'price' => 19900, 'original' => 24900, 'rating' => 4.3, 'reviews' => 210, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
                    ['name' => 'Huawei Watch GT 4', 'series' => 'GPS', 'brand' => 'Huawei', 'price' => 69900, 'original' => null, 'rating' => 4.5, 'reviews' => 73, 'badge' => 'NEW', 'img' => 'https://images.unsplash.com/photo-1551816230-ef5deaed4a26?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
                    ['name' => 'Garmin Venu Sq 2', 'series' => 'GPS', 'brand' => 'Garmin', 'price' => 84900, 'original' => 94900, 'rating' => 4.6, 'reviews' => 41, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1575311373937-040b8e1fd5b6?w=320&h=320&fit=crop&auto=format', 'inStock' => true],
                    ['name' => 'Amazfit GTR 4', 'series' => 'Luxury', 'brand' => 'Amazfit', 'price' => 54900, 'original' => 64900, 'rating' => 4.4, 'reviews' => 55, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=320&h=320&fit=crop&auto=format', 'inStock' => false],
                ],
            ],
        ];
    }
}
