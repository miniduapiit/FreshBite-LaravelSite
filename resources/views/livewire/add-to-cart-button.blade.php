<div>
    <div class="flex items-center gap-3 mb-3">
        <!-- Quantity Controls -->
        <div class="flex items-center border-2 border-gray-300 rounded-lg overflow-hidden">
            <button wire:click="$set('quantity', quantity > 1 ? quantity - 1 : 1)" 
                    type="button"
                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                </svg>
            </button>
            <input type="number" 
                   wire:model.live="quantity" 
                   min="1" 
                   max="99"
                   class="w-16 text-center border-0 border-y-0 py-2 focus:ring-0 font-semibold text-gray-900">
            <button wire:click="$set('quantity', quantity < 99 ? quantity + 1 : 99)" 
                    type="button"
                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </button>
        </div>
    </div>
    
    <!-- Add to Cart Button -->
    <button wire:click="addToCart" 
            type="button"
            wire:loading.attr="disabled"
            class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-4 rounded-lg hover:from-green-700 hover:to-green-800 font-semibold transition-smooth shadow-md hover:shadow-lg transform hover:scale-105 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
        <svg wire:loading.remove class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <svg wire:loading class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span wire:loading.remove>Add to Cart</span>
        <span wire:loading>Adding...</span>
    </button>
</div>

