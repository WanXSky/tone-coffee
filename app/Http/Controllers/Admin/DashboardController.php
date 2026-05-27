<?php

// ============================================================
// FILE: app/Http/Controllers/Admin/DashboardController.php
// ============================================================
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Courier;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
 
class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders'    => Order::count(),
            'pending_orders'  => Order::where('status', 'pending')->count(),
            'processing'      => Order::where('status', 'processing')->count(),
            'shipped'         => Order::where('status', 'shipped')->count(),
            'completed'       => Order::where('status', 'completed')->count(),
            'total_revenue'   => Payment::where('status', 'success')->sum('amount'),
            'today_revenue'   => Payment::where('status', 'success')
                ->whereDate('paid_at', today())->sum('amount'),
            'online_couriers' => Courier::where('status', 'online')->count(),
            'total_couriers'  => Courier::count(),
            'total_menus'     => Menu::where('is_available', true)->count(),
            'total_users'     => User::where('is_admin', false)->count(),
        ];
 
        $recentOrders = Order::with(['user', 'courier', 'payment'])
            ->latest()
            ->take(8)
            ->get();
 
        $pendingPayments = Payment::with(['order.user'])
            ->where('status', 'pending')
            ->whereNotNull('proof_image')
            ->latest()
            ->take(5)
            ->get();
 
        return view('admin.dashboard', compact('stats', 'recentOrders', 'pendingPayments'));
    }
}
