{{-- ============================================================ --}}
{{-- FILE: resources/views/payment/show.blade.php               --}}
{{-- ============================================================ --}}
@extends('layouts.app')
@section('title', 'Pembayaran - ' . $order->order_number)
 
@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden animate__animated animate__fadeIn">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-red-600 to-red-700 text-white p-6">
            <p class="text-red-200 text-sm mb-1">No. Pesanan</p>
            <h1 class="text-2xl font-black">{{ $order->order_number }}</h1>
            <p class="text-red-100 text-sm mt-2">Selesaikan pembayaran untuk memproses pesananmu</p>
        </div>
 
        <div class="p-6">
            {{-- Ringkasan pesanan --}}
            <h3 class="font-bold text-gray-900 mb-3">Detail Pesanan</h3>
            <div class="bg-gray-50 rounded-xl p-4 mb-6 space-y-2">
                @foreach($order->items as $item)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-700">{{ $item->menu_name }} <span class="text-gray-400">×{{ $item->quantity }}</span></span>
                    <span class="font-semibold">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
                @endforeach
                <hr class="border-gray-200">
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Ongkos kirim</span>
                    <span>Rp{{ number_format($order->delivery_fee, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-black text-base">
                    <span>Total</span>
                    <span class="text-red-600">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
 
            {{-- Info kurir --}}
            @if($order->courier)
            <div class="flex items-center gap-3 bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                <div class="w-10 h-10 rounded-full bg-green-600 text-white flex items-center justify-center font-bold text-sm">
                    {{ substr($order->courier->name, 0, 1) }}
                </div>
                <div>
                    <p class="font-semibold text-green-800 text-sm">Kurir ditugaskan</p>
                    <p class="text-green-700 font-bold">{{ $order->courier->name }}</p>
                    <p class="text-green-600 text-xs">{{ $order->courier->vehicle_number }} · {{ $order->courier->phone }}</p>
                </div>
                <span class="ml-auto bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full">🟢 Online</span>
            </div>
            @endif
 
            {{-- Metode pembayaran & aksi --}}
            @if($order->payment)
            @if($order->payment->method === 'cash')
            {{-- Cash --}}
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 text-center">
                <div class="text-4xl mb-2">💵</div>
                <h3 class="font-bold text-yellow-800 text-lg">Bayar Tunai ke Kurir</h3>
                <p class="text-yellow-700 text-sm mt-1">Siapkan uang tunai sebesar:</p>
                <p class="text-3xl font-black text-yellow-600 my-3">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>
                <p class="text-yellow-600 text-xs">Kurir akan segera menghubungi kamu</p>
            </div>
 
            @elseif($order->payment->method === 'qris')
            {{-- QRIS --}}
            <div>
                @if($order->payment->status === 'pending' && !$order->payment->proof_image)
                {{-- Belum upload bukti --}}
                <div class="text-center mb-6">
                    <h3 class="font-bold text-gray-900 text-lg mb-2">Scan QRIS untuk Membayar</h3>
                    <p class="text-gray-500 text-sm mb-4">Total: <strong class="text-red-600 text-lg">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</strong></p>
                    {{-- Placeholder QRIS - ganti dengan gambar QRIS asli --}}
                    <div class="inline-block bg-white border-4 border-red-600 rounded-2xl p-4 shadow-lg">
                        <img src="{{ asset('images/qris.png') }}"
                             alt="QRIS ONE T.O Coffee"
                             class="w-52 h-52 object-contain"
                             onerror="this.parentElement.innerHTML='<div class=\'w-52 h-52 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 text-sm\'>Upload gambar QRIS<br>ke public/images/qris.png</div>'">
                    </div>
                    <p class="text-xs text-gray-400 mt-3">Gunakan aplikasi apapun yang mendukung QRIS</p>
                </div>
 
                {{-- Form upload bukti --}}
                <div class="bg-gray-50 rounded-xl p-5">
                    <h4 class="font-bold text-gray-900 mb-3">Upload Bukti Pembayaran</h4>
                    <form action="{{ route('payment.upload', $order) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-red-400 transition" id="upload-area">
                            <input type="file" name="proof_image" id="proof-input" accept="image/*"
                                   class="sr-only" onchange="previewImage(this)">
                            <label for="proof-input" class="cursor-pointer">
                                <div id="upload-placeholder">
                                    <div class="text-3xl mb-2">📸</div>
                                    <p class="text-gray-600 font-medium">Klik untuk pilih foto bukti</p>
                                    <p class="text-gray-400 text-xs mt-1">JPG, PNG max 2MB</p>
                                </div>
                                <img id="preview-img" class="hidden w-full max-h-48 object-contain rounded-lg">
                            </label>
                        </div>
                        @error('proof_image')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                        <button type="submit" class="mt-4 w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl transition">
                            📤 Kirim Bukti Pembayaran
                        </button>
                    </form>
                </div>
 
                @elseif($order->payment->proof_image && $order->payment->status === 'pending')
                {{-- Sudah upload, menunggu konfirmasi --}}
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 text-center">
                    <div class="text-4xl mb-2">⏳</div>
                    <h3 class="font-bold text-blue-800">Bukti Dikirim, Menunggu Konfirmasi</h3>
                    <p class="text-blue-600 text-sm mt-1">Admin akan segera mengkonfirmasi pembayaranmu</p>
                    <img src="{{ $order->payment->proof_image_url }}" class="w-32 h-32 object-cover rounded-xl mx-auto mt-4 shadow">
                </div>
 
                @elseif($order->payment->status === 'success')
                <div class="bg-green-50 border border-green-200 rounded-xl p-5 text-center">
                    <div class="text-4xl mb-2">✅</div>
                    <h3 class="font-bold text-green-800">Pembayaran Dikonfirmasi!</h3>
                    <p class="text-green-600 text-sm mt-1">Pesananmu sedang diproses oleh tim kami</p>
                </div>
 
                @elseif($order->payment->status === 'failed')
                <div class="bg-red-50 border border-red-200 rounded-xl p-5 text-center">
                    <div class="text-4xl mb-2">❌</div>
                    <h3 class="font-bold text-red-800">Pembayaran Ditolak</h3>
                    <p class="text-red-600 text-sm mt-1">{{ $order->payment->notes ?? 'Silakan hubungi admin untuk informasi lebih lanjut' }}</p>
                </div>
                @endif
            </div>
            @endif
            @endif
 
            {{-- Tombol lihat pesanan --}}
            <div class="mt-6 flex gap-3">
                <a href="{{ route('order.show', $order) }}" class="flex-1 border-2 border-red-600 text-red-600 hover:bg-red-600 hover:text-white font-bold py-3 rounded-xl transition text-center">
                    📦 Lihat Status Pesanan
                </a>
                <a href="{{ route('menu') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 rounded-xl transition text-center">
                    + Pesan Lagi
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
 
@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('upload-placeholder').classList.add('hidden');
            const img = document.getElementById('preview-img');
            img.src = e.target.result;
            img.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush