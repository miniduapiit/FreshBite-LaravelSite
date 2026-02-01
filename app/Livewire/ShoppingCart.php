<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ShoppingCart extends Component
{
    public $cart = [];
    public $vendorId = null;

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cart = session()->get('cart', []);
        $this->updateVendorId();
    }

    public function updateVendorId()
    {
        if (!empty($this->cart)) {
            $firstItem = reset($this->cart);
            $this->vendorId = $firstItem['supplier_id'] ?? null;
        }
    }

    protected $listeners = ['add-to-cart' => 'handleAddToCart'];

    public function handleAddToCart($productId, $quantity = 1)
    {
        $this->addToCart($productId, $quantity);
    }

    public function addToCart($productId, $quantity = 1)
    {
        $product = Product::with('supplier')->findOrFail($productId);

        // Check if cart is empty or all items are from the same supplier
        if (!empty($this->cart)) {
            $currentVendorId = $this->vendorId;
            if ($currentVendorId && $product->supplier_id != $currentVendorId) {
                $this->dispatch('cart-error', message: 'All items must be from the same supplier. Please clear your cart first.');
                return;
            }
        }

        // Check if product is available
        if (!$product->is_active) {
            $this->dispatch('cart-error', message: 'This product is currently unavailable.');
            return;
        }

        // Add or update item in cart
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity'] += $quantity;
        } else {
            $this->cart[$productId] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->price,
                'image' => $product->image_url,
                'supplier_id' => $product->supplier_id,
                'supplier_name' => $product->supplier->name ?? 'Unknown',
                'quantity' => $quantity,
            ];
        }

        $this->saveCart();
        $this->dispatch('cart-updated');
        $this->dispatch('cart-success', message: 'Product added to cart!');
    }

    public function removeFromCart($productId)
    {
        if (isset($this->cart[$productId])) {
            unset($this->cart[$productId]);
            $this->saveCart();
            $this->updateVendorId();
            $this->dispatch('cart-updated');
        }
    }

    public function updateQuantity($productId, $quantity)
    {
        if ($quantity <= 0) {
            $this->removeFromCart($productId);
            return;
        }

        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity'] = $quantity;
            $this->saveCart();
            $this->dispatch('cart-updated');
        }
    }

    public function clearCart()
    {
        $this->cart = [];
        $this->vendorId = null;
        session()->forget('cart');
        $this->dispatch('cart-updated');
    }

    protected function saveCart()
    {
        session()->put('cart', $this->cart);
    }

    public function getTotalProperty()
    {
        $total = 0;
        foreach ($this->cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public function getItemCountProperty()
    {
        return array_sum(array_column($this->cart, 'quantity'));
    }

    public function render()
    {
        return view('livewire.shopping-cart');
    }
}
