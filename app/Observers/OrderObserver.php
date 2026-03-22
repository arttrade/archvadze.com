<?php
namespace App\Observers;

use App\Models\Order;
use App\Models\Project;
use App\Models\Client;

class OrderObserver
{
    public function updated(Order $order): void
    {
        if ($order->wasChanged('status') && $order->status === 'accepted') {
            $this->createProjectFromOrder($order);
        }
    }

    private function createProjectFromOrder(Order $order): void
    {
        $client = $order->client;

        if (!$client) {
            $client = Client::firstOrCreate(
                ['email' => $order->email],
                [
                    'name'  => $order->client_name,
                    'email' => $order->email,
                    'phone' => $order->phone,
                ]
            );
        }

        $exists = Project::where('client_id', $client->id)
            ->where('title', 'like', '%' . $order->domain . '%')
            ->exists();

        if (!$exists) {
            Project::create([
                'client_id'   => $client->id,
                'title'       => ucfirst(str_replace('-', ' ', $order->website_type)) . ' — ' . $order->domain,
                'description' => $order->project_description ?? 'Project created from order #' . $order->id,
                'status'      => 'pending',
                'price'       => $order->price_estimate,
                'deadline'    => now()->addDays(60),
            ]);
        }
    }
}
