<div>
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 sticky top-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Order Summary</h2>

        @if(count($cart) > 0)
            <div class="space-y-3 mb-6 max-h-64 overflow-y-auto">
                @foreach($cart as $item)
                    <div class="flex justify-between text-sm py-2 border-b border-gray-100">
                        <span class="text-gray-700 font-medium">{{ $item['name'] }} <span class="text-green-600">× {{ $item['quantity'] }}</span></span>
                        <span class="font-semibold text-gray-900">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </div>
                @endforeach
            </div>

            <div class="space-y-3 border-t-2 pt-4 mb-6">
                <div class="flex justify-between text-gray-600">
                    <span class="font-medium">Subtotal:</span>
                    <span class="font-semibold">${{ number_format($this->subtotal, 2) }}</span>
                </div>
                @if($deliveryFee > 0)
                    <div class="flex justify-between text-gray-600">
                        <span class="font-medium">Delivery Fee:</span>
                        <span class="font-semibold">${{ number_format($deliveryFee, 2) }}</span>
                    </div>
                @endif
                <div class="flex justify-between text-gray-600">
                    <span class="font-medium">Tax ({{ number_format($taxRate * 100) }}%):</span>
                    <span class="font-semibold">${{ number_format($this->taxAmount, 2) }}</span>
                </div>
                <div class="flex justify-between text-xl font-bold border-t-2 pt-3 mt-3 bg-gradient-to-r from-green-50 to-green-100 -mx-6 px-6 py-4 rounded-lg">
                    <span class="text-gray-900">Total:</span>
                    <span class="bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent">${{ number_format($this->total, 2) }}</span>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label for="delivery_address" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Delivery Address *
                    </label>
                    <textarea wire:model.live="deliveryAddress" 
                              id="delivery_address" 
                              rows="2"
                              class="w-full rounded-lg border-2 border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-smooth px-4 py-2"
                              placeholder="Enter your delivery address"></textarea>
                    @error('deliveryAddress') <span class="text-red-600 text-xs font-medium">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="delivery_phone" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        Delivery Phone
                    </label>
                    <input type="text" 
                           wire:model.live="deliveryPhone" 
                           id="delivery_phone"
                           class="w-full rounded-lg border-2 border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-smooth px-4 py-2"
                           placeholder="Optional phone number">
                </div>

                <div>
                    <label for="special_instructions" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        Special Instructions
                    </label>
                    <textarea wire:model.live="specialInstructions" 
                              id="special_instructions" 
                              rows="2"
                              class="w-full rounded-lg border-2 border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-smooth px-4 py-2"
                              placeholder="Any special instructions for delivery"></textarea>
                </div>
            </div>

            <div class="mt-6">
                <form action="{{ route('customer.checkout') }}" method="GET" id="orderForm">
                    <input type="hidden" name="delivery_address" id="hidden_delivery_address" value="{{ $deliveryAddress }}">
                    <input type="hidden" name="delivery_phone" id="hidden_delivery_phone" value="{{ $deliveryPhone }}">
                    <input type="hidden" name="special_instructions" id="hidden_special_instructions" value="{{ $specialInstructions }}">

                    <button type="submit" 
                            wire:loading.attr="disabled"
                            class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-4 rounded-lg hover:from-green-700 hover:to-green-800 font-bold text-lg shadow-md hover:shadow-lg disabled:from-gray-300 disabled:to-gray-400 disabled:cursor-not-allowed transition-smooth transform hover:scale-105 flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" wire:loading.remove>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                        <svg class="w-6 h-6 animate-spin" wire:loading fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span wire:loading.remove>Proceed to Checkout</span>
                        <span wire:loading>Processing...</span>
                    </button>
                </form>
            </div>

            <script>
                // Update hidden fields when Livewire updates
                document.addEventListener('livewire:initialized', () => {
                    Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
                        succeed(({ snapshot, effect }) => {
                            // Update hidden form fields with current Livewire data
                            const addressField = document.getElementById('hidden_delivery_address');
                            const phoneField = document.getElementById('hidden_delivery_phone');
                            const instructionsField = document.getElementById('hidden_special_instructions');
                            
                            if (addressField && component.deliveryAddress !== undefined) {
                                addressField.value = component.deliveryAddress;
                            }
                            if (phoneField && component.deliveryPhone !== undefined) {
                                phoneField.value = component.deliveryPhone;
                            }
                            if (instructionsField && component.specialInstructions !== undefined) {
                                instructionsField.value = component.specialInstructions;
                            }
                        });
                    });
                });

                // Validate before submit
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.getElementById('orderForm');
                    if (form) {
                        form.addEventListener('submit', function(e) {
                            const addressInput = document.querySelector('textarea[wire\\:model\\.live="deliveryAddress"]');
                            if (addressInput && addressInput.value.trim() === '') {
                                e.preventDefault();
                                alert('Please enter a delivery address');
                                addressInput.focus();
                                return false;
                            }
                        });
                    }
                });
            </script>
        @else
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <p class="text-gray-500 font-medium">Your cart is empty</p>
                <p class="text-sm text-gray-400 mt-1">Add items to see order summary</p>
            </div>
        @endif
    </div>
</div>
