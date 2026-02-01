<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'order_number' => $this->order_number,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'payment_method' => $this->payment_method,
            'subtotal' => (float) $this->subtotal,
            'tax_amount' => (float) $this->tax_amount,
            'delivery_fee' => (float) $this->delivery_fee,
            'discount_amount' => (float) $this->discount_amount,
            'total_amount' => (float) $this->total_amount,
            'delivery_address' => $this->delivery_address,
            'delivery_phone' => $this->delivery_phone,
            'special_instructions' => $this->special_instructions,
            'ordered_at' => $this->ordered_at?->toISOString(),
            'delivered_at' => $this->delivered_at?->toISOString(),
            'vendor' => $this->whenLoaded('vendor', function () {
                return [
                    'id' => $this->vendor->id,
                    'name' => $this->vendor->name,
                    'slug' => $this->vendor->slug,
                ];
            }),
            'order_items' => OrderItemResource::collection($this->whenLoaded('orderItems')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
