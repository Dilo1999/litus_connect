<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'TechZone — Premium Electronics')</title>
    <meta name="description" content="@yield('meta_description', 'Your trusted destination for premium, authentic electronics — with unbeatable prices and expert support.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen bg-background">
    <x-announcement-bar />
    <x-header :cart-count="$cartCount ?? 3" :wish-count="$wishCount ?? 7" />

    <main>
        @yield('content')
    </main>

    <x-footer />

    @stack('scripts')
</body>
</html>
