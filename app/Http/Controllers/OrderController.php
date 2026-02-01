<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display customer's order history.
     */
    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->with(['orderItems.product'])
            ->orderBy('order_date', 'desc')
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order (cart/checkout).
     */
    public function create()
    {
        // This would typically show a cart/checkout page
        // For now, we'll redirect to product listing
        return redirect()->route('products.index')
            ->with('info', 'Add products to cart first.');
    }

    /**
     * Show checkout page with payment details.
     */
    public function checkout(Request $request)
    {
        $user = Auth::user();

        // Get cart from session
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('customer.cart')
                ->with('error', 'Your cart is empty.');
        }

        // Get delivery details from request
        $deliveryAddress = $request->input('delivery_address');

        // Validate delivery address
        if (empty($deliveryAddress)) {
            return redirect()->route('customer.cart')
                ->with('error', 'Please enter a delivery address.');
        }

        // Calculate totals
        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        return view('customer.checkout', compact(
            'cart',
            'deliveryAddress',
            'totalAmount'
        ));
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Get cart from session
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('customer.cart')
                ->with('error', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'delivery_address' => 'required|string',
            'payment_method' => 'required|in:card,cash,paypal',
            'card_number' => 'required_if:payment_method,card|nullable|string',
            'expiry_date' => 'required_if:payment_method,card|nullable|string',
            'cvv' => 'required_if:payment_method,card|nullable|string',
            'card_holder' => 'required_if:payment_method,card|nullable|string',
        ]);

        // Calculate totals
        $totalAmount = 0;
        $orderItems = [];

        foreach ($cart as $item) {
            $product = Product::findOrFail($item['product_id']);

            $itemSubtotal = $product->price * $item['quantity'];
            $totalAmount += $itemSubtotal;

            $orderItems[] = [
                'product_id' => $product->id,
                'supplier_id' => $product->supplier_id, // Track supplier at item level
                'product_name' => $product->name,
                'unit_price' => $product->price,
                'quantity' => $item['quantity'],
                'subtotal' => $itemSubtotal,
            ];
        }

        // Create order
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'status' => 'pending',
            'total_amount' => $totalAmount,
            'delivery_address' => $validated['delivery_address'],
            'order_date' => now(),
        ]);

        // Create order items with supplier tracking
        foreach ($orderItems as $item) {
            $order->orderItems()->create($item);
        }

        // Clear cart after successful order
        session()->forget('cart');

        return redirect()->route('customer.orders.show', $order->id)
            ->with('success', 'Order placed successfully! Your order number is ' . $order->order_number);
    }

    /**
     * Display the specified order.
     */
    public function show(string $id)
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)
            ->with(['orderItems.product'])
            ->findOrFail($id);

        return view('customer.orders.show', compact('order'));
    }
}
