<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
    <meta name="description" content="{{ $description ?? 'Professional web design and development services' }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-primary">
                    {{ data_get($siteSettings, 'site_name', 'archvadze') }}
                </a>

                <nav class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-sm font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'text-primary' : 'text-gray-600 hover:text-primary' }}">
                        Home
                    </a>
                    <a href="{{ route('services') }}" class="text-sm font-medium transition-colors duration-200 {{ request()->routeIs('services') ? 'text-primary' : 'text-gray-600 hover:text-primary' }}">
                        Services
                    </a>
                    <a href="{{ route('portfolio') }}" class="text-sm font-medium transition-colors duration-200 {{ request()->routeIs('portfolio') ? 'text-primary' : 'text-gray-600 hover:text-primary' }}">
                        Portfolio
                    </a>
                    <a href="{{ route('blog') }}" class="text-sm font-medium transition-colors duration-200 {{ request()->routeIs('blog*') ? 'text-primary' : 'text-gray-600 hover:text-primary' }}">
                        Blog
                    </a>
                    <a href="{{ route('guides') }}" class="text-sm font-medium transition-colors duration-200 {{ request()->routeIs('guides*') ? 'text-primary' : 'text-gray-600 hover:text-primary' }}">
                        Guides
                    </a>
                    <a href="{{ route('order.create') }}" class="text-sm font-medium transition-colors duration-200 {{ request()->routeIs('order*') ? 'text-primary' : 'text-gray-600 hover:text-primary' }}">
                        Order
                    </a>
                </nav>

                <div class="hidden md:flex items-center gap-3">
                    @auth
                        @if(auth()->user()->hasRole('client'))
                            <a href="{{ route('client-dashboard.index') }}" class="text-sm font-medium text-gray-600 hover:text-primary transition-colors">
                                Dashboard
                            </a>
                        @else
                            <a href="/admin" class="text-sm font-medium text-gray-600 hover:text-primary transition-colors">
                                Admin
                            </a>
                        @endif
                        <span class="text-gray-400 mx-2">|</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-gray-600 hover:text-primary transition-colors">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-primary transition-colors">
                            Login
                        </a>
                    @endauth
                </div>

                <button class="md:hidden p-2 text-gray-600 hover:text-primary transition-colors" onclick="toggleMobileMenu()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="md:hidden bg-white border-t border-gray-200 hidden">
            <nav class="px-4 py-4 space-y-3">
                <a href="{{ route('home') }}" class="block py-2 text-sm font-medium {{ request()->routeIs('home') ? 'text-primary' : 'text-gray-600' }}">
                    Home
                </a>
                <a href="{{ route('services') }}" class="block py-2 text-sm font-medium {{ request()->routeIs('services') ? 'text-primary' : 'text-gray-600' }}">
                    Services
                </a>
                <a href="{{ route('portfolio') }}" class="block py-2 text-sm font-medium {{ request()->routeIs('portfolio') ? 'text-primary' : 'text-gray-600' }}">
                    Portfolio
                </a>
                <a href="{{ route('blog') }}" class="block py-2 text-sm font-medium {{ request()->routeIs('blog*') ? 'text-primary' : 'text-gray-600' }}">
                    Blog
                </a>
                <a href="{{ route('guides') }}" class="block py-2 text-sm font-medium {{ request()->routeIs('guides*') ? 'text-primary' : 'text-gray-600' }}">
                    Guides
                </a>
                <a href="{{ route('order.create') }}" class="block py-2 text-sm font-medium {{ request()->routeIs('order*') ? 'text-primary' : 'text-gray-600' }}">
                    Order
                </a>
                <div class="pt-3 border-t border-gray-200 space-y-2">
                    @auth
                        @if(auth()->user()->hasRole('client'))
                            <a href="{{ route('client-dashboard.index') }}" class="block py-2 text-sm font-medium text-gray-600">
                                Dashboard
                            </a>
                        @else
                            <a href="/admin" class="block py-2 text-sm font-medium text-gray-600">
                                Admin
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="block w-full text-left py-2 text-sm font-medium text-gray-600">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block py-2 text-sm font-medium text-gray-600">
                            Login
                        </a>
                    @endauth
                </div>
            </nav>
        </div>
    </header>

    <!-- Page Content -->
    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-950 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <span class="text-2xl font-bold text-white mb-4 block">archvadze</span>
                    <p class="text-sm leading-relaxed">
                        {{ data_get($siteSettings, 'footer_tagline', 'Building exceptional digital experiences for businesses worldwide. Your vision, our expertise.') }}
                    </p>
                </div>

                <div>
                    <span class="text-white font-semibold mb-4 block">Quick Links</span>
                    <nav class="space-y-2">
                        <a href="{{ route('services') }}" class="block text-sm hover:text-white transition-colors">Services</a>
                        <a href="{{ route('portfolio') }}" class="block text-sm hover:text-white transition-colors">Portfolio</a>
                        <a href="{{ route('blog') }}" class="block text-sm hover:text-white transition-colors">Blog</a>
                        <a href="{{ route('order.create') }}" class="block text-sm hover:text-white transition-colors">Order Now</a>
                        <a href="{{ route('about') }}" class="block text-sm hover:text-white transition-colors">About</a>
                        <a href="{{ route('contact') }}" class="block text-sm hover:text-white transition-colors">Contact</a>
                    </nav>
                </div>

                <div>
                    <span class="text-white font-semibold mb-4 block">Contact</span>
                    <div class="space-y-3">
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span>{{ data_get($siteSettings, 'contact_email', 'info@archvadze.com') }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span>{{ data_get($siteSettings, 'contact_phone', '+995 555 123 456') }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>{{ data_get($siteSettings, 'contact_address', 'Tbilisi, Georgia') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-gray-800 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-sm">© {{ date('Y') }} {{ data_get($siteSettings, 'site_name', 'archvadze') }}. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="text-sm hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="text-sm hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>
</html>