<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'phone' => '01710000000',
            'password' => Hash::make('password'),
            'status' => 'active'
        ]);

        // Vendor
        User::create([
            'name' => 'Vendor One',
            'email' => 'vendor@example.com',
            'phone' => '01720000000',
            'password' => Hash::make('password'),
            'status' => 'active'
        ]);

        // Customer
        User::create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'phone' => '01730000000',
            'password' => Hash::make('password'),
            'status' => 'active'
        ]);
    }
}
