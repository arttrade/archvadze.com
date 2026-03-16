@extends('layouts.auth', ['title' => 'Sign in to your account'])

@section('auth-content')

<!-- Session Status -->
@if (session('status'))
    <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg p-4">
        {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-4">
        <ul class="text-sm text-red-600 bg-red-50 border border-red-200 rounded-lg p-4">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('login') }}" class="space-y-6">
    @csrf

    <!-- Email Address -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">
            Email address
        </label>
        <div class="mt-1">
            <input id="email" name="email" type="email" autocomplete="email" required
                   value="{{ old('email') }}"
                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
        </div>
    </div>

    <!-- Password -->
    <div>
        <label for="password" class="block text-sm font-medium text-gray-700">
            Password
        </label>
        <div class="mt-1">
            <input id="password" name="password" type="password" autocomplete="current-password" required
                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
        </div>
    </div>

    <!-- Remember Me -->
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <input id="remember_me" name="remember" type="checkbox"
                   class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
            <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                Remember me
            </label>
        </div>

        @if (Route::has('password.request'))
            <div class="text-sm">
                <a href="{{ route('password.request') }}" class="font-medium text-primary hover:text-primary/80 transition-colors">
                    Forgot your password?
                </a>
            </div>
        @endif
    </div>

    <div>
        <button type="submit"
                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
            Sign in
        </button>
    </div>

    <div class="text-center">
        <p class="text-sm text-gray-600">
            Don't have an account?
            <a href="{{ route('register') }}" class="font-medium text-primary hover:text-primary/80 transition-colors">
                Sign up
            </a>
        </p>
    </div>
</form>
@endsection
