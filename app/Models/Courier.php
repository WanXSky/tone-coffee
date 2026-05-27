<?php

// ============================================================
// FILE: app/Models/Courier.php
// ============================================================
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Courier extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'name',
        'phone',
        'vehicle_number',
        'photo',
        'status',
    ];
 
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
 
    // Scope: hanya yang online
    public function scopeOnline($query)
    {
        return $query->where('status', 'online');
    }
 
    // Helper: cek apakah online
    public function isOnline(): bool
    {
        return $this->status === 'online';
    }
 
    // Helper: URL foto
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return asset('images/default-courier.png');
    }
 
    // Toggle status online/offline
    public function toggleStatus(): void
    {
        $this->update([
            'status' => $this->status === 'online' ? 'offline' : 'online',
        ]);
    }
}
