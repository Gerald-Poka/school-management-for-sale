<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Create single admin user if it doesn't exist
        if (!User::where('username', 'admin')->exists()) {
            User::create([
                'name' => 'Admin User',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'avatar' => 'avatar-1.jpg',
                'role' => 'admin',
                'is_active' => true,
                'phone' => '1234567890',
                'address' => 'Admin Address',
                'employee_id' => 'EMP001',
                'department' => 'Administration',
            ]);
        }
    }
}