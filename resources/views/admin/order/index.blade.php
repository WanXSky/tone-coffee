{{-- ============================================================ --}}
{{-- FILE: resources/views/admin/order/index.blade.php            --}}
{{-- ============================================================ --}}
@extends('layouts.admin')
@section('title', 'Kelola Pesanan')
 
@section('content')
{{-- Filter tab status --}}
<div class="flex gap-2 mb-6 overflow-x-auto pb-1">
    @php $statuses = ['all'=>'Semua','pending'=>'Pending','processing'=>'Diproses','shipped'=>'Dikirim','completed'=>'Selesai','cancelled'=>'Dibatalkan']; @endphp
    @foreach($statuses as $key => $label)
    <a href="{{ route('admin.orders.index', ['status' => $key === 'all' ? null : $key]) }}"
       class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-semibold transition
              {{ (request('status', 'all') === $key || ($key === 'all' && !request('status'))) ? 'bg-red-600 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-red-400' }}">
        {{ $label }}
        <span class="ml-1 text-xs opacity-70">({{ $counts[$key === 'all' ? 'all' : $key] ?? 0 }})</span>
    </a>
    @endforeach
</div>
 
{{-- Search --}}
<form method="GET" action="{{ route('admin.orders.index') }}" class="mb-5 flex gap-3">
    @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari no. pesanan atau nama pelanggan..."
           class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
    <button type="submit" class="bg-gray-900 text-white px-5 py-2.5 rounded-xl text-sm font-semibold">Cari</button>
</form>
 
{{-- Tabel pesanan --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100">
    <div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-5 py-3.5 font-bold text-gray-600">No. Order</th>
                <th class="text-left px-5 py-3.5 font-bold text-gray-600">Pelanggan</th>
                <th class="text-left px-5 py-3.5 font-bold text-gray-600">Kurir</th>
                <th class="text-left px-5 py-3.5 font-bold text-gray-600">Total</th>
                <th class="text-center px-5 py-3.5 font-bold text-gray-600">Status</th>
                <th class="text-right px-5 py-3.5 font-bold text-gray-600">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($orders as $order)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-5 py-4 font-mono text-xs text-gray-700">{{ $order->order_number }}</td>
                <td class="px-5 py-4">
                    <p class="font-semibold text-gray-900">{{ $order->user->name }}</p>
                    <p class="text-gray-400 text-xs">{{ $order->created_at->format('d M H:i') }}</p>
                </td>
                <td class="px-5 py-4 text-gray-600 text-xs">
                    {{ $order->courier?->name ?? '-' }}
                </td>
                <td class="px-5 py-4 font-bold text-red-600">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                <td class="px-5 py-4 text-center">
                    <span class="px-3 py-1 rounded-full text-xs font-bold
                        {{ match($order->status) {
                            'pending'    => 'bg-yellow-100 text-yellow-700',
                            'processing' => 'bg-blue-100 text-blue-700',
                            'shipped'    => 'bg-purple-100 text-purple-700',
                            'completed'  => 'bg-green-100 text-green-700',
                            default      => 'bg-red-100 text-red-700',
                        } }}">
                        {{ $order->status_label }}
                    </span>
                </td>
                <td class="px-5 py-4 text-right">
                    <a href="{{ route('admin.orders.show', $order) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-3 py-1.5 rounded-lg text-xs transition">
                        Detail →
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-5 py-12 text-center text-gray-400">Tidak ada pesanan ditemukan</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
    <div class="p-5">{{ $orders->links() }}</div>
</div>
@endsection