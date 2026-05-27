<?php

// ============================================================
// FILE: app/Models/OrderItem.php
// ============================================================
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class OrderItem extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'order_id',
        'menu_id',
        'menu_name',
        'menu_price',
        'quantity',
        'subtotal',
        'notes',
    ];
 
    protected $casts = [
        'menu_price' => 'decimal:2',
        'subtotal'   => 'decimal:2',
        'quantity'   => 'integer',
    ];
 
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
 
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
