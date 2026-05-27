<?php

// ============================================================
// FILE: app/Http/Controllers/Admin/OrderController.php
// ============================================================

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['user', 'courier', 'payment'])
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->when($request->search, function ($q, $s) {
                $q->where('order_number', 'like', "%{$s}%")
                  ->orWhereHas('user', fn($uq) => $uq->where('name', 'like', "%{$s}%"));
            })
            ->latest()
            ->paginate(15);

        $counts = [
            'all'        => Order::count(),
            'pending'    => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped'    => Order::where('status', 'shipped')->count(),
            'ready'      => Order::where('status', 'ready')->count(), // ✅ ditambahkan
            'completed'  => Order::where('status', 'completed')->count(),
            'cancelled'  => Order::where('status', 'cancelled')->count(),
        ];

        return view('admin.order.index', compact('orders', 'counts'));
    }

    public function show(Order $order)
    {
        $order->load(['items.menu', 'user', 'courier', 'payment']);
        $couriers = Courier::where('status', 'online')->get();

        return view('admin.order.show', compact('order', 'couriers'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,ready,completed,cancelled',
        ]);

        // 🔐 Aturan transisi status (biar tidak lompat sembarangan)
        $allowedTransitions = [
            'pending'    => ['processing', 'cancelled'],
            'processing' => $order->isTakeaway()
                ? ['ready', 'cancelled']
                : ['shipped', 'cancelled'],
            'shipped'    => ['completed'],
            'ready'      => ['completed'],
            'completed'  => [],
            'cancelled'  => [],
        ];

        // ❌ Jika status tidak valid sesuai alur
        if (!in_array($request->status, $allowedTransitions[$order->status] ?? [])) {
            return back()->with('error', 'Perubahan status tidak valid!');
        }

        // ✅ Update status
        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function assignCourier(Request $request, Order $order)
    {
        $request->validate([
            'courier_id' => 'required|exists:couriers,id',
        ]);

        $order->update([
            'courier_id' => $request->courier_id
        ]);

        return back()->with('success', 'Kurir berhasil ditugaskan.');
    }
}