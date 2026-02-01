# FreshBite Database ERD (Entity Relationship Diagram)

## Visual Database Structure

```
┌──────────────────────────────────────────────────────────────────────────────┐
│                                    USERS                                      │
│ ┌──────────────────────────────────────────────────────────────────────────┐ │
│ │ id (PK)                                                                  │ │
│ │ name                                                                     │ │
│ │ email (unique)                                                           │ │
│ │ ⭐ role (enum: admin, customer, supplier)                               │ │
│ │ phone (nullable)                                                         │ │
│ │ address (nullable)                                                       │ │
│ │ password                                                                 │ │
│ │ timestamps                                                               │ │
│ └──────────────────────────────────────────────────────────────────────────┘ │
└──────────────────────────────────────────────────────────────────────────────┘
                    │
                    │ (if role = 'supplier')
                    ├──────────────────┐
                    │                  │
                    ▼                  │
    ┌────────────────────────────┐    │
    │   SUPPLIER_PROFILES        │    │
    │ ┌────────────────────────┐ │    │
    │ │ id (PK)                │ │    │
    │ │ user_id (FK → users)   │ │    │
    │ │ business_name          │ │    │
    │ │ description            │ │    │
    │ │ business_phone         │ │    │
    │ │ business_address       │ │    │
    │ │ city, state            │ │    │
    │ │ logo                   │ │    │
    │ │ is_active              │ │    │
    │ │ rating (decimal)       │ │    │
    │ │ total_reviews          │ │    │
    │ │ timestamps             │ │    │
    │ └────────────────────────┘ │    │
    └────────────────────────────┘    │
                                      │
                                      ▼
                    ┌─────────────────────────────────┐
                    │         PRODUCTS                │
                    │ ┌─────────────────────────────┐ │
                    │ │ id (PK)                     │ │
                    │ │ supplier_id (FK → users)    │ │◄────────┐
                    │ │ category_id (FK → cat...)   │ │         │
                    │ │ name, slug                  │ │         │
                    │ │ description                 │ │         │
                    │ │ price (decimal)             │ │         │
                    │ │ image_url                   │ │         │
                    │ │ is_active (boolean)         │ │         │
                    │ │ stock_quantity (int)        │ │         │
                    │ │ ⭐ approval_status          │ │         │
                    │ │    (pending/approved/...)   │ │         │
                    │ │ approved_by (FK → users)    │ │         │
                    │ │ approved_at                 │ │         │
                    │ │ deleted_at (soft delete)    │ │         │
                    │ │ timestamps                  │ │         │
                    │ └─────────────────────────────┘ │         │
                    └─────────────────────────────────┘         │
                              │                                  │
                              │                                  │
            ┌─────────────────┼──────────────────┐              │
            │                 │                  │              │
            ▼                 ▼                  ▼              │
    ┌───────────────┐  ┌────────────────┐  ┌─────────────┐    │
    │  CART_ITEMS   │  │ WISHLIST_ITEMS │  │  REVIEWS    │    │
    │ ┌───────────┐ │  │ ┌────────────┐ │  │ ┌─────────┐ │    │
    │ │ id (PK)   │ │  │ │ id (PK)    │ │  │ │ id (PK) │ │    │
    │ │ cart_id   │ │  │ │ wishlist_id│ │  │ │ user_id │ │    │
    │ │ product_id│ │  │ │ product_id │ │  │ │ prod_id │ │    │
    │ │ quantity  │ │  │ │ timestamps │ │  │ │ ⭐ rating│ │    │
    │ │ timestamps│ │  │ │            │ │  │ │ comment │ │    │
    │ └───────────┘ │  │ └────────────┘ │  │ │ verified│ │    │
    └───────────────┘  └────────────────┘  │ │ deleted │ │    │
            ▲                   ▲           │ └─────────┘ │    │
            │                   │           └─────────────┘    │
            │                   │                              │
    ┌───────────────┐   ┌──────────────┐                      │
    │    CARTS      │   │  WISHLISTS   │                      │
    │ ┌───────────┐ │   │ ┌──────────┐ │                      │
    │ │ id (PK)   │ │   │ │ id (PK)  │ │                      │
    │ │ user_id   │ │   │ │ user_id  │ │                      │
    │ │ timestamps│ │   │ │ times... │ │                      │
    │ └───────────┘ │   │ └──────────┘ │                      │
    └───────────────┘   └──────────────┘                      │
            ▲                   ▲                              │
            │                   │                              │
            └───────────────────┴──────────────────────────────┘
                           (user_id FK)

┌────────────────────────────────────────────────────────────────────────────┐
│                         ORDERS & ORDER FLOW                                │
└────────────────────────────────────────────────────────────────────────────┘

    ┌───────────────────────────────────┐
    │          ORDERS                   │
    │ ┌───────────────────────────────┐ │
    │ │ id (PK)                       │ │
    │ │ user_id (FK → users)          │ │
    │ │ order_number (unique)         │ │
    │ │ ⭐ status (pending/confirmed/│ │
    │ │    shipped/delivered/...)     │ │
    │ │ total_amount                  │ │
    │ │ delivery_address              │ │
    │ │ order_date (datetime)         │ │
    │ │ timestamps                    │ │
    │ └───────────────────────────────┘ │
    └───────────────────────────────────┘
                │
                ├───────────────────────┬──────────────────────┐
                │                       │                      │
                ▼                       ▼                      ▼
    ┌─────────────────────┐  ┌──────────────────┐  ┌──────────────────┐
    │   ORDER_ITEMS       │  │    PAYMENTS      │  │   DELIVERIES     │
    │ ┌─────────────────┐ │  │ ┌──────────────┐ │  │ ┌──────────────┐ │
    │ │ id (PK)         │ │  │ │ id (PK)      │ │  │ │ id (PK)      │ │
    │ │ order_id (FK)   │ │  │ │ order_id (FK)│ │  │ │ order_id (FK)│ │
    │ │ ⭐ product_id   │ │  │ │   (unique)   │ │  │ │   (unique)   │ │
    │ │   (FK, RESTRICT)│ │  │ │ amount       │ │  │ │ driver_name  │ │
    │ │ ⭐ supplier_id  │ │  │ │ ⭐ method    │ │  │ │ driver_phone │ │
    │ │   (FK → users)  │ │  │ │   (card/cod) │ │  │ │ tracking#    │ │
    │ │ product_name    │ │  │ │ ⭐ status    │ │  │ │ est_time     │ │
    │ │   (snapshot)    │ │  │ │   (pending/  │ │  │ │ actual_time  │ │
    │ │ unit_price      │ │  │ │   paid/...)  │ │  │ │ ⭐ status    │ │
    │ │ quantity        │ │  │ │ paid_at      │ │  │ │   (assigned/ │ │
    │ │ subtotal        │ │  │ │ trans_ref    │ │  │ │   delivered) │ │
    │ │ timestamps      │ │  │ │ timestamps   │ │  │ │ notes        │ │
    │ └─────────────────┘ │  │ └──────────────┘ │  │ │ timestamps   │ │
    └─────────────────────┘  └──────────────────┘  │ └──────────────┘ │
            │                                       └──────────────────┘
            │
            └───────────► PRODUCTS (RESTRICT delete)
                         (preserves order history)

┌────────────────────────────────────────────────────────────────────────────┐
│                            CATEGORIES                                      │
│ ┌────────────────────────────────────────────────────────────────────────┐ │
│ │ id (PK)                                                                │ │
│ │ name                                                                   │ │
│ │ description                                                            │ │
│ │ timestamps                                                             │ │
│ └────────────────────────────────────────────────────────────────────────┘ │
└────────────────────────────────────────────────────────────────────────────┘
                │
                │ (1:N)
                ▼
            PRODUCTS (category_id FK)
```

## Key Relationships Summary

### User Relationships:
```
User (role=supplier)
  ├── hasOne(SupplierProfile)
  └── hasMany(Product) via supplier_id

User (role=customer)
  ├── hasOne(Cart)
  │     └── hasMany(CartItem) → Product
  ├── hasOne(Wishlist)
  │     └── hasMany(WishlistItem) → Product
  ├── hasMany(Order)
  └── hasMany(Review) → Product

User (role=admin)
  └── hasMany(Product) via approved_by
```

### Product Relationships:
```
Product
  ├── belongsTo(User) as supplier
  ├── belongsTo(Category)
  ├── belongsTo(User) as approver (admin)
  ├── hasMany(CartItem)
  ├── hasMany(WishlistItem)
  ├── hasMany(OrderItem) ⚠️ RESTRICT delete
  └── hasMany(Review)
```

### Order Flow:
```
Order
  ├── belongsTo(User)
  ├── hasMany(OrderItem)
  │     ├── belongsTo(Product) ⚠️ RESTRICT delete
  │     └── belongsTo(User) as supplier
  ├── hasOne(Payment) - unique
  └── hasOne(Delivery) - unique (optional)
```

## Important Constraints

### 🔒 RESTRICT Delete (Preserve History):
- **order_items → products**: Cannot delete products with order history
- **order_items → supplier**: Cannot delete supplier users with order history

### 🗑️ CASCADE Delete (Auto-cleanup):
- **cart → cart_items**: Delete cart items when cart deleted
- **wishlist → wishlist_items**: Delete wishlist items when wishlist deleted
- **order → order_items**: Delete order items when order deleted
- **user → supplier_profile**: Delete profile when user deleted
- **order → payment**: Delete payment when order deleted
- **order → delivery**: Delete delivery when order deleted

### 🔄 Soft Deletes:
- **products**: Use soft delete to preserve order history
- **reviews**: Use soft delete to allow moderation

### 🔑 Unique Constraints:
- **(user_id)** in: carts, wishlists, supplier_profiles
- **(cart_id, product_id)** in: cart_items
- **(wishlist_id, product_id)** in: wishlist_items
- **(user_id, product_id)** in: reviews
- **(order_id)** in: payments, deliveries

## Enum Values

### User Roles:
- `admin` - System administrator
- `customer` - Regular customer
- `supplier` - Product supplier

### Product Approval Status:
- `pending` - Awaiting admin approval
- `approved` - Approved for sale
- `rejected` - Rejected by admin

### Order Status:
- `pending` - Order placed, awaiting confirmation
- `confirmed` - Order confirmed by system
- `shipped` - Order shipped
- `delivered` - Order delivered
- `cancelled` - Order cancelled

### Payment Method:
- `card` - Credit/Debit card
- `cod` - Cash on delivery
- `bank_transfer` - Bank transfer
- `paypal` - PayPal

### Payment Status:
- `pending` - Payment not yet made
- `paid` - Payment successful
- `failed` - Payment failed
- `refunded` - Payment refunded

### Delivery Status:
- `unassigned` - No driver assigned
- `assigned` - Driver assigned
- `out_for_delivery` - Out for delivery
- `delivered` - Successfully delivered
- `failed` - Delivery failed

## Indexes for Performance

### User Table:
- `role` - For role-based queries

### Products Table:
- `supplier_id` - Supplier's products
- `category_id` - Category products
- `is_active` - Active products
- `approval_status` - Filter by approval
- `[supplier_id, category_id]` - Combined queries

### Orders Table:
- `user_id` - User's orders
- `status` - Filter by status
- `[user_id, status]` - User's orders by status
- `order_date` - Date-based queries

### Order Items Table:
- `order_id` - Order's items
- `product_id` - Product orders
- `supplier_id` - Supplier's orders

### Reviews Table:
- `user_id` - User's reviews
- `product_id` - Product reviews
- `rating` - Filter by rating
- `is_verified_purchase` - Verified reviews

---

**Legend:**
- ⭐ = New/Modified field
- (PK) = Primary Key
- (FK) = Foreign Key
- ⚠️ = Important constraint
- 🔒 = RESTRICT delete
- 🗑️ = CASCADE delete
- 🔄 = Soft delete

Generated: 2026-02-01
