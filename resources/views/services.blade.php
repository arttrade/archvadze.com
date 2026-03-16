@extends('layouts.main')

@section('title', optional($page)->seo_title ?? 'Services - archvadze')
@section('description', optional($page)->seo_description ?? 'Explore our comprehensive web development services including design, development, e-commerce, SEO, and maintenance.')

@section('content')
<div class="min-h-screen bg-white pt-24 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4" style="letter-spacing: -0.02em;">
                {{ optional($page)->hero_title ?? 'Our services' }}
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                {{ optional($page)->hero_subtitle ?? 'Comprehensive solutions to bring your digital vision to life' }}
            </p>
        </div>

        <div class="grid grid-cols-1 gap-12 md:grid-cols-2 lg:grid-cols-3">
            @foreach($services as $service)
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 group">
                    <div class="p-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-primary/10 text-primary mb-6">
                            @if($service->icon)
                                <i class="fas fa-{{ $service->icon }} text-2xl"></i>
                            @else
                                <i class="fas fa-code text-2xl"></i>
                            @endif
                        </div>

                        <h2 class="text-3xl font-semibold text-gray-900 mb-4">{{ $service->name }}</h2>
                        <p class="text-lg text-gray-600 leading-relaxed mb-6">{{ $service->description }}</p>

                        @if($service->base_price)
                            <div class="text-primary font-semibold mb-6">
                                Starting at {{ number_format($service->base_price, 2) }} USD
                            </div>
                        @endif

                        <a href="{{ route('order.create') }}" class="inline-flex items-center justify-center px-6 py-3 text-sm font-medium text-white bg-primary rounded-lg hover:bg-primary/90 transition-colors">
                            {{ $service->button_text ?? 'Get Started' }}
                        </a>
                    </div>
                </div>
            @endforeach

            @if($services->isEmpty())
                <div class="col-span-full text-center py-16">
                    <p class="text-gray-500 text-lg">No services available at the moment.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection