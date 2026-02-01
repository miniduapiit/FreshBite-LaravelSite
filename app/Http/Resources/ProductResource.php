<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => (float) $this->price,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'is_available' => $this->is_available,
            'is_featured' => $this->is_featured,
            'stock_quantity' => $this->stock_quantity,
            'preparation_time' => $this->preparation_time,
            'calories' => $this->calories,
            'allergens' => $this->allergens,
            'category' => [
                'id' => $this->category->id ?? null,
                'name' => $this->category->name ?? null,
                'slug' => $this->category->slug ?? null,
            ],
            'vendor' => [
                'id' => $this->vendor->id ?? null,
                'name' => $this->vendor->name ?? null,
                'slug' => $this->vendor->slug ?? null,
            ],
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
