<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class AddToCartButton extends Component
{
    public Product $product;
    public $quantity = 1;

    public function addToCart()
    {
        try {
            Log::info('AddToCart button clicked', [
                'product_id' => $this->product->id,
                'quantity' => $this->quantity
            ]);
            
            // Get or create cart in session
            $cart = session()->get('cart', []);
            
            // Add or update product in cart
            if (isset($cart[$this->product->id])) {
                $cart[$this->product->id]['quantity'] += $this->quantity;
            } else {
                $cart[$this->product->id] = [
                    'product_id' => $this->product->id,
                    'name' => $this->product->name,
                    'slug' => $this->product->slug,
                    'price' => $this->product->price,
                    'image' => $this->product->image_url,
                    'supplier_id' => $this->product->supplier_id,
                    'supplier_name' => $this->product->supplier->name ?? 'Unknown',
                    'quantity' => $this->quantity,
                ];
            }
            
            // Save cart to session
            session()->put('cart', $cart);
            
            Log::info('Product added to cart', ['cart' => $cart]);
            
            // Dispatch success event
            $this->dispatch('cart-success', message: 'Product added to cart successfully!');
            $this->dispatch('cart-updated');
            
            // Reset quantity
            $this->quantity = 1;
            
        } catch (\Exception $e) {
            Log::error('Error adding to cart', [
                'error' => $e->getMessage(),
                'product_id' => $this->product->id
            ]);
            
            $this->dispatch('cart-error', message: 'Failed to add product to cart: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.add-to-cart-button');
    }
}
