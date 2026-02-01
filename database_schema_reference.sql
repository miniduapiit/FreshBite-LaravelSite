-- FreshBite Database Redesign - Quick Reference SQL
-- This file shows the key table structures after the redesign

-- ============================================================================
-- USERS TABLE (Modified)
-- ============================================================================
ALTER TABLE users 
ADD COLUMN role ENUM('admin', 'customer', 'supplier') DEFAULT 'customer' AFTER email,
ADD COLUMN phone VARCHAR(255) NULL AFTER email_verified_at,
ADD COLUMN address TEXT NULL AFTER phone,
ADD INDEX idx_users_role (role);

-- ============================================================================
-- SUPPLIER PROFILES TABLE (New)
-- ============================================================================
CREATE TABLE supplier_profiles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL UNIQUE,
    business_name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    business_phone VARCHAR(255) NULL,
    business_address TEXT NULL,
    city VARCHAR(255) NULL,
    state VARCHAR(255) NULL,
    postal_code VARCHAR(255) NULL,
    country VARCHAR(255) NULL,
    logo VARCHAR(255) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    rating DECIMAL(3,2) NULL,
    total_reviews INT DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_supplier_profiles_is_active (is_active),
    INDEX idx_supplier_profiles_city (city),
    INDEX idx_supplier_profiles_rating (rating)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- PRODUCTS TABLE (Modified)
-- ============================================================================
-- Rename vendor_id to supplier_id, add approval workflow
ALTER TABLE products
DROP FOREIGN KEY products_vendor_id_foreign,
CHANGE COLUMN vendor_id supplier_id BIGINT UNSIGNED NOT NULL,
ADD FOREIGN KEY (supplier_id) REFERENCES users(id) ON DELETE RESTRICT,
CHANGE COLUMN image image_url VARCHAR(255) NULL,
CHANGE COLUMN is_available is_active BOOLEAN DEFAULT TRUE,
DROP COLUMN is_featured,
DROP COLUMN preparation_time,
DROP COLUMN calories,
DROP COLUMN allergens,
ADD COLUMN approval_status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending' AFTER is_active,
ADD COLUMN approved_by BIGINT UNSIGNED NULL AFTER approval_status,
ADD COLUMN approved_at TIMESTAMP NULL AFTER approved_by,
ADD COLUMN deleted_at TIMESTAMP NULL,
ADD FOREIGN KEY (approved_by) REFERENCES users(id) ON DELETE SET NULL,
ADD INDEX idx_products_is_active (is_active),
ADD INDEX idx_products_approval_status (approval_status);

-- ============================================================================
-- CARTS TABLE (New)
-- ============================================================================
CREATE TABLE carts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL UNIQUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_carts_updated_at (updated_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- CART ITEMS TABLE (New)
-- ============================================================================
CREATE TABLE cart_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cart_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    quantity INT DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (cart_id) REFERENCES carts(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_cart_product (cart_id, product_id),
    INDEX idx_cart_items_product_id (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- WISHLISTS TABLE (New)
-- ============================================================================
CREATE TABLE wishlists (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL UNIQUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- WISHLIST ITEMS TABLE (New)
-- ============================================================================
CREATE TABLE wishlist_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    wishlist_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (wishlist_id) REFERENCES wishlists(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_wishlist_product (wishlist_id, product_id),
    INDEX idx_wishlist_items_product_id (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- ORDERS TABLE (Modified)
-- ============================================================================
-- Remove vendor_id, payment fields, simplify structure
ALTER TABLE orders
DROP FOREIGN KEY orders_vendor_id_foreign,
DROP COLUMN vendor_id,
DROP COLUMN payment_method,
DROP COLUMN payment_status,
DROP COLUMN subtotal,
DROP COLUMN tax_amount,
DROP COLUMN delivery_fee,
DROP COLUMN discount_amount,
DROP COLUMN delivery_phone,
DROP COLUMN special_instructions,
DROP COLUMN delivered_at,
CHANGE COLUMN ordered_at order_date DATETIME NOT NULL,
MODIFY COLUMN status ENUM('pending', 'confirmed', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending';

-- ============================================================================
-- ORDER ITEMS TABLE (Modified)
-- ============================================================================
-- Add supplier_id, rename product_price to unit_price
ALTER TABLE order_items
DROP FOREIGN KEY order_items_product_id_foreign,
MODIFY COLUMN product_id BIGINT UNSIGNED NOT NULL,
ADD FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT,
CHANGE COLUMN product_price unit_price DECIMAL(10,2) NOT NULL,
ADD COLUMN supplier_id BIGINT UNSIGNED NOT NULL AFTER product_id,
ADD FOREIGN KEY (supplier_id) REFERENCES users(id) ON DELETE RESTRICT,
DROP COLUMN special_instructions,
ADD INDEX idx_order_items_supplier_id (supplier_id);

-- ============================================================================
-- PAYMENTS TABLE (New)
-- ============================================================================
CREATE TABLE payments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id BIGINT UNSIGNED NOT NULL UNIQUE,
    amount DECIMAL(10,2) NOT NULL,
    method ENUM('card', 'cod', 'bank_transfer', 'paypal') DEFAULT 'cod',
    status ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
    paid_at TIMESTAMP NULL,
    transaction_ref VARCHAR(255) NULL,
    notes TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    INDEX idx_payments_status (status),
    INDEX idx_payments_method (method),
    INDEX idx_payments_paid_at (paid_at),
    INDEX idx_payments_transaction_ref (transaction_ref)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- REVIEWS TABLE (New)
-- ============================================================================
CREATE TABLE reviews (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    rating TINYINT UNSIGNED NOT NULL,
    comment TEXT NULL,
    is_verified_purchase BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_product_review (user_id, product_id),
    INDEX idx_reviews_product_id (product_id),
    INDEX idx_reviews_rating (rating),
    INDEX idx_reviews_is_verified_purchase (is_verified_purchase)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- DELIVERIES TABLE (New, Optional)
-- ============================================================================
CREATE TABLE deliveries (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id BIGINT UNSIGNED NOT NULL UNIQUE,
    driver_name VARCHAR(255) NULL,
    driver_phone VARCHAR(255) NULL,
    tracking_number VARCHAR(255) UNIQUE NULL,
    estimated_delivery_time TIMESTAMP NULL,
    actual_delivery_time TIMESTAMP NULL,
    status ENUM('unassigned', 'assigned', 'out_for_delivery', 'delivered', 'failed') DEFAULT 'unassigned',
    delivery_notes TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    INDEX idx_deliveries_status (status),
    INDEX idx_deliveries_driver_name (driver_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- KEY RELATIONSHIPS SUMMARY
-- ============================================================================
-- users.role → supplier_profiles (1:1 if role=supplier)
-- users (supplier) → products.supplier_id (1:N)
-- users → carts (1:1)
-- users → wishlists (1:1)
-- users → orders (1:N)
-- users → reviews (1:N)
-- users (admin) → products.approved_by (1:N)
--
-- products → order_items (1:N, restrict delete)
-- products → cart_items (1:N, cascade delete)
-- products → wishlist_items (1:N, cascade delete)
-- products → reviews (1:N, cascade delete)
--
-- orders → order_items (1:N, cascade delete)
-- orders → payments (1:1, cascade delete)
-- orders → deliveries (1:1, cascade delete)
--
-- categories → products (1:N, set null)
