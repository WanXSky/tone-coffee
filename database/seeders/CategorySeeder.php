<?php

// ============================================================
// FILE: database/seeders/CategorySeeder.php
// ============================================================
 
namespace Database\Seeders;
 
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
 
class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Coffee Series',  'icon' => '☕'],
            ['name' => 'Non Coffee',     'icon' => '🧋'],
            ['name' => 'Boba Gacor',     'icon' => '🟤'],
            ['name' => 'Matcha Series',  'icon' => '🍵'],
            ['name' => 'Squash',         'icon' => '🍹'],
            ['name' => 'Hot Coffee',     'icon' => '🔥'],
        ];
 
        foreach ($categories as $cat) {
            Category::create([
                'name'      => $cat['name'],
                'slug'      => Str::slug($cat['name']),
                'icon'      => $cat['icon'],
                'is_active' => true,
            ]);
        }
    }
}
