<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'logo',
        'is_active',
        'rating',
        'delivery_time',
        'minimum_order',
        'delivery_fee',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'rating' => 'decimal:2',
            'delivery_time' => 'integer',
            'minimum_order' => 'decimal:2',
            'delivery_fee' => 'decimal:2',
        ];
    }

    /**
     * Get the user (owner) that owns the vendor.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the products for the vendor.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the orders for the vendor.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
