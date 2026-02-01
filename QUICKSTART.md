# 🚀 Quick Start Guide - FreshBite Database Redesign

## 📋 What You Have

✅ **12 New Migration Files** - Complete database redesign
✅ **13 Eloquent Models** - All relationships configured
✅ **Sample Seeder** - Ready-to-use test data
✅ **Complete Documentation** - Schema, ERD, and instructions

---

## ⚡ Quick Setup (3 Steps)

### Step 1: Backup Your Database (If Existing Data)
```bash
# Create backup
mysqldump -u root -p freshbite > backup_$(date +%Y%m%d).sql
```

### Step 2: Run Migrations
```bash
# Option A: Fresh start (destroys all data)
php artisan migrate:fresh

# Option B: Keep existing data (attempts migration)
php artisan migrate
```

### Step 3: Seed Sample Data (Optional)
```bash
php artisan db:seed --class=MarketplaceSeeder
```

---

## 🎯 Test Your Setup

### Using Tinker
```bash
php artisan tinker
```

### Test Commands
```php
// Check users by role
User::where('role', 'admin')->get();
User::where('role', 'supplier')->get();
User::where('role', 'customer')->get();

// Check supplier profiles
SupplierProfile::with('user')->get();

// Check products with approval status
Product::where('approval_status', 'approved')->get();
Product::where('approval_status', 'pending')->get();

// Check a product's relationships
$product = Product::first();
$product->supplier; // User (supplier)
$product->category;
$product->reviews;
$product->averageRating();

// Check order items have product reference
$orderItem = OrderItem::first();
$orderItem->product; // Should work
$orderItem->supplier; // Should work

// Test cart
$user = User::where('role', 'customer')->first();
$cart = $user->cart ?? Cart::create(['user_id' => $user->id]);
$cart->items()->create([
    'product_id' => Product::first()->id,
    'quantity' => 2
]);

// Test review
$customer = User::where('role', 'customer')->first();
Review::create([
    'user_id' => $customer->id,
    'product_id' => Product::first()->id,
    'rating' => 5,
    'comment' => 'Great product!',
    'is_verified_purchase' => true
]);
```

---

## 📊 Verify Database Structure

### Check Tables Exist
```bash
php artisan tinker
```
```php
Schema::hasTable('supplier_profiles');
Schema::hasTable('carts');
Schema::hasTable('cart_items');
Schema::hasTable('wishlists');
Schema::hasTable('wishlist_items');
Schema::hasTable('payments');
Schema::hasTable('reviews');
Schema::hasTable('deliveries');
```

### Check Columns
```php
Schema::hasColumn('users', 'role');
Schema::hasColumn('users', 'phone');
Schema::hasColumn('products', 'supplier_id');
Schema::hasColumn('products', 'approval_status');
Schema::hasColumn('order_items', 'supplier_id');
```

---

## 🔑 Sample Login Credentials

After running `MarketplaceSeeder`:

| Role | Email | Password |
|------|-------|----------|
| 👤 Admin | admin@freshbite.com | password |
| 🌾 Supplier | john@farmfresh.com | password |
| 🌱 Supplier | sarah@organic.com | password |
| 🛒 Customer | alice@example.com | password |
| 🛒 Customer | bob@example.com | password |

---

## 🎨 Key Features to Test

### 1. Product Approval Workflow
```php
// Create a product (starts as pending)
$supplier = User::where('role', 'supplier')->first();
$product = Product::create([
    'supplier_id' => $supplier->id,
    'category_id' => Category::first()->id,
    'name' => 'Test Product',
    'slug' => 'test-product',
    'price' => 9.99,
    'stock_quantity' => 50,
    'is_active' => true,
    'approval_status' => 'pending'
]);

// Admin approves
$admin = User::where('role', 'admin')->first();
$product->update([
    'approval_status' => 'approved',
    'approved_by' => $admin->id,
    'approved_at' => now()
]);
```

### 2. Shopping Cart
```php
$customer = User::where('role', 'customer')->first();
$cart = $customer->cart;
$product = Product::approved()->first();

// Add to cart
$cart->items()->create([
    'product_id' => $product->id,
    'quantity' => 3
]);

// Get cart total
$cart->totalAmount();
```

### 3. Create Order
```php
$customer = User::where('role', 'customer')->first();
$order = Order::create([
    'user_id' => $customer->id,
    'order_number' => 'ORD-' . strtoupper(uniqid()),
    'status' => 'pending',
    'total_amount' => 0,
    'delivery_address' => $customer->address,
    'order_date' => now()
]);

// Add order items
foreach ($customer->cart->items as $cartItem) {
    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $cartItem->product_id,
        'supplier_id' => $cartItem->product->supplier_id,
        'product_name' => $cartItem->product->name,
        'unit_price' => $cartItem->product->price,
        'quantity' => $cartItem->quantity,
        'subtotal' => $cartItem->quantity * $cartItem->product->price
    ]);
}

// Update order total
$order->update(['total_amount' => $order->items->sum('subtotal')]);

// Create payment
Payment::create([
    'order_id' => $order->id,
    'amount' => $order->total_amount,
    'method' => 'cod',
    'status' => 'pending'
]);
```

### 4. Product Reviews
```php
$customer = User::where('role', 'customer')->first();
$product = Product::first();

Review::create([
    'user_id' => $customer->id,
    'product_id' => $product->id,
    'rating' => 5,
    'comment' => 'Excellent quality!',
    'is_verified_purchase' => true
]);

// Get product average rating
$product->averageRating();
```

---

## 🐛 Troubleshooting

### Migration Errors?
```bash
# Check migration status
php artisan migrate:status

# Rollback last batch
php artisan migrate:rollback

# Rollback specific steps
php artisan migrate:rollback --step=1
```

### Foreign Key Constraints?
Make sure migrations run in order. The date prefix ensures proper ordering.

### Can't Delete Product?
Products are protected with RESTRICT constraint in order_items. Use soft delete:
```php
$product->delete(); // Soft delete
$product->forceDelete(); // Hard delete (only if no orders)
```

---

## 📚 Documentation Files

- **[MIGRATION_SUMMARY.md](MIGRATION_SUMMARY.md)** - Complete overview
- **[DATABASE_REDESIGN.md](DATABASE_REDESIGN.md)** - Detailed schema documentation
- **[database_schema_reference.sql](database_schema_reference.sql)** - SQL reference

---

## 🔄 Migration Order

Migrations run in this order (by filename date):
1. Users role & contact fields
2. Supplier profiles
3. Products marketplace updates
4. Orders marketplace updates
5. Order items updates
6. Carts
7. Cart items
8. Wishlists
9. Wishlist items
10. Payments
11. Reviews
12. Deliveries

---

## ✅ Verification Checklist

After setup, verify:

- [ ] Users table has `role`, `phone`, `address` columns
- [ ] SupplierProfile table exists and links to users
- [ ] Products table has `supplier_id` (not vendor_id)
- [ ] Products table has `approval_status`, `approved_by`, `approved_at`
- [ ] Orders table doesn't have `vendor_id`
- [ ] OrderItems has `product_id` (NOT NULL), `supplier_id`
- [ ] Carts and CartItems tables exist
- [ ] Wishlists and WishlistItems tables exist
- [ ] Payments table exists with unique order_id
- [ ] Reviews table exists with unique (user_id, product_id)
- [ ] Can create users with different roles
- [ ] Can create supplier profiles
- [ ] Can create products (pending approval)
- [ ] Can approve products (admin)
- [ ] Can add products to cart
- [ ] Can create orders with items
- [ ] Can add reviews to products

---

## 🎉 You're Ready!

Your database is now fully redesigned for a fresh produce marketplace with:
- ✅ Role-based user system
- ✅ Supplier profiles & product approval
- ✅ Shopping cart & wishlist
- ✅ Multi-supplier orders
- ✅ Payment tracking
- ✅ Product reviews & ratings
- ✅ Delivery tracking

**Next Steps:**
1. Update your controllers to use new models
2. Update views to show supplier info
3. Implement approval workflow UI
4. Build cart/checkout flow
5. Add review system to product pages

---

**Need Help?** Check the detailed documentation files included in your project.

Generated: 2026-02-01
