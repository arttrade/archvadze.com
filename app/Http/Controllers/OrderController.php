<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ) {}

    public function create()
    {
        $services = $this->orderService->getAvailableServices();
        $features = $this->orderService->getAvailableFeatures();

        return view('order.create', compact('services', 'features'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'domain' => 'required|string|max:255',
            'website_type' => 'required|string|max:255',
            'timeline' => 'required|string|max:255',
            'budget_range' => 'required|string|max:255',
            'services' => 'required|array|min:1',
            'services.*' => 'exists:services,id',
            'features' => 'nullable|array',
            'features.*' => 'exists:features,id',
            'project_description' => 'required|string|max:2000',
            'additional_requirements' => 'nullable|string|max:2000',
        ]);

        // Get client ID if user is authenticated and has client role
        $clientId = null;
        if (Auth::check() && Auth::user()->hasRole('Client') && Auth::user()->client) {
            $clientId = Auth::user()->client->id;
        }

        try {
            $order = $this->orderService->createOrder($validated, $clientId);

            return redirect()->route('order.success', $order->id)
                ->with('success', 'Your order has been submitted successfully! We will contact you soon.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to submit order. Please try again.');
        }
    }

    public function success($orderId)
    {
        $order = $this->orderService->getOrderById($orderId);

        if (!$order) {
            abort(404);
        }

        return view('order.success', compact('order'));
    }
}
