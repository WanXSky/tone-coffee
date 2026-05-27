<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['items', 'courier', 'payment'])
            ->where('user_id', auth()->id())
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(10);

        return view('order.index', compact('orders'));
    }

    public function store(Request $request)
    {
        // ================= VALIDASI =================
        $rules = [
            'order_type'     => 'required|in:delivery,takeaway',
            'payment_method' => 'required|in:cash,qris',
            'notes'          => 'nullable|string|max:500',
        ];

        if ($request->order_type === 'delivery') {
            $rules['delivery_name']    = 'required|string|max:100';
            $rules['delivery_phone']   = 'required|string|max:20';
            $rules['delivery_address'] = 'required|string|max:500';
        }

        if ($request->order_type === 'takeaway') {
            $rules['pickup_name'] = 'required|string|max:100';
            $rules['pickup_time'] = 'required|date_format:H:i';
        }

        $request->validate($rules);

        // ================= CART =================
        $cart = session('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Keranjang kamu kosong!');
        }

        // ================= HITUNG TOTAL =================
        $subtotal    = collect($cart)->sum('subtotal');
        $deliveryFee = $request->order_type === 'delivery' ? 10000 : 0;
        $totalAmount = $subtotal + $deliveryFee;

        // ================= COURIER =================
        $courierId = null;
        if ($request->order_type === 'delivery') {
            $courier = Courier::where('status', 'online')->inRandomOrder()->first();

            if (!$courier) {
                return back()->with('error', 'Maaf, belum ada kurir tersedia saat ini.');
            }

            $courierId = $courier->id;
        }

        // ================= FIX UTAMA =================
        if ($request->order_type === 'takeaway') {
            $deliveryName    = $request->pickup_name;
            $deliveryPhone   = auth()->user()->phone ?? '-';
            $deliveryAddress = 'Ambil di tempat';
        } else {
            $deliveryName    = $request->delivery_name;
            $deliveryPhone   = $request->delivery_phone;
            $deliveryAddress = $request->delivery_address;
        }

        // ================= CREATE ORDER =================
        $order = Order::create([
            'user_id'          => auth()->id(),
            'courier_id'       => $courierId,
            'status'           => 'pending',
            'order_type'       => $request->order_type,

            'pickup_name'      => $request->pickup_name,
            'pickup_time'      => $request->pickup_time,

            // 🔥 sudah aman dari null
            'delivery_name'    => $deliveryName,
            'delivery_phone'   => $deliveryPhone,
            'delivery_address' => $deliveryAddress,

            'subtotal'         => $subtotal,
            'delivery_fee'     => $deliveryFee,
            'total_amount'     => $totalAmount,
            'notes'            => $request->notes,
        ]);

        // ================= ITEMS =================
        foreach ($cart as $item) {
            $order->items()->create([
                'menu_id'    => $item['menu_id'],
                'menu_name'  => $item['name'],
                'menu_price' => $item['price'],
                'quantity'   => $item['qty'],
                'subtotal'   => $item['subtotal'],
                'notes'      => $item['notes'] ?? null,
            ]);
        }

        // ================= PAYMENT =================
        Payment::create([
            'order_id' => $order->id,
            'method'   => $request->payment_method,
            'amount'   => $totalAmount,
            'status'   => 'pending',
        ]);

        // ================= CLEAR CART =================
        session()->forget('cart');

        return redirect()->route('payment.show', $order)
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);

        $order->load(['items.menu', 'courier', 'payment']);

        return view('order.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);

        if (!$order->canBeCancelled()) {
            return back()->with('error', 'Pesanan tidak bisa dibatalkan.');
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->route('orders')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function checkStatus(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);

        $order->load(['courier', 'payment']);

        $allStatuses = $order->isTakeaway()
            ? ['pending', 'processing', 'ready', 'completed']
            : ['pending', 'processing', 'shipped', 'completed'];

        $currentIndex = array_search($order->status, $allStatuses);

        return response()->json([
            'status'        => $order->status,
            'status_label'  => $order->status_label,
            'order_type'    => $order->order_type,
            'current_index' => $currentIndex !== false ? $currentIndex : -1,
            'is_cancelled'  => $order->status === 'cancelled',
            'is_completed'  => $order->status === 'completed',
            'courier'       => $order->courier ? [
                'name'           => $order->courier->name,
                'vehicle_number' => $order->courier->vehicle_number,
                'phone'          => $order->courier->phone,
            ] : null,
            'payment' => $order->payment ? [
                'status' => $order->payment->status,
                'method' => $order->payment->method,
            ] : null,
        ]);
    }
}