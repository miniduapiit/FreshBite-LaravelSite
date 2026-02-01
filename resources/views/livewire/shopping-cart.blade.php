<div>
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-900">Shopping Cart</h2>
            @if(count($cart) > 0)
                <button wire:click="clearCart" 
                        class="text-red-600 hover:text-red-700 text-sm font-semibold flex items-center gap-2 transition-smooth"
                        onclick="return confirm('Are you sure you want to clear your cart?')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Clear Cart
                </button>
            @endif
        </div>

        @if(count($cart) > 0)
            <div class="space-y-4">
                @foreach($cart as $item)
                    <div class="flex items-center gap-4 p-4 border-2 border-gray-100 rounded-xl hover:border-green-200 hover:shadow-md transition-smooth bg-gradient-to-r from-white to-gray-50">
                        <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex-shrink-0 flex items-center justify-center overflow-hidden">
                            @if($item['image'])
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            @endif
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-lg text-gray-900 mb-1">{{ $item['name'] }}</h3>
                            <p class="text-sm text-gray-500 mb-2">{{ $item['supplier_name'] ?? 'Unknown Supplier' }}</p>
                            <p class="text-xl font-bold bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent">
                                ${{ number_format($item['price'], 2) }}
                            </p>
                        </div>

                        <div class="flex items-center border-2 border-gray-300 rounded-lg overflow-hidden">
                            <button wire:click="updateQuantity({{ $item['product_id'] }}, {{ $item['quantity'] - 1 }})" 
                                    class="w-10 h-10 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition-smooth flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                            </button>
                            <input type="number" 
                                   value="{{ $item['quantity'] }}" 
                                   min="1"
                                   wire:change="updateQuantity({{ $item['product_id'] }}, $event.target.value)"
                                   class="w-16 text-center border-0 border-y-0 py-2 focus:ring-0 font-semibold text-gray-900">
                            <button wire:click="updateQuantity({{ $item['product_id'] }}, {{ $item['quantity'] + 1 }})" 
                                    class="w-10 h-10 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition-smooth flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>

                        <div class="text-right w-32">
                            <p class="text-lg font-bold text-gray-900">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                        </div>

                        <button wire:click="removeFromCart({{ $item['product_id'] }})" 
                                class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-smooth">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 pt-6 border-t-2 border-gray-200">
                <div class="flex justify-between items-center bg-gradient-to-r from-green-50 to-green-100 p-6 rounded-xl border-2 border-green-200">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Subtotal</p>
                        <p class="text-lg font-semibold text-gray-900">({{ $this->itemCount }} {{ $this->itemCount == 1 ? 'item' : 'items' }})</p>
                    </div>
                    <p class="text-3xl font-bold bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent">
                        ${{ number_format($this->total, 2) }}
                    </p>
                </div>
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-32 h-32 bg-gradient-to-br from-green-100 to-green-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Your cart is empty</h3>
                <p class="text-gray-500 mb-8">Discover our delicious menu and start adding items!</p>
                <a href="{{ route('menu') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 font-semibold shadow-md hover:shadow-lg transition-smooth transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Browse Menu
                </a>
            </div>
        @endif
    </div>

    @script
    <script>
        $wire.on('cart-updated', () => {
            // Cart was updated, component will re-render automatically
        });

        $wire.on('cart-success', (event) => {
            // Show success message
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: event.message || 'Item updated!',
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            }
        });

        $wire.on('cart-error', (event) => {
            // Show error message
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: event.message || 'An error occurred',
                    confirmButtonColor: '#16a34a'
                });
            }
        });
    </script>
    @endscript
</div>
