<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SupplierProfile;
use App\Models\Category;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MarketplaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@freshbite.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+1234567890',
            'address' => '123 Admin Street',
        ]);

        // Create Suppliers
        $supplier1 = User::create([
            'name' => 'John Farmer',
            'email' => 'john@farmfresh.com',
            'password' => Hash::make('password'),
            'role' => 'supplier',
            'phone' => '+1234567891',
            'address' => '456 Farm Road',
        ]);

        SupplierProfile::create([
            'user_id' => $supplier1->id,
            'business_name' => 'Fresh Farm Produce',
            'description' => 'Organic vegetables and fruits from our family farm',
            'business_phone' => '+1234567891',
            'business_address' => '456 Farm Road, Countryside',
            'city' => 'Farmville',
            'state' => 'California',
            'postal_code' => '12345',
            'country' => 'USA',
            'is_active' => true,
            'rating' => 4.8,
            'total_reviews' => 120,
        ]);

        $supplier2 = User::create([
            'name' => 'Sarah Organic',
            'email' => 'sarah@organic.com',
            'password' => Hash::make('password'),
            'role' => 'supplier',
            'phone' => '+1234567892',
            'address' => '789 Green Lane',
        ]);

        SupplierProfile::create([
            'user_id' => $supplier2->id,
            'business_name' => 'Organic Valley',
            'description' => 'Premium organic produce delivered fresh daily',
            'business_phone' => '+1234567892',
            'business_address' => '789 Green Lane, Valley Town',
            'city' => 'Valley Town',
            'state' => 'Oregon',
            'postal_code' => '54321',
            'country' => 'USA',
            'is_active' => true,
            'rating' => 4.9,
            'total_reviews' => 85,
        ]);

        // Create Customers
        $customer1 = User::create([
            'name' => 'Alice Customer',
            'email' => 'alice@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '+1234567893',
            'address' => '101 Customer Ave',
        ]);

        $customer2 = User::create([
            'name' => 'Bob Buyer',
            'email' => 'bob@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '+1234567894',
            'address' => '202 Buyer Blvd',
        ]);

        // Create carts and wishlists for customers
        Cart::create(['user_id' => $customer1->id]);
        Cart::create(['user_id' => $customer2->id]);
        Wishlist::create(['user_id' => $customer1->id]);
        Wishlist::create(['user_id' => $customer2->id]);

        // Create Categories
        $vegetables = Category::create([
            'name' => 'Vegetables',
            'description' => 'Fresh vegetables',
        ]);

        $fruits = Category::create([
            'name' => 'Fruits',
            'description' => 'Fresh fruits',
        ]);

        $herbs = Category::create([
            'name' => 'Herbs',
            'description' => 'Fresh herbs and spices',
        ]);

        // Create Products
        $products = [
            [
                'supplier_id' => $supplier1->id,
                'category_id' => $vegetables->id,
                'name' => 'Organic Tomatoes',
                'slug' => 'organic-tomatoes',
                'description' => 'Fresh organic tomatoes, locally grown',
                'price' => 4.99,
                'stock_quantity' => 50,
                'image_url' => 'https://via.placeholder.com/300x300/FF6347/FFFFFF?text=Tomatoes',
                'is_active' => true,
                'approval_status' => 'approved',
                'approved_by' => $admin->id,
                'approved_at' => now(),
            ],
            [
                'supplier_id' => $supplier1->id,
                'category_id' => $vegetables->id,
                'name' => 'Organic Carrots',
                'slug' => 'organic-carrots',
                'description' => 'Crunchy organic carrots',
                'price' => 3.49,
                'stock_quantity' => 75,
                'image_url' => 'https://via.placeholder.com/300x300/FF8C00/FFFFFF?text=Carrots',
                'is_active' => true,
                'approval_status' => 'approved',
                'approved_by' => $admin->id,
                'approved_at' => now(),
            ],
            [
                'supplier_id' => $supplier2->id,
                'category_id' => $fruits->id,
                'name' => 'Organic Apples',
                'slug' => 'organic-apples',
                'description' => 'Sweet and crisp organic apples',
                'price' => 5.99,
                'stock_quantity' => 100,
                'image_url' => 'https://via.placeholder.com/300x300/FF0000/FFFFFF?text=Apples',
                'is_active' => true,
                'approval_status' => 'approved',
                'approved_by' => $admin->id,
                'approved_at' => now(),
            ],
            [
                'supplier_id' => $supplier2->id,
                'category_id' => $fruits->id,
                'name' => 'Organic Bananas',
                'slug' => 'organic-bananas',
                'description' => 'Ripe organic bananas',
                'price' => 2.99,
                'stock_quantity' => 120,
                'image_url' => 'https://via.placeholder.com/300x300/FFFF00/000000?text=Bananas',
                'is_active' => true,
                'approval_status' => 'approved',
                'approved_by' => $admin->id,
                'approved_at' => now(),
            ],
            [
                'supplier_id' => $supplier1->id,
                'category_id' => $herbs->id,
                'name' => 'Fresh Basil',
                'slug' => 'fresh-basil',
                'description' => 'Aromatic fresh basil leaves',
                'price' => 1.99,
                'stock_quantity' => 30,
                'image_url' => 'https://via.placeholder.com/300x300/228B22/FFFFFF?text=Basil',
                'is_active' => true,
                'approval_status' => 'approved',
                'approved_by' => $admin->id,
                'approved_at' => now(),
            ],
            [
                'supplier_id' => $supplier2->id,
                'category_id' => $vegetables->id,
                'name' => 'Organic Spinach',
                'slug' => 'organic-spinach',
                'description' => 'Fresh organic spinach leaves',
                'price' => 3.99,
                'stock_quantity' => 40,
                'image_url' => 'https://via.placeholder.com/300x300/006400/FFFFFF?text=Spinach',
                'is_active' => true,
                'approval_status' => 'pending',
                'approved_by' => null,
                'approved_at' => null,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        $this->command->info('✅ Marketplace seeded successfully!');
        $this->command->info('');
        $this->command->info('👤 Admin: admin@freshbite.com / password');
        $this->command->info('🌾 Supplier 1: john@farmfresh.com / password');
        $this->command->info('🌱 Supplier 2: sarah@organic.com / password');
        $this->command->info('🛒 Customer 1: alice@example.com / password');
        $this->command->info('🛒 Customer 2: bob@example.com / password');
    }
}
