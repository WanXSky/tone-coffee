{{-- ============================================================ --}}
{{-- FILE: resources/views/admin/dashboard.blade.php              --}}
{{-- ============================================================ --}}
@extends('layouts.admin')
@section('title', 'Dashboard')
 
@section('content')
<div class="space-y-6">
    {{-- Stat cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Total Order</p>
            <p class="text-3xl font-black text-gray-900 mt-1">{{ $stats['total_orders'] }}</p>
            <p class="text-xs text-gray-400 mt-1">Semua waktu</p>
        </div>
        <div class="bg-yellow-50 rounded-2xl p-5 shadow-sm border border-yellow-200">
            <p class="text-xs font-semibold text-yellow-600 uppercase tracking-wide">Pending</p>
            <p class="text-3xl font-black text-yellow-700 mt-1">{{ $stats['pending_orders'] }}</p>
            <p class="text-xs text-yellow-500 mt-1">Menunggu konfirmasi</p>
        </div>
        <div class="bg-blue-50 rounded-2xl p-5 shadow-sm border border-blue-200">
            <p class="text-xs font-semibold text-blue-600 uppercase tracking-wide">Diproses</p>
            <p class="text-3xl font-black text-blue-700 mt-1">{{ $stats['processing'] }}</p>
            <p class="text-xs text-blue-500 mt-1">Sedang dibuat</p>
        </div>
        <div class="bg-green-50 rounded-2xl p-5 shadow-sm border border-green-200">
            <p class="text-xs font-semibold text-green-600 uppercase tracking-wide">Pendapatan</p>
            <p class="text-2xl font-black text-green-700 mt-1">Rp{{ number_format($stats['today_revenue'], 0, ',', '.') }}</p>
            <p class="text-xs text-green-500 mt-1">Hari ini</p>
        </div>
        <div class="bg-red-50 rounded-2xl p-5 shadow-sm border border-red-200">
            <p class="text-xs font-semibold text-red-600 uppercase tracking-wide">Kurir Online</p>
            <p class="text-3xl font-black text-red-700 mt-1">{{ $stats['online_couriers'] }}</p>
            <p class="text-xs text-red-500 mt-1">dari {{ $stats['total_couriers'] }} kurir</p>
        </div>
    </div>
 
    {{-- Pending payments & recent orders --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Pembayaran perlu dikonfirmasi --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between p-5 border-b border-gray-100">
                <h3 class="font-bold text-gray-900">⚡ Pembayaran Menunggu Konfirmasi</h3>
                <a href="{{ route('admin.payments.index') }}" class="text-red-600 text-sm font-semibold hover:underline">Lihat semua</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($pendingPayments as $payment)
                <div class="p-4 flex items-center gap-3">
                    <img src="{{ $payment->proof_image_url }}" class="w-12 h-12 rounded-xl object-cover border border-gray-200">
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-900 text-sm truncate">{{ $payment->order->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $payment->order->order_number }}</p>
                        <p class="text-red-600 font-bold text-sm">Rp{{ number_format($payment->amount, 0, ',', '.') }}</p>
                    </div>
                    <form action="{{ route('admin.payments.confirm', $payment) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold px-3 py-2 rounded-lg transition">
                            Konfirmasi
                        </button>
                    </form>
                </div>
                @empty
                <div class="p-8 text-center text-gray-400 text-sm">
                    ✅ Tidak ada pembayaran yang perlu dikonfirmasi
                </div>
                @endforelse
            </div>
        </div>
 
        {{-- Pesanan terbaru --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between p-5 border-b border-gray-100">
                <h3 class="font-bold text-gray-900">📦 Pesanan Terbaru</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-red-600 text-sm font-semibold hover:underline">Lihat semua</a>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($recentOrders as $order)
                <div class="p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center text-red-600 font-black text-sm flex-shrink-0">
                        {{ substr($order->user->name, 0, 2) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-900 text-sm">{{ $order->user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $order->order_number }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-gray-900 text-sm">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        <span class="text-xs px-2 py-0.5 rounded-full font-semibold
                            {{ match($order->status) {
                                'pending'    => 'bg-yellow-100 text-yellow-700',
                                'processing' => 'bg-blue-100 text-blue-700',
                                'shipped'    => 'bg-purple-100 text-purple-700',
                                'completed'  => 'bg-green-100 text-green-700',
                                default      => 'bg-red-100 text-red-700',
                            } }}">
                            {{ $order->status_label }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection