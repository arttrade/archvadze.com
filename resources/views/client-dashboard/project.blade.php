<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $project->title }} - Client Dashboard</title>
    <meta name="description" content="Project details for {{ $project->title }}">
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
                    <div class="ml-3 relative">
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-700">{{ Auth::user()->name }}</span>
                            <a href="{{ route('client-dashboard.index') }}" class="bg-indigo-600 text-white px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-500 hover:text-gray-700 text-sm">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Project Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="min-w-0 flex-1">
                    <h1 class="text-3xl font-bold leading-7 text-gray-900 sm:truncate sm:text-4xl sm:tracking-tight">
                        {{ $project->title }}
                    </h1>
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($project->status === 'completed') bg-green-100 text-green-800
                            @elseif($project->status === 'in_progress') bg-blue-100 text-blue-800
                            @elseif($project->status === 'review') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                        </span>
                        @if($project->deadline)
                        <span class="ml-4">Due: {{ $project->deadline->format('M j, Y') }}</span>
                        @endif
                        @if($project->price)
                        <span class="ml-4">Price: ${{ number_format($project->price, 2) }}</span>
                        @endif
                    </div>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <a href="{{ route('client-dashboard.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        ← Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Project Content -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Description -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Project Description</h2>
                        <p class="text-gray-600">{{ $project->description }}</p>
                    </div>

                    <!-- Messages -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Messages</h2>

                        <!-- Message Form -->
                        <form action="{{ route('client-dashboard.send-message', $project->id) }}" method="POST" class="mb-6">
                            @csrf
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700">Send Message</label>
                                <textarea name="message" id="message" rows="3" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    Send Message
                                </button>
                            </div>
                        </form>

                        <!-- Messages List -->
                        <div class="space-y-4">
                            @forelse($messages as $message)
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center">
                                            <span class="text-white text-sm font-medium">
                                                {{ substr($message->sender->name, 0, 1) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-sm font-medium text-gray-900">{{ $message->sender->name }}</span>
                                            <span class="text-sm text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-sm text-gray-700 mt-1">{{ $message->message }}</p>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center py-4">No messages yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- File Upload -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Upload Files</h3>
                        <form action="{{ route('client-dashboard.upload-file', $project->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <label for="file" class="block text-sm font-medium text-gray-700">Select File</label>
                                <input type="file" name="file" id="file" required class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    Upload File
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Files List -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Project Files</h3>
                        @if($files->count() > 0)
                        <div class="space-y-3">
                            @foreach($files as $file)
                            <div class="flex items-center justify-between bg-white rounded-lg p-3 shadow-sm">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ basename($file->file_path) }}</p>
                                    <p class="text-xs text-gray-500">Uploaded {{ $file->created_at->diffForHumans() }} by {{ $file->uploader->name }}</p>
                                </div>
                                <a href="{{ route('client-dashboard.download-file', $file->id) }}" class="ml-3 inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                                    Download
                                </a>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-gray-500 text-sm">No files uploaded yet.</p>
                        @endif
                    </div>
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