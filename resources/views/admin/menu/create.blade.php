{{-- ============================================================ --}}
{{-- FILE: resources/views/admin/menu/create.blade.php            --}}
{{-- ============================================================ --}}
@extends('layouts.admin')
@section('title', 'Tambah Menu')
 
@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.menus.index') }}" class="text-gray-400 hover:text-gray-600 text-sm mb-6 flex items-center gap-1 transition">
        ← Kembali ke Daftar Menu
    </a>
 
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-5">
                <div class="grid grid-cols-2 gap-5">
                    <div class="col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Menu *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kategori *</label>
                        <select name="category_id" required
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Harga (Rp) *</label>
                        <input type="number" name="price" value="{{ old('price') }}" required min="0" step="500"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500">
                        @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Stok</label>
                        <input type="number" name="stock" value="{{ old('stock', 100) }}" required min="0"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>
                    <div class="flex items-center gap-3 pt-4">
                        <input type="checkbox" name="is_available" id="is_available" value="1" checked
                               class="w-5 h-5 text-red-600 rounded border-gray-300 focus:ring-red-500">
                        <label for="is_available" class="text-sm font-semibold text-gray-700">Menu Tersedia</label>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                        <textarea name="description" rows="3"
                                  class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 resize-none">{{ old('description') }}</textarea>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Foto Menu</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-red-400 transition cursor-pointer" id="img-drop">
                            <input type="file" name="image" id="img-input" accept="image/*" class="sr-only" onchange="previewImg(this)">
                            <label for="img-input" class="cursor-pointer">
                                <div id="img-placeholder">
                                    <div class="text-4xl mb-2">🖼️</div>
                                    <p class="text-gray-500 font-medium">Klik untuk upload foto</p>
                                    <p class="text-gray-400 text-xs mt-1">JPG, PNG max 2MB</p>
                                </div>
                                <img id="img-preview" class="hidden max-h-48 mx-auto rounded-xl object-contain">
                            </label>
                        </div>
                    </div>
                </div>
 
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl transition">
                        Simpan Menu
                    </button>
                    <a href="{{ route('admin.menus.index') }}" class="px-6 py-3 border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold rounded-xl transition">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
 
@push('scripts')
<script>
function previewImg(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('img-placeholder').classList.add('hidden');
            const img = document.getElementById('img-preview');
            img.src = e.target.result;
            img.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush