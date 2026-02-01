<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
    ];

    /**
     * Get the user that owns the cart.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the cart items for the cart.
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the total number of items in the cart.
     */
    public function totalItems(): int
    {
        return $this->items()->sum('quantity');
    }

    /**
     * Get the total amount of the cart.
     */
    public function totalAmount(): float
    {
        return $this->items()->get()->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }

    /**
     * Clear all items from the cart.
     */
    public function clear(): void
    {
        $this->items()->delete();
    }
}
