<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Delivery extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'driver_name',
        'driver_phone',
        'tracking_number',
        'estimated_delivery_time',
        'actual_delivery_time',
        'status',
        'delivery_notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'estimated_delivery_time' => 'datetime',
            'actual_delivery_time' => 'datetime',
        ];
    }

    /**
     * Get the order that owns the delivery.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Check if the delivery is unassigned.
     */
    public function isUnassigned(): bool
    {
        return $this->status === 'unassigned';
    }

    /**
     * Check if the delivery is assigned.
     */
    public function isAssigned(): bool
    {
        return $this->status === 'assigned';
    }

    /**
     * Check if the delivery is out for delivery.
     */
    public function isOutForDelivery(): bool
    {
        return $this->status === 'out_for_delivery';
    }

    /**
     * Check if the delivery is delivered.
     */
    public function isDelivered(): bool
    {
        return $this->status === 'delivered';
    }

    /**
     * Check if the delivery failed.
     */
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    /**
     * Assign the delivery to a driver.
     */
    public function assignDriver(string $driverName, string $driverPhone = null): void
    {
        $this->update([
            'driver_name' => $driverName,
            'driver_phone' => $driverPhone,
            'status' => 'assigned',
        ]);
    }

    /**
     * Mark the delivery as delivered.
     */
    public function markAsDelivered(): void
    {
        $this->update([
            'status' => 'delivered',
            'actual_delivery_time' => now(),
        ]);
    }
}
