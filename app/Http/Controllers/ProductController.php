<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function show(int $id)
    {
        $product = $this->findProduct($id);

        if (! $product) {
            abort(404);
        }

        $related = collect($this->catalog())
            ->reject(fn ($item) => $item['id'] === $product['id'])
            ->filter(fn ($item) => ($item['brand'] ?? null) === ($product['brand'] ?? null)
                || ($item['cat'] ?? null) === ($product['cat'] ?? null))
            ->take(5)
            ->values()
            ->all();

        if (count($related) < 5) {
            $related = collect($this->catalog())
                ->reject(fn ($item) => $item['id'] === $product['id'])
                ->take(5)
                ->values()
                ->all();
        }

        return view('pages.product-details', [
            'cartCount' => 2,
            'wishCount' => 0,
            'product' => $product,
            'related' => $related,
            'trustBar' => [
                ['icon' => 'truck', 'label' => 'Free Delivery'],
                ['icon' => 'shield-check', 'label' => '1 Year Warranty'],
                ['icon' => 'refresh', 'label' => 'Easy Returns'],
                ['icon' => 'lock', 'label' => 'Secure Checkout'],
            ],
        ]);
    }

    private function findProduct(int $id): ?array
    {
        foreach ($this->catalog() as $product) {
            if ((int) $product['id'] === $id) {
                return $this->enrich($product);
            }
        }

        // Fallback for catalog clones
        $baseId = null;
        if ($id >= 201 && $id < 300) {
            $baseId = 201 + (($id - 201) % 8);
        } elseif ($id >= 301 && $id < 400) {
            $baseId = 301 + (($id - 301) % 8);
        } elseif ($id >= 401 && $id < 500) {
            $baseId = 401 + (($id - 401) % 8);
        } elseif ($id >= 1 && $id <= 96) {
            $baseId = (($id - 1) % 16) + 1;
        }

        if ($baseId) {
            foreach ($this->catalog() as $product) {
                if ((int) $product['id'] === $baseId) {
                    $copy = $this->enrich($product);
                    $copy['id'] = $id;
                    $copy['price'] = $product['price'] + (($id % 5) * 500);
                    if (! empty($copy['original'])) {
                        $copy['original'] = $copy['price'] + 10000;
                    }

                    return $copy;
                }
            }
        }

        return null;
    }

    private function enrich(array $product): array
    {
        $slug = Str::slug($product['name']);
        $discount = ! empty($product['original'])
            ? (int) round((($product['original'] - $product['price']) / $product['original']) * 100)
            : null;

        $defaults = [
            'slug' => $slug,
            'sku' => 'TZ-' . str_pad((string) $product['id'], 5, '0', STR_PAD_LEFT),
            'discount' => $discount,
            'bestSeller' => $product['bestSeller'] ?? (($product['reviews'] ?? 0) >= 100),
            'qaCount' => $product['qaCount'] ?? 18,
            'shortDescription' => $product['shortDescription'] ?? 'Authentic product with official warranty, island-wide delivery, and LITUS Connect support.',
            'description' => $product['description'] ?? 'Experience premium performance with this carefully selected LITUS Connect product. Built for everyday reliability and backed by official warranty coverage across Maldives.',
            'descriptionBullets' => $product['descriptionBullets'] ?? [
                'Official warranty included with every purchase',
                'Genuine sealed pack from authorized distributors',
                'Island-wide delivery with secure packaging',
                'Easy 7-day returns on unused products',
            ],
            'images' => $product['images'] ?? [
                $product['img'],
                $product['img'],
                $product['img'],
                $product['img'],
            ],
            'colors' => $product['colors'] ?? [
                ['name' => 'Black', 'hex' => '#111827'],
                ['name' => 'Silver', 'hex' => '#D1D5DB'],
                ['name' => 'Blue', 'hex' => '#1464F4'],
            ],
            'storageOptions' => $product['storageOptions'] ?? ['128GB', '256GB', '512GB'],
            'selectedStorage' => $product['selectedStorage'] ?? '256GB',
            'highlights' => $product['highlights'] ?? [
                'Official warranty included',
                'Fast island-wide delivery',
                'Genuine sealed pack',
                'Easy 7-day returns',
            ],
            'keyFeatures' => $product['keyFeatures'] ?? [
                ['icon' => 'camera', 'title' => '48MP Main Camera', 'sub' => 'Super-high resolution photos'],
                ['icon' => 'cpu', 'title' => 'A17 Pro Chip', 'sub' => 'Next-level performance'],
                ['icon' => 'clock', 'title' => 'Up to 29 hrs Video Playback', 'sub' => 'All-day battery life'],
                ['icon' => 'zap', 'title' => 'USB-C Connector', 'sub' => 'Faster charging & data transfer'],
            ],
            'specList' => $product['specList'] ?? [
                ['icon' => 'smartphone', 'label' => 'Display', 'value' => '6.7" Super Retina XDR'],
                ['icon' => 'cpu', 'label' => 'Chip', 'value' => 'A17 Pro'],
                ['icon' => 'hard-drive', 'label' => 'Storage', 'value' => $product['selectedStorage'] ?? '256GB'],
                ['icon' => 'camera', 'label' => 'Camera', 'value' => '48MP Pro system'],
                ['icon' => 'battery', 'label' => 'Battery', 'value' => 'All-day battery life'],
                ['icon' => 'zap', 'label' => 'Charging', 'value' => 'USB-C Fast Charging'],
            ],
            'specs' => $product['specs'] ?? [
                'Brand' => $product['brand'] ?? 'LITUS Connect',
                'Category' => $product['cat'] ?? ($product['series'] ?? 'Electronics'),
                'Condition' => 'Brand New',
                'Warranty' => '1 Year Official Warranty',
                'SKU' => 'TZ-' . str_pad((string) $product['id'], 5, '0', STR_PAD_LEFT),
            ],
            'cat' => $product['cat'] ?? ($product['series'] ?? 'Electronics'),
            'breadcrumb' => $product['breadcrumb'] ?? [
                ['label' => 'Home', 'route' => 'home'],
                ['label' => 'Shop', 'route' => 'shop'],
                ['label' => $product['name'], 'route' => null],
            ],
        ];

        return array_merge($product, $defaults);
    }

    private function catalog(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'iPhone 15 Pro Max 256GB',
                'series' => 'iPhone',
                'cat' => 'Smartphones',
                'brand' => 'Apple',
                'price' => 499990,
                'original' => 529990,
                'rating' => 4.5,
                'reviews' => 128,
                'badge' => 'SALE',
                'bestSeller' => true,
                'qaCount' => 18,
                'img' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'shortDescription' => 'Titanium design. A17 Pro chip. Pro camera system with 5x Telephoto. The ultimate iPhone for performance and creativity.',
                'description' => 'iPhone 15 Pro Max brings a strong titanium design, the A17 Pro chip, and a powerful camera system for next-level photography and gaming. Enjoy USB-C, Action button customization, and all-day battery life with official Apple warranty through LITUS Connect.',
                'descriptionBullets' => [
                    'Aerospace-grade titanium design — lighter and stronger',
                    'A17 Pro chip with hardware-accelerated ray tracing',
                    'Pro camera system with 5x Telephoto zoom',
                    'Action Button for custom shortcuts',
                    'USB-C with USB 3 transfer speeds',
                ],
                'keyFeatures' => [
                    ['icon' => 'camera', 'title' => '48MP Main Camera', 'sub' => 'Super-high resolution photos'],
                    ['icon' => 'cpu', 'title' => 'A17 Pro Chip', 'sub' => 'Next-level performance'],
                    ['icon' => 'clock', 'title' => 'Up to 29 hrs Video Playback', 'sub' => 'All-day battery life'],
                    ['icon' => 'zap', 'title' => 'USB-C Connector', 'sub' => 'Faster charging & data transfer'],
                ],
                'specList' => [
                    ['icon' => 'smartphone', 'label' => 'Display', 'value' => '6.7" Super Retina XDR OLED'],
                    ['icon' => 'cpu', 'label' => 'Chip', 'value' => 'A17 Pro'],
                    ['icon' => 'hard-drive', 'label' => 'RAM', 'value' => '8GB'],
                    ['icon' => 'hard-drive', 'label' => 'Storage', 'value' => '256GB'],
                    ['icon' => 'camera', 'label' => 'Camera', 'value' => '48MP + Ultra Wide + 5x Telephoto'],
                    ['icon' => 'battery', 'label' => 'Battery', 'value' => 'Up to 29 hours video'],
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=640&h=640&fit=crop&auto=format',
                    'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=640&h=640&fit=crop&auto=format&sat=-20',
                    'https://images.unsplash.com/photo-1663499482523-1c0c1bae4ce1?w=640&h=640&fit=crop&auto=format',
                    'https://images.unsplash.com/photo-1632661674596-df8be070a5c9?w=640&h=640&fit=crop&auto=format',
                ],
                'colors' => [
                    ['name' => 'Natural Titanium', 'hex' => '#9A958A'],
                    ['name' => 'Blue Titanium', 'hex' => '#3B4254'],
                    ['name' => 'White Titanium', 'hex' => '#F2F1ED'],
                    ['name' => 'Black Titanium', 'hex' => '#3C3C3C'],
                ],
                'storageOptions' => ['256GB', '512GB', '1TB'],
                'selectedStorage' => '256GB',
                'highlights' => [
                    'A17 Pro chip with 6-core GPU',
                    'Pro camera system with 5x Telephoto',
                    'Aerospace-grade titanium design',
                    'USB-C with USB 3 speeds',
                ],
                'specs' => [
                    'Brand' => 'Apple',
                    'Model' => 'iPhone 15 Pro Max',
                    'Display' => '6.7" Super Retina XDR',
                    'Chip' => 'A17 Pro',
                    'Camera' => '48MP Main + Ultra Wide + 5x Telephoto',
                    'Battery' => 'Up to 29 hours video playback',
                    'Connectivity' => '5G, Wi-Fi 6E, USB-C',
                    'Warranty' => '1 Year Official Warranty',
                ],
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Mobile Phones', 'route' => 'mobile-phones'],
                    ['label' => 'iPhone 15 Pro Max 256GB', 'route' => null],
                ],
            ],
            [
                'id' => 2,
                'name' => 'Samsung Galaxy S24 Ultra 256GB',
                'series' => 'Samsung',
                'cat' => 'Smartphones',
                'brand' => 'Samsung',
                'price' => 389900,
                'original' => 419900,
                'rating' => 4.8,
                'reviews' => 94,
                'badge' => 'SALE',
                'img' => 'https://images.unsplash.com/photo-1610945264803-c22b62d2a7b3?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'shortDescription' => 'Galaxy AI, built-in S Pen, and a 200MP camera in a premium titanium frame.',
                'description' => 'Samsung Galaxy S24 Ultra delivers flagship performance with Galaxy AI tools, a precise S Pen, and an advanced camera setup. Ideal for creators and power users who want speed, clarity, and productivity in one device.',
                'colors' => [
                    ['name' => 'Titanium Gray', 'hex' => '#6B6E73'],
                    ['name' => 'Titanium Black', 'hex' => '#2B2B2B'],
                    ['name' => 'Titanium Violet', 'hex' => '#6E5A7B'],
                ],
                'storageOptions' => ['256GB', '512GB', '1TB'],
                'selectedStorage' => '256GB',
                'highlights' => [
                    'Built-in S Pen',
                    '200MP pro-grade camera',
                    'Galaxy AI features',
                    'Armor aluminum frame',
                ],
                'specs' => [
                    'Brand' => 'Samsung',
                    'Model' => 'Galaxy S24 Ultra',
                    'Display' => '6.8" Dynamic AMOLED 2X',
                    'Processor' => 'Snapdragon 8 Gen 3',
                    'Camera' => '200MP + 50MP + 12MP + 10MP',
                    'Battery' => '5000mAh',
                    'Warranty' => '1 Year Official Warranty',
                ],
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Mobile Phones', 'route' => 'mobile-phones'],
                    ['label' => 'Samsung Galaxy S24 Ultra 256GB', 'route' => null],
                ],
            ],
            [
                'id' => 3,
                'name' => 'iPhone 15 128GB',
                'series' => 'iPhone',
                'cat' => 'Smartphones',
                'brand' => 'Apple',
                'price' => 289900,
                'original' => null,
                'rating' => 4.8,
                'reviews' => 156,
                'badge' => 'NEW',
                'img' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'shortDescription' => 'Dynamic Island, 48MP camera, and USB-C in a colorful aluminum design.',
                'description' => 'iPhone 15 combines a vibrant design with powerful everyday performance. Capture stunning detail with the 48MP Main camera and enjoy a smooth experience powered by the A16 Bionic chip.',
                'storageOptions' => ['128GB', '256GB', '512GB'],
                'selectedStorage' => '128GB',
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Mobile Phones', 'route' => 'mobile-phones'],
                    ['label' => 'iPhone 15 128GB', 'route' => null],
                ],
            ],
            [
                'id' => 4,
                'name' => 'Xiaomi 14 Ultra 512GB',
                'series' => 'Xiaomi',
                'cat' => 'Smartphones',
                'brand' => 'Xiaomi',
                'price' => 259900,
                'original' => 289900,
                'rating' => 4.7,
                'reviews' => 67,
                'badge' => 'SALE',
                'img' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'shortDescription' => 'Leica optics and flagship Snapdragon performance for creators.',
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Mobile Phones', 'route' => 'mobile-phones'],
                    ['label' => 'Xiaomi 14 Ultra 512GB', 'route' => null],
                ],
            ],
            [
                'id' => 5,
                'name' => 'Google Pixel 8 Pro 256GB',
                'series' => 'Google',
                'cat' => 'Smartphones',
                'brand' => 'Google',
                'price' => 299900,
                'original' => null,
                'rating' => 4.8,
                'reviews' => 82,
                'badge' => 'NEW',
                'img' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'shortDescription' => 'Best-in-class computational photography with Pixel AI features.',
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Mobile Phones', 'route' => 'mobile-phones'],
                    ['label' => 'Google Pixel 8 Pro 256GB', 'route' => null],
                ],
            ],
            [
                'id' => 6,
                'name' => 'Samsung Galaxy A55 5G 128GB',
                'series' => 'Samsung',
                'cat' => 'Smartphones',
                'brand' => 'Samsung',
                'price' => 89900,
                'original' => 99900,
                'rating' => 4.5,
                'reviews' => 143,
                'badge' => 'SALE',
                'img' => 'https://images.unsplash.com/photo-1610945264803-c22b62d2a7b3?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'storageOptions' => ['128GB', '256GB'],
                'selectedStorage' => '128GB',
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Mobile Phones', 'route' => 'mobile-phones'],
                    ['label' => 'Samsung Galaxy A55 5G 128GB', 'route' => null],
                ],
            ],
            [
                'id' => 7,
                'name' => 'OnePlus 12 256GB',
                'series' => 'OnePlus',
                'cat' => 'Smartphones',
                'brand' => 'OnePlus',
                'price' => 189900,
                'original' => 209900,
                'rating' => 4.6,
                'reviews' => 58,
                'badge' => 'SALE',
                'img' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Mobile Phones', 'route' => 'mobile-phones'],
                    ['label' => 'OnePlus 12 256GB', 'route' => null],
                ],
            ],
            [
                'id' => 8,
                'name' => 'iPhone 14 Pro 128GB',
                'series' => 'iPhone',
                'cat' => 'Smartphones',
                'brand' => 'Apple',
                'price' => 349900,
                'original' => 379900,
                'rating' => 4.8,
                'reviews' => 211,
                'badge' => 'SALE',
                'img' => 'https://images.unsplash.com/photo-1663499482523-1c0c1bae4ce1?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'storageOptions' => ['128GB', '256GB', '512GB'],
                'selectedStorage' => '128GB',
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Mobile Phones', 'route' => 'mobile-phones'],
                    ['label' => 'iPhone 14 Pro 128GB', 'route' => null],
                ],
            ],
            [
                'id' => 9,
                'name' => 'Nothing Phone (2) 256GB',
                'series' => 'Nothing',
                'cat' => 'Smartphones',
                'brand' => 'Nothing',
                'price' => 149900,
                'original' => null,
                'rating' => 4.4,
                'reviews' => 39,
                'badge' => 'NEW',
                'img' => 'https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Mobile Phones', 'route' => 'mobile-phones'],
                    ['label' => 'Nothing Phone (2) 256GB', 'route' => null],
                ],
            ],
            [
                'id' => 10,
                'name' => 'OPPO Find X7 Pro 512GB',
                'series' => 'OPPO',
                'cat' => 'Smartphones',
                'brand' => 'OPPO',
                'price' => 229900,
                'original' => 249900,
                'rating' => 4.5,
                'reviews' => 44,
                'badge' => 'SALE',
                'img' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Mobile Phones', 'route' => 'mobile-phones'],
                    ['label' => 'OPPO Find X7 Pro 512GB', 'route' => null],
                ],
            ],
            [
                'id' => 11,
                'name' => 'Samsung Galaxy Z Flip5',
                'series' => 'Samsung',
                'cat' => 'Smartphones',
                'brand' => 'Samsung',
                'price' => 279900,
                'original' => null,
                'rating' => 4.6,
                'reviews' => 71,
                'badge' => null,
                'img' => 'https://images.unsplash.com/photo-1610945264803-c22b62d2a7b3?w=640&h=640&fit=crop&auto=format',
                'inStock' => false,
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Mobile Phones', 'route' => 'mobile-phones'],
                    ['label' => 'Samsung Galaxy Z Flip5', 'route' => null],
                ],
            ],
            [
                'id' => 12,
                'name' => 'Xiaomi Redmi Note 13 Pro',
                'series' => 'Xiaomi',
                'cat' => 'Smartphones',
                'brand' => 'Xiaomi',
                'price' => 69900,
                'original' => 79900,
                'rating' => 4.4,
                'reviews' => 188,
                'badge' => 'SALE',
                'img' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'storageOptions' => ['128GB', '256GB'],
                'selectedStorage' => '128GB',
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Mobile Phones', 'route' => 'mobile-phones'],
                    ['label' => 'Xiaomi Redmi Note 13 Pro', 'route' => null],
                ],
            ],
            [
                'id' => 13,
                'name' => 'iPhone 13 128GB',
                'series' => 'iPhone',
                'cat' => 'Smartphones',
                'brand' => 'Apple',
                'price' => 199900,
                'original' => 219900,
                'rating' => 4.7,
                'reviews' => 302,
                'badge' => 'SALE',
                'img' => 'https://images.unsplash.com/photo-1632661674596-df8be070a5c9?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'storageOptions' => ['128GB', '256GB'],
                'selectedStorage' => '128GB',
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Mobile Phones', 'route' => 'mobile-phones'],
                    ['label' => 'iPhone 13 128GB', 'route' => null],
                ],
            ],
            [
                'id' => 14,
                'name' => 'Google Pixel 8a 128GB',
                'series' => 'Google',
                'cat' => 'Smartphones',
                'brand' => 'Google',
                'price' => 129900,
                'original' => null,
                'rating' => 4.6,
                'reviews' => 55,
                'badge' => 'NEW',
                'img' => 'https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'storageOptions' => ['128GB', '256GB'],
                'selectedStorage' => '128GB',
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Mobile Phones', 'route' => 'mobile-phones'],
                    ['label' => 'Google Pixel 8a 128GB', 'route' => null],
                ],
            ],
            [
                'id' => 15,
                'name' => 'Vivo V30 Pro 256GB',
                'series' => 'Vivo',
                'cat' => 'Smartphones',
                'brand' => 'Vivo',
                'price' => 119900,
                'original' => 134900,
                'rating' => 4.3,
                'reviews' => 36,
                'badge' => 'SALE',
                'img' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Mobile Phones', 'route' => 'mobile-phones'],
                    ['label' => 'Vivo V30 Pro 256GB', 'route' => null],
                ],
            ],
            [
                'id' => 16,
                'name' => 'OnePlus Nord 4 256GB',
                'series' => 'OnePlus',
                'cat' => 'Smartphones',
                'brand' => 'OnePlus',
                'price' => 99900,
                'original' => 109900,
                'rating' => 4.5,
                'reviews' => 49,
                'badge' => 'SALE',
                'img' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Mobile Phones', 'route' => 'mobile-phones'],
                    ['label' => 'OnePlus Nord 4 256GB', 'route' => null],
                ],
            ],
            [
                'id' => 101,
                'name' => 'Sony WH-1000XM5 Headphones',
                'cat' => 'Audio',
                'brand' => 'Sony',
                'price' => 119900,
                'original' => 149900,
                'rating' => 4.9,
                'reviews' => 312,
                'badge' => 'SALE',
                'img' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'storageOptions' => [],
                'selectedStorage' => null,
                'shortDescription' => 'Industry-leading noise cancellation with premium comfort.',
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Shop', 'route' => 'shop'],
                    ['label' => 'Sony WH-1000XM5 Headphones', 'route' => null],
                ],
            ],
            [
                'id' => 102,
                'name' => 'Apple Watch Series 9 GPS',
                'cat' => 'Smartwatches',
                'brand' => 'Apple',
                'price' => 129900,
                'original' => 149900,
                'rating' => 4.7,
                'reviews' => 87,
                'badge' => null,
                'img' => 'https://images.unsplash.com/photo-1544117519-31a4b719223d?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'storageOptions' => [],
                'selectedStorage' => null,
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Shop', 'route' => 'shop'],
                    ['label' => 'Apple Watch Series 9 GPS', 'route' => null],
                ],
            ],
            [
                'id' => 103,
                'name' => 'Apple AirPods Pro (2nd Gen)',
                'cat' => 'Audio',
                'brand' => 'Apple',
                'price' => 74900,
                'original' => 89900,
                'rating' => 4.8,
                'reviews' => 256,
                'badge' => 'SALE',
                'img' => 'https://images.unsplash.com/photo-1603351154351-5e2d0600bb77?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'storageOptions' => [],
                'selectedStorage' => null,
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Shop', 'route' => 'shop'],
                    ['label' => 'Apple AirPods Pro (2nd Gen)', 'route' => null],
                ],
            ],
            [
                'id' => 104,
                'name' => 'Samsung Galaxy Watch 6',
                'cat' => 'Smartwatches',
                'brand' => 'Samsung',
                'price' => 89900,
                'original' => null,
                'rating' => 4.6,
                'reviews' => 64,
                'badge' => null,
                'img' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'storageOptions' => [],
                'selectedStorage' => null,
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Shop', 'route' => 'shop'],
                    ['label' => 'Samsung Galaxy Watch 6', 'route' => null],
                ],
            ],
            [
                'id' => 105,
                'name' => 'JBL Charge 5 Portable Speaker',
                'cat' => 'Speakers',
                'brand' => 'JBL',
                'price' => 45900,
                'original' => 55900,
                'rating' => 4.7,
                'reviews' => 143,
                'badge' => 'SALE',
                'img' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'storageOptions' => [],
                'selectedStorage' => null,
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Shop', 'route' => 'shop'],
                    ['label' => 'JBL Charge 5 Portable Speaker', 'route' => null],
                ],
            ],
            [
                'id' => 106,
                'name' => 'Anker 65W USB-C Fast Charger',
                'cat' => 'Chargers',
                'brand' => 'Anker',
                'price' => 12990,
                'original' => 15990,
                'rating' => 4.8,
                'reviews' => 412,
                'badge' => 'SALE',
                'img' => 'https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'storageOptions' => [],
                'selectedStorage' => null,
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Shop', 'route' => 'shop'],
                    ['label' => 'Anker 65W USB-C Fast Charger', 'route' => null],
                ],
            ],
            [
                'id' => 107,
                'name' => 'iPad Pro 12.9" M2 Chip',
                'cat' => 'Tablets',
                'brand' => 'Apple',
                'price' => 349900,
                'original' => null,
                'rating' => 4.8,
                'reviews' => 76,
                'badge' => null,
                'img' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'storageOptions' => ['128GB', '256GB', '512GB', '1TB'],
                'selectedStorage' => '256GB',
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Shop', 'route' => 'shop'],
                    ['label' => 'iPad Pro 12.9" M2 Chip', 'route' => null],
                ],
            ],
            [
                'id' => 108,
                'name' => 'ASUS ROG Zephyrus G16',
                'cat' => 'Laptops',
                'brand' => 'ASUS',
                'price' => 549900,
                'original' => 599900,
                'rating' => 4.5,
                'reviews' => 52,
                'badge' => 'SALE',
                'img' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'storageOptions' => [],
                'selectedStorage' => null,
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Shop', 'route' => 'shop'],
                    ['label' => 'ASUS ROG Zephyrus G16', 'route' => null],
                ],
            ],
            [
                'id' => 109,
                'name' => 'Sony PlayStation 5 Console',
                'cat' => 'Gaming',
                'brand' => 'Sony',
                'price' => 189900,
                'original' => null,
                'rating' => 4.9,
                'reviews' => 521,
                'badge' => null,
                'img' => 'https://images.unsplash.com/photo-1606144042614-b2417e99c4e3?w=640&h=640&fit=crop&auto=format',
                'inStock' => false,
                'storageOptions' => [],
                'selectedStorage' => null,
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Shop', 'route' => 'shop'],
                    ['label' => 'Sony PlayStation 5 Console', 'route' => null],
                ],
            ],
            [
                'id' => 110,
                'name' => 'Bose QuietComfort 45',
                'cat' => 'Audio',
                'brand' => 'Bose',
                'price' => 99900,
                'original' => 119900,
                'rating' => 4.7,
                'reviews' => 198,
                'badge' => 'SALE',
                'img' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'storageOptions' => [],
                'selectedStorage' => null,
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Shop', 'route' => 'shop'],
                    ['label' => 'Bose QuietComfort 45', 'route' => null],
                ],
            ],
            [
                'id' => 111,
                'name' => 'Logitech MX Master 3S Mouse',
                'cat' => 'Accessories',
                'brand' => 'Logitech',
                'price' => 28900,
                'original' => 34900,
                'rating' => 4.7,
                'reviews' => 267,
                'badge' => 'SALE',
                'img' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'storageOptions' => [],
                'selectedStorage' => null,
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Shop', 'route' => 'shop'],
                    ['label' => 'Logitech MX Master 3S Mouse', 'route' => null],
                ],
            ],
            [
                'id' => 112,
                'name' => 'Anker PowerCore 20000mAh',
                'cat' => 'Power Banks',
                'brand' => 'Anker',
                'price' => 18990,
                'original' => 22990,
                'rating' => 4.6,
                'reviews' => 334,
                'badge' => 'SALE',
                'img' => 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'storageOptions' => [],
                'selectedStorage' => null,
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Shop', 'route' => 'shop'],
                    ['label' => 'Anker PowerCore 20000mAh', 'route' => null],
                ],
            ],
            [
                'id' => 113,
                'name' => 'MacBook Air 13" M3',
                'cat' => 'Laptops',
                'brand' => 'Apple',
                'price' => 389900,
                'original' => null,
                'rating' => 4.9,
                'reviews' => 89,
                'badge' => null,
                'img' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=640&h=640&fit=crop&auto=format',
                'inStock' => true,
                'storageOptions' => ['256GB', '512GB'],
                'selectedStorage' => '256GB',
                'breadcrumb' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Shop', 'route' => 'shop'],
                    ['label' => 'MacBook Air 13" M3', 'route' => null],
                ],
            ],
            // Headsets 201-208
            ['id' => 201, 'name' => 'Sony WH-1000XM5 Headphones', 'cat' => 'Audio', 'series' => 'Over-Ear', 'brand' => 'Sony', 'price' => 119900, 'original' => 149900, 'rating' => 4.9, 'reviews' => 312, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=640&h=640&fit=crop&auto=format', 'inStock' => true, 'storageOptions' => [], 'selectedStorage' => null, 'breadcrumb' => [['label' => 'Home', 'route' => 'home'], ['label' => 'Headsets', 'route' => 'headsets'], ['label' => 'Sony WH-1000XM5 Headphones', 'route' => null]]],
            ['id' => 202, 'name' => 'Apple AirPods Pro (2nd Gen)', 'cat' => 'Audio', 'series' => 'True Wireless', 'brand' => 'Apple', 'price' => 74900, 'original' => 89900, 'rating' => 4.8, 'reviews' => 256, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1603351154351-5e2d0600bb77?w=640&h=640&fit=crop&auto=format', 'inStock' => true, 'storageOptions' => [], 'selectedStorage' => null, 'breadcrumb' => [['label' => 'Home', 'route' => 'home'], ['label' => 'Headsets', 'route' => 'headsets'], ['label' => 'Apple AirPods Pro (2nd Gen)', 'route' => null]]],
            ['id' => 203, 'name' => 'Bose QuietComfort 45', 'cat' => 'Audio', 'series' => 'Noise Cancelling', 'brand' => 'Bose', 'price' => 99900, 'original' => 119900, 'rating' => 4.7, 'reviews' => 198, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=640&h=640&fit=crop&auto=format', 'inStock' => true, 'storageOptions' => [], 'selectedStorage' => null, 'breadcrumb' => [['label' => 'Home', 'route' => 'home'], ['label' => 'Headsets', 'route' => 'headsets'], ['label' => 'Bose QuietComfort 45', 'route' => null]]],
            ['id' => 204, 'name' => 'JBL Tune 760NC', 'cat' => 'Audio', 'series' => 'On-Ear', 'brand' => 'JBL', 'price' => 32900, 'original' => 39900, 'rating' => 4.5, 'reviews' => 144, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1484704849700-f032a568e944?w=640&h=640&fit=crop&auto=format', 'inStock' => true, 'storageOptions' => [], 'selectedStorage' => null, 'breadcrumb' => [['label' => 'Home', 'route' => 'home'], ['label' => 'Headsets', 'route' => 'headsets'], ['label' => 'JBL Tune 760NC', 'route' => null]]],
            ['id' => 205, 'name' => 'Samsung Galaxy Buds2 Pro', 'cat' => 'Audio', 'series' => 'True Wireless', 'brand' => 'Samsung', 'price' => 54900, 'original' => null, 'rating' => 4.6, 'reviews' => 87, 'badge' => 'NEW', 'img' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=640&h=640&fit=crop&auto=format', 'inStock' => true, 'storageOptions' => [], 'selectedStorage' => null, 'breadcrumb' => [['label' => 'Home', 'route' => 'home'], ['label' => 'Headsets', 'route' => 'headsets'], ['label' => 'Samsung Galaxy Buds2 Pro', 'route' => null]]],
            ['id' => 206, 'name' => 'Anker Soundcore Life Q30', 'cat' => 'Audio', 'series' => 'Over-Ear', 'brand' => 'Anker', 'price' => 24900, 'original' => 29900, 'rating' => 4.4, 'reviews' => 221, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=640&h=640&fit=crop&auto=format', 'inStock' => true, 'storageOptions' => [], 'selectedStorage' => null, 'breadcrumb' => [['label' => 'Home', 'route' => 'home'], ['label' => 'Headsets', 'route' => 'headsets'], ['label' => 'Anker Soundcore Life Q30', 'route' => null]]],
            ['id' => 207, 'name' => 'Logitech G Pro X Gaming Headset', 'cat' => 'Audio', 'series' => 'Gaming', 'brand' => 'Logitech', 'price' => 42900, 'original' => 49900, 'rating' => 4.5, 'reviews' => 96, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=640&h=640&fit=crop&auto=format', 'inStock' => true, 'storageOptions' => [], 'selectedStorage' => null, 'breadcrumb' => [['label' => 'Home', 'route' => 'home'], ['label' => 'Headsets', 'route' => 'headsets'], ['label' => 'Logitech G Pro X Gaming Headset', 'route' => null]]],
            ['id' => 208, 'name' => 'JBL Endurance Peak 3', 'cat' => 'Audio', 'series' => 'Sports', 'brand' => 'JBL', 'price' => 28900, 'original' => null, 'rating' => 4.3, 'reviews' => 64, 'badge' => 'NEW', 'img' => 'https://images.unsplash.com/photo-1603351154351-5e2d0600bb77?w=640&h=640&fit=crop&auto=format', 'inStock' => false, 'storageOptions' => [], 'selectedStorage' => null, 'breadcrumb' => [['label' => 'Home', 'route' => 'home'], ['label' => 'Headsets', 'route' => 'headsets'], ['label' => 'JBL Endurance Peak 3', 'route' => null]]],
            // Smart watches 301-308
            ['id' => 301, 'name' => 'Apple Watch Series 9 GPS', 'cat' => 'Smartwatches', 'series' => 'Apple Watch', 'brand' => 'Apple', 'price' => 129900, 'original' => 149900, 'rating' => 4.7, 'reviews' => 87, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1544117519-31a4b719223d?w=640&h=640&fit=crop&auto=format', 'inStock' => true, 'storageOptions' => [], 'selectedStorage' => null, 'breadcrumb' => [['label' => 'Home', 'route' => 'home'], ['label' => 'Smart Watches', 'route' => 'smart-watches'], ['label' => 'Apple Watch Series 9 GPS', 'route' => null]]],
            ['id' => 302, 'name' => 'Samsung Galaxy Watch 6', 'cat' => 'Smartwatches', 'series' => 'Galaxy Watch', 'brand' => 'Samsung', 'price' => 89900, 'original' => null, 'rating' => 4.6, 'reviews' => 64, 'badge' => 'NEW', 'img' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=640&h=640&fit=crop&auto=format', 'inStock' => true, 'storageOptions' => [], 'selectedStorage' => null, 'breadcrumb' => [['label' => 'Home', 'route' => 'home'], ['label' => 'Smart Watches', 'route' => 'smart-watches'], ['label' => 'Samsung Galaxy Watch 6', 'route' => null]]],
            ['id' => 303, 'name' => 'Apple Watch SE (2nd Gen)', 'cat' => 'Smartwatches', 'series' => 'Apple Watch', 'brand' => 'Apple', 'price' => 79900, 'original' => 89900, 'rating' => 4.6, 'reviews' => 142, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1434493789847-2f02dc6ca35d?w=640&h=640&fit=crop&auto=format', 'inStock' => true, 'storageOptions' => [], 'selectedStorage' => null, 'breadcrumb' => [['label' => 'Home', 'route' => 'home'], ['label' => 'Smart Watches', 'route' => 'smart-watches'], ['label' => 'Apple Watch SE (2nd Gen)', 'route' => null]]],
            ['id' => 304, 'name' => 'Samsung Galaxy Watch 6 Classic', 'cat' => 'Smartwatches', 'series' => 'Galaxy Watch', 'brand' => 'Samsung', 'price' => 109900, 'original' => 119900, 'rating' => 4.7, 'reviews' => 58, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=640&h=640&fit=crop&auto=format', 'inStock' => true, 'storageOptions' => [], 'selectedStorage' => null, 'breadcrumb' => [['label' => 'Home', 'route' => 'home'], ['label' => 'Smart Watches', 'route' => 'smart-watches'], ['label' => 'Samsung Galaxy Watch 6 Classic', 'route' => null]]],
            ['id' => 305, 'name' => 'Xiaomi Redmi Watch 4', 'cat' => 'Smartwatches', 'series' => 'Fitness', 'brand' => 'Xiaomi', 'price' => 19900, 'original' => 24900, 'rating' => 4.3, 'reviews' => 210, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?w=640&h=640&fit=crop&auto=format', 'inStock' => true, 'storageOptions' => [], 'selectedStorage' => null, 'breadcrumb' => [['label' => 'Home', 'route' => 'home'], ['label' => 'Smart Watches', 'route' => 'smart-watches'], ['label' => 'Xiaomi Redmi Watch 4', 'route' => null]]],
            ['id' => 306, 'name' => 'Huawei Watch GT 4', 'cat' => 'Smartwatches', 'series' => 'GPS', 'brand' => 'Huawei', 'price' => 69900, 'original' => null, 'rating' => 4.5, 'reviews' => 73, 'badge' => 'NEW', 'img' => 'https://images.unsplash.com/photo-1551816230-ef5deaed4a26?w=640&h=640&fit=crop&auto=format', 'inStock' => true, 'storageOptions' => [], 'selectedStorage' => null, 'breadcrumb' => [['label' => 'Home', 'route' => 'home'], ['label' => 'Smart Watches', 'route' => 'smart-watches'], ['label' => 'Huawei Watch GT 4', 'route' => null]]],
            ['id' => 307, 'name' => 'Garmin Venu Sq 2', 'cat' => 'Smartwatches', 'series' => 'GPS', 'brand' => 'Garmin', 'price' => 84900, 'original' => 94900, 'rating' => 4.6, 'reviews' => 41, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1575311373937-040b8e1fd5b6?w=640&h=640&fit=crop&auto=format', 'inStock' => true, 'storageOptions' => [], 'selectedStorage' => null, 'breadcrumb' => [['label' => 'Home', 'route' => 'home'], ['label' => 'Smart Watches', 'route' => 'smart-watches'], ['label' => 'Garmin Venu Sq 2', 'route' => null]]],
            ['id' => 308, 'name' => 'Amazfit GTR 4', 'cat' => 'Smartwatches', 'series' => 'Luxury', 'brand' => 'Amazfit', 'price' => 54900, 'original' => 64900, 'rating' => 4.4, 'reviews' => 55, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=640&h=640&fit=crop&auto=format', 'inStock' => false, 'storageOptions' => [], 'selectedStorage' => null, 'breadcrumb' => [['label' => 'Home', 'route' => 'home'], ['label' => 'Smart Watches', 'route' => 'smart-watches'], ['label' => 'Amazfit GTR 4', 'route' => null]]],
            // Accessories 401-408
            ['id' => 401, 'name' => 'Anker 65W USB-C Fast Charger', 'cat' => 'Accessories', 'series' => 'Chargers', 'brand' => 'Anker', 'price' => 12990, 'original' => 15990, 'rating' => 4.8, 'reviews' => 412, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=640&h=640&fit=crop&auto=format', 'inStock' => true, 'storageOptions' => [], 'selectedStorage' => null, 'breadcrumb' => [['label' => 'Home', 'route' => 'home'], ['label' => 'Accessories', 'route' => 'accessories'], ['label' => 'Anker 65W USB-C Fast Charger', 'route' => null]]],
            ['id' => 402, 'name' => 'Anker PowerCore 20000mAh', 'cat' => 'Accessories', 'series' => 'Power Banks', 'brand' => 'Anker', 'price' => 18990, 'original' => 22990, 'rating' => 4.6, 'reviews' => 334, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=640&h=640&fit=crop&auto=format', 'inStock' => true, 'storageOptions' => [], 'selectedStorage' => null, 'breadcrumb' => [['label' => 'Home', 'route' => 'home'], ['label' => 'Accessories', 'route' => 'accessories'], ['label' => 'Anker PowerCore 20000mAh', 'route' => null]]],
            ['id' => 403, 'name' => 'Apple USB-C to Lightning Cable 1m', 'cat' => 'Accessories', 'series' => 'Cables', 'brand' => 'Apple', 'price' => 8900, 'original' => null, 'rating' => 4.7, 'reviews' => 198, 'badge' => null, 'img' => 'https://images.unsplash.com/photo-1583394838330-e3289c0f7b4c?w=640&h=640&fit=crop&auto=format', 'inStock' => true, 'storageOptions' => [], 'selectedStorage' => null, 'breadcrumb' => [['label' => 'Home', 'route' => 'home'], ['label' => 'Accessories', 'route' => 'accessories'], ['label' => 'Apple USB-C to Lightning Cable 1m', 'route' => null]]],
            ['id' => 404, 'name' => 'Spigen Ultra Hybrid iPhone Case', 'cat' => 'Accessories', 'series' => 'Cases', 'brand' => 'Spigen', 'price' => 5900, 'original' => 7900, 'rating' => 4.5, 'reviews' => 156, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1601784551446-20c9e07cdbdb?w=640&h=640&fit=crop&auto=format', 'inStock' => true, 'storageOptions' => [], 'selectedStorage' => null, 'breadcrumb' => [['label' => 'Home', 'route' => 'home'], ['label' => 'Accessories', 'route' => 'accessories'], ['label' => 'Spigen Ultra Hybrid iPhone Case', 'route' => null]]],
            ['id' => 405, 'name' => 'Samsung 25W Super Fast Charger', 'cat' => 'Accessories', 'series' => 'Chargers', 'brand' => 'Samsung', 'price' => 7990, 'original' => 9990, 'rating' => 4.6, 'reviews' => 221, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1583863788434-e58a36330cf0?w=640&h=640&fit=crop&auto=format', 'inStock' => true, 'storageOptions' => [], 'selectedStorage' => null, 'breadcrumb' => [['label' => 'Home', 'route' => 'home'], ['label' => 'Accessories', 'route' => 'accessories'], ['label' => 'Samsung 25W Super Fast Charger', 'route' => null]]],
            ['id' => 406, 'name' => 'Baseus Magnetic Car Mount', 'cat' => 'Accessories', 'series' => 'Stands', 'brand' => 'Baseus', 'price' => 3990, 'original' => 4990, 'rating' => 4.4, 'reviews' => 89, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=640&h=640&fit=crop&auto=format', 'inStock' => true, 'storageOptions' => [], 'selectedStorage' => null, 'breadcrumb' => [['label' => 'Home', 'route' => 'home'], ['label' => 'Accessories', 'route' => 'accessories'], ['label' => 'Baseus Magnetic Car Mount', 'route' => null]]],
            ['id' => 407, 'name' => 'Belkin ScreenForce Tempered Glass', 'cat' => 'Accessories', 'series' => 'Screen Protectors', 'brand' => 'Belkin', 'price' => 4500, 'original' => null, 'rating' => 4.5, 'reviews' => 112, 'badge' => 'NEW', 'img' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=640&h=640&fit=crop&auto=format', 'inStock' => true, 'storageOptions' => [], 'selectedStorage' => null, 'breadcrumb' => [['label' => 'Home', 'route' => 'home'], ['label' => 'Accessories', 'route' => 'accessories'], ['label' => 'Belkin ScreenForce Tempered Glass', 'route' => null]]],
            ['id' => 408, 'name' => 'Xiaomi 33W Dual Port Adapter', 'cat' => 'Accessories', 'series' => 'Adapters', 'brand' => 'Xiaomi', 'price' => 3490, 'original' => 4490, 'rating' => 4.3, 'reviews' => 76, 'badge' => 'SALE', 'img' => 'https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=640&h=640&fit=crop&auto=format', 'inStock' => false, 'storageOptions' => [], 'selectedStorage' => null, 'breadcrumb' => [['label' => 'Home', 'route' => 'home'], ['label' => 'Accessories', 'route' => 'accessories'], ['label' => 'Xiaomi 33W Dual Port Adapter', 'route' => null]]],
        ];
    }
}
