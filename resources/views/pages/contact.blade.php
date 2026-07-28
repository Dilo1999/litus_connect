@extends('layouts.app')

@section('title', 'Contact Us — LITUS Connect')
@section('meta_description', 'Get in touch with LITUS Connect in Malé, Maldives. Visit our store, call +960 332 2295, or send us a message for support and feedback.')

@section('content')

<div class="bg-white" data-contact-page>
    {{-- Hero --}}
    <section class="relative overflow-hidden border-b border-border/60 bg-gradient-to-br from-[#F0F5FF] via-[#F7F8FA] to-white">
        <div class="site-container py-8 md:py-12">
            <div class="flex flex-wrap items-center gap-2 text-sm text-muted-foreground mb-5">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors font-medium">Home</a>
                <x-lucide name="chevron-right" :size="13" class="text-gray-300" />
                <span class="font-bold text-[#011848]">Contact Us</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-[#011848] mb-3">Contact Us</h1>
                    <p class="text-sm md:text-base text-muted-foreground max-w-lg leading-relaxed">
                        We're here to help! Get in touch with us for any questions, support or feedback.
                    </p>
                </div>
                <div class="relative hidden sm:flex justify-end">
                    <div class="relative w-full max-w-md aspect-[5/3] rounded-2xl overflow-hidden bg-[#E8F0FE]">
                        <img
                            src="https://images.unsplash.com/photo-1603351154351-5e2d0600bb77?w=640&h=400&fit=crop&auto=format"
                            alt="LITUS Connect products"
                            class="absolute inset-0 w-full h-full object-cover"
                        >
                        <div class="absolute inset-0 bg-gradient-to-tr from-primary/25 via-transparent to-[#011848]/20"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Form + Contact info --}}
    <section class="site-container py-8 md:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-8">
            {{-- Form --}}
            <div class="lg:col-span-3 bg-white rounded-2xl border border-border p-5 md:p-8">
                <h2 class="text-xl font-extrabold text-[#011848] mb-1">Send Us a Message</h2>
                <p class="text-sm text-muted-foreground mb-6">Fill out the form below and our team will get back to you shortly.</p>

                @if (session('contact_success'))
                    <div class="mb-5 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        <x-lucide name="check-circle" :size="18" class="text-emerald-600 mt-0.5 shrink-0" />
                        <div>
                            <p class="font-bold">Message sent successfully!</p>
                            <p class="text-emerald-700/90">Thanks for contacting LITUS Connect. We'll reply as soon as possible.</p>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <p class="font-bold mb-1">Please fix the following:</p>
                        <ul class="list-disc pl-4 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-4" data-contact-form>
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-xs font-bold text-[#011848] mb-1.5">Your Name <span class="text-red-500">*</span></label>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                placeholder="Enter your name"
                                class="w-full h-11 px-3.5 rounded-lg border border-border bg-white text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 transition-all"
                            >
                        </div>
                        <div>
                            <label for="email" class="block text-xs font-bold text-[#011848] mb-1.5">Email Address <span class="text-red-500">*</span></label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                placeholder="Enter your email"
                                class="w-full h-11 px-3.5 rounded-lg border border-border bg-white text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 transition-all"
                            >
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="phone" class="block text-xs font-bold text-[#011848] mb-1.5">Phone Number</label>
                            <input
                                id="phone"
                                type="tel"
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder="+960 XXX XXXX"
                                class="w-full h-11 px-3.5 rounded-lg border border-border bg-white text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 transition-all"
                            >
                        </div>
                        <div>
                            <label for="subject" class="block text-xs font-bold text-[#011848] mb-1.5">Subject <span class="text-red-500">*</span></label>
                            <select
                                id="subject"
                                name="subject"
                                required
                                class="w-full h-11 px-3.5 rounded-lg border border-border bg-white text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 transition-all"
                            >
                                <option value="" disabled @selected(! old('subject'))>Select a subject</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject }}" @selected(old('subject') === $subject)>{{ $subject }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="message" class="block text-xs font-bold text-[#011848] mb-1.5">Message <span class="text-red-500">*</span></label>
                        <textarea
                            id="message"
                            name="message"
                            rows="5"
                            required
                            placeholder="How can we help you?"
                            class="w-full px-3.5 py-3 rounded-lg border border-border bg-white text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 transition-all resize-y min-h-[120px]"
                        >{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 h-12 rounded-lg bg-primary hover:bg-[#005266] text-white text-sm font-bold transition-colors">
                        Send Message
                        <x-lucide name="send" :size="16" />
                    </button>
                </form>
            </div>

            {{-- Contact information --}}
            <div class="lg:col-span-2 bg-[#F3F5F9] rounded-2xl border border-border p-5 md:p-7">
                <h2 class="text-xl font-extrabold text-[#011848] mb-5">Contact Information</h2>
                <ul class="flex flex-col gap-5">
                    @foreach ($contactInfo as $item)
                        <li class="flex gap-3.5">
                            <div class="w-11 h-11 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                <x-lucide :name="$item['icon']" :size="18" />
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-sm font-extrabold text-[#011848] mb-0.5">{{ $item['title'] }}</h3>
                                @foreach ($item['lines'] as $line)
                                    <p class="text-sm text-muted-foreground leading-snug">{{ $line }}</p>
                                @endforeach
                                @if (!empty($item['link']))
                                    <a href="{{ $item['link']['href'] }}" class="inline-flex items-center gap-1 mt-1.5 text-xs font-bold text-primary hover:underline">
                                        {{ $item['link']['label'] }}
                                        <x-lucide name="arrow-right" :size="12" />
                                    </a>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    {{-- Map --}}
    <section id="store-map" class="site-container pb-8 md:pb-12">
        <div class="relative rounded-2xl overflow-hidden border border-border bg-white min-h-[280px] md:min-h-[360px]">
            <iframe
                title="LITUS Connect store location"
                src="{{ $mapEmbedUrl }}"
                class="absolute inset-0 w-full h-full border-0"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
            <div class="absolute left-4 bottom-4 md:left-6 md:bottom-6 z-10 w-[min(100%-2rem,280px)] bg-white rounded-xl border border-border shadow-lg p-4">
                <p class="text-sm font-extrabold text-[#011848] mb-1">LITUS Connect</p>
                <p class="text-xs text-muted-foreground leading-relaxed mb-3">{{ $storeAddress }}</p>
                <a
                    href="{{ $mapDirectionsUrl }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 w-full justify-center bg-primary hover:bg-[#005266] text-white text-xs font-bold px-4 py-2.5 rounded-lg transition-colors"
                >
                    <x-lucide name="map-pin" :size="14" />
                    Get Directions
                </a>
            </div>
        </div>
    </section>

    {{-- Trust bar --}}
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

    {{-- FAQ + Support cards --}}
    <section class="site-container py-8 md:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
            <div class="bg-white rounded-2xl border border-border p-5 md:p-7">
                <h2 class="text-xl font-extrabold text-[#011848] mb-5">Frequently Asked Questions</h2>
                <div class="divide-y divide-border" data-faq-list>
                    @foreach ($faqs as $index => $faq)
                        <div data-faq-item class="py-1" @if ($index === 0) data-open="true" @endif>
                            <button
                                type="button"
                                data-faq-toggle
                                class="w-full flex items-center justify-between gap-3 py-3.5 text-left"
                            >
                                <span class="text-sm font-bold text-[#011848]">{{ $faq['q'] }}</span>
                                <span class="w-8 h-8 rounded-full bg-[#F3F5F9] flex items-center justify-center shrink-0 text-gray-500">
                                    <x-lucide name="chevron-down" :size="16" data-faq-chevron class="transition-transform duration-200" />
                                </span>
                            </button>
                            <div data-faq-panel class="{{ $index === 0 ? '' : 'hidden' }} pb-3.5 pr-10">
                                <p class="text-sm text-muted-foreground leading-relaxed">{{ $faq['a'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('blog') }}" class="inline-flex items-center gap-1.5 mt-4 text-sm font-bold text-primary hover:underline">
                    Still have questions? Visit our Help Center
                    <x-lucide name="arrow-right" :size="14" />
                </a>
            </div>

            <div class="flex flex-col gap-5">
                <div class="relative overflow-hidden rounded-2xl border border-border bg-gradient-to-br from-[#E8F0FE] to-[#F5F8FF] p-6 md:p-7">
                    <div class="relative z-10 max-w-[70%]">
                        <h3 class="text-lg font-extrabold text-[#011848] mb-1.5">Need Immediate Help?</h3>
                        <p class="text-sm text-muted-foreground mb-4 leading-relaxed">Chat with our support team for quick answers about orders, products, and warranty.</p>
                        <a href="tel:+9603322295" class="inline-flex items-center gap-2 bg-primary hover:bg-[#005266] text-white text-sm font-bold px-5 py-2.5 rounded-lg transition-colors">
                            <x-lucide name="message-circle" :size="15" />
                            Start Live Chat
                        </a>
                    </div>
                    <div class="absolute right-4 bottom-4 md:right-6 md:bottom-6 text-primary/25">
                        <x-lucide name="message-square" :size="88" />
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-2xl border border-border bg-white p-6 md:p-7">
                    <div class="relative z-10 max-w-[75%]">
                        <h3 class="text-lg font-extrabold text-[#011848] mb-1.5">Bulk Orders / Corporate Inquiries</h3>
                        <p class="text-sm text-muted-foreground mb-3 leading-relaxed">Planning a business purchase or volume order? Our sales team can help with pricing and availability.</p>
                        <a href="mailto:sales@litusgroup.mv" class="inline-flex items-center gap-1.5 text-sm font-bold text-primary hover:underline">
                            sales@litusgroup.mv
                            <x-lucide name="arrow-right" :size="14" />
                        </a>
                    </div>
                    <div class="absolute right-4 bottom-4 md:right-6 md:bottom-6 text-gray-200">
                        <x-lucide name="briefcase" :size="80" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-newsletter />
</div>

@endsection
