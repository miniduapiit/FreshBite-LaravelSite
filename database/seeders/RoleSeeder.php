<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'System administrator with full access',
            ],
            [
                'name' => 'Vendor',
                'slug' => 'vendor',
                'description' => 'Restaurant/vendor owner who can manage their business',
            ],
            [
                'name' => 'Customer',
                'slug' => 'customer',
                'description' => 'Regular customer who can place orders',
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
}
