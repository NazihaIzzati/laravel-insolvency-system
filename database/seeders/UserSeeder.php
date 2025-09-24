<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create default regular user
        User::create([
            'name' => 'John Doe',
            'email' => 'user@example.com',
            'password' => 'password123',
            'role' => 'user',
            'is_active' => true,
        ]);

        // Create some additional test users
        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => 'password123',
            'role' => 'user',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Bob Johnson',
            'email' => 'bob@example.com',
            'password' => 'password123',
            'role' => 'user',
            'is_active' => false,
        ]);
    }
}
