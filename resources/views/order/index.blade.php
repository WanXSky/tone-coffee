@extends('layouts.app')
@section('title', 'Pesanan Saya')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-black text-gray-900">📦 Pesanan Saya</h1>
            <p class="text-gray-400 text-sm mt-1">Riwayat semua pesananmu di ONE T.O Coffee</p>
        </div>
        <a href="{{ route('menu') }}"
           class="bg-red-600 hover:bg-red-700 text-white font-bold px-5 py-2.5
                  rounded-xl transition text-sm">
            + Pesan Lagi
        </a>
    </div>

    {{-- Filter status --}}
    <div class="flex gap-2 mb-6 overflow-x-auto pb-2 scrollbar-hide">
        @php
            $filterStatuses = [
                ''           => 'Semua',
                'pending'    => 'Menunggu',
                'processing' => 'Diproses',
                'shipped'    => 'Dikirim',
                'completed'  => 'Selesai',
                'cancelled'  => 'Dibatalkan',
            ];
        @endphp

        @foreach($filterStatuses as $key => $label)
        <a href="{{ route('orders', $key ? ['status' => $key] : []) }}"
           class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-semibold transition
                  {{ request('status', '') === $key
                      ? 'bg-red-600 text-white shadow-md shadow-red-200'
                      : 'bg-white text-gray-600 border border-gray-200 hover:border-red-400 hover:text-red-600' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    {{-- Daftar pesanan --}}
    @if($orders->isEmpty())
    <div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="text-7xl mb-4">📭</div>
        <h3 class="text-xl font-bold text-gray-700 mb-2">Belum ada pesanan</h3>
        <p class="text-gray-400 mb-6">
            Kamu belum pernah memesan di ONE T.O Coffee.<br>
            Yuk mulai pesan sekarang!
        </p>
        <a href="{{ route('menu') }}"
           class="bg-red-600 hover:bg-red-700 text-white font-bold
                  px-8 py-3 rounded-full transition inline-block">
            Lihat Menu
        </a>
    </div>

    @else

    <div class="space-y-4">
        @foreach($orders as $order)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden
                    hover:shadow-md transition animate__animated animate__fadeIn">

            {{-- Header card --}}
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    {{-- Icon status --}}
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl
                        {{ match($order->status) {
                            'pending'    => 'bg-yellow-100',
                            'processing' => 'bg-blue-100',
                            'shipped'    => 'bg-purple-100',
                            'completed'  => 'bg-green-100',
                            'cancelled'  => 'bg-red-100',
                            default      => 'bg-gray-100',
                        } }}">
                        {{ match($order->status) {
                            'pending'    => '⏳',
                            'processing' => '👨‍🍳',
                            'shipped'    => '🚴',
                            'completed'  => '✅',
                            'cancelled'  => '❌',
                            default      => '📦',
                        } }}
                    </div>
                    <div>
                        <p class="font-black text-gray-900 font-mono text-sm">
                            {{ $order->order_number }}
                        </p>
                        <p class="text-gray-400 text-xs">
                            {{ $order->created_at->isoFormat('dddd, D MMMM Y · HH:mm') }} WIB
                        </p>
                    </div>
                </div>

                {{-- Badge status --}}
                <span class="px-3 py-1.5 rounded-full text-xs font-bold flex-shrink-0
                    {{ match($order->status) {
                        'pending'    => 'bg-yellow-100 text-yellow-700',
                        'processing' => 'bg-blue-100 text-blue-700',
                        'shipped'    => 'bg-purple-100 text-purple-700',
                        'completed'  => 'bg-green-100 text-green-700',
                        'cancelled'  => 'bg-red-100 text-red-700',
                        default      => 'bg-gray-100 text-gray-700',
                    } }}">
                    {{ $order->status_label }}
                </span>
            </div>

            {{-- Body card: daftar item --}}
            <div class="px-5 py-4">

                {{-- Tampilkan max 3 item, sisanya tampilkan "+N lagi" --}}
                @php $visibleItems = $order->items->take(3); @endphp

                <div class="space-y-2">
                    @foreach($visibleItems as $item)
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-red-100 text-red-600
                                         text-xs font-bold flex items-center justify-center flex-shrink-0">
                                {{ $item->quantity }}
                            </span>
                            <span class="text-gray-700 font-medium">{{ $item->menu_name }}</span>
                            @if($item->notes)
                            <span class="text-gray-400 text-xs italic">({{ $item->notes }})</span>
                            @endif
                        </div>
                        <span class="text-gray-600 font-semibold flex-shrink-0">
                            Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                        </span>
                    </div>
                    @endforeach
                </div>

                {{-- Lebih dari 3 item --}}
                @if($order->items->count() > 3)
                <p class="text-gray-400 text-xs mt-2 italic">
                    +{{ $order->items->count() - 3 }} item lainnya...
                </p>
                @endif

            </div>

            {{-- Footer card --}}
            <div class="px-5 py-4 bg-gray-50 border-t border-gray-100
                        flex items-center justify-between gap-4">

                <div class="flex items-center gap-4 text-sm text-gray-500 flex-wrap">

                    {{-- Total --}}
                    <div>
                        <span class="text-gray-400 text-xs">Total</span>
                        <p class="font-black text-red-600 text-base">
                            Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                        </p>
                    </div>

                    {{-- Kurir --}}
                    @if($order->courier)
                    <div class="hidden sm:block">
                        <span class="text-gray-400 text-xs">Kurir</span>
                        <p class="font-semibold text-gray-700">{{ $order->courier->name }}</p>
                    </div>
                    @endif

                    {{-- Pembayaran --}}
                    @if($order->payment)
                    <div>
                        <span class="text-gray-400 text-xs">Pembayaran</span>
                        <p class="font-semibold text-gray-700 uppercase text-xs">
                            {{ $order->payment->method }}
                            <span class="ml-1
                                {{ $order->payment->status === 'success' ? 'text-green-600' :
                                   ($order->payment->status === 'failed' ? 'text-red-500' : 'text-yellow-600') }}">
                                • {{ match($order->payment->status) {
                                    'success' => 'Lunas',
                                    'failed'  => 'Ditolak',
                                    default   => 'Menunggu',
                                } }}
                            </span>
                        </p>
                    </div>
                    @endif

                </div>

                {{-- Tombol aksi --}}
                <div class="flex items-center gap-2 flex-shrink-0">

                    {{-- Lanjutkan bayar jika QRIS belum bayar --}}
                    @if($order->payment &&
                        $order->payment->method === 'qris' &&
                        $order->payment->status === 'pending')
                    <a href="{{ route('payment.show', $order) }}"
                       class="bg-red-600 hover:bg-red-700 text-white text-xs
                              font-bold px-4 py-2 rounded-xl transition">
                        💳 Bayar
                    </a>
                    @endif

                    {{-- Tombol detail --}}
                    <a href="{{ route('order.show', $order) }}"
                       class="border border-gray-200 hover:border-red-400 hover:text-red-600
                              text-gray-600 text-xs font-semibold px-4 py-2 rounded-xl transition">
                        Detail →
                    </a>

                </div>
            </div>

        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $orders->withQueryString()->links() }}
    </div>

    @endif

</div>
@endsection