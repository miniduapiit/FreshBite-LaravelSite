<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Appetizers', 'slug' => 'appetizers', 'description' => 'Start your meal with delicious appetizers'],
            ['name' => 'Main Courses', 'slug' => 'main-courses', 'description' => 'Hearty and satisfying main dishes'],
            ['name' => 'Desserts', 'slug' => 'desserts', 'description' => 'Sweet treats to end your meal'],
            ['name' => 'Beverages', 'slug' => 'beverages', 'description' => 'Refreshing drinks and beverages'],
            ['name' => 'Salads', 'slug' => 'salads', 'description' => 'Fresh and healthy salad options'],
            ['name' => 'Grilled', 'slug' => 'grilled', 'description' => 'Perfectly grilled meats and vegetables'],
            ['name' => 'Shawarma', 'slug' => 'shawarma', 'description' => 'Authentic Middle Eastern shawarma'],
            ['name' => 'Sandwiches', 'slug' => 'sandwiches', 'description' => 'Delicious sandwich options'],
            ['name' => 'Pizza', 'slug' => 'pizza', 'description' => 'Hot and fresh pizzas'],
            ['name' => 'Pasta', 'slug' => 'pasta', 'description' => 'Italian pasta dishes'],
            ['name' => 'Seafood', 'slug' => 'seafood', 'description' => 'Fresh seafood options'],
            ['name' => 'Breakfast', 'slug' => 'breakfast', 'description' => 'Start your day right'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
