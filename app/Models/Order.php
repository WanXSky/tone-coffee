<?php

// ============================================================
// FILE: app/Models/Order.php
// ============================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'courier_id',
        'order_number',
        'status',
        'order_type',       // ← tambah
        'pickup_time',      // ← tambah
        'pickup_name',      // ← tambah
        'delivery_address',
        'delivery_name',
        'delivery_phone',
        'subtotal',
        'delivery_fee',
        'total_amount',
        'notes',
    ];

    protected $casts = [
        'subtotal'      => 'decimal:2',
        'delivery_fee'  => 'decimal:2',
        'total_amount'  => 'decimal:2',
    ];

    const STATUS_LABELS = [
        'pending'    => ['label' => 'Menunggu',   'color' => 'yellow'],
        'processing' => ['label' => 'Diproses',   'color' => 'blue'],
        'shipped'    => ['label' => 'Dikirim',    'color' => 'purple'],
        'ready'      => ['label' => 'Siap Ambil', 'color' => 'orange'],
        'completed'  => ['label' => 'Selesai',    'color' => 'green'],
        'cancelled'  => ['label' => 'Dibatalkan', 'color' => 'red'],
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            $order->order_number = 'TO-' . strtoupper(substr(uniqid(), -8));
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Cek apakah takeaway
    public function isTakeaway(): bool
    {
        return $this->order_type === 'takeaway';
    }

    // Cek apakah delivery
    public function isDelivery(): bool
    {
        return $this->order_type === 'delivery';
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status]['label'] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_LABELS[$this->status]['color'] ?? 'gray';
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending']);
    }
}