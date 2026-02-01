# FreshBite Database Redesign - Migration Guide

## Overview
This document describes the complete database redesign from a restaurant-based system to a fresh produce marketplace with Suppliers, Products, Orders, Payments, Reviews, and more.

---

## Design Decisions

### 1. **User Roles Architecture**
**Approach A (Implemented)**: Role enum in users table + supplier_profiles table
- `users.role` enum: `'admin'`, `'customer'`, `'supplier'`
- Separate `supplier_profiles` table for supplier-specific data
- Cleaner separation of concerns and easier to manage

### 2. **Key Changes from Restaurant Model**
- **vendors** → **supplier_profiles** (linked to users with role='supplier')
- **vendor_id** → **supplier_id** (references users.id)
- Products now have approval workflow (`pending`, `approved`, `rejected`)
- Orders can contain items from multiple suppliers
- Removed restaurant-specific fields (preparation_time, calories, allergens)
- Added cart and wishlist functionality
- Separate payments table with transaction tracking
- Product reviews with ratings (1-5)
- Soft deletes on products and reviews to preserve history

---

## Database Schema

### **Users Table** (Modified)
```sql
users
├── id (PK)
├── name
├── email (unique)
├── role (enum: admin, customer, supplier) -- NEW
├── phone (nullable) -- NEW
├── address (text, nullable) -- NEW
├── email_verified_at
├── password
├── remember_token
├── current_team_id
├── profile_photo_path
├── created_at
└── updated_at

Indexes: role
```

### **Supplier Profiles Table** (New)
```sql
supplier_profiles
├── id (PK)
├── user_id (FK → users.id, unique, cascade delete)
├── business_name
├── description (text, nullable)
├── business_phone (nullable)
├── business_address (text, nullable)
├── city (nullable)
├── state (nullable)
├── postal_code (nullable)
├── country (nullable)
├── logo (nullable)
├── is_active (boolean, default: true)
├── rating (decimal 3,2, nullable)
├── total_reviews (int, default: 0)
├── created_at
└── updated_at

Indexes: user_id (unique), is_active, city, rating
```

### **Categories Table** (Unchanged)
```sql
categories
├── id (PK)
├── name
├── description (text, nullable)
├── created_at
└── updated_at
```

### **Products Table** (Modified)
```sql
products
├── id (PK)
├── supplier_id (FK → users.id, restrict delete) -- CHANGED from vendor_id
├── category_id (FK → categories.id, set null)
├── name
├── slug (unique)
├── description (text, nullable)
├── price (decimal 10,2)
├── image_url (nullable) -- RENAMED from image
├── is_active (boolean, default: true) -- RENAMED from is_available
├── stock_quantity (int, nullable)
├── approval_status (enum: pending, approved, rejected) -- NEW
├── approved_by (FK → users.id, set null) -- NEW
├── approved_at (datetime, nullable) -- NEW
├── created_at
├── updated_at
└── deleted_at (soft deletes) -- NEW

Removed: is_featured, preparation_time, calories, allergens

Indexes: supplier_id, category_id, is_active, approval_status, [supplier_id, category_id]
```

### **Carts Table** (New)
```sql
carts
├── id (PK)
├── user_id (FK → users.id, unique, cascade delete)
├── created_at
└── updated_at

Indexes: user_id (unique), updated_at
```

### **Cart Items Table** (New)
```sql
cart_items
├── id (PK)
├── cart_id (FK → carts.id, cascade delete)
├── product_id (FK → products.id, cascade delete)
├── quantity (int, default: 1)
├── created_at
└── updated_at

Constraints: unique(cart_id, product_id)
Indexes: cart_id, product_id
```

### **Wishlists Table** (New)
```sql
wishlists
├── id (PK)
├── user_id (FK → users.id, unique, cascade delete)
├── created_at
└── updated_at

Indexes: user_id (unique)
```

### **Wishlist Items Table** (New)
```sql
wishlist_items
├── id (PK)
├── wishlist_id (FK → wishlists.id, cascade delete)
├── product_id (FK → products.id, cascade delete)
├── created_at
└── updated_at

Constraints: unique(wishlist_id, product_id)
Indexes: wishlist_id, product_id
```

### **Orders Table** (Modified)
```sql
orders
├── id (PK)
├── user_id (FK → users.id, cascade delete)
├── order_number (unique)
├── status (enum: pending, confirmed, shipped, delivered, cancelled)
├── total_amount (decimal 10,2)
├── delivery_address (text)
├── order_date (datetime) -- RENAMED from ordered_at
├── created_at
└── updated_at

Removed: vendor_id, subtotal, tax_amount, delivery_fee, discount_amount, 
         payment_method, payment_status, delivery_phone, special_instructions, delivered_at

Indexes: user_id, status, [user_id, status], order_date
```

### **Order Items Table** (Modified)
```sql
order_items
├── id (PK)
├── order_id (FK → orders.id, cascade delete)
├── product_id (FK → products.id, restrict delete) -- NOT NULL, restrict
├── supplier_id (FK → users.id, restrict delete) -- NEW
├── product_name (snapshot)
├── unit_price (decimal 10,2) -- RENAMED from product_price
├── quantity (int)
├── subtotal (decimal 10,2)
├── created_at
└── updated_at

Removed: special_instructions

Indexes: order_id, product_id, supplier_id
```

### **Payments Table** (New)
```sql
payments
├── id (PK)
├── order_id (FK → orders.id, unique, cascade delete)
├── amount (decimal 10,2)
├── method (enum: card, cod, bank_transfer, paypal)
├── status (enum: pending, paid, failed, refunded)
├── paid_at (datetime, nullable)
├── transaction_ref (nullable)
├── notes (text, nullable)
├── created_at
└── updated_at

Constraints: order_id (unique - one payment per order)
Indexes: order_id, status, method, paid_at, transaction_ref
```

### **Reviews Table** (New)
```sql
reviews
├── id (PK)
├── user_id (FK → users.id, cascade delete)
├── product_id (FK → products.id, cascade delete)
├── rating (tinyint, 1-5)
├── comment (text, nullable)
├── is_verified_purchase (boolean, default: false)
├── created_at
├── updated_at
└── deleted_at (soft deletes)

Constraints: unique(user_id, product_id)
Indexes: user_id, product_id, rating, is_verified_purchase
```

### **Deliveries Table** (New, Optional)
```sql
deliveries
├── id (PK)
├── order_id (FK → orders.id, unique, cascade delete)
├── driver_name (nullable)
├── driver_phone (nullable)
├── tracking_number (unique, nullable)
├── estimated_delivery_time (datetime, nullable)
├── actual_delivery_time (datetime, nullable)
├── status (enum: unassigned, assigned, out_for_delivery, delivered, failed)
├── delivery_notes (text, nullable)
├── created_at
└── updated_at

Constraints: order_id (unique)
Indexes: order_id, status, driver_name
```

---

## Migration Files Created

### New Migrations (in order):
1. `2026_02_01_000001_add_role_and_contact_to_users_table.php`
2. `2026_02_01_000002_create_supplier_profiles_table.php`
3. `2026_02_01_000003_update_products_table_for_marketplace.php`
4. `2026_02_01_000004_update_orders_table_for_marketplace.php`
5. `2026_02_01_000005_update_order_items_table_for_marketplace.php`
6. `2026_02_01_000006_create_carts_table.php`
7. `2026_02_01_000007_create_cart_items_table.php`
8. `2026_02_01_000008_create_wishlists_table.php`
9. `2026_02_01_000009_create_wishlist_items_table.php`
10. `2026_02_01_000010_create_payments_table.php`
11. `2026_02_01_000011_create_reviews_table.php`
12. `2026_02_01_000012_create_deliveries_table.php`

---

## Eloquent Models

### Created/Updated Models:
- ✅ **User** - Updated with role enum, relationships to supplier_profile, cart, wishlist, orders, reviews
- ✅ **SupplierProfile** - New model for supplier-specific data
- ✅ **Product** - Updated with supplier_id, approval workflow, soft deletes
- ✅ **Category** - Unchanged (already exists)
- ✅ **Order** - Simplified, removed vendor_id and payment fields
- ✅ **OrderItem** - Updated with product_id (restrict), supplier_id, unit_price
- ✅ **Cart** - New model for shopping carts
- ✅ **CartItem** - New model for cart items
- ✅ **Wishlist** - New model for user wishlists
- ✅ **WishlistItem** - New model for wishlist items
- ✅ **Payment** - New model for order payments
- ✅ **Review** - New model for product reviews with soft deletes
- ✅ **Delivery** - New model for delivery tracking (optional)

### Key Relationships:

**User**
- `hasOne(SupplierProfile)` - supplier profile
- `hasMany(Product, 'supplier_id')` - products they supply
- `hasOne(Cart)` - shopping cart
- `hasOne(Wishlist)` - wishlist
- `hasMany(Order)` - orders placed
- `hasMany(Review)` - reviews written
- `hasMany(Product, 'approved_by')` - products approved (admin)

**SupplierProfile**
- `belongsTo(User)`
- `hasMany(Product)` through user_id

**Product**
- `belongsTo(User, 'supplier_id')` - the supplier
- `belongsTo(Category)`
- `belongsTo(User, 'approved_by')` - admin who approved
- `hasMany(OrderItem)`
- `hasMany(CartItem)`
- `hasMany(WishlistItem)`
- `hasMany(Review)`

**Order**
- `belongsTo(User)`
- `hasMany(OrderItem)`
- `hasOne(Payment)`
- `hasOne(Delivery)`

**OrderItem**
- `belongsTo(Order)`
- `belongsTo(Product)` - restrict delete
- `belongsTo(User, 'supplier_id')` - the supplier

**Cart/CartItem, Wishlist/WishlistItem**
- Standard parent-child relationships with products

**Payment**
- `belongsTo(Order)` - unique constraint

**Review**
- `belongsTo(User)`
- `belongsTo(Product)`
- Unique: one review per user per product

**Delivery**
- `belongsTo(Order)` - unique constraint

---

## Running Migrations

### ⚠️ IMPORTANT: Choose ONE approach

### Option 1: Fresh Migration (Development - DESTROYS ALL DATA)
```bash
# Drop all tables and re-run migrations
php artisan migrate:fresh

# With seeders
php artisan migrate:fresh --seed
```

### Option 2: Regular Migration (Production - Preserves Data Where Possible)
```bash
# Run new migrations
php artisan migrate

# Note: This will attempt to modify existing tables
# Backup your database first!
```

### Option 3: Manual Migration (Recommended for Production)
```bash
# 1. Backup database
mysqldump -u root -p freshbite > backup_$(date +%Y%m%d).sql

# 2. Review migrations manually
# 3. Test on staging environment first
# 4. Run migrations one by one and verify
php artisan migrate --step

# 5. If issues occur, rollback
php artisan migrate:rollback --step=1
```

---

## Data Migration Considerations

### If You Have Existing Data:

1. **Vendors → Supplier Profiles**
   - Create users with role='supplier' for each vendor
   - Migrate vendor data to supplier_profiles
   - Update products.vendor_id to products.supplier_id (reference users)

2. **Orders**
   - Remove vendor_id references (orders can have items from multiple suppliers)
   - Create payment records for existing orders
   - Set default order_date from ordered_at

3. **Products**
   - Set default approval_status='approved' for existing products
   - Set is_active=true where is_available=true
   - Rename image to image_url

4. **Order Items**
   - Ensure product_id is NOT NULL
   - Add supplier_id from products table
   - Rename product_price to unit_price

---

## Constraints & Cascades

### Cascade Delete (Safe):
- `cart_items` when `cart` deleted
- `wishlist_items` when `wishlist` deleted
- `order_items` when `order` deleted
- `supplier_profiles` when `user` deleted
- `reviews` when `user` or `product` deleted
- `payments` when `order` deleted
- `deliveries` when `order` deleted

### Restrict Delete (Preserve History):
- `products` cannot be deleted if referenced in `order_items`
- Use soft deletes on products instead

### Set Null:
- `category_id` in products (if category deleted)
- `approved_by` in products (if admin user deleted)

---

## Testing Checklist

After migration, verify:
- [ ] Users can be created with roles (admin, customer, supplier)
- [ ] Suppliers can create products (pending approval)
- [ ] Admins can approve/reject products
- [ ] Products belong to categories and suppliers
- [ ] Customers can add products to cart
- [ ] Customers can add products to wishlist
- [ ] Customers can place orders (creates order + order_items)
- [ ] Order items reference products and suppliers correctly
- [ ] Payments can be created for orders
- [ ] Reviews can be added to products (unique per user)
- [ ] Product stock is tracked
- [ ] Deliveries can be assigned to orders
- [ ] Soft deletes work on products and reviews

---

## API/Controller Updates Needed

You'll need to update:
1. **AuthController** - Handle role assignment on registration
2. **ProductController** - Implement approval workflow
3. **CartController** - CRUD for cart items
4. **WishlistController** - CRUD for wishlist items
5. **OrderController** - Create orders from cart, handle multi-supplier items
6. **PaymentController** - Payment processing
7. **ReviewController** - Add/edit reviews
8. **SupplierController** - Manage supplier profile
9. **AdminController** - Approve/reject products

---

## Seeder Updates

If you have seeders, update:
- `UserSeeder` - Create users with roles
- `SupplierProfileSeeder` - Create supplier profiles
- `ProductSeeder` - Use supplier_id instead of vendor_id
- Create new seeders for carts, wishlists, reviews, etc.

---

## Notes

1. **Soft Deletes**: Products and reviews use soft deletes to preserve order history
2. **Product Approval**: All new products start as 'pending' and require admin approval
3. **Multi-Supplier Orders**: Orders can contain items from multiple suppliers (tracked in order_items)
4. **Payment Tracking**: Separate payments table with transaction references
5. **Inventory**: stock_quantity is tracked per product
6. **Reviews**: One review per user per product, with 1-5 rating
7. **Cart & Wishlist**: Automatically created when user adds first item
8. **Indexes**: All foreign keys have indexes for performance

---

## Database Diagram (ERD)

```
users (role: admin/customer/supplier)
  ├── supplier_profiles (1:1, if role=supplier)
  │     └── products (1:N via user_id)
  ├── carts (1:1)
  │     └── cart_items (1:N)
  │           └── products
  ├── wishlists (1:1)
  │     └── wishlist_items (1:N)
  │           └── products
  ├── orders (1:N)
  │     ├── order_items (1:N)
  │     │     ├── products (N:1, restrict)
  │     │     └── suppliers (N:1, via user_id)
  │     ├── payment (1:1)
  │     └── delivery (1:1, optional)
  └── reviews (1:N)
        └── products (N:1)

categories
  └── products (1:N)
```

---

## Support

For issues or questions:
1. Check migration files in `database/migrations/`
2. Check model relationships in `app/Models/`
3. Run `php artisan migrate:status` to see migration status
4. Use `php artisan tinker` to test relationships

---

**Generated**: 2026-02-01
**Laravel Version**: 11.x
**Database**: MySQL/MariaDB
