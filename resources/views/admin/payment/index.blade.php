@extends('layouts.admin')
@section('title', 'Kelola Pembayaran')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-black text-gray-900">Daftar Pembayaran</h2>
    </div>

    {{-- Filter status --}}
    <form method="GET" class="flex gap-3">
        <select name="status" class="border border-gray-200 rounded-xl px-4 py-2">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
            <option value="success" {{ request('status')=='success'?'selected':'' }}>Success</option>
            <option value="failed"  {{ request('status')=='failed'?'selected':'' }}>Failed</option>
        </select>

        <button class="bg-gray-900 text-white px-4 py-2 rounded-xl">
            Cari
        </button>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left">Order</th>
                    <th class="px-5 py-3 text-left">User</th>
                    <th class="px-5 py-3 text-left">Jumlah</th>
                    <th class="px-5 py-3 text-left">Status</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($payments as $payment)
                <tr>
                    <td class="px-5 py-4 text-xs font-mono">
                        {{ $payment->order->order_number }}
                    </td>

                    <td class="px-5 py-4">
                        {{ $payment->order->user->name }}
                    </td>

                    <td class="px-5 py-4 font-bold text-red-600">
                        Rp{{ number_format($payment->amount,0,',','.') }}
                    </td>

                    <td class="px-5 py-4">
                        <span class="px-2 py-1 rounded text-xs font-bold
                            {{ $payment->status == 'success' ? 'bg-green-100 text-green-700' :
                               ($payment->status == 'failed' ? 'bg-red-100 text-red-700' :
                               'bg-yellow-100 text-yellow-700') }}">
                            {{ $payment->status }}
                        </span>
                    </td>

                    <td class="px-5 py-4 text-right space-x-2">

                        {{-- tombol konfirmasi --}}
                        @if($payment->status == 'pending')
                        <form action="{{ route('admin.payments.confirm', $payment) }}" method="POST" class="inline">
                            @csrf
                            <button class="bg-green-600 text-white px-3 py-1 rounded text-xs">
                                Konfirmasi
                            </button>
                        </form>
                        @endif

                        {{-- tombol lihat bukti --}}
                        @if($payment->proof_image)
                        <a href="{{ $payment->proof_image_url }}" target="_blank"
                           class="bg-blue-100 text-blue-700 px-3 py-1 rounded text-xs">
                            Lihat Bukti
                        </a>
                        @endif

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-10 text-gray-400">
                        Tidak ada data pembayaran
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-5">
            {{ $payments->links() }}
        </div>
    </div>
</div>
@endsection