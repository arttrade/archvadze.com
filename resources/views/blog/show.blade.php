@extends('layouts.main')

@section('title', $publication->title . ' - Archvadze Blog')
@section('description', $publication->excerpt ?? Str::limit(strip_tags($publication->content), 160))

@section('content')
<main class="pt-24 pb-20">
  <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Article Header -->
    <header class="mb-12">
      <div class="text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight" style="letter-spacing: -0.02em;">
          {{ $publication->title }}
        </h1>
        @if($publication->excerpt)
        <p class="text-xl text-gray-600 leading-relaxed max-w-2xl mx-auto mb-6">
          {{ $publication->excerpt }}
        </p>
        @endif
        <div class="flex items-center justify-center space-x-4 text-sm text-gray-500">
          <time datetime="{{ $publication->published_at->format('Y-m-d') }}">
            {{ $publication->published_at->format('M j, Y') }}
          </time>
          @if($publication->author)
          <span>•</span>
          <span>By {{ $publication->author->name }}</span>
          @endif
          @if($publication->categories->count() > 0)
          <span>•</span>
          <div class="flex space-x-2">
            @foreach($publication->categories as $category)
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary">
              {{ $category->name }}
            </span>
            @endforeach
          </div>
          @endif
        </div>
      </div>
    </header>

    <!-- Article Content -->
    <div class="prose prose-lg prose-gray max-w-none mb-12">
      {!! $publication->content !!}
    </div>

    <!-- Tags -->
    @if($publication->tags->count() > 0)
    <div class="border-t border-gray-200 pt-8 mb-12">
      <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-4">Tags</h3>
      <div class="flex flex-wrap gap-2">
        @foreach($publication->tags as $tag)
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 hover:bg-gray-200 transition-colors">
          {{ $tag->name }}
        </span>
        @endforeach
      </div>
    </div>
    @endif

    <!-- Back to Blog -->
    <div class="text-center">
      <a href="{{ route('blog') }}"
         class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary/90 transition-colors">
        <svg class="mr-2 -ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Back to Blog
      </a>
    </div>
  </article>
</main>
@endsection