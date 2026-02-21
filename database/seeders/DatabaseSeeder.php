<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Account
        User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@mail.com',
            'password' => Hash::make('Admin123!'),
            'role' => 'admin'
        ]);

        // User Account
        User::create([
            'name' => 'Budi',
            'email' => 'budi@mail.com',
            'password' => Hash::make('password123'),
            'role' => 'user'
        ]);
    }
}
