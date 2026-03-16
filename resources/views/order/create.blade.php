@extends('layouts.main')

@section('title', 'Start Your Project - Archvadze')
@section('description', 'Fill out the form below and we\'ll get back to you shortly')

@section('content')
<main class="pt-24 pb-20">
  <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
      <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4" style="letter-spacing: -0.02em;">
        Start your project
      </h1>
      <p class="text-xl text-gray-600 leading-relaxed">
        Fill out the form below and we'll get back to you shortly
      </p>
    </div>

    <form action="{{ route('order.store') }}" method="POST" class="space-y-6">
      @csrf

      @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
          <div class="flex">
            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-red-800">
                There were some errors with your submission:
              </h3>
              <div class="mt-2 text-sm text-red-700">
                <ul class="list-disc pl-5 space-y-1">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
        </div>
      @endif

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
          <label for="client_name" class="block text-sm font-medium text-gray-700">Full Name *</label>
          <input type="text" name="client_name" id="client_name" required
                 value="{{ old('client_name', auth()->check() && auth()->user()->client ? auth()->user()->client->name : '') }}"
                 class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-gray-900">
        </div>

        <div class="space-y-2">
          <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
          <input type="email" name="email" id="email" required
                 value="{{ old('email', auth()->check() && auth()->user()->client ? auth()->user()->client->email : '') }}"
                 class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-gray-900">
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
          <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
          <input type="tel" name="phone" id="phone"
                 value="{{ old('phone', auth()->check() && auth()->user()->client ? auth()->user()->client->phone : '') }}"
                 class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-gray-900">
        </div>

        <div class="space-y-2">
          <label for="domain" class="block text-sm font-medium text-gray-700">Domain Name *</label>
          <input type="text" name="domain" id="domain" required
                 value="{{ old('domain') }}"
                 placeholder="example.com"
                 class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-gray-900">
        </div>
      </div>

      <div class="space-y-2">
        <label for="website_type" class="block text-sm font-medium text-gray-700">Website Type *</label>
        <select name="website_type" id="website_type" required
                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-gray-900">
          <option value="">Select website type</option>
          <option value="business" {{ old('website_type') == 'business' ? 'selected' : '' }}>Business Website</option>
          <option value="e-commerce" {{ old('website_type') == 'e-commerce' ? 'selected' : '' }}>E-commerce</option>
          <option value="portfolio" {{ old('website_type') == 'portfolio' ? 'selected' : '' }}>Portfolio</option>
          <option value="blog" {{ old('website_type') == 'blog' ? 'selected' : '' }}>Blog</option>
          <option value="landing-page" {{ old('website_type') == 'landing-page' ? 'selected' : '' }}>Landing Page</option>
          <option value="other" {{ old('website_type') == 'other' ? 'selected' : '' }}>Other</option>
        </select>
      </div>

      <div class="space-y-3">
        <label class="block text-sm font-medium text-gray-700">Services Required *</label>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
          @foreach($services as $service)
          <div class="flex items-center space-x-2">
            <input type="checkbox" name="services[]" value="{{ $service->id }}" id="service-{{ $service->id }}"
                   {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}
                   class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
            <label for="service-{{ $service->id }}" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 cursor-pointer">
              {{ $service->name }}
              @if($service->base_price > 0)
                <span class="text-gray-500">(${number_format($service->base_price, 0)})</span>
              @endif
            </label>
          </div>
          @endforeach
        </div>
      </div>

      <div class="space-y-3">
        <label class="block text-sm font-medium text-gray-700">Additional Features</label>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
          @foreach($features as $feature)
          <div class="flex items-center space-x-2">
            <input type="checkbox" name="features[]" value="{{ $feature->id }}" id="feature-{{ $feature->id }}"
                   {{ in_array($feature->id, old('features', [])) ? 'checked' : '' }}
                   class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
            <label for="feature-{{ $feature->id }}" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 cursor-pointer">
              {{ $feature->name }}
              @if($feature->price > 0)
                <span class="text-gray-500">(${number_format($feature->price, 0)})</span>
              @endif
            </label>
          </div>
          @endforeach
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
          <label for="timeline" class="block text-sm font-medium text-gray-700">Preferred Timeline *</label>
          <select name="timeline" id="timeline" required
                  class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-gray-900">
            <option value="">Select timeline</option>
            <option value="asap" {{ old('timeline') == 'asap' ? 'selected' : '' }}>ASAP</option>
            <option value="1-month" {{ old('timeline') == '1-month' ? 'selected' : '' }}>1 Month</option>
            <option value="2-3-months" {{ old('timeline') == '2-3-months' ? 'selected' : '' }}>2-3 Months</option>
            <option value="3-6-months" {{ old('timeline') == '3-6-months' ? 'selected' : '' }}>3-6 Months</option>
            <option value="flexible" {{ old('timeline') == 'flexible' ? 'selected' : '' }}>Flexible</option>
          </select>
        </div>

        <div class="space-y-2">
          <label for="budget_range" class="block text-sm font-medium text-gray-700">Budget Range *</label>
          <select name="budget_range" id="budget_range" required
                  class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-gray-900">
            <option value="">Select budget</option>
            <option value="under-5k" {{ old('budget_range') == 'under-5k' ? 'selected' : '' }}>Under $5,000</option>
            <option value="5k-10k" {{ old('budget_range') == '5k-10k' ? 'selected' : '' }}>5,000 - 10,000</option>
            <option value="10k-25k" {{ old('budget_range') == '10k-25k' ? 'selected' : '' }}>10,000 - 25,000</option>
            <option value="25k-50k" {{ old('budget_range') == '25k-50k' ? 'selected' : '' }}>25,000 - 50,000</option>
            <option value="over-50k" {{ old('budget_range') == 'over-50k' ? 'selected' : '' }}>Over 50,000</option>
          </select>
        </div>
      </div>

      <div class="space-y-2">
        <label for="project_description" class="block text-sm font-medium text-gray-700">Project Description *</label>
        <textarea name="project_description" id="project_description" rows="5" required
                  class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-gray-900"
                  placeholder="Tell us about your project requirements...">{{ old('project_description') }}</textarea>
      </div>

      <div class="space-y-2">
        <label for="additional_requirements" class="block text-sm font-medium text-gray-700">Additional Requirements</label>
        <textarea name="additional_requirements" id="additional_requirements" rows="3"
                  class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-gray-900"
                  placeholder="Any specific technologies, integrations, or other requirements...">{{ old('additional_requirements') }}</textarea>
      </div>

      <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 w-full">
        Submit Order Request
      </button>
    </form>
  </div>
</main>
@endsection