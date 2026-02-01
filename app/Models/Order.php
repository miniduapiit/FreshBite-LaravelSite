<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'total_amount',
        'delivery_address',
        'order_date',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'order_date' => 'datetime',
        ];
    }

    /**
     * Get the user that placed the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the unique suppliers for this order through order items.
     * Returns a collection of users with their supplier profiles.
     */
    public function getUniqueSuppliers()
    {
        $supplierIds = $this->orderItems()->pluck('supplier_id')->unique();
        return User::with('supplierProfile')->whereIn('id', $supplierIds)->get();
    }

    /**
     * Get the primary supplier user for this order.
     * Returns the supplier of the first order item.
     */
    public function getPrimarySupplierAttribute()
    {
        $firstItem = $this->orderItems()->first();
        if ($firstItem && $firstItem->supplier_id) {
            return User::with('supplierProfile')->find($firstItem->supplier_id);
        }
        return null;
    }

    /**
     * Get the order items for the order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the order items for the order (alias).
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the payment for the order.
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Get the delivery for the order.
     */
    public function delivery(): HasOne
    {
        return $this->hasOne(Delivery::class);
    }

    /**
     * Check if the order is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the order is confirmed.
     */
    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    /**
     * Check if the order is delivered.
     */
    public function isDelivered(): bool
    {
        return $this->status === 'delivered';
    }

    /**
     * Check if the order is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Scope to get orders by status.
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
}
