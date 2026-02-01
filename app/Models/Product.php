<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'supplier_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'image_url',
        'is_active',
        'stock_quantity',
        'approval_status',
        'approved_by',
        'approved_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
            'stock_quantity' => 'integer',
            'approved_at' => 'datetime',
        ];
    }

    /**
     * Get the supplier (user) that owns the product.
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    /**
     * Get the category that the product belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the admin who approved the product.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the order items for the product.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the cart items for the product.
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the wishlist items for the product.
     */
    public function wishlistItems(): HasMany
    {
        return $this->hasMany(WishlistItem::class);
    }

    /**
     * Get the reviews for the product.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Check if the product is approved.
     */
    public function isApproved(): bool
    {
        return $this->approval_status === 'approved';
    }

    /**
     * Check if the product is pending approval.
     */
    public function isPending(): bool
    {
        return $this->approval_status === 'pending';
    }

    /**
     * Check if the product is in stock.
     */
    public function inStock(): bool
    {
        return $this->stock_quantity > 0;
    }

    /**
     * Get the average rating of the product.
     */
    public function averageRating(): float
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Scope to get only active products.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get only approved products.
     */
    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'approved');
    }

    /**
     * Scope to get products in stock.
     */
    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }
}
