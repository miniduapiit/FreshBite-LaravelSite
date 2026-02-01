<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get today's revenue
        $todayRevenue = Order::whereDate('created_at', today())
            ->whereIn('status', ['completed', 'delivered'])
            ->sum('total_amount');

        // Get today's order count
        $todayOrders = Order::whereDate('created_at', today())->count();

        // Get average expenses (using order costs)
        $averageExpenses = Order::whereIn('status', ['completed', 'delivered'])
            ->avg('total_amount') ?? 0;

        // Get average revenue
        $averageRevenue = Order::whereIn('status', ['completed', 'delivered'])
            ->avg('total_amount') ?? 0;

        // Get recent orders
        $recentOrders = Order::with(['user', 'orderItems.product'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Get today's orders with products
        $todayOrdersList = Order::with(['user', 'orderItems.product'])
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get reservations (you'll need to create a Reservation model if not exists)
        // For now, using a placeholder
        $reservations = [];

        // Stats for dashboard
        $stats = [
            'today_revenue' => $todayRevenue,
            'today_orders' => $todayOrders,
            'average_expenses' => $averageExpenses,
            'average_revenue' => $averageRevenue,
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'pending_products' => Product::where('approval_status', 'pending')->count(),
        ];

        return view('admin.dashboard', compact('stats', 'recentOrders', 'todayOrdersList', 'reservations'));
    }
}
