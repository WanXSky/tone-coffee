<?php

// ============================================================
// FILE: database/seeders/CourierSeeder.php
// ============================================================
 
namespace Database\Seeders;
 
use App\Models\Courier;
use Illuminate\Database\Seeder;
 
class CourierSeeder extends Seeder
{
    public function run(): void
    {
        $couriers = [
            ['name' => 'Budi Santoso',   'phone' => '081234567890', 'vehicle_number' => 'BP 1234 AB', 'status' => 'online'],
            ['name' => 'Andi Pratama',   'phone' => '082345678901', 'vehicle_number' => 'BP 5678 CD', 'status' => 'online'],
            ['name' => 'Reza Firmansyah','phone' => '083456789012', 'vehicle_number' => 'BP 9012 EF', 'status' => 'offline'],
        ];
 
        foreach ($couriers as $courier) {
            Courier::create($courier);
        }
    }
}
