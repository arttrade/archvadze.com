@extends('layouts.auth', ['title' => 'Create your account'])

@section('auth-content')

<!-- Validation Errors -->
@if ($errors->any())
    <div class="mb-4">
        <ul class="text-sm text-red-600 bg-red-50 border border-red-200 rounded-lg p-4">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('register') }}" class="space-y-6">
    @csrf

    <!-- Name -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">
            Full name
        </label>
        <div class="mt-1">
            <input id="name" name="name" type="text" autocomplete="name" required
                   value="{{ old('name') }}"
                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
        </div>
    </div>

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
            <input id="password" name="password" type="password" autocomplete="new-password" required
                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
        </div>
    </div>

    <!-- Confirm Password -->
    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
            Confirm password
        </label>
        <div class="mt-1">
            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
        </div>
    </div>

    <div>
        <button type="submit"
                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
            Create account
        </button>
    </div>

    <div class="text-center">
        <p class="text-sm text-gray-600">
            Already have an account?
            <a href="{{ route('login') }}" class="font-medium text-primary hover:text-primary/80 transition-colors">
                Sign in
            </a>
        </p>
    </div>
</form>
@endsection
