<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-gray-900 leading-tight">
                    Checkout
                </h2>
                <p class="text-sm text-gray-600 mt-1">Complete your payment to place the order</p>
            </div>
            <a href="{{ route('customer.cart') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-smooth">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Cart
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-gray-50 to-green-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="bg-red-50 border-2 border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-red-700 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Payment Details Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Payment Details</h3>

                        @if($errors->any())
                            <div class="bg-red-50 border-2 border-red-200 rounded-lg p-4 mb-6">
                                <div class="flex items-start gap-3">
                                    <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-red-900 mb-2">Please correct the following errors:</h4>
                                        <ul class="list-disc list-inside space-y-1 text-red-700">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('customer.orders.store') }}" method="POST" id="checkoutForm">
                            @csrf
                            <input type="hidden" name="delivery_address" value="{{ $deliveryAddress }}">

                            <!-- Payment Method -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Payment Method *</label>
                                <div class="space-y-3">
                                    <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-green-500 transition-smooth has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                        <input type="radio" name="payment_method" value="card" class="w-5 h-5 text-green-600 focus:ring-green-500" checked>
                                        <div class="ml-3 flex items-center gap-3">
                                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                            <span class="font-medium text-gray-900">Credit/Debit Card</span>
                                        </div>
                                    </label>

                                    <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-green-500 transition-smooth has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                        <input type="radio" name="payment_method" value="cash" class="w-5 h-5 text-green-600 focus:ring-green-500">
                                        <div class="ml-3 flex items-center gap-3">
                                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <span class="font-medium text-gray-900">Cash on Delivery</span>
                                        </div>
                                    </label>

                                    <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-green-500 transition-smooth has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                        <input type="radio" name="payment_method" value="paypal" class="w-5 h-5 text-green-600 focus:ring-green-500">
                                        <div class="ml-3 flex items-center gap-3">
                                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="font-medium text-gray-900">PayPal</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Card Details Section (shown only when card is selected) -->
                            <div id="cardDetails" class="space-y-4">
                                <div>
                                    <label for="card_number" class="block text-sm font-semibold text-gray-700 mb-2">Card Number *</label>
                                    <input type="text" 
                                           id="card_number" 
                                           name="card_number"
                                           placeholder="1234 5678 9012 3456"
                                           maxlength="19"
                                           class="w-full rounded-lg border-2 border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-smooth px-4 py-3">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="expiry_date" class="block text-sm font-semibold text-gray-700 mb-2">Expiry Date *</label>
                                        <input type="text" 
                                               id="expiry_date" 
                                               name="expiry_date"
                                               placeholder="MM/YY"
                                               maxlength="5"
                                               class="w-full rounded-lg border-2 border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-smooth px-4 py-3">
                                    </div>
                                    <div>
                                        <label for="cvv" class="block text-sm font-semibold text-gray-700 mb-2">CVV *</label>
                                        <input type="text" 
                                               id="cvv" 
                                               name="cvv"
                                               placeholder="123"
                                               maxlength="4"
                                               class="w-full rounded-lg border-2 border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-smooth px-4 py-3">
                                    </div>
                                </div>

                                <div>
                                    <label for="card_holder" class="block text-sm font-semibold text-gray-700 mb-2">Cardholder Name *</label>
                                    <input type="text" 
                                           id="card_holder" 
                                           name="card_holder"
                                           placeholder="John Doe"
                                           class="w-full rounded-lg border-2 border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-smooth px-4 py-3">
                                </div>
                            </div>

                            <!-- Billing Address -->
                            <div class="mt-6 pt-6 border-t-2 border-gray-200">
                                <h4 class="text-lg font-bold text-gray-900 mb-4">Billing Address</h4>
                                <div class="space-y-4">
                                    <div>
                                        <label for="billing_address" class="block text-sm font-semibold text-gray-700 mb-2">Address</label>
                                        <textarea id="billing_address" 
                                                  name="billing_address"
                                                  rows="2"
                                                  class="w-full rounded-lg border-2 border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-smooth px-4 py-3"
                                                  placeholder="Same as delivery address">{{ $deliveryAddress }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Place Order Button -->
                            <div class="mt-8">
                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-4 rounded-lg hover:from-green-700 hover:to-green-800 font-bold text-lg shadow-md hover:shadow-lg transition-smooth transform hover:scale-105 flex items-center justify-center gap-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Place Order - ${{ number_format($totalAmount, 2) }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Delivery Information Card -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 mt-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Delivery Information</h3>
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-green-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-gray-700">Delivery Address</p>
                                <p class="text-gray-900">{{ $deliveryAddress }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 sticky top-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Order Summary</h3>

                        <!-- Cart Items -->
                        <div class="space-y-3 mb-6 max-h-64 overflow-y-auto">
                            @foreach($cart as $item)
                                <div class="flex gap-3 py-2 border-b border-gray-100">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded-lg">
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900 text-sm">{{ $item['name'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $item['supplier_name'] ?? 'Unknown Supplier' }}</p>
                                        <p class="text-green-600 font-bold text-sm mt-1">${{ number_format($item['price'], 2) }} × {{ $item['quantity'] }}</p>
                                    </div>
                                    <p class="font-bold text-gray-900">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                </div>
                            @endforeach
                        </div>

                        <!-- Totals -->
                        <div class="space-y-3 border-t-2 pt-4">
                            <div class="flex justify-between text-xl font-bold border-t-2 pt-3 mt-3 bg-gradient-to-r from-green-50 to-green-100 -mx-6 px-6 py-4 rounded-lg">
                                <span class="text-gray-900">Total:</span>
                                <span class="bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent">${{ number_format($totalAmount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Toggle card details based on payment method
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
            const cardDetails = document.getElementById('cardDetails');
            
            function toggleCardDetails() {
                const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
                if (selectedMethod === 'card') {
                    cardDetails.style.display = 'block';
                    // Make card fields required
                    document.getElementById('card_number').required = true;
                    document.getElementById('expiry_date').required = true;
                    document.getElementById('cvv').required = true;
                    document.getElementById('card_holder').required = true;
                } else {
                    cardDetails.style.display = 'none';
                    // Remove required attribute
                    document.getElementById('card_number').required = false;
                    document.getElementById('expiry_date').required = false;
                    document.getElementById('cvv').required = false;
                    document.getElementById('card_holder').required = false;
                }
            }
            
            paymentMethods.forEach(radio => {
                radio.addEventListener('change', toggleCardDetails);
            });
            
            // Initialize on page load
            toggleCardDetails();

            // Format card number with spaces
            document.getElementById('card_number').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\s/g, '');
                let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
                e.target.value = formattedValue;
            });

            // Format expiry date
            document.getElementById('expiry_date').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length >= 2) {
                    value = value.slice(0, 2) + '/' + value.slice(2, 4);
                }
                e.target.value = value;
            });

            // Only allow numbers in CVV
            document.getElementById('cvv').addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '');
            });
        });
    </script>
    @endpush
</x-app-layout>
