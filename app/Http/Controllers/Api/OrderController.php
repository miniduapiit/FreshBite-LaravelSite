<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the authenticated user's orders.
     * 
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = Order::where('user_id', $user->id)
            ->with(['vendor', 'orderItems.product']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Pagination
        $perPage = $request->get('per_page', 10);
        $perPage = min($perPage, 100);

        $orders = $query->orderBy('ordered_at', 'desc')->paginate($perPage);

        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created order.
     * 
     * Requires 'orders:create' token scope.
     * 
     * @param Request $request
     * @return OrderResource|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id|integer',
            'items' => 'required|array|min:1|max:50',
            'items.*.product_id' => 'required|exists:products,id|integer',
            'items.*.quantity' => 'required|integer|min:1|max:100',
            'items.*.special_instructions' => 'nullable|string|max:500',
            'delivery_address' => 'required|string|max:500|regex:/^[a-zA-Z0-9\s\-_,.()]+$/',
            'delivery_phone' => 'nullable|string|max:20|regex:/^[\d\s\-\+()]+$/',
            'special_instructions' => 'nullable|string|max:1000',
            'payment_method' => 'nullable|string|in:cash,card,online',
        ], [
            'vendor_id.integer' => 'Vendor ID must be a valid integer.',
            'items.max' => 'Maximum 50 items per order allowed.',
            'items.*.quantity.max' => 'Maximum quantity per item is 100.',
            'delivery_address.regex' => 'Delivery address contains invalid characters.',
            'delivery_phone.regex' => 'Phone number format is invalid.',
        ]);

        // Get vendor
        $vendor = Vendor::findOrFail($validated['vendor_id']);

        // Calculate totals
        $subtotal = 0;
        $orderItems = [];

        foreach ($validated['items'] as $item) {
            $product = Product::findOrFail($item['product_id']);
            
            // Verify product belongs to vendor
            if ($product->vendor_id != $vendor->id) {
                return response()->json([
                    'message' => 'All products must be from the same vendor.',
                    'errors' => ['items' => ['Product ' . $product->name . ' does not belong to the selected vendor.']]
                ], 422);
            }

            // Check if product is available
            if (!$product->is_available) {
                return response()->json([
                    'message' => 'One or more products are unavailable.',
                    'errors' => ['items' => ['Product ' . $product->name . ' is currently unavailable.']]
                ], 422);
            }

            $itemSubtotal = $product->price * $item['quantity'];
            $subtotal += $itemSubtotal;

            $orderItems[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_price' => $product->price,
                'quantity' => $item['quantity'],
                'subtotal' => $itemSubtotal,
                'special_instructions' => $item['special_instructions'] ?? null,
            ];
        }

        // Calculate totals
        $taxAmount = $subtotal * 0.10; // 10% tax
        $deliveryFee = $vendor->delivery_fee ?? 0;
        $totalAmount = $subtotal + $taxAmount + $deliveryFee;

        // Create order
        $order = Order::create([
            'user_id' => $user->id,
            'vendor_id' => $vendor->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'status' => 'pending',
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'delivery_fee' => $deliveryFee,
            'discount_amount' => 0,
            'total_amount' => $totalAmount,
            'payment_method' => $validated['payment_method'] ?? 'cash',
            'payment_status' => 'pending',
            'delivery_address' => $validated['delivery_address'],
            'delivery_phone' => $validated['delivery_phone'] ?? null,
            'special_instructions' => $validated['special_instructions'] ?? null,
            'ordered_at' => now(),
        ]);

        // Create order items
        foreach ($orderItems as $item) {
            $order->orderItems()->create($item);
        }

        return new OrderResource($order->load(['vendor', 'orderItems.product']));
    }

    /**
     * Display the specified order.
     * 
     * @param string $id
     * @return OrderResource
     */
    public function show(string $id)
    {
        $user = Auth::user();
        
        $order = Order::where('user_id', $user->id)
            ->with(['vendor', 'orderItems.product'])
            ->findOrFail($id);

        return new OrderResource($order);
    }
}
