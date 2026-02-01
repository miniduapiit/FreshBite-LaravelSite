@extends('layouts.freshbite')

@section('title', $product->name . ' - FreshBite')
@section('description', $product->description ?? 'View ' . $product->name . ' details and order now.')

@push('head')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .transition-smooth {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .stat-card {
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        border-radius: 12px;
        padding: 16px;
        text-align: center;
        border: 1px solid #e5e7eb;
    }
    
    .value-badge {
        display: inline-flex;
        align-items: center;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
        margin: 4px;
        background: rgba(22, 163, 74, 0.1);
        color: #16a34a;
        border: 1px solid rgba(22, 163, 74, 0.2);
    }
    
    .nutrient-card {
        text-align: center;
        padding: 20px;
        background: white;
        border-radius: 12px;
        border: 2px solid #f3f4f6;
        transition: all 0.3s ease;
    }
    
    .nutrient-card:hover {
        border-color: #16a34a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.15);
    }
    
    .ingredient-item {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f3f4f6;
    }
    
    .ingredient-item:last-child {
        border-bottom: none;
    }
    
    .ingredient-dot {
        width: 8px;
        height: 8px;
        background: #16a34a;
        border-radius: 50%;
        margin-right: 12px;
    }
</style>
@endpush

@section('content')
<div class="bg-gradient-to-br from-green-50 via-white to-green-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-green-600 transition-smooth">Home</a></li>
                <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg></li>
                <li><a href="{{ route('menu') }}" class="hover:text-green-600 transition-smooth">Menu</a></li>
                <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg></li>
                <li class="text-gray-900 font-medium">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content (Left 2 columns) -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Product Image -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="relative h-96 bg-gradient-to-br from-gray-50 to-gray-100">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-32 h-32 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Info Card -->
                <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                    <!-- Header -->
                    <div class="mb-6">
                        <h1 class="text-4xl font-bold text-gray-900 mb-3">{{ $product->name }}</h1>
                        <div class="flex flex-wrap items-center gap-2 mb-4">
                            @if($product->category)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gradient-to-r from-green-100 to-green-200 text-green-800 border border-green-300">
                                    {{ $product->category->name }}
                                </span>
                            @endif
                            @if($product->supplier)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-700">
                                    {{ $product->supplier->name }}
                                </span>
                            @endif
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gradient-to-r from-amber-100 to-amber-200 text-amber-800 border border-amber-300">
                                Customizable
                            </span>
                        </div>
                    </div>

                    <!-- Stats Row -->
                    <div class="grid grid-cols-4 gap-4 mb-8">
                        <div class="stat-card">
                            <div class="flex items-center justify-center mb-2">
                                <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-2xl font-bold text-gray-900 ml-1">{{ number_format(rand(40, 50) / 10, 1) }}</span>
                            </div>
                            <p class="text-xs text-gray-500 font-medium">/5 Rating</p>
                        </div>
                        
                        <div class="stat-card">
                            <div class="flex items-center justify-center mb-2">
                                <svg class="w-5 h-5 text-green-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                                <span class="text-2xl font-bold text-gray-900">{{ rand(50, 150) }}</span>
                            </div>
                            <p class="text-xs text-gray-500 font-medium">Reviews</p>
                        </div>
                        
                        <div class="stat-card">
                            <div class="flex items-center justify-center mb-2">
                                <svg class="w-5 h-5 text-green-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <span class="text-2xl font-bold text-gray-900">{{ rand(100, 300) }}</span>
                            </div>
                            <p class="text-xs text-gray-500 font-medium">Orders</p>
                        </div>
                        
                        <div class="stat-card">
                            <div class="flex items-center justify-center mb-2">
                                <svg class="w-5 h-5 text-red-500 mr-1 fill-current" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-2xl font-bold text-gray-900">{{ rand(30, 80) }}</span>
                            </div>
                            <p class="text-xs text-gray-500 font-medium">Favorites</p>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($product->description)
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Description</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                    </div>
                    @endif

                    <!-- Values/Tags -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Values</h3>
                        <div class="flex flex-wrap gap-2">
                            <span class="value-badge">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Tropical & Refreshing
                            </span>
                            <span class="value-badge">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Creamy & Indulgent
                            </span>
                            <span class="value-badge">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Nutrient-Rich
                            </span>
                            <span class="value-badge">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Naturally Sweet
                            </span>
                            <span class="value-badge">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Energizing
                            </span>
                            <span class="value-badge">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Versatile & Customizable
                            </span>
                        </div>
                    </div>

                    <!-- Nutritional Info -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Nutritional Information</h3>
                        <div class="grid grid-cols-4 gap-4">
                            <div class="nutrient-card">
                                <p class="text-xs text-gray-500 font-medium mb-2">Calories</p>
                                <p class="text-3xl font-bold text-gray-900 mb-1">320</p>
                                <p class="text-xs text-gray-400">Kcal</p>
                            </div>
                            <div class="nutrient-card">
                                <p class="text-xs text-gray-500 font-medium mb-2">Proteins</p>
                                <p class="text-3xl font-bold text-gray-900 mb-1">5</p>
                                <p class="text-xs text-gray-400">gram</p>
                            </div>
                            <div class="nutrient-card">
                                <p class="text-xs text-gray-500 font-medium mb-2">Fats</p>
                                <p class="text-3xl font-bold text-gray-900 mb-1">12</p>
                                <p class="text-xs text-gray-400">gram</p>
                            </div>
                            <div class="nutrient-card">
                                <p class="text-xs text-gray-500 font-medium mb-2">Carbo</p>
                                <p class="text-3xl font-bold text-gray-900 mb-1">50</p>
                                <p class="text-xs text-gray-400">gram</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar (Right 1 column) -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Price & Actions Card -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 sticky top-6">
                    <div class="flex items-baseline justify-between mb-6">
                        <div>
                            <p class="text-5xl font-bold bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent">
                                ${{ number_format($product->price, 2) }}
                            </p>
                        </div>
                        <div class="flex gap-2">
                            <button class="p-2 rounded-lg hover:bg-gray-100 transition-smooth" title="Share">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                </svg>
                            </button>
                            <button class="p-2 rounded-lg hover:bg-gray-100 transition-smooth" title="Bookmark">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Ingredients -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-900">Ingredients</h3>
                            <button class="text-green-600 hover:text-green-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                </svg>
                            </button>
                        </div>
                        <div class="space-y-1">
                            <div class="ingredient-item">
                                <span class="ingredient-dot"></span>
                                <span class="text-sm text-gray-700">Mango</span>
                            </div>
                            <div class="ingredient-item">
                                <span class="ingredient-dot"></span>
                                <span class="text-sm text-gray-700">Coconut milk</span>
                            </div>
                            <div class="ingredient-item">
                                <span class="ingredient-dot"></span>
                                <span class="text-sm text-gray-700">Banana</span>
                            </div>
                            <div class="ingredient-item">
                                <span class="ingredient-dot"></span>
                                <span class="text-sm text-gray-700">Pineapple</span>
                            </div>
                            <div class="ingredient-item">
                                <span class="ingredient-dot"></span>
                                <span class="text-sm text-gray-700">Coconut flakes</span>
                            </div>
                            <div class="ingredient-item">
                                <span class="ingredient-dot"></span>
                                <span class="text-sm text-gray-700">Fresh berries (strawberries, blueberries)</span>
                            </div>
                            <div class="ingredient-item">
                                <span class="ingredient-dot"></span>
                                <span class="text-sm text-gray-700">Granola</span>
                            </div>
                        </div>
                    </div>

                    <!-- Add to Cart Button -->
                    @auth
                        @if(Auth::user()->hasRole('customer'))
                            <div class="space-y-3">
                                <livewire:add-to-cart-button :product="$product" />
                                <a href="{{ route('customer.cart') }}" class="block w-full bg-gradient-to-r from-gray-800 to-gray-900 text-white text-center px-6 py-3 rounded-lg hover:from-gray-900 hover:to-black font-semibold transition-smooth shadow-md hover:shadow-lg">
                                    View Cart
                                </a>
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="block w-full bg-gradient-to-r from-green-600 to-green-700 text-white text-center px-6 py-4 rounded-lg hover:from-green-700 hover:to-green-800 font-semibold transition-smooth shadow-md hover:shadow-lg transform hover:scale-105">
                            Login to Order
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="mt-16">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent">More from {{ $product->supplier->name ?? 'this vendor' }}</h2>
                <a href="{{ route('menu') }}" class="text-green-600 hover:text-green-700 font-semibold flex items-center gap-2">
                    View All
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    <a href="{{ route('products.show', $related->slug) }}" class="bg-white rounded-xl shadow-md overflow-hidden card-hover border border-gray-100 transition-smooth hover:shadow-lg">
                        <div class="relative h-48 bg-gradient-to-br from-gray-50 to-gray-100">
                            @if($related->image_url)
                                <img src="{{ $related->image_url }}" alt="{{ $related->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 mb-1 line-clamp-1">{{ $related->name }}</h3>
                            <p class="text-sm text-gray-500 mb-3">{{ $related->category->name ?? 'Uncategorized' }}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1">
                                    @for($i = 0; $i < 5; $i++)
                                    <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    @endfor
                                </div>
                                <span class="text-lg font-bold bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent">
                                    ${{ number_format($related->price, 2) }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Listen for cart events
    document.addEventListener('livewire:initialized', () => {
        console.log('Livewire initialized on product page');
        
        Livewire.on('cart-success', (event) => {
            console.log('Cart success event received', event);
            
            Swal.fire({
                icon: 'success',
                title: 'Added to Cart!',
                text: event.message || 'Product added to cart successfully!',
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                background: '#10b981',
                color: '#fff',
                iconColor: '#fff'
            });
        });
        
        Livewire.on('cart-error', (event) => {
            console.log('Cart error event received', event);
            
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: event.message || 'Failed to add product to cart.',
                confirmButtonColor: '#16a34a'
            });
        });
    });
</script>
@endpush
@endsection
