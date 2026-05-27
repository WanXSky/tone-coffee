@extends('layouts.admin')
@section('title', 'Detail Pesanan ' . $order->order_number)

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.orders.index') }}"
       class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-red-600 transition">
        ← Kembali ke Pesanan
    </a>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── LEFT: Detail order ── --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Info utama --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-start justify-between mb-5">
                <div>
                    <h2 class="font-black text-xl text-gray-900">{{ $order->order_number }}</h2>
                    <p class="text-gray-400 text-sm mt-0.5">
                        {{ $order->created_at->format('d F Y, H:i') }} WIB
                    </p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    {{-- Badge tipe order --}}
                    <span class="px-3 py-1.5 rounded-full text-xs font-bold
                        {{ $order->isTakeaway()
                            ? 'bg-green-100 text-green-700'
                            : 'bg-blue-100 text-blue-700' }}">
                        {{ $order->isTakeaway() ? '🥤 Take Away' : '🛵 Delivery' }}
                    </span>
                    {{-- Badge status --}}
                    <span class="px-3 py-1.5 rounded-full text-sm font-bold
                        {{ match($order->status) {
                            'pending'    => 'bg-yellow-100 text-yellow-700',
                            'processing' => 'bg-blue-100 text-blue-700',
                            'shipped'    => 'bg-purple-100 text-purple-700',
                            'ready'      => 'bg-orange-100 text-orange-700',
                            'completed'  => 'bg-green-100 text-green-700',
                            default      => 'bg-red-100 text-red-700',
                        } }}">
                        {{ $order->status_label }}
                    </span>
                </div>
            </div>

            {{-- Item pesanan --}}
            <div class="space-y-3">
                @foreach($order->items as $item)
                <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl">
                    <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center text-xl flex-shrink-0">
                        ☕
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-900 text-sm">{{ $item->menu_name }}</p>
                        <p class="text-gray-500 text-xs">
                            Rp{{ number_format($item->menu_price, 0, ',', '.') }} × {{ $item->quantity }}
                        </p>
                        @if($item->notes)
                        <p class="text-gray-400 text-xs italic">{{ $item->notes }}</p>
                        @endif
                    </div>
                    <p class="font-bold text-gray-900 flex-shrink-0">
                        Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                    </p>
                </div>
                @endforeach
            </div>

            {{-- Total --}}
            <div class="border-t border-gray-100 mt-4 pt-4 space-y-2">
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Subtotal</span>
                    <span>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Ongkos kirim</span>
                    <span>
                        @if($order->delivery_fee == 0)
                            <span class="text-green-600 font-semibold">GRATIS</span>
                        @else
                            Rp{{ number_format($order->delivery_fee, 0, ',', '.') }}
                        @endif
                    </span>
                </div>
                <div class="flex justify-between font-black text-lg">
                    <span>Total</span>
                    <span class="text-red-600">
                        Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Info pelanggan & pengiriman/takeaway --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="grid grid-cols-2 gap-5">

                {{-- Pelanggan --}}
                <div>
                    <h4 class="font-bold text-gray-900 mb-2">👤 Pelanggan</h4>
                    <p class="text-gray-700 font-medium text-sm">{{ $order->user->name }}</p>
                    <p class="text-gray-500 text-sm">{{ $order->user->email }}</p>
                </div>

                {{-- Delivery atau Takeaway --}}
                @if($order->isTakeaway())
                <div>
                    <h4 class="font-bold text-gray-900 mb-2">🥤 Info Take Away</h4>
                    <p class="text-gray-700 font-medium text-sm">{{ $order->pickup_name }}</p>
                    <p class="text-gray-500 text-sm">
                        Ambil pukul:
                        <strong>{{ \Carbon\Carbon::createFromFormat('H:i:s', $order->pickup_time)->format('H:i') }} WIB</strong>
                    </p>
                </div>
                @else
                <div>
                    <h4 class="font-bold text-gray-900 mb-2">🛵 Penerima</h4>
                    <p class="text-gray-700 font-medium text-sm">{{ $order->delivery_name }}</p>
                    <p class="text-gray-500 text-sm">{{ $order->delivery_phone }}</p>
                    <p class="text-gray-500 text-sm mt-1">{{ $order->delivery_address }}</p>
                </div>
                @endif

            </div>

            @if($order->notes)
            <div class="mt-4 bg-gray-50 rounded-xl p-3">
                <p class="text-xs font-semibold text-gray-500 mb-1">📝 Catatan</p>
                <p class="text-gray-700 text-sm">{{ $order->notes }}</p>
            </div>
            @endif
        </div>

    </div>

    {{-- ── RIGHT: Panel aksi ── --}}
    <div class="space-y-5">

        {{-- Update status --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h4 class="font-bold text-gray-900 mb-4">Update Status Pesanan</h4>
            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                @csrf @method('PATCH')

                {{-- Pilihan status berbeda untuk takeaway vs delivery --}}
                <select name="status"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm mb-3
                               focus:outline-none focus:ring-2 focus:ring-red-500">
                    @if($order->isTakeaway())
                        @foreach(['pending', 'processing', 'ready', 'completed', 'cancelled'] as $s)
                        <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>
                            {{ \App\Models\Order::STATUS_LABELS[$s]['label'] }}
                        </option>
                        @endforeach
                    @else
                        @foreach(['pending', 'processing', 'shipped', 'completed', 'cancelled'] as $s)
                        <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>
                            {{ \App\Models\Order::STATUS_LABELS[$s]['label'] }}
                        </option>
                        @endforeach
                    @endif
                </select>

                <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white
                               font-bold py-3 rounded-xl transition">
                    Update Status
                </button>
            </form>

            {{-- Panduan status --}}
            <div class="mt-4 bg-gray-50 rounded-xl p-3">
                <p class="text-xs font-semibold text-gray-500 mb-2">Panduan Status:</p>
                @if($order->isTakeaway())
                <ul class="text-xs text-gray-400 space-y-1">
                    <li>⏳ <strong>Menunggu</strong> — Pesanan baru masuk</li>
                    <li>👨‍🍳 <strong>Diproses</strong> — Sedang diracik</li>
                    <li>🔔 <strong>Siap Ambil</strong> — Notifikasi ke pelanggan</li>
                    <li>✅ <strong>Selesai</strong> — Sudah diambil</li>
                </ul>
                @else
                <ul class="text-xs text-gray-400 space-y-1">
                    <li>⏳ <strong>Menunggu</strong> — Pesanan baru masuk</li>
                    <li>👨‍🍳 <strong>Diproses</strong> — Sedang diracik</li>
                    <li>🚴 <strong>Dikirim</strong> — Kurir berangkat</li>
                    <li>✅ <strong>Selesai</strong> — Sampai di tujuan</li>
                </ul>
                @endif
            </div>
        </div>

        {{-- Assign kurir — hanya untuk delivery --}}
        @if($order->isDelivery())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h4 class="font-bold text-gray-900 mb-3">🚴 Kurir</h4>

            @if($order->courier)
            <div class="flex items-center gap-2 mb-3 p-2 bg-gray-50 rounded-xl">
                <div class="w-8 h-8 rounded-full bg-red-100 text-red-600
                            flex items-center justify-center font-bold text-sm flex-shrink-0">
                    {{ substr($order->courier->name, 0, 1) }}
                </div>
                <div class="min-w-0">
                    <p class="font-semibold text-sm truncate">{{ $order->courier->name }}</p>
                    <p class="text-xs text-gray-400">{{ $order->courier->vehicle_number }}</p>
                </div>
                <span class="ml-auto text-xs text-green-600 font-semibold flex-shrink-0">✓ Ditugaskan</span>
            </div>
            @endif

            <form action="{{ route('admin.orders.courier', $order) }}" method="POST">
                @csrf @method('PATCH')
                <select name="courier_id"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm mb-3
                               focus:outline-none focus:ring-2 focus:ring-red-500">
                    <option value="">-- Pilih Kurir Online --</option>
                    @foreach($couriers as $c)
                    <option value="{{ $c->id }}"
                            {{ $order->courier_id === $c->id ? 'selected' : '' }}>
                        {{ $c->name }} — {{ $c->vehicle_number }}
                    </option>
                    @endforeach
                </select>
                <button type="submit"
                        class="w-full bg-gray-900 hover:bg-gray-700 text-white
                               font-bold py-2.5 rounded-xl transition">
                    Tugaskan Kurir
                </button>
            </form>

            @if($couriers->isEmpty())
            <p class="text-xs text-red-500 text-center mt-2">
                ⚠ Tidak ada kurir online saat ini
            </p>
            @endif
        </div>
        @else
        {{-- Info takeaway untuk admin --}}
        <div class="bg-green-50 border border-green-200 rounded-2xl p-5">
            <h4 class="font-bold text-green-800 mb-2">🥤 Take Away</h4>
            <p class="text-green-600 text-sm">Pesanan ini tidak memerlukan kurir.</p>
            <p class="text-green-600 text-sm mt-1">
                Pelanggan akan mengambil sendiri pukul
                <strong>{{ \Carbon\Carbon::createFromFormat('H:i:s', $order->pickup_time)->format('H:i') }} WIB</strong>
            </p>
        </div>
        @endif

        {{-- Pembayaran --}}
        @if($order->payment)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h4 class="font-bold text-gray-900 mb-3">💳 Pembayaran</h4>
            <div class="space-y-2 text-sm mb-4">
                <div class="flex justify-between">
                    <span class="text-gray-500">Metode</span>
                    <span class="font-bold uppercase">{{ $order->payment->method }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Status</span>
                    <span class="font-bold
                        {{ $order->payment->status === 'success'
                            ? 'text-green-600'
                            : ($order->payment->status === 'failed'
                                ? 'text-red-600'
                                : 'text-yellow-600') }}">
                        {{ match($order->payment->status) {
                            'success' => '✓ Lunas',
                            'failed'  => '✗ Ditolak',
                            default   => '⏳ Menunggu',
                        } }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Jumlah</span>
                    <span class="font-bold text-red-600">
                        Rp{{ number_format($order->payment->amount, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            @if($order->payment->proof_image)
            <img src="{{ $order->payment->proof_image_url }}"
                 class="w-full rounded-xl mb-4 border border-gray-200"
                 alt="Bukti pembayaran">
            @endif

            @if($order->payment->status === 'pending' && $order->payment->proof_image)
            <form action="{{ route('admin.payments.confirm', $order->payment) }}"
                  method="POST" class="mb-2">
                @csrf
                <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white
                               font-bold py-2.5 rounded-xl transition">
                    ✓ Konfirmasi Pembayaran
                </button>
            </form>
            <form action="{{ route('admin.payments.reject', $order->payment) }}" method="POST">
                @csrf
                <input type="hidden" name="reason" value="Bukti pembayaran tidak valid">
                <button type="submit"
                        class="w-full bg-red-100 text-red-600 hover:bg-red-200
                               font-semibold py-2.5 rounded-xl transition">
                    ✗ Tolak Pembayaran
                </button>
            </form>
            @elseif($order->payment->status === 'pending' && !$order->payment->proof_image)

                @if($order->payment->method === 'qris')
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-3 text-center">
                        <p class="text-yellow-700 text-xs font-medium">
                            ⏳ Menunggu pelanggan upload bukti pembayaran
                        </p>
                    </div>

                @elseif($order->payment->method === 'cash')
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 text-center">
                        <p class="text-blue-700 text-xs font-medium">
                            💵 Pembayaran dilakukan saat pesanan diterima (COD)
                        </p>
                    </div>
                @endif

            @endif
        </div>
        @endif

    </div>
</div>
@endsection