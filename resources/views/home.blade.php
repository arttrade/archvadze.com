@extends('layouts.main')

@section('title', $homePage->seo_title ?? 'archvadze - Build Your Digital Presence')
@section('description', $homePage->seo_description ?? 'Professional web design and development services. Create stunning websites that drive results for your business.')

@section('content')

<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0">
        @if($homePage && $homePage->hero_image)
            <img
                src="{{ asset('storage/' . $homePage->hero_image) }}"
                alt="{{ $homePage->hero_title ?? 'Hero image' }}"
                class="w-full h-full object-cover"
            />
        @endif
        <div class="absolute inset-0 bg-gradient-to-r from-gray-900/90 to-gray-900/70"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
            {{ $homePage->hero_title ?? 'Build your digital presence' }}
        </h1>

        <p class="text-xl text-gray-200 mb-8 max-w-2xl mx-auto">
            {{ $homePage->hero_subtitle ?? 'Professional web design and development services that transform your vision into reality' }}
        </p>

        @if($homePage && $homePage->hero_button_text)
        <a href="{{ $homePage->hero_button_url ?? route('order.create') }}"
           class="inline-flex items-center px-8 py-4 text-lg font-medium text-white bg-primary rounded-lg hover:bg-primary/90">
            {{ $homePage->hero_button_text }}
        </a>
        @endif
    </div>
</section>


<!-- Portfolio Section -->
<section class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">

        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">
                {{ $homePage->portfolio_title ?? 'Our Portfolio' }}
            </h2>

            <p class="text-xl text-gray-600">
                {{ $homePage->portfolio_subtitle ?? 'Showcasing our latest projects' }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach($featuredProjects ?? [] as $project)

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">

                @if($project->cover_image)
                <img
                    src="{{ asset('storage/'.$project->cover_image) }}"
                    class="w-full h-48 object-cover"
                >
                @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500">No image available</span>
                </div>
                @endif

                <div class="p-6">

                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                        {{ $project->title }}
                    </h3>

                    <p class="text-gray-600 mb-4">
                        {{ Str::limit($project->description,100) }}
                    </p>

                    @if($project->technologies)

                    @php
                    $techs = is_array($project->technologies)
                        ? $project->technologies
                        : explode(',', $project->technologies);
                    @endphp

                    <div class="flex flex-wrap gap-2">

                        @foreach($techs as $tech)

                        @if(trim($tech))

                        <span class="px-2 py-1 text-xs bg-gray-100 rounded">
                            {{ trim($tech) }}
                        </span>

                        @endif
                        @endforeach

                    </div>

                    @endif

                </div>
            </div>

            @endforeach

        </div>

    </div>
</section>


<!-- Services Section -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4">

        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">
                {{ $homePage->services_title ?? 'Our Services' }}
            </h2>
            <p class="text-xl text-gray-600">
                {{ $homePage->services_subtitle ?? 'Comprehensive web solutions tailored to your business needs' }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach($featuredServices as $service)
            <div class="bg-gray-50 p-8 rounded-lg text-center hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-{{ $service->icon ?? 'code' }} text-white text-2xl"></i>
                </div>

                <h3 class="text-xl font-semibold text-gray-900 mb-4">
                    {{ $service->name }}
                </h3>

                <p class="text-gray-600">
                    {{ $service->description }}
                </p>
            </div>
            @endforeach

        </div>

    </div>
</section>


<!-- Features Section -->
<section class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">

        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">
                {{ $homePage->features_title ?? 'Why Choose Us' }}
            </h2>
            <p class="text-xl text-gray-600">
                {{ $homePage->features_subtitle ?? 'What sets us apart from the competition' }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

            @foreach($features as $feature)
            <div class="text-center">
                <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-{{ $feature->icon ?? 'star' }} text-white text-2xl"></i>
                </div>

                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                    {{ $feature->name }}
                </h3>

                <p class="text-gray-600 text-sm">
                    {{ $feature->description }}
                </p>
            </div>
            @endforeach

        </div>

    </div>
</section>


<!-- Testimonials -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-3" style="letter-spacing:-0.02em">
                {{ $homePage->testimonials_title ?? 'What our clients say' }}
            </h2>
            <p class="text-gray-500">Real feedback from businesses we've helped grow</p>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            @foreach($testimonials ?? [] as $testimonial)
            <div class="border border-gray-200 rounded-2xl p-8">
                {{-- Quote icon SVG --}}
                <svg class="w-8 h-8 text-primary/30 mb-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.598-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.598-3.996 5.849h3.983v10h-9.983z"/>
                </svg>

                <p class="text-gray-700 leading-relaxed mb-6">
                    {{ $testimonial->testimonial_text }}
                </p>

                {{-- Author --}}
                <div class="flex items-center gap-3">
                    @if($testimonial->photo)
                        <img src="{{ asset('storage/'.$testimonial->photo) }}"
                             alt="{{ $testimonial->client_name }}"
                             class="w-10 h-10 rounded-full object-cover">
                    @else
                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-sm">
                            {{ substr($testimonial->client_name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <p class="font-semibold text-gray-900 text-sm">{{ $testimonial->client_name }}</p>
                        <p class="text-xs text-gray-500">
                            {{ $testimonial->client_position }}{{ $testimonial->company ? ', '.$testimonial->company : '' }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection