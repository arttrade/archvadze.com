<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Order;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderService
{
    public function __construct(
        private OrderRepository $orderRepository
    ) {}

    public function createOrder(array $data, ?int $clientId = null): Order
    {
        return DB::transaction(function () use ($data, $clientId) {
            // If client_id is provided, get client info
            if ($clientId) {
                $client = Client::find($clientId);
                if ($client) {
                    $data['client_id'] = $clientId;
                    $data['client_name'] = $client->name;
                    $data['email'] = $client->email;
                    $data['phone'] = $client->phone;
                }
            }

            // Calculate total price
            $totalPrice = $this->calculateTotalPrice($data);
            $data['price_estimate'] = $totalPrice;

            $order = $this->orderRepository->create($data);

            // Attach services and features
            if (isset($data['services']) && is_array($data['services'])) {
                $this->orderRepository->attachServices($order, $data['services']);
            }

            if (isset($data['features']) && is_array($data['features'])) {
                $this->orderRepository->attachFeatures($order, $data['features']);
            }

            // Send notification email (would implement later)
            // $this->sendOrderNotification($order);

            return $order;
        });
    }

    public function updateOrderStatus(int $orderId, string $status): bool
    {
        return $this->orderRepository->updateStatus($orderId, $status);
    }

    public function getOrderById(int $id): ?Order
    {
        return $this->orderRepository->findById($id);
    }

    public function getAllOrders(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->orderRepository->getAll();
    }

    public function getOrdersByClient(int $clientId): \Illuminate\Database\Eloquent\Collection
    {
        return $this->orderRepository->getByClient($clientId);
    }

    private function calculateTotalPrice(array $data): float
    {
        $total = 0;

        // Add service prices
        if (isset($data['services']) && is_array($data['services'])) {
            $services = \App\Models\Service::whereIn('id', $data['services'])->get();
            foreach ($services as $service) {
                $total += $service->base_price ?? 0;
            }
        }

        // Add feature prices
        if (isset($data['features']) && is_array($data['features'])) {
            $features = \App\Models\Feature::whereIn('id', $data['features'])->get();
            foreach ($features as $feature) {
                $total += $feature->price ?? 0;
            }
        }

        return $total;
    }

    public function getAvailableServices()
    {
        return \App\Models\Service::where('status', true)->get();
    }

    public function getAvailableFeatures()
    {
        return \App\Models\Feature::all();
    }
}