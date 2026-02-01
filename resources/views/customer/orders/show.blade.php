<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('customer.orders.index') }}" class="text-blue-600 hover:text-blue-800">My Orders</a> / Order {{ $order->order_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-white rounded-2xl shadow-lg p-8 mb-6 border-2 border-green-500">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Order Placed Successfully!</h3>
                            <p class="text-gray-600 mb-4">{{ session('success') }}</p>
                            <div class="flex gap-4">
                                <a href="{{ route('menu') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 font-semibold transition-smooth shadow-md hover:shadow-lg">
                                    Continue Shopping
                                </a>
                                <a href="{{ route('customer.orders.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-smooth">
                                    View All Orders
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h1 class="text-2xl font-bold mb-2">Order {{ $order->order_number }}</h1>
                        <p class="text-gray-600">Placed on {{ $order->order_date ? $order->order_date->format('F d, Y \a\t g:i A') : $order->created_at->format('F d, Y \a\t g:i A') }}</p>
                    </div>
                    <div>
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'processing' => 'bg-blue-100 text-blue-800',
                                'preparing' => 'bg-purple-100 text-purple-800',
                                'ready' => 'bg-indigo-100 text-indigo-800',
                                'out_for_delivery' => 'bg-cyan-100 text-cyan-800',
                                'delivered' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                            ];
                            $color = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $color }}">
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </div>
                </div>

                <!-- Supplier Info -->
                @php
                    $suppliers = $order->getUniqueSuppliers();
                @endphp
                @if($suppliers->count() > 0)
                    <div class="border-b pb-4 mb-4">
                        <h3 class="font-semibold mb-2">{{ $suppliers->count() > 1 ? 'Suppliers' : 'Supplier' }}</h3>
                        @foreach($suppliers as $supplier)
                            <div class="mb-2">
                                <p class="text-gray-700">{{ $supplier->supplierProfile->business_name ?? $supplier->name ?? 'N/A' }}</p>
                                @if($supplier->supplierProfile && $supplier->supplierProfile->business_phone)
                                    <p class="text-sm text-gray-600">Phone: {{ $supplier->supplierProfile->business_phone }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Order Items -->
                <div class="mb-6">
                    <h3 class="font-semibold mb-4">Order Items</h3>
                    <div class="space-y-3">
                        @foreach($order->orderItems as $item)
                            <div class="flex justify-between items-center py-3 border-b">
                                <div class="flex-1">
                                    <p class="font-medium">{{ $item->product_name }}</p>
                                    <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }} × ${{ number_format($item->unit_price, 2) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold">${{ number_format($item->subtotal, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="border-t pt-4">
                    <div class="space-y-2">
                        <div class="flex justify-between text-lg font-bold border-t pt-2 mt-2">
                            <span>Total:</span>
                            <span>${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Delivery Information -->
                @if($order->delivery_address)
                    <div class="border-t pt-4 mt-4">
                        <h3 class="font-semibold mb-2">Delivery Address</h3>
                        <p class="text-gray-700">{{ $order->delivery_address }}</p>
                    </div>
                @endif
            </div>

            <div class="text-center">
                <a href="{{ route('customer.orders.index') }}" class="text-blue-600 hover:text-blue-800">
                    ← Back to Orders
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
