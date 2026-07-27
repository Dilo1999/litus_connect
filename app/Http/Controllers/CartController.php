<?php

namespace App\Http\Controllers;

class CartController extends Controller
{
    public function index()
    {
        $items = [
            [
                'id' => 1,
                'name' => 'iPhone 15 Pro Max 256GB',
                'variant' => 'Natural Titanium',
                'price' => 499990,
                'qty' => 1,
                'inStock' => true,
                'freeDelivery' => true,
                'img' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=160&h=160&fit=crop&auto=format',
            ],
            [
                'id' => 101,
                'name' => 'Sony WH-1000XM5 Headphones',
                'variant' => 'Black',
                'price' => 119900,
                'qty' => 1,
                'inStock' => true,
                'freeDelivery' => true,
                'img' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=160&h=160&fit=crop&auto=format',
            ],
            [
                'id' => 102,
                'name' => 'Apple Watch Series 9 GPS',
                'variant' => 'Midnight Aluminum',
                'price' => 129900,
                'qty' => 1,
                'inStock' => true,
                'freeDelivery' => true,
                'img' => 'https://images.unsplash.com/photo-1544117519-31a4b719223d?w=160&h=160&fit=crop&auto=format',
            ],
            [
                'id' => 106,
                'name' => 'Anker 65W USB-C Fast Charger',
                'variant' => 'White',
                'price' => 12990,
                'qty' => 1,
                'inStock' => true,
                'freeDelivery' => true,
                'img' => 'https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=160&h=160&fit=crop&auto=format',
            ],
        ];

        $subtotal = collect($items)->sum(fn ($item) => $item['price'] * $item['qty']);
        $discountCode = 'WELCOME10';
        $discount = 10000;
        $delivery = 0;
        $freeDeliveryThreshold = 5000;
        $total = max(0, $subtotal - $discount + $delivery);

        return view('pages.cart', [
            'cartCount' => collect($items)->sum('qty'),
            'wishCount' => 0,
            'items' => $items,
            'subtotal' => $subtotal,
            'discountCode' => $discountCode,
            'discount' => $discount,
            'delivery' => $delivery,
            'total' => $total,
            'freeDeliveryThreshold' => $freeDeliveryThreshold,
            'suggested' => [
                ['id' => 103, 'name' => 'Apple AirPods Pro (2nd Gen)', 'price' => 74900, 'original' => 89900, 'rating' => 4.8, 'reviews' => 312, 'img' => 'https://images.unsplash.com/photo-1603351154351-5e2d0600bb77?w=280&h=280&fit=crop&auto=format'],
                ['id' => 104, 'name' => 'Samsung Galaxy Watch 6', 'price' => 89900, 'original' => 109900, 'rating' => 4.7, 'reviews' => 94, 'img' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=280&h=280&fit=crop&auto=format'],
                ['id' => 110, 'name' => 'Bose QuietComfort 45', 'price' => 99900, 'original' => 119900, 'rating' => 4.8, 'reviews' => 156, 'img' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=280&h=280&fit=crop&auto=format'],
                ['id' => 112, 'name' => 'Anker PowerCore 20000mAh', 'price' => 18990, 'original' => 22990, 'rating' => 4.6, 'reviews' => 210, 'img' => 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=280&h=280&fit=crop&auto=format'],
                ['id' => 105, 'name' => 'JBL Charge 5 Portable Speaker', 'price' => 45900, 'original' => 55900, 'rating' => 4.7, 'reviews' => 188, 'img' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=280&h=280&fit=crop&auto=format'],
                ['id' => 12, 'name' => 'Xiaomi Redmi Note 13 Pro', 'price' => 69900, 'original' => 79900, 'rating' => 4.5, 'reviews' => 142, 'img' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=280&h=280&fit=crop&auto=format'],
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
}
