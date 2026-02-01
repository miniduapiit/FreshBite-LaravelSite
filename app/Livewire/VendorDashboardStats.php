<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VendorDashboardStats extends Component
{
    public $vendor;

    public function mount()
    {
        $user = Auth::user();
        $this->vendor = $user->vendors()->first();
    }

    public function getTotalOrdersProperty()
    {
        if (!$this->vendor) {
            return 0;
        }
        return Order::where('vendor_id', $this->vendor->id)->count();
    }

    public function getTotalRevenueProperty()
    {
        if (!$this->vendor) {
            return 0;
        }
        return Order::where('vendor_id', $this->vendor->id)
            ->where('payment_status', 'paid')
            ->sum('total_amount');
    }

    public function getPendingOrdersProperty()
    {
        if (!$this->vendor) {
            return 0;
        }
        return Order::where('vendor_id', $this->vendor->id)
            ->whereIn('status', ['pending', 'processing', 'preparing'])
            ->count();
    }

    public function getActiveProductsProperty()
    {
        if (!$this->vendor) {
            return 0;
        }
        return Product::where('vendor_id', $this->vendor->id)
            ->where('is_available', true)
            ->count();
    }

    public function getTotalProductsProperty()
    {
        if (!$this->vendor) {
            return 0;
        }
        return Product::where('vendor_id', $this->vendor->id)->count();
    }

    public function getTodayOrdersProperty()
    {
        if (!$this->vendor) {
            return 0;
        }
        return Order::where('vendor_id', $this->vendor->id)
            ->whereDate('created_at', today())
            ->count();
    }

    public function getTodayRevenueProperty()
    {
        if (!$this->vendor) {
            return 0;
        }
        return Order::where('vendor_id', $this->vendor->id)
            ->whereDate('created_at', today())
            ->where('payment_status', 'paid')
            ->sum('total_amount');
    }

    public function getRecentOrdersProperty()
    {
        if (!$this->vendor) {
            return collect();
        }
        return Order::where('vendor_id', $this->vendor->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.vendor-dashboard-stats');
    }
}
