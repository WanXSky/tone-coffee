<?php

// ============================================================
// FILE: app/Models/Menu.php
// ============================================================
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
 
class Menu extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'image',
        'is_available',
        'stock',
    ];
 
    protected $casts = [
        'price'        => 'decimal:2',
        'is_available' => 'boolean',
        'stock'        => 'integer',
    ];
 
    // Auto-generate slug dari name
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($menu) {
            if (empty($menu->slug)) {
                $menu->slug = Str::slug($menu->name) . '-' . uniqid();
            }
        });
    }
 
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
 
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
 
    // Helper: harga formatted rupiah
    public function getPriceFormattedAttribute(): string
    {
        return 'Rp' . number_format($this->price, 0, ',', '.');
    }
 
    // Helper: URL gambar
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-menu.png');
    }
}
