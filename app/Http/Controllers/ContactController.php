<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        return view('pages.contact', [
            'cartCount' => 2,
            'wishCount' => 0,
            'subjects' => [
                'General Inquiry',
                'Order Support',
                'Product Question',
                'Warranty Claim',
                'Returns & Refunds',
                'Bulk / Corporate Order',
                'Other',
            ],
            'contactInfo' => [
                [
                    'icon' => 'map-pin',
                    'title' => 'Visit Our Store',
                    'lines' => [
                        'Ma. Elyzium, Buruzu Magu',
                        'Malé, Maldives',
                    ],
                    'link' => [
                        'label' => 'View on Map',
                        'href' => '#store-map',
                    ],
                ],
                [
                    'icon' => 'phone',
                    'title' => 'Call Us',
                    'lines' => [
                        '+960 332 2295',
                        'Sun – Thu: 8:00 AM – 5:00 PM',
                    ],
                    'link' => [
                        'label' => 'Call now',
                        'href' => 'tel:+9603322295',
                    ],
                ],
                [
                    'icon' => 'mail',
                    'title' => 'Email Us',
                    'lines' => [
                        'sales@litusgroup.mv',
                        'We reply within 24 hours',
                    ],
                    'link' => [
                        'label' => 'Send email',
                        'href' => 'mailto:sales@litusgroup.mv',
                    ],
                ],
                [
                    'icon' => 'headphones',
                    'title' => 'Customer Support',
                    'lines' => [
                        '24/7 Support Available',
                        'Chat, phone & email help desk',
                    ],
                ],
                [
                    'icon' => 'clock',
                    'title' => 'Business Hours',
                    'lines' => [
                        'Sun – Thu: 8:00 AM – 5:00 PM',
                        'Sat: 9:00 AM – 1:00 PM · Fri: Closed',
                    ],
                ],
            ],
            'faqs' => [
                [
                    'q' => 'How long does delivery take?',
                    'a' => 'Orders within Malé are typically delivered within 1–2 business days. Island deliveries may take 3–5 business days depending on ferry and logistics schedules.',
                ],
                [
                    'q' => 'What is your return policy?',
                    'a' => 'Unused products in original packaging can be returned within 7 days of delivery. Please contact support with your order number to start a return.',
                ],
                [
                    'q' => 'Do you offer warranty for products?',
                    'a' => 'Yes. All eligible products include official manufacturer warranty. Warranty terms vary by brand and product — check the product page for details.',
                ],
                [
                    'q' => 'How can I track my order?',
                    'a' => 'Once your order ships, you will receive a tracking update by SMS or email. You can also contact us with your order number for live status.',
                ],
            ],
            'serviceFeatures' => [
                ['icon' => 'truck', 'title' => 'Free Delivery', 'sub' => 'For orders over MVR 5,000'],
                ['icon' => 'shield-check', 'title' => '1 Year Warranty', 'sub' => 'Official product warranty'],
                ['icon' => 'headphones', 'title' => '24/7 Support', 'sub' => 'Always here to help'],
                ['icon' => 'refresh', 'title' => 'Easy Returns', 'sub' => '7 days return policy'],
                ['icon' => 'credit-card', 'title' => 'Secure Payments', 'sub' => '100% secure checkout'],
            ],
            'storeAddress' => 'Ma. Elyzium, Buruzu Magu, Malé, Maldives',
            'mapEmbedUrl' => 'https://www.openstreetmap.org/export/embed.html?bbox=73.5000%2C4.1650%2C73.5200%2C4.1850&layer=mapnik&marker=4.1755%2C73.5093',
            'mapDirectionsUrl' => 'https://www.google.com/maps/search/?api=1&query=Ma.+Elyzium+Buruzu+Magu+Male+Maldives',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string', 'max:40'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:10000'],
        ], [
            'name.required' => 'Please enter your name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'subject.required' => 'Please select a subject.',
            'message.required' => 'Please enter your message.',
        ]);

        $subject = $validated['subject'];
        if (! empty($validated['phone'])) {
            $subject .= ' | Phone: '.$validated['phone'];
        }

        try {
            Mail::to(config('mail.contact_to', config('mail.from.address')))
                ->send(new ContactFormMail(
                    senderName: $validated['name'],
                    senderEmail: $validated['email'],
                    formSubject: $subject,
                    messageBody: $validated['message'],
                ));
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()->route('contact')->with('contact_success', true);
    }
}
