<?php

// ============================================================
// FILE: app/Http/Controllers/Admin/PaymentController.php
// ============================================================
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
 
class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::with(['order.user'])
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(15);
 
        return view('admin.payment.index', compact('payments'));
    }
 
    public function confirm(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return back()->with('error', 'Pembayaran sudah dikonfirmasi sebelumnya.');
        }
 
        $payment->confirm();
 
        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }
 
    public function reject(Request $request, Payment $payment)
    {
        $request->validate([
            'reason' => 'nullable|string|max:255',
        ]);
 
        $payment->reject($request->reason ?? 'Ditolak oleh admin');
 
        return redirect()->back()->with('success', 'Pembayaran berhasil ditolak.');
    }
}
