<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Submitted - Archvadze</title>
    <meta name="description" content="Your project order has been submitted successfully">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="text-xl font-bold text-gray-800">Archvadze</a>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="/" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Home</a>
                        <a href="/services" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Services</a>
                        <a href="/portfolio" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Portfolio</a>
                        <a href="/blog" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Blog</a>
                        <a href="/guides" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Guides</a>
                        <a href="/about" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">About</a>
                        <a href="/contact" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Contact</a>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    @auth
                        @if(auth()->user()->hasRole('client'))
                            <a href="{{ route('client-dashboard.index') }}" class="text-gray-500 hover:text-gray-700">Dashboard</a>
                        @else
                            <a href="/admin" class="text-gray-500 hover:text-gray-700">Admin</a>
                        @endif
                        <span class="text-gray-400 mx-2">|</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-gray-700">Logout</button>
                        </form>
                    @else
                        <a href="/login" class="text-gray-500 hover:text-gray-700">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Success Section -->
    <div class="bg-gradient-to-r from-green-600 to-blue-600 text-white">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="mt-4 text-4xl font-extrabold sm:text-5xl md:text-6xl">
                    Order Submitted!
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Thank you for choosing Archvadze. Your project order has been submitted successfully.
                </p>
            </div>
        </div>
    </div>

    <!-- Order Details -->
    <div class="py-12 bg-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-50 rounded-lg shadow p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Order Details</h2>

                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Order ID</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">#{{ $order->id }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Project</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $order->domain }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Website Type</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ ucfirst(str_replace('-', ' ', $order->website_type)) }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Timeline</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ ucfirst(str_replace('-', ' ', $order->timeline)) }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Budget Range</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ ucfirst(str_replace('-', ' ', $order->budget_range)) }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Services</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @if($order->services->count() > 0)
                                    <ul class="list-disc list-inside">
                                        @foreach($order->services as $service)
                                            <li>{{ $service->name }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-gray-500">None selected</span>
                                @endif
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Features</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @if($order->features->count() > 0)
                                    <ul class="list-disc list-inside">
                                        @foreach($order->features as $feature)
                                            <li>{{ $feature->name }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-gray-500">None selected</span>
                                @endif
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Estimated Total</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 font-semibold">
                                ${{ number_format($order->price_estimate, 2) }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Submitted</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $order->created_at->format('M j, Y \a\t g:i A') }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="mt-6">
                    <h3 class="text-sm font-medium text-gray-900 mb-2">What's Next?</h3>
                    <div class="text-sm text-gray-600 space-y-2">
                        <p>1. Our team will review your order within 24 hours</p>
                        <p>2. We'll send you a detailed proposal with timeline and pricing</p>
                        <p>3. Once approved, we'll start working on your project</p>
                        <p>4. You'll receive regular updates on progress</p>
                    </div>
                </div>

                <div class="mt-6 flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('client-dashboard.index') }}" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        View Dashboard
                    </a>
                    <a href="/" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
            <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                <div class="space-y-8 xl:col-span-1">
                    <div class="text-xl font-bold text-gray-800">Archvadze</div>
                    <p class="text-gray-500 text-base">
                        Professional web development and digital solutions for modern businesses.
                    </p>
                </div>
                <div class="mt-12 grid grid-cols-2 gap-8 xl:mt-0 xl:col-span-2">
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">
                                Services
                            </h3>
                            <ul class="mt-4 space-y-4">
                                <li>
                                    <a href="/services" class="text-base text-gray-500 hover:text-gray-900">
                                        Web Development
                                    </a>
                                </li>
                                <li>
                                    <a href="/services" class="text-base text-gray-500 hover:text-gray-900">
                                        Design
                                    </a>
                                </li>
                                <li>
                                    <a href="/services" class="text-base text-gray-500 hover:text-gray-900">
                                        Consulting
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-12 md:mt-0">
                            <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">
                                Company
                            </h3>
                            <ul class="mt-4 space-y-4">
                                <li>
                                    <a href="/about" class="text-base text-gray-500 hover:text-gray-900">
                                        About
                                    </a>
                                </li>
                                <li>
                                    <a href="/blog" class="text-base text-gray-500 hover:text-gray-900">
                                        Blog
                                    </a>
                                </li>
                                <li>
                                    <a href="/contact" class="text-base text-gray-500 hover:text-gray-900">
                                        Contact
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-200 pt-8">
                <p class="text-base text-gray-400 xl:text-center">
                    &copy; 2026 Archvadze. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>