<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorProductController;
use App\Http\Controllers\Admin\AdminAuthController;
use Illuminate\Support\Facades\Route;
use App\Models\Product;

// ============================================
// ADMIN AUTH ROUTES (Public - for login)
// ============================================

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
});

// ============================================
// PUBLIC ROUTES (No Authentication Required)
// ============================================

// Home Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// About Us Page
Route::get('/about', function () {
    return view('public.about');
})->name('about');

// Menu Page (using products as menu items)
Route::get('/menu', [ProductController::class, 'index'])->name('menu');

// Testimonials Page
Route::get('/testimonials', function () {
    return view('public.testimonials');
})->name('testimonials');

// Reservation Page
Route::get('/reservation', function () {
    return view('public.reservation');
})->name('reservation');

Route::post('/reservation', function (Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|string|max:20',
        'guests' => 'required|integer|min:1|max:20',
        'date' => 'required|date',
        'time' => 'required',
        'special_requests' => 'nullable|string',
    ]);

    App\Models\Reservation::create([
        'user_id' => auth()->id(),
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'table_number' => 1, // Default table number, admin can change later
        'guests' => $request->guests,
        'reservation_date' => $request->date,
        'reservation_time' => $request->time,
        'special_requests' => $request->special_requests,
        'status' => 'pending',
    ]);

    return redirect()->route('reservation')->with('success', 'Reservation request submitted successfully! We will contact you shortly.');
})->name('reservation.store');

// Contact Page
Route::get('/contact', function () {
    return view('public.contact');
})->name('contact');

// Public product routes (for detailed product views)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// ✅ Mobile/Android JSON endpoints (NOT /api/*, so nginx should forward it)
Route::get('/products-json', function () {
    $products = Product::query()
        ->select([
            'id',
            'supplier_id',
            'category_id',
            'name',
            'slug',
            'description',
            'price',
            'image_url',
            'is_active',
            'approval_status',
            'stock_quantity',
            'created_at',
            'updated_at',
        ])
        ->whereNull('deleted_at')
        ->where('is_active', 1)
        ->orderByDesc('id')
        ->get();

    return response()->json($products);
});

Route::get('/products-json/{id}', function ($id) {
    $product = Product::query()
        ->where('id', $id)
        ->whereNull('deleted_at')
        ->firstOrFail();

    return response()->json($product);
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Admin Routes - Only accessible by users with 'admin' role
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:admin',
])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Orders Management
    Route::get('/orders', [App\Http\Controllers\Admin\AdminOrderController::class, 'index'])->name('orders');
    Route::get('/orders/{id}', [App\Http\Controllers\Admin\AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/status', [App\Http\Controllers\Admin\AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::delete('/orders/{id}', [App\Http\Controllers\Admin\AdminOrderController::class, 'destroy'])->name('orders.destroy');
    
    // Products Management
    Route::get('/items', [App\Http\Controllers\Admin\AdminProductController::class, 'index'])->name('items');
    Route::get('/products', [App\Http\Controllers\Admin\AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [App\Http\Controllers\Admin\AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [App\Http\Controllers\Admin\AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [App\Http\Controllers\Admin\AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [App\Http\Controllers\Admin\AdminProductController::class, 'update'])->name('products.update');
    Route::post('/products/{id}/approve', [App\Http\Controllers\Admin\AdminProductController::class, 'approve'])->name('products.approve');
    Route::post('/products/{id}/reject', [App\Http\Controllers\Admin\AdminProductController::class, 'reject'])->name('products.reject');
    Route::delete('/products/{id}', [App\Http\Controllers\Admin\AdminProductController::class, 'destroy'])->name('products.destroy');
    
    // Reservations Management
    Route::get('/reservations', [App\Http\Controllers\Admin\AdminReservationController::class, 'index'])->name('reservations');
    Route::get('/reservations/create', [App\Http\Controllers\Admin\AdminReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [App\Http\Controllers\Admin\AdminReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{id}/edit', [App\Http\Controllers\Admin\AdminReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('/reservations/{id}', [App\Http\Controllers\Admin\AdminReservationController::class, 'update'])->name('reservations.update');
    Route::post('/reservations/{id}/status', [App\Http\Controllers\Admin\AdminReservationController::class, 'updateStatus'])->name('reservations.update-status');
    Route::delete('/reservations/{id}', [App\Http\Controllers\Admin\AdminReservationController::class, 'destroy'])->name('reservations.destroy');
    
    // Users Management
    Route::get('/users', [App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [App\Http\Controllers\Admin\AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [App\Http\Controllers\Admin\AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [App\Http\Controllers\Admin\AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [App\Http\Controllers\Admin\AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [App\Http\Controllers\Admin\AdminUserController::class, 'destroy'])->name('users.destroy');
    
    // Payments
    Route::get('/payments', function () {
        return view('admin.payments');
    })->name('payments');
    
    // Settings
    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('settings');
});

// Vendor Routes - Only accessible by users with 'vendor' role
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:vendor',
])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard', function () {
        return view('vendor.dashboard', ['message' => 'Welcome to Vendor Dashboard']);
    })->name('dashboard');
    
    // Vendor Product Management (CRUD)
    Route::resource('products', VendorProductController::class);
    
    Route::get('/orders', function () {
        return view('vendor.orders', ['message' => 'Your Orders']);
    })->name('orders');
    
    Route::get('/profile', function () {
        return view('vendor.profile', ['message' => 'Vendor Profile']);
    })->name('profile');
});

// Customer Routes - Only accessible by users with 'customer' role
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:customer',
])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', function () {
        return view('customer.dashboard', ['message' => 'Welcome to Customer Dashboard']);
    })->name('dashboard');
    
    // Customer Order Management
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    
    Route::get('/cart', function () {
        return view('customer.cart', ['message' => 'Shopping Cart']);
    })->name('cart');
    
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    
    // Customer Reservations
    Route::get('/reservations', function () {
        $reservations = App\Models\Reservation::where('user_id', auth()->id())
            ->orWhere('email', auth()->user()->email)
            ->orderBy('reservation_date', 'desc')
            ->orderBy('reservation_time', 'desc')
            ->get();
        return view('customer.reservations.index', compact('reservations'));
    })->name('reservations.index');
    
    Route::get('/reservations/{id}', function ($id) {
        $reservation = App\Models\Reservation::where('id', $id)
            ->where(function($query) {
                $query->where('user_id', auth()->id())
                      ->orWhere('email', auth()->user()->email);
            })
            ->firstOrFail();
        return view('customer.reservations.show', compact('reservation'));
    })->name('reservations.show');
});
