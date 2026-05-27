<?php

// ============================================================
// FILE: app/Models/Payment.php
// ============================================================
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Payment extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'order_id',
        'method',
        'amount',
        'status',
        'proof_image',
        'notes',
        'paid_at',
    ];
 
    protected $casts = [
        'amount'  => 'decimal:2',
        'paid_at' => 'datetime',
    ];
 
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
 
    // Helper: URL bukti bayar
    public function getProofImageUrlAttribute(): ?string
    {
        if ($this->proof_image) {
            return asset('storage/' . $this->proof_image);
        }
        return null;
    }
 
    // Konfirmasi pembayaran berhasil
    public function confirm(): void
    {
        $this->update([
            'status'  => 'success',
            'paid_at' => now(),
        ]);
 
        // Update status order jadi processing
        $this->order->update(['status' => 'processing']);
    }
 
    // Tolak pembayaran
    public function reject(string $reason = ''): void
    {
        $this->update([
            'status' => 'failed',
            'notes'  => $reason,
        ]);
 
        // Order kembali ke pending
        $this->order->update(['status' => 'pending']);
    }
}
