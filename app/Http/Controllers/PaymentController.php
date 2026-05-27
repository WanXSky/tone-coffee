<?php

// ============================================================
// FILE: app/Http/Controllers/PaymentController.php
// ============================================================
 
namespace App\Http\Controllers;
 
use App\Models\Order;
use Illuminate\Http\Request;
 
class PaymentController extends Controller
{
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
 
        $order->load(['items', 'payment', 'courier']);
 
        return view('payment.show', compact('order'));
    }
 
    public function upload(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
 
        $request->validate([
            'proof_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);
 
        $path = $request->file('proof_image')->store('payments', 'public');
 
        $order->payment()->update([
            'proof_image' => $path,
            'status'      => 'pending', // Admin harus konfirmasi
        ]);
 
        return redirect()->route('order.show', $order)
            ->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu konfirmasi admin.');
    }
}