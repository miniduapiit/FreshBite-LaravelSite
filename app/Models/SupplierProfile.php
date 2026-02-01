<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierProfile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'business_name',
        'description',
        'business_phone',
        'business_address',
        'city',
        'state',
        'postal_code',
        'country',
        'logo',
        'is_active',
        'rating',
        'total_reviews',
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
            'total_reviews' => 'integer',
        ];
    }

    /**
     * Get the user that owns the supplier profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the products supplied by this profile (through user).
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'supplier_id', 'user_id');
    }

    /**
     * Update the supplier rating based on product reviews.
     */
    public function updateRating(): void
    {
        $reviews = Review::whereHas('product', function ($query) {
            $query->where('supplier_id', $this->user_id);
        })->get();

        if ($reviews->count() > 0) {
            $this->rating = $reviews->avg('rating');
            $this->total_reviews = $reviews->count();
            $this->save();
        }
    }
}
