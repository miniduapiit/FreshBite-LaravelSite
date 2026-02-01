<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'FreshBite')) - {{ config('app.name', 'FreshBite') }}</title>

    <meta name="description" content="@yield('description', 'FreshBite - Delivering fresh, delicious meals right to your door. Quality ingredients, exceptional taste, every single time.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    <!-- Additional Head Content -->
    @stack('head')
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Skip to main content (Accessibility) -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:px-4 focus:py-2 focus:bg-green-600 focus:text-white focus:rounded-lg">
        Skip to main content
    </a>

    <!-- Header Navigation -->
    <header role="banner">
        <x-public-header />
    </header>

    <!-- Main Content -->
    <main id="main-content" role="main" class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer role="contentinfo">
        <x-public-footer />
    </footer>

    <!-- Livewire Scripts -->
    @livewireScripts

    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>
