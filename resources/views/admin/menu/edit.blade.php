@extends('layouts.admin')
@section('title', 'Edit Menu')

@section('content')
<div class="max-w-2xl">

    <a href="{{ route('admin.menus.index') }}" class="text-gray-400 hover:text-gray-600 text-sm mb-6 flex items-center gap-1">
        ← Kembali ke Daftar Menu
    </a>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <form action="{{ route('admin.menus.update', $menu) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-5">

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Menu</label>
                    <input type="text" name="name" value="{{ old('name', $menu->name) }}"
                           class="w-full border rounded-xl px-4 py-3">
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                    <select name="category_id" class="w-full border rounded-xl px-4 py-3">
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ $menu->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Harga --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Harga</label>
                    <input type="number" name="price" value="{{ old('price', $menu->price) }}"
                           class="w-full border rounded-xl px-4 py-3">
                </div>

                {{-- Stok --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', $menu->stock) }}"
                           class="w-full border rounded-xl px-4 py-3">
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="3"
                              class="w-full border rounded-xl px-4 py-3">{{ old('description', $menu->description) }}</textarea>
                </div>

                {{-- Gambar --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Foto</label>

                    @if($menu->image)
                        <img src="{{ $menu->image_url }}" class="w-32 mb-3 rounded-xl">
                    @endif

                    <input type="file" name="image" class="w-full">
                </div>

                {{-- Status --}}
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_available" value="1"
                        {{ $menu->is_available ? 'checked' : '' }}>
                    <label>Menu Tersedia</label>
                </div>

                {{-- Button --}}
                <div class="flex gap-3 pt-3">
                    <button type="submit" class="flex-1 bg-red-600 text-white py-3 rounded-xl">
                        Update Menu
                    </button>

                    <a href="{{ route('admin.menus.index') }}"
                       class="px-6 py-3 border rounded-xl">
                        Batal
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection
