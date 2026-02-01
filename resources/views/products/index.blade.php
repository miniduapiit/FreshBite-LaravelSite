@extends('layouts.freshbite')

@section('title', 'Menu - FreshBite')
@section('description', 'Browse our delicious menu featuring fresh ingredients and exceptional flavors.')

@push('head')
<style>
    .transition-smooth {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .filter-checkbox:checked {
        background-color: #16a34a;
        border-color: #16a34a;
    }
    
    .product-tag {
        position: absolute;
        top: 10px;
        left: 10px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.025em;
        z-index: 10;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .product-tag.customizable {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }
    
    .product-tag.discount {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
    }
    
    .product-tag.bogo {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
    }
    
    .product-tag.seasonal {
        background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%);
        color: #831843;
    }
    
    .glass-effect {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }
    
    .card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .filter-section-collapsed {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
    }
    
    .filter-section-expanded {
        max-height: 500px;
        transition: max-height 0.3s ease-in;
    }
</style>
@endpush

@section('content')
<div class="bg-gradient-to-br from-green-50 via-white to-green-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <aside class="lg:w-72 flex-shrink-0">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden sticky top-6 border border-gray-100">
                    <!-- Filter Header -->
                    <div class="px-6 py-4 bg-gradient-to-r from-green-600 to-green-700 border-b border-green-700">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                                Filter
                            </h2>
                            <button onclick="resetFilters()" class="text-white hover:text-green-100 transition-smooth" title="Reset Filters">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <form id="filterForm" method="GET" action="{{ route('menu') }}" class="divide-y divide-gray-100">
                        <!-- Category Filter -->
                        <div class="px-6 py-4">
                            <button type="button" onclick="toggleSection('categorySection')" class="flex items-center justify-between w-full text-left group">
                                <h3 class="font-semibold text-gray-900 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                                    </svg>
                                    Category
                                </h3>
                                <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 group-hover:text-green-600" id="categoryIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div id="categorySection" class="mt-4 space-y-3 filter-section-expanded">
                                @php
                                    $selectedCategories = request('categories', []);
                                    if (!is_array($selectedCategories)) {
                                        $selectedCategories = [$selectedCategories];
                                    }
                                @endphp
                                <label class="flex items-center cursor-pointer group">
                                    <input type="checkbox" name="categories[]" value="all" class="filter-checkbox w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500 focus:ring-2 cursor-pointer" {{ in_array('all', $selectedCategories) || empty($selectedCategories) ? 'checked' : '' }} onchange="handleAllCheckbox(this, 'categories')">
                                    <span class="ml-3 text-sm text-gray-700 group-hover:text-green-600 transition-smooth">All</span>
                                </label>
                                @foreach($categories as $category)
                                <label class="flex items-center cursor-pointer group">
                                    <input type="checkbox" name="categories[]" value="{{ $category->slug }}" class="filter-checkbox w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500 focus:ring-2 cursor-pointer" {{ in_array($category->slug, $selectedCategories) ? 'checked' : '' }} onchange="handleCheckbox(this, 'categories')">
                                    <span class="ml-3 text-sm text-gray-700 group-hover:text-green-600 transition-smooth">{{ $category->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Meal Times Filter -->
                        <div class="px-6 py-4">
                            <button type="button" onclick="toggleSection('mealSection')" class="flex items-center justify-between w-full text-left group">
                                <h3 class="font-semibold text-gray-900 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                    Meal Times
                                </h3>
                                <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 group-hover:text-green-600" id="mealIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div id="mealSection" class="mt-4 space-y-3 filter-section-expanded">
                                @php
                                    $selectedMeals = request('meal_times', []);
                                    if (!is_array($selectedMeals)) {
                                        $selectedMeals = [$selectedMeals];
                                    }
                                    $mealTimes = ['All', 'Breakfast', 'Lunch', 'Snack', 'Dinner'];
                                @endphp
                                @foreach($mealTimes as $meal)
                                <label class="flex items-center cursor-pointer group">
                                    <input type="checkbox" name="meal_times[]" value="{{ strtolower($meal) }}" class="filter-checkbox w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500 focus:ring-2 cursor-pointer" {{ in_array(strtolower($meal), $selectedMeals) || ($meal === 'All' && empty($selectedMeals)) ? 'checked' : '' }}>
                                    <span class="ml-3 text-sm text-gray-700 group-hover:text-green-600 transition-smooth">{{ $meal }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Range Filter -->
                        <div class="px-6 py-4">
                            <button type="button" onclick="toggleSection('priceSection')" class="flex items-center justify-between w-full text-left group">
                                <h3 class="font-semibold text-gray-900 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                                    </svg>
                                    Price Range
                                </h3>
                                <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 group-hover:text-green-600" id="priceIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div id="priceSection" class="mt-4 space-y-3 filter-section-expanded">
                                @php
                                    $selectedPrices = request('price_range', []);
                                    if (!is_array($selectedPrices)) {
                                        $selectedPrices = [$selectedPrices];
                                    }
                                    $priceRanges = [
                                        ['value' => '5-10', 'label' => '$5 - $10'],
                                        ['value' => '10-20', 'label' => '$10 - $20'],
                                        ['value' => '20-30', 'label' => '$20 - $30'],
                                        ['value' => 'above-30', 'label' => 'Above $30']
                                    ];
                                @endphp
                                @foreach($priceRanges as $range)
                                <label class="flex items-center cursor-pointer group">
                                    <input type="checkbox" name="price_range[]" value="{{ $range['value'] }}" class="filter-checkbox w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500 focus:ring-2 cursor-pointer" {{ in_array($range['value'], $selectedPrices) ? 'checked' : '' }}>
                                    <span class="ml-3 text-sm text-gray-700 group-hover:text-green-600 transition-smooth">{{ $range['label'] }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Rating Filter -->
                        <div class="px-6 py-4">
                            <button type="button" onclick="toggleSection('ratingSection')" class="flex items-center justify-between w-full text-left group">
                                <h3 class="font-semibold text-gray-900 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    Rating
                                </h3>
                                <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 group-hover:text-green-600" id="ratingIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div id="ratingSection" class="mt-4 space-y-3 filter-section-expanded">
                                @php
                                    $selectedRatings = request('ratings', []);
                                    if (!is_array($selectedRatings)) {
                                        $selectedRatings = [$selectedRatings];
                                    }
                                @endphp
                                @for($i = 5; $i >= 1; $i--)
                                <label class="flex items-center cursor-pointer group">
                                    <input type="checkbox" name="ratings[]" value="{{ $i }}" class="filter-checkbox w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500 focus:ring-2 cursor-pointer" {{ in_array((string)$i, $selectedRatings) ? 'checked' : '' }}>
                                    <span class="ml-3 flex items-center text-sm text-gray-700 group-hover:text-green-600 transition-smooth">
                                        @for($j = 0; $j < $i; $j++)
                                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        @endfor
                                        <span class="ml-1.5">{{ $i }}</span>
                                    </span>
                                </label>
                                @endfor
                            </div>
                        </div>

                        <!-- Promos Filter -->
                        <div class="px-6 py-4">
                            <button type="button" onclick="toggleSection('promoSection')" class="flex items-center justify-between w-full text-left group">
                                <h3 class="font-semibold text-gray-900 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17C5.06 5.687 5 5.35 5 5zm4 1V5a1 1 0 10-1 1h1zm3 0a1 1 0 10-1-1v1h1z" clip-rule="evenodd" />
                                        <path d="M9 11H3v5a2 2 0 002 2h4v-7zM11 18h4a2 2 0 002-2v-5h-6v7z" />
                                    </svg>
                                    Promos
                                </h3>
                                <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 group-hover:text-green-600" id="promoIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div id="promoSection" class="mt-4 space-y-3 filter-section-expanded">
                                @php
                                    $selectedPromos = request('promos', []);
                                    if (!is_array($selectedPromos)) {
                                        $selectedPromos = [$selectedPromos];
                                    }
                                    $promos = ['All Promo', 'Buy 1 Get 1 Free', 'Seasonal Offers', '10% Off', 'Member Discount'];
                                @endphp
                                @foreach($promos as $promo)
                                <label class="flex items-center cursor-pointer group">
                                    <input type="checkbox" name="promos[]" value="{{ strtolower(str_replace(' ', '-', $promo)) }}" class="filter-checkbox w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500 focus:ring-2 cursor-pointer" {{ in_array(strtolower(str_replace(' ', '-', $promo)), $selectedPromos) ? 'checked' : '' }}>
                                    <span class="ml-3 text-sm text-gray-700 group-hover:text-green-600 transition-smooth">{{ $promo }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 min-w-0">
                <!-- Search and Sort Bar -->
                <div class="bg-white rounded-xl shadow-lg p-5 mb-8 border border-gray-100">
                    <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
                        <!-- Search -->
                        <div class="flex-1 w-full sm:max-w-md">
                            <div class="relative">
                                <input type="text" id="searchInput" placeholder="Search for menu" value="{{ request('search') }}" class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-smooth text-sm">
                                <svg class="absolute left-3.5 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3 w-full sm:w-auto">
                            <button onclick="searchProducts()" class="flex-1 sm:flex-initial bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-8 py-3 rounded-lg font-semibold transition-smooth shadow-md hover:shadow-lg transform hover:scale-105">
                                Search
                            </button>
                            
                            <!-- Sort -->
                            <div class="flex items-center gap-2 flex-1 sm:flex-initial">
                                <span class="text-sm text-gray-600 whitespace-nowrap hidden sm:inline">Sort by:</span>
                                <select id="sortSelect" onchange="sortProducts()" class="flex-1 sm:flex-initial border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-smooth bg-white">
                                    <option value="popular" {{ request('sort_by') == 'popular' ? 'selected' : '' }}>Popular</option>
                                    <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Newest</option>
                                    <option value="price_low" {{ request('sort_by') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="price_high" {{ request('sort_by') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
                        @foreach($products as $product)
                            <a href="{{ route('products.show', $product->slug) }}" class="bg-white rounded-xl shadow-md overflow-hidden card-hover border border-gray-100 flex flex-col block">
                                <!-- Product Image -->
                                <div class="relative h-56 bg-gradient-to-br from-gray-50 to-gray-100 flex-shrink-0">
                                    @if($product->image_url)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-20 h-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <!-- Tags (positioned inside image area) -->
                                    @php
                                        $randomTag = rand(1, 4);
                                    @endphp
                                    @if($randomTag == 1)
                                        <div class="product-tag customizable">CUSTOMIZABLE</div>
                                    @elseif($randomTag == 2)
                                        <div class="product-tag discount">10% OFF</div>
                                    @elseif($randomTag == 3)
                                        <div class="product-tag bogo">BUY 1 GET 1</div>
                                    @else
                                        <div class="product-tag seasonal">SEASONAL</div>
                                    @endif
                                </div>
                                
                                <!-- Product Details (separated from image) -->
                                <div class="p-5 flex-1 flex flex-col">
                                    <h3 class="font-bold text-lg text-gray-900 mb-1 line-clamp-1">{{ $product->name }}</h3>
                                    <p class="text-sm text-gray-500 mb-4">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                    
                                    <!-- Rating and Price -->
                                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                        <div class="flex items-center gap-2">
                                            <div class="flex">
                                                @for($i = 0; $i < 5; $i++)
                                                <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                                @endfor
                                            </div>
                                            <span class="text-sm font-semibold text-gray-700">{{ number_format(rand(40, 50) / 10, 1) }}</span>
                                        </div>
                                        <div class="text-2xl font-bold bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent">
                                            ${{ number_format($product->price, 2) }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                        <div class="flex justify-center">
                            <div class="inline-flex rounded-lg shadow-sm overflow-hidden border border-gray-200">
                                {{ $products->links() }}
                            </div>
                        </div>
                    @endif
                @else
                    <div class="bg-white rounded-xl shadow-lg p-16 text-center border border-gray-100">
                        <div class="max-w-md mx-auto">
                            <div class="w-24 h-24 bg-gradient-to-br from-green-100 to-green-200 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">No products found</h3>
                            <p class="text-gray-500 mb-8">We couldn't find any products matching your filters. Try adjusting your search criteria.</p>
                            <button onclick="resetFilters()" class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-8 py-3 rounded-lg font-semibold transition-smooth shadow-md hover:shadow-lg transform hover:scale-105">
                                Clear All Filters
                            </button>
                        </div>
                    </div>
                @endif
            </main>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Toggle filter sections
    function toggleSection(sectionId) {
        const section = document.getElementById(sectionId);
        const icon = document.getElementById(sectionId.replace('Section', 'Icon'));
        section.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    }

    // Handle "All" checkbox behavior
    function handleAllCheckbox(checkbox, groupName) {
        const checkboxes = document.querySelectorAll(`input[name="${groupName}[]"]:not([value="all"])`);
        if (checkbox.checked) {
            checkboxes.forEach(cb => cb.checked = false);
        }
        applyFilters();
    }

    // Handle regular checkbox behavior
    function handleCheckbox(checkbox, groupName) {
        const allCheckbox = document.querySelector(`input[name="${groupName}[]"][value="all"]`);
        if (checkbox.checked && allCheckbox) {
            allCheckbox.checked = false;
        }
        applyFilters();
    }

    // Apply filters
    function applyFilters() {
        const form = document.getElementById('filterForm');
        const formData = new FormData(form);
        const params = new URLSearchParams(formData);
        
        // Add search and sort
        const search = document.getElementById('searchInput').value;
        const sort = document.getElementById('sortSelect').value;
        if (search) params.set('search', search);
        if (sort) params.set('sort_by', sort);
        
        window.location.href = `{{ route('menu') }}?${params.toString()}`;
    }

    // Search products
    function searchProducts() {
        applyFilters();
    }

    // Sort products
    function sortProducts() {
        applyFilters();
    }

    // Reset filters
    function resetFilters() {
        window.location.href = `{{ route('menu') }}`;
    }

    // Auto-submit filters on checkbox change
    document.querySelectorAll('.filter-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (!this.hasAttribute('onchange')) {
                applyFilters();
            }
        });
    });

    // Enter key on search
    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchProducts();
        }
    });
</script>
@endpush
@endsection
