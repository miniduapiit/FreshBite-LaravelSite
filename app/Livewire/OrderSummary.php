<?php

namespace App\Livewire;

use App\Models\Vendor;
use Livewire\Component;

class OrderSummary extends Component
{
    public $cart = [];
    public $deliveryAddress = '';
    public $deliveryPhone = '';
    public $specialInstructions = '';
    public $taxRate = 0.10; // 10% tax
    public $deliveryFee = 0;

    protected $listeners = ['cart-updated' => 'loadCart'];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cart = session()->get('cart', []);
        $this->calculateDeliveryFee();
    }

    public function calculateDeliveryFee()
    {
        if (!empty($this->cart)) {
            $firstItem = reset($this->cart);
            $supplierId = $firstItem['supplier_id'] ?? null;
            
            if ($supplierId) {
                $supplier = \App\Models\SupplierProfile::find($supplierId);
                $this->deliveryFee = $supplier->delivery_fee ?? 0;
            }
        } else {
            $this->deliveryFee = 0;
        }
    }

    public function getSubtotalProperty()
    {
        $subtotal = 0;
        foreach ($this->cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        return $subtotal;
    }

    public function getTaxAmountProperty()
    {
        return $this->subtotal * $this->taxRate;
    }

    public function getTotalProperty()
    {
        return $this->subtotal + $this->taxAmount + $this->deliveryFee;
    }

    public function getItemCountProperty()
    {
        return array_sum(array_column($this->cart, 'quantity'));
    }

    public function render()
    {
        return view('livewire.order-summary');
    }
}
