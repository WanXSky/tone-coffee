<?php

// ============================================================
// FILE: database/seeders/MenuSeeder.php
// ============================================================
 
namespace Database\Seeders;
 
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
 
class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $coffeeId   = Category::where('name', 'Coffee Series')->first()->id;
        $nonCoffeeId= Category::where('name', 'Non Coffee')->first()->id;
        $bobaId     = Category::where('name', 'Boba Gacor')->first()->id;
        $matchaId   = Category::where('name', 'Matcha Series')->first()->id;
        $squashId   = Category::where('name', 'Squash')->first()->id;
        $hotId      = Category::where('name', 'Hot Coffee')->first()->id;
 
        $menus = [
            // Coffee Series - 15K
            ['category_id' => $coffeeId, 'name' => 'Kopi Aren',          'price' => 15000],
            ['category_id' => $coffeeId, 'name' => 'Kopi Regal Aren',    'price' => 15000],
            ['category_id' => $coffeeId, 'name' => 'Kopi T.O',           'price' => 15000],
            ['category_id' => $coffeeId, 'name' => 'Kopi Susu Latte',    'price' => 15000],
            ['category_id' => $coffeeId, 'name' => 'Kopi Butterscotch',  'price' => 15000],
            ['category_id' => $coffeeId, 'name' => 'Kopi Caramel',       'price' => 15000],
            ['category_id' => $coffeeId, 'name' => 'Kopi Banana Latte',  'price' => 15000],
            ['category_id' => $coffeeId, 'name' => 'Kopi Pandanos',      'price' => 15000],
            ['category_id' => $coffeeId, 'name' => 'Peach Americano',    'price' => 15000],
            ['category_id' => $coffeeId, 'name' => 'Americano Ice',      'price' => 13000],
 
            // Non Coffee
            ['category_id' => $nonCoffeeId, 'name' => 'Coklat',          'price' => 10000],
            ['category_id' => $nonCoffeeId, 'name' => 'Coklat Gacor',    'price' => 15000],
            ['category_id' => $nonCoffeeId, 'name' => 'Taro',            'price' => 10000],
            ['category_id' => $nonCoffeeId, 'name' => 'Cotton Candy',    'price' => 13000],
            ['category_id' => $nonCoffeeId, 'name' => 'Greentea',        'price' => 10000],
            ['category_id' => $nonCoffeeId, 'name' => 'Thaitea',         'price' => 10000],
            ['category_id' => $nonCoffeeId, 'name' => 'Milo',            'price' => 10000],
            ['category_id' => $nonCoffeeId, 'name' => 'Milo Tea',        'price' => 13000],
            ['category_id' => $nonCoffeeId, 'name' => 'Redvelvet',       'price' => 10000],
            ['category_id' => $nonCoffeeId, 'name' => 'Vanila Manggo',   'price' => 13000],
            ['category_id' => $nonCoffeeId, 'name' => 'Lemontea',        'price' => 10000],
            ['category_id' => $nonCoffeeId, 'name' => 'Milk Oreo',       'price' => 10000],
            ['category_id' => $nonCoffeeId, 'name' => 'Cappucino',       'price' => 10000],
 
            // Boba Gacor
            ['category_id' => $bobaId, 'name' => 'Brown Sugar Boba',    'price' => 15000],
            ['category_id' => $bobaId, 'name' => 'Coklat Boba',         'price' => 13000],
            ['category_id' => $bobaId, 'name' => 'Coklat Gacor Boba',   'price' => 15000],
            ['category_id' => $bobaId, 'name' => 'Taro Boba',           'price' => 13000],
            ['category_id' => $bobaId, 'name' => 'Cotton Candy Boba',   'price' => 15000],
            ['category_id' => $bobaId, 'name' => 'Greentea Boba',       'price' => 13000],
            ['category_id' => $bobaId, 'name' => 'Thaitea Boba',        'price' => 13000],
            ['category_id' => $bobaId, 'name' => 'Milo Boba',           'price' => 13000],
            ['category_id' => $bobaId, 'name' => 'Milotea Boba',        'price' => 15000],
            ['category_id' => $bobaId, 'name' => 'Redvelvet Boba',      'price' => 13000],
            ['category_id' => $bobaId, 'name' => 'Vanila Manggo Boba',  'price' => 15000],
            ['category_id' => $bobaId, 'name' => 'Milk Oreo Boba',      'price' => 13000],
            ['category_id' => $bobaId, 'name' => 'Cappucino Boba',      'price' => 13000],
 
            // Matcha Series
            ['category_id' => $matchaId, 'name' => 'Japanese Matcha',           'price' => 18000],
            ['category_id' => $matchaId, 'name' => 'Japanese Strawberry Matcha','price' => 18000],
            ['category_id' => $matchaId, 'name' => 'Greentea Matcha',           'price' => 15000],
 
            // Squash
            ['category_id' => $squashId, 'name' => 'Manggo Squash',    'price' => 15000],
            ['category_id' => $squashId, 'name' => 'Sipaling Biru',    'price' => 15000],
 
            // Hot Coffee
            ['category_id' => $hotId, 'name' => 'Kopi Susu Hot',   'price' => 13000],
            ['category_id' => $hotId, 'name' => 'Americano Hot',    'price' => 13000],
        ];
 
        foreach ($menus as $menu) {
            Menu::create([
                'category_id'  => $menu['category_id'],
                'name'         => $menu['name'],
                'slug'         => Str::slug($menu['name']) . '-' . uniqid(),
                'description'  => 'Minuman segar dari ONE T.O Coffee',
                'price'        => $menu['price'],
                'image'        => null,
                'is_available' => true,
                'stock'        => 100,
            ]);
        }
    }
}
