<?php

// ============================================================
// FILE: database/seeders/DatabaseSeeder.php
// ============================================================
 
namespace Database\Seeders;
 
use App\Models\User;
use Illuminate\Database\Seeder;
 
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat akun admin
        User::create([
            'name'     => 'Admin ONE T.O',
            'email'    => 'admin@oneto.com',
            'password' => bcrypt('admin123'),
            'is_admin' => true,
        ]);
 
        // Buat akun customer contoh
        User::create([
            'name'     => 'Customer Test',
            'email'    => 'customer@oneto.com',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);
 
        // Jalankan seeder lain
        $this->call([
            CategorySeeder::class,
            MenuSeeder::class,
            CourierSeeder::class,
        ]);
    }
}
