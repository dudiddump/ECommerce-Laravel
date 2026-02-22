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
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('Admin123!'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Budi',
            'email' => 'budi@mail.com',
            'password' => Hash::make('Password123'),
            'role' => 'user'
        ]);

        Product::create([
            'name' => 'Laptop Gaming Pro',
            'description' => 'Laptop spesifikasi tinggi untuk gaming dan desain.',
            'price' => 15000000,
            'status' => 'active'
        ]);

        Product::create([
            'name' => 'Mouse Wireless',
            'description' => 'Mouse ergonomis tanpa kabel.',
            'price' => 250000,
            'status' => 'active'
        ]);

        Product::create([
            'name' => 'Keyboard Mekanik',
            'description' => 'Keyboard dengan switch biru yang clicky.',
            'price' => 750000,
            'status' => 'inactive'
        ]);
    }
}