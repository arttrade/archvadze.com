@extends('layouts.main')

@section('title', optional($page)->seo_title ?? 'Guides - Archvadze')
@section('description', optional($page)->seo_description ?? 'Comprehensive guides for web development')

@section('content')
<main class="pt-24 pb-20">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16">
      <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4" style="letter-spacing: -0.02em;">
        {{ optional($page)->hero_title ?? 'Guides' }}
      </h1>
      <p class="text-xl text-gray-600 leading-relaxed max-w-2xl mx-auto">
        {{ optional($page)->hero_subtitle ?? 'Step-by-step guides to help you master web development.' }}
      </p>
    </div>

    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
      @foreach($guides as $guide)
      <article class="group bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300">
        <div class="p-6">
          <h2 class="text-xl font-semibold text-gray-900 mb-3 group-hover:text-primary transition-colors">
            <a href="{{ route('guides.show', $guide->slug) }}" class="block">
              {{ $guide->title }}
            </a>
          </h2>
          <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">
            {{ Str::limit(strip_tags($guide->content), 150) }}
          </p>
          <div class="flex items-center justify-between">
            <div class="flex items-center text-sm text-gray-500">
              @if($guide->published_at)
              <span>{{ $guide->published_at->format('M j, Y') }}</span>
              @endif
            </div>
            <a href="{{ route('guides.show', $guide->slug) }}"
               class="inline-flex items-center text-sm font-medium text-primary hover:text-primary/80 transition-colors">
              Read Guide
              <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </a>
          </div>
        </div>
      </article>
      @endforeach
    </div>

    @if($guides->hasPages())
    <div class="mt-12 flex justify-center">
      <div class="flex space-x-1">
        {{-- Previous Page Link --}}
        @if ($guides->onFirstPage())
          <span class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md cursor-not-allowed">
            Previous
          </span>
        @else
          <a href="{{ $guides->previousPageUrl() }}" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50 transition-colors">
            Previous
          </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($guides->getUrlRange(1, $guides->lastPage()) as $page => $url)
          @if ($page == $guides->currentPage())
            <span class="px-3 py-2 text-sm font-medium text-white bg-primary border border-primary">
              {{ $page }}
            </span>
          @else
            <a href="{{ $url }}" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 transition-colors">
              {{ $page }}
            </a>
          @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($guides->hasMorePages())
          <a href="{{ $guides->nextPageUrl() }}" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50 transition-colors">
            Next
          </a>
        @else
          <span class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md cursor-not-allowed">
            Next
          </span>
        @endif
      </div>
    </div>
    @endif
  </div>
</main>
@endsection