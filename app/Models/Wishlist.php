<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wishlist extends Model
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
     * Get the user that owns the wishlist.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the wishlist items for the wishlist.
     */
    public function items(): HasMany
    {
        return $this->hasMany(WishlistItem::class);
    }

    /**
     * Check if a product is in the wishlist.
     */
    public function hasProduct(int $productId): bool
    {
        return $this->items()->where('product_id', $productId)->exists();
    }

    /**
     * Add a product to the wishlist.
     */
    public function addProduct(int $productId): WishlistItem
    {
        return $this->items()->firstOrCreate(['product_id' => $productId]);
    }

    /**
     * Remove a product from the wishlist.
     */
    public function removeProduct(int $productId): void
    {
        $this->items()->where('product_id', $productId)->delete();
    }
}
