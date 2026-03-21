<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'client_name',
        'email',
        'phone',
        'domain',
        'website_type',
        'price_estimate',
        'status',
        'timeline',
        'budget_range',
        'project_description',
        'additional_requirements',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'order_services');
    }

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class, 'order_features');
    }
}
