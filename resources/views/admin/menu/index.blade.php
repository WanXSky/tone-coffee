{{-- ============================================================ --}}
{{-- FILE: resources/views/admin/menu/index.blade.php            --}}
{{-- ============================================================ --}}
@extends('layouts.admin')
@section('title', 'Kelola Menu')

@section('content')

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-gray-500 text-sm">Total {{ $menus->total() }} menu terdaftar</p>
    </div>
    <a href="{{ route('admin.menus.create') }}"
       class="bg-red-600 hover:bg-red-700 text-white font-bold px-5 py-2.5 rounded-xl transition flex items-center gap-2">
        + Tambah Menu
    </a>
</div>

{{-- FILTER --}}
<form action="{{ route('admin.menus.index') }}" method="GET"
      x-data="{ openFilter: false }"
      class="flex gap-3 mb-6 items-center">

    {{-- SEARCH --}}
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Cari nama menu..."
           class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                  focus:outline-none focus:ring-2 focus:ring-red-500">

    {{-- ICON FILTER (mobile) --}}
    <button type="button"
        @click="openFilter = true"
        class="lg:hidden bg-gray-100 hover:bg-gray-200 p-3 rounded-xl text-lg">
        🎛️
    </button>

    {{-- FILTER DESKTOP --}}
    <select name="category"
        class="hidden lg:block border border-gray-200 rounded-xl px-4 py-2.5 text-sm">
        <option value="">Semua Kategori</option>
        @foreach($categories as $cat)
        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
            {{ $cat->name }}
        </option>
        @endforeach
    </select>

    <button type="submit"
        class="bg-gray-900 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-700 transition">
        Cari
    </button>

    {{-- MODAL FILTER MOBILE --}}
    <div x-show="openFilter"
         x-transition
         class="fixed inset-0 bg-black/40 z-50 flex items-center justify-center lg:hidden">

        <div @click.outside="openFilter = false"
             class="bg-white rounded-2xl w-[90%] p-5">

            <h3 class="font-bold text-gray-900 mb-4">Filter Kategori</h3>

            <select name="category"
                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm mb-4">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
                @endforeach
            </select>

            <div class="flex gap-2">
                <button type="button"
                    @click="openFilter = false"
                    class="flex-1 bg-gray-100 py-2 rounded-xl">
                    Batal
                </button>

                <button type="submit"
                    class="flex-1 bg-red-600 text-white py-2 rounded-xl">
                    Terapkan
                </button>
            </div>

        </div>
    </div>

</form>

{{-- TABEL --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100">

    <div class="overflow-x-auto [-webkit-overflow-scrolling:touch]">
        <table class="min-w-[700px] text-sm">

            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-5 py-3.5 font-bold text-gray-600">Menu</th>
                    <th class="text-left px-5 py-3.5 font-bold text-gray-600">Kategori</th>
                    <th class="text-left px-5 py-3.5 font-bold text-gray-600">Harga</th>
                    <th class="text-center px-5 py-3.5 font-bold text-gray-600">Tersedia</th>
                    <th class="text-right px-5 py-3.5 font-bold text-gray-600">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-50">
                @forelse($menus as $menu)
                <tr class="hover:bg-gray-50 transition">

                    {{-- MENU --}}
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $menu->image_url }}"
                                 class="w-12 h-12 rounded-xl object-cover border border-gray-200"
                                 onerror="this.src='https://placehold.co/48x48/dc2626/white?text=☕'">

                            <span class="font-semibold text-gray-900">
                                {{ $menu->name }}
                            </span>
                        </div>
                    </td>

                    {{-- KATEGORI --}}
                    <td class="px-5 py-4 text-gray-500">
                        {{ $menu->category->name }}
                    </td>

                    {{-- HARGA --}}
                    <td class="px-5 py-4 font-bold text-red-600">
                        {{ $menu->price_formatted }}
                    </td>

                    {{-- STATUS --}}
                    <td class="px-5 py-4 text-center">
                        <button onclick="toggleMenu({{ $menu->id }}, this)"
                                class="px-3 py-1 rounded-full text-xs font-bold transition
                                {{ $menu->is_available
                                    ? 'bg-green-100 text-green-700 hover:bg-green-200'
                                    : 'bg-red-100 text-red-700 hover:bg-red-200' }}">
                            {{ $menu->is_available ? '✓ Aktif' : '✗ Nonaktif' }}
                        </button>
                    </td>

                    {{-- AKSI --}}
                    <td class="px-5 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.menus.edit', $menu) }}"
                               class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                Edit
                            </a>

                            <form action="{{ route('admin.menus.destroy', $menu) }}"
                                  method="POST"
                                  onsubmit="return confirm('Nonaktifkan menu ini?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-10 text-gray-400">
                        Tidak ada menu ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="p-5">
        {{ $menus->links() }}
    </div>

</div>

@endsection

@push('scripts')
<script>
async function toggleMenu(menuId, btn) {
    const res  = await fetch(`/admin/menus/toggle/${menuId}`);
    const data = await res.json();

    if (data.success) {
        btn.textContent = data.is_available ? '✓ Aktif' : '✗ Nonaktif';

        btn.className = `px-3 py-1 rounded-full text-xs font-bold transition ${
            data.is_available
            ? 'bg-green-100 text-green-700 hover:bg-green-200'
            : 'bg-red-100 text-red-700 hover:bg-red-200'
        }`;
    }
}
</script>
@endpush