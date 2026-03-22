@extends('layouts.main')
@section('title', $project->title . ' - Dashboard')

@section('content')
<main class="pt-24 pb-20 bg-gray-50 min-h-screen">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- Header --}}
    <div class="mb-8 flex items-start justify-between">
      <div>
        <div class="flex items-center gap-3 mb-2">
          <a href="{{ route('client-dashboard.index') }}"
             class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Dashboard
          </a>
          <span class="text-gray-300">/</span>
          <span class="text-sm text-gray-500">{{ $project->title }}</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-900" style="letter-spacing:-0.02em">
          {{ $project->title }}
        </h1>
        <div class="flex items-center gap-4 mt-2">
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
            @if($project->status === 'completed') bg-green-100 text-green-800
            @elseif($project->status === 'in_progress') bg-blue-100 text-blue-800
            @elseif($project->status === 'review') bg-yellow-100 text-yellow-800
            @else bg-gray-100 text-gray-800 @endif">
            {{ ucfirst(str_replace('_', ' ', $project->status)) }}
          </span>
          @if($project->deadline)
            <span class="text-sm text-gray-500">
              Due: {{ \Carbon\Carbon::parse($project->deadline)->format('M j, Y') }}
            </span>
          @endif
          @if($project->price)
            <span class="text-sm text-gray-500">
              Price: ${{ number_format($project->price, 2) }}
            </span>
          @endif
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      {{-- Main Content --}}
      <div class="lg:col-span-2 space-y-6">

        {{-- Description --}}
        @if($project->description)
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
          <h2 class="text-lg font-semibold text-gray-900 mb-3">Project Description</h2>
          <p class="text-gray-600 leading-relaxed">{{ $project->description }}</p>
        </div>
        @endif

        {{-- Messages --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
          <h2 class="text-lg font-semibold text-gray-900 mb-6">Messages</h2>

          {{-- Message Form --}}
          @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-4 text-sm text-green-800">
              {{ session('success') }}
            </div>
          @endif

          <form action="{{ route('client-dashboard.send-message', $project->id) }}" method="POST" class="mb-6">
            @csrf
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Send Message</label>
              <textarea name="message" rows="3" required
                class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring text-gray-900"
                placeholder="Type your message..."></textarea>
              @error('message')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
            </div>
            <div class="mt-3">
              <button type="submit"
                class="inline-flex items-center justify-center rounded-md bg-primary text-primary-foreground hover:bg-primary/90 text-sm font-medium h-9 px-4">
                Send Message
              </button>
            </div>
          </form>

          {{-- Messages List --}}
          <div class="space-y-4">
            @forelse($messages as $message)
            <div class="flex items-start gap-3 {{ $message->sender_id === auth()->id() ? 'flex-row-reverse' : '' }}">
              <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary flex items-center justify-center">
                <span class="text-white text-xs font-bold">
                  {{ substr($message->sender->name ?? 'U', 0, 1) }}
                </span>
              </div>
              <div class="flex-1 {{ $message->sender_id === auth()->id() ? 'items-end' : '' }}">
                <div class="flex items-center gap-2 mb-1 {{ $message->sender_id === auth()->id() ? 'justify-end' : '' }}">
                  <span class="text-xs font-medium text-gray-900">{{ $message->sender->name ?? 'Unknown' }}</span>
                  <span class="text-xs text-gray-400">{{ $message->created_at->diffForHumans() }}</span>
                </div>
                <div class="inline-block px-4 py-2.5 rounded-2xl text-sm
                  {{ $message->sender_id === auth()->id()
                    ? 'bg-primary text-white rounded-tr-sm'
                    : 'bg-gray-100 text-gray-900 rounded-tl-sm' }}">
                  {{ $message->message }}
                </div>
              </div>
            </div>
            @empty
            <div class="text-center py-8">
              <p class="text-gray-400 text-sm">No messages yet. Start the conversation!</p>
            </div>
            @endforelse
          </div>
        </div>
      </div>

      {{-- Sidebar --}}
      <div class="space-y-6">

        {{-- File Upload --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
          <h3 class="text-base font-semibold text-gray-900 mb-4">Upload File</h3>
          <form action="{{ route('client-dashboard.upload-file', $project->id) }}"
                method="POST" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <input type="file" name="file" required
              class="block w-full text-sm text-gray-500
                file:mr-3 file:py-2 file:px-4 file:rounded-md file:border-0
                file:text-sm file:font-medium file:bg-primary/10 file:text-primary
                hover:file:bg-primary/20 cursor-pointer">
            @error('file')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
            <button type="submit"
              class="w-full inline-flex justify-center items-center rounded-md bg-primary text-primary-foreground hover:bg-primary/90 text-sm font-medium h-9 px-4">
              Upload
            </button>
          </form>
        </div>

        {{-- Files List --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
          <h3 class="text-base font-semibold text-gray-900 mb-4">Project Files</h3>
          @if($files->count() > 0)
            <div class="space-y-2">
              @foreach($files as $file)
              <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center gap-2 min-w-0">
                  <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                  </svg>
                  <div class="min-w-0">
                    <p class="text-xs font-medium text-gray-900 truncate">{{ basename($file->file_path) }}</p>
                    <p class="text-xs text-gray-400">{{ $file->created_at->diffForHumans() }}</p>
                  </div>
                </div>
                <a href="{{ route('client-dashboard.download-file', $file->id) }}"
                   class="flex-shrink-0 text-xs text-primary hover:text-primary/80 font-medium ml-2">
                  Download
                </a>
              </div>
              @endforeach
            </div>
          @else
            <p class="text-gray-400 text-sm text-center py-4">No files yet</p>
          @endif
        </div>

        {{-- Project Info --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
          <h3 class="text-base font-semibold text-gray-900 mb-4">Project Info</h3>
          <dl class="space-y-3">
            <div>
              <dt class="text-xs text-gray-400 uppercase tracking-wide">Status</dt>
              <dd class="mt-0.5">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                  @if($project->status === 'completed') bg-green-100 text-green-800
                  @elseif($project->status === 'in_progress') bg-blue-100 text-blue-800
                  @elseif($project->status === 'review') bg-yellow-100 text-yellow-800
                  @else bg-gray-100 text-gray-800 @endif">
                  {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                </span>
              </dd>
            </div>
            @if($project->price)
            <div>
              <dt class="text-xs text-gray-400 uppercase tracking-wide">Price</dt>
              <dd class="text-sm font-semibold text-gray-900">${{ number_format($project->price, 2) }}</dd>
            </div>
            @endif
            @if($project->deadline)
            <div>
              <dt class="text-xs text-gray-400 uppercase tracking-wide">Deadline</dt>
              <dd class="text-sm font-semibold text-gray-900">
                {{ \Carbon\Carbon::parse($project->deadline)->format('M j, Y') }}
              </dd>
            </div>
            @endif
            <div>
              <dt class="text-xs text-gray-400 uppercase tracking-wide">Started</dt>
              <dd class="text-sm text-gray-900">{{ $project->created_at->format('M j, Y') }}</dd>
            </div>
          </dl>
        </div>

      </div>
    </div>
  </div>
</main>
@endsection
