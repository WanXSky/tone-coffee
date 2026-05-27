{{-- ============================================================ --}}
{{-- FILE: resources/views/admin/courier/index.blade.php          --}}
{{-- ============================================================ --}}
@extends('layouts.admin')
@section('title', 'Kelola Kurir')
 
@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-gray-500 text-sm">{{ $couriers->total() }} kurir terdaftar</p>
    <a href="{{ route('admin.couriers.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold px-5 py-2.5 rounded-xl transition">
        + Tambah Kurir
    </a>
</div>
 
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
    @foreach($couriers as $courier)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-black text-lg">
                    {{ substr($courier->name, 0, 1) }}
                </div>
                <div>
                    <h3 class="font-bold text-gray-900">{{ $courier->name }}</h3>
                    <p class="text-gray-500 text-sm">{{ $courier->vehicle_number }}</p>
                </div>
            </div>
            {{-- Toggle status --}}
            <button onclick="toggleCourier({{ $courier->id }}, this)"
                    data-status="{{ $courier->status }}"
                    class="px-3 py-1.5 rounded-full text-xs font-bold transition
                           {{ $courier->status === 'online' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                {{ $courier->status === 'online' ? '🟢 Online' : '⚫ Offline' }}
            </button>
        </div>
 
        <div class="space-y-1.5 text-sm text-gray-600 mb-4">
            <p>📱 {{ $courier->phone }}</p>
            <p>📦 {{ $courier->orders_count }} total pesanan</p>
        </div>
 
        <div class="flex gap-2">
            <a href="{{ route('admin.couriers.edit', $courier) }}" class="flex-1 bg-blue-50 text-blue-700 hover:bg-blue-100 font-semibold text-sm py-2 rounded-xl text-center transition">
                Edit
            </a>
            <form action="{{ route('admin.couriers.destroy', $courier) }}" method="POST"
                  onsubmit="return confirm('Hapus kurir ini?')" class="flex-1">
                @csrf @method('DELETE')
                <button type="submit" class="w-full bg-red-50 text-red-700 hover:bg-red-100 font-semibold text-sm py-2 rounded-xl transition">
                    Hapus
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>
 
<div class="mt-6">{{ $couriers->links() }}</div>
@endsection
 
@push('scripts')
<script>
async function toggleCourier(courierId, btn) {
    const res  = await fetch(`/admin/couriers/${courierId}/toggle`);
    const data = await res.json();
    if (data.success) {
        btn.dataset.status = data.status;
        btn.textContent    = data.status === 'online' ? '🟢 Online' : '⚫ Offline';
        btn.className = `px-3 py-1.5 rounded-full text-xs font-bold transition ${
            data.status === 'online' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500'
        }`;
    }
}
</script>
@endpush