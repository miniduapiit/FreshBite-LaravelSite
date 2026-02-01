<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Al Baik Restaurant',
                'email' => 'albaik@freshbite.com',
                'password' => Hash::make('supplier123'),
                'role' => 'supplier',
            ],
            [
                'name' => 'Shawarma House',
                'email' => 'shawarma@freshbite.com',
                'password' => Hash::make('supplier123'),
                'role' => 'supplier',
            ],
            [
                'name' => 'Pizza Corner',
                'email' => 'pizza@freshbite.com',
                'password' => Hash::make('supplier123'),
                'role' => 'supplier',
            ],
            [
                'name' => 'Fresh Grill',
                'email' => 'grill@freshbite.com',
                'password' => Hash::make('supplier123'),
                'role' => 'supplier',
            ],
            [
                'name' => 'Pasta Palace',
                'email' => 'pasta@freshbite.com',
                'password' => Hash::make('supplier123'),
                'role' => 'supplier',
            ],
            [
                'name' => 'Seafood Delight',
                'email' => 'seafood@freshbite.com',
                'password' => Hash::make('supplier123'),
                'role' => 'supplier',
            ],
            [
                'name' => 'Dessert Dreams',
                'email' => 'desserts@freshbite.com',
                'password' => Hash::make('supplier123'),
                'role' => 'supplier',
            ],
            [
                'name' => 'Healthy Bites',
                'email' => 'healthy@freshbite.com',
                'password' => Hash::make('supplier123'),
                'role' => 'supplier',
            ],
        ];

        foreach ($suppliers as $supplier) {
            User::create($supplier);
        }
    }
}
