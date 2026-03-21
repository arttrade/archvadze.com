@extends('layouts.main')
@section('title', 'Order Submitted - Archvadze')

@section('content')
<main class="pt-24 pb-20">
  <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- Success Header --}}
    <div class="text-center mb-10">
      <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
      </div>
      <h1 class="text-4xl font-bold text-gray-900 mb-3" style="letter-spacing: -0.02em;">Order Submitted!</h1>
      <p class="text-xl text-gray-600">Thank you! We will contact you within 24 hours.</p>
    </div>

    {{-- Order Details --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mb-6">
      <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="text-lg font-semibold text-gray-900">Order #{{ $order->id }}</h2>
      </div>
      <dl class="divide-y divide-gray-100">
        <div class="px-6 py-4 grid grid-cols-3 gap-4">
          <dt class="text-sm text-gray-500">Status</dt>
          <dd class="col-span-2">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
              {{ ucfirst($order->status) }}
            </span>
          </dd>
        </div>
        <div class="px-6 py-4 grid grid-cols-3 gap-4">
          <dt class="text-sm text-gray-500">Domain</dt>
          <dd class="col-span-2 text-sm text-gray-900 font-medium">{{ $order->domain }}</dd>
        </div>
        <div class="px-6 py-4 grid grid-cols-3 gap-4">
          <dt class="text-sm text-gray-500">Website Type</dt>
          <dd class="col-span-2 text-sm text-gray-900">{{ ucfirst(str_replace('-', ' ', $order->website_type)) }}</dd>
        </div>
        <div class="px-6 py-4 grid grid-cols-3 gap-4">
          <dt class="text-sm text-gray-500">Timeline</dt>
          <dd class="col-span-2 text-sm text-gray-900">{{ ucfirst(str_replace('-', ' ', $order->timeline ?? '-')) }}</dd>
        </div>
        <div class="px-6 py-4 grid grid-cols-3 gap-4">
          <dt class="text-sm text-gray-500">Budget</dt>
          <dd class="col-span-2 text-sm text-gray-900">{{ str_replace('-', ' ', $order->budget_range ?? '-') }}</dd>
        </div>
        <div class="px-6 py-4 grid grid-cols-3 gap-4">
          <dt class="text-sm text-gray-500">Services</dt>
          <dd class="col-span-2">
            @if($order->services->count() > 0)
              <div class="flex flex-wrap gap-1">
                @foreach($order->services as $service)
                  <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-primary/10 text-primary">
                    {{ $service->name }}
                  </span>
                @endforeach
              </div>
            @else
              <span class="text-sm text-gray-400">None</span>
            @endif
          </dd>
        </div>
        @if($order->features->count() > 0)
        <div class="px-6 py-4 grid grid-cols-3 gap-4">
          <dt class="text-sm text-gray-500">Features</dt>
          <dd class="col-span-2">
            <div class="flex flex-wrap gap-1">
              @foreach($order->features as $feature)
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-700">
                  {{ $feature->name }}
                </span>
              @endforeach
            </div>
          </dd>
        </div>
        @endif
        <div class="px-6 py-4 grid grid-cols-3 gap-4">
          <dt class="text-sm text-gray-500">Estimated Total</dt>
          <dd class="col-span-2 text-sm font-bold text-gray-900">${{ number_format($order->price_estimate, 2) }}</dd>
        </div>
        <div class="px-6 py-4 grid grid-cols-3 gap-4">
          <dt class="text-sm text-gray-500">Submitted</dt>
          <dd class="col-span-2 text-sm text-gray-900">{{ $order->created_at->format('M j, Y \a\t g:i A') }}</dd>
        </div>
      </dl>
    </div>

    {{-- Next Steps --}}
    <div class="bg-blue-50 rounded-xl border border-blue-100 p-6 mb-8">
      <h3 class="text-sm font-semibold text-blue-900 mb-3">What's Next?</h3>
      <ol class="space-y-2 text-sm text-blue-800">
        <li class="flex items-start gap-2"><span class="font-bold">1.</span> Our team will review your order within 24 hours</li>
        <li class="flex items-start gap-2"><span class="font-bold">2.</span> We'll send you a detailed proposal with timeline and pricing</li>
        <li class="flex items-start gap-2"><span class="font-bold">3.</span> Once approved, we'll start working on your project</li>
        <li class="flex items-start gap-2"><span class="font-bold">4.</span> You'll receive regular updates through your dashboard</li>
      </ol>
    </div>

    {{-- Actions --}}
    <div class="flex flex-col sm:flex-row gap-4">
      <a href="{{ route('client-dashboard.index') }}"
         class="inline-flex justify-center items-center rounded-md text-sm font-medium bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-6 py-2 flex-1">
        View Dashboard
      </a>
      <a href="{{ route('home') }}"
         class="inline-flex justify-center items-center rounded-md text-sm font-medium border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 h-10 px-6 py-2 flex-1">
        Back to Home
      </a>
    </div>

  </div>
</main>
@endsection
