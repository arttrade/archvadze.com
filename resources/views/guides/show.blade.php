@extends('layouts.main')

@section('title', $guide->title . ' - Archvadze Guides')
@section('description', 'Guide: ' . $guide->title)

@section('content')
<main class="pt-24 pb-20">
  <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Guide Header -->
    <header class="mb-12">
      <div class="text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight" style="letter-spacing: -0.02em;">
          {{ $guide->title }}
        </h1>
        @if($guide->category)
        <div class="flex items-center justify-center space-x-4 text-sm text-gray-500">
          <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary/10 text-primary">
            {{ $guide->category->name }}
          </span>
          @if($guide->published_at)
          <span>{{ $guide->published_at->format('M j, Y') }}</span>
          @endif
        </div>
        @endif
      </div>
    </header>

    <!-- Guide Content -->
    <div class="prose prose-lg prose-gray max-w-none mb-12">
      {!! $guide->content !!}
    </div>

    <!-- Back to Guides -->
    <div class="text-center">
      <a href="{{ route('guides') }}"
         class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary/90 transition-colors">
        <svg class="mr-2 -ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Back to Guides
      </a>
    </div>
  </article>
</main>
@endsection