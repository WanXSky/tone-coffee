@extends('layouts.admin')
@section('title', 'Tambah Kurir')

@section('content')
<div class="max-w-2xl">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <a href="{{ route('admin.couriers.index') }}"
           class="hover:text-red-600 transition">
            Kurir
        </a>
        <span>/</span>
        <span class="text-gray-600 font-medium">Tambah Kurir Baru</span>
    </div>

    {{-- Card form --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Header --}}
        <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600
                        flex items-center justify-center text-2xl">
                🚴
            </div>
            <div>
                <h2 class="font-black text-gray-900">Tambah Kurir Baru</h2>
                <p class="text-gray-400 text-sm">Isi data lengkap kurir yang akan ditambahkan</p>
            </div>
        </div>

        {{-- Form --}}
        <form action="{{ route('admin.couriers.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="p-6">
            @csrf

            <div class="space-y-5">

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                            👤
                        </span>
                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               placeholder="Masukkan nama lengkap kurir"
                               class="w-full border rounded-xl pl-11 pr-4 py-3 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent
                                      transition placeholder-gray-400
                                      @error('name') border-red-400 bg-red-50 @else border-gray-200 @enderror">
                    </div>
                    @error('name')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        <span>⚠</span> {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Nomor HP --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Nomor HP <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                            📱
                        </span>
                        <input type="tel"
                               name="phone"
                               value="{{ old('phone') }}"
                               required
                               placeholder="08xxxxxxxxxx"
                               class="w-full border rounded-xl pl-11 pr-4 py-3 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent
                                      transition placeholder-gray-400
                                      @error('phone') border-red-400 bg-red-50 @else border-gray-200 @enderror">
                    </div>
                    @error('phone')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        <span>⚠</span> {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Nomor Kendaraan --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Nomor Kendaraan <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                            🏍️
                        </span>
                        <input type="text"
                               name="vehicle_number"
                               value="{{ old('vehicle_number') }}"
                               required
                               placeholder="Contoh: BP 1234 AB"
                               style="text-transform: uppercase"
                               oninput="this.value = this.value.toUpperCase()"
                               class="w-full border rounded-xl pl-11 pr-4 py-3 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent
                                      transition placeholder-gray-400
                                      @error('vehicle_number') border-red-400 bg-red-50 @else border-gray-200 @enderror">
                    </div>
                    @error('vehicle_number')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        <span>⚠</span> {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Status Awal <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-3">

                        {{-- Online --}}
                        <label for="status-online"
                               class="relative border-2 rounded-xl p-4 cursor-pointer
                                      transition hover:border-green-400
                                      has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                            <input type="radio"
                                   id="status-online"
                                   name="status"
                                   value="online"
                                   class="sr-only"
                                   {{ old('status', 'online') === 'online' ? 'checked' : '' }}>
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">🟢</span>
                                <div>
                                    <p class="font-bold text-gray-900 text-sm">Online</p>
                                    <p class="text-gray-400 text-xs">Siap menerima order</p>
                                </div>
                            </div>
                        </label>

                        {{-- Offline --}}
                        <label for="status-offline"
                               class="relative border-2 rounded-xl p-4 cursor-pointer
                                      transition hover:border-gray-400
                                      has-[:checked]:border-gray-500 has-[:checked]:bg-gray-50">
                            <input type="radio"
                                   id="status-offline"
                                   name="status"
                                   value="offline"
                                   class="sr-only"
                                   {{ old('status') === 'offline' ? 'checked' : '' }}>
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">⚫</span>
                                <div>
                                    <p class="font-bold text-gray-900 text-sm">Offline</p>
                                    <p class="text-gray-400 text-xs">Tidak menerima order</p>
                                </div>
                            </div>
                        </label>

                    </div>
                    @error('status')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        <span>⚠</span> {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Foto Kurir --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Foto Kurir
                        <span class="text-gray-400 font-normal">(Opsional)</span>
                    </label>

                    {{-- Area upload --}}
                    <div class="border-2 border-dashed border-gray-300 rounded-xl
                                hover:border-red-400 transition cursor-pointer"
                         onclick="document.getElementById('photo-input').click()">

                        <input type="file"
                               name="photo"
                               id="photo-input"
                               accept="image/jpeg,image/png,image/jpg"
                               class="sr-only"
                               onchange="previewPhoto(this)">

                        {{-- Placeholder --}}
                        <div class="p-8 text-center" id="upload-placeholder">
                            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center
                                        justify-center text-3xl mx-auto mb-3">
                                📷
                            </div>
                            <p class="text-gray-600 font-medium text-sm">
                                Klik untuk upload foto kurir
                            </p>
                            <p class="text-gray-400 text-xs mt-1">
                                JPG, PNG · Maksimal 1MB
                            </p>
                        </div>

                        {{-- Preview foto --}}
                        <div class="hidden p-4 text-center" id="preview-container">
                            <img id="preview-img"
                                 class="w-32 h-32 rounded-full object-cover mx-auto
                                        border-4 border-red-200 shadow-md">
                            <p class="text-green-600 text-xs font-semibold mt-3">
                                ✓ Foto siap diupload
                            </p>
                            <button type="button"
                                    onclick="resetPhoto(event)"
                                    class="text-red-400 hover:text-red-600 text-xs mt-1
                                           underline transition">
                                Ganti foto
                            </button>
                        </div>

                    </div>

                    @error('photo')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        <span>⚠</span> {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Info penting --}}
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <p class="text-blue-700 text-xs font-semibold mb-2">ℹ️ Informasi Penting</p>
                    <ul class="text-blue-600 text-xs space-y-1">
                        <li>• Kurir dengan status <strong>Online</strong> akan langsung menerima order dari pelanggan</li>
                        <li>• Status kurir dapat diubah kapan saja dari halaman daftar kurir</li>
                        <li>• Pastikan nomor HP aktif agar pelanggan bisa menghubungi kurir</li>
                    </ul>
                </div>

            </div>

            {{-- Tombol aksi --}}
            <div class="flex gap-3 mt-8 pt-6 border-t border-gray-100">
                <button type="submit"
                        class="flex-1 bg-red-600 hover:bg-red-700 active:scale-95
                               text-white font-bold py-3 rounded-xl transition
                               flex items-center justify-center gap-2">
                    <span>🚴</span>
                    <span>Tambah Kurir</span>
                </button>
                <a href="{{ route('admin.couriers.index') }}"
                   class="px-6 py-3 border-2 border-gray-200 hover:border-gray-300
                          text-gray-600 font-semibold rounded-xl transition text-center">
                    Batal
                </a>
            </div>

        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // ── Preview foto yang diupload ────────────────────────────────
    function previewPhoto(input) {
        if (!input.files || !input.files[0]) return;

        const file = input.files[0];

        // Validasi ukuran (max 1MB)
        if (file.size > 1024 * 1024) {
            alert('Ukuran foto maksimal 1MB. Silakan pilih foto yang lebih kecil.');
            input.value = '';
            return;
        }

        // Validasi tipe file
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format foto tidak didukung. Gunakan JPG atau PNG.');
            input.value = '';
            return;
        }

        const reader = new FileReader();

        reader.onload = function (e) {
            // Sembunyikan placeholder
            document.getElementById('upload-placeholder').classList.add('hidden');

            // Tampilkan preview
            const container = document.getElementById('preview-container');
            const img       = document.getElementById('preview-img');

            img.src = e.target.result;
            container.classList.remove('hidden');
        };

        reader.readAsDataURL(file);
    }

    // ── Reset / ganti foto ────────────────────────────────────────
    function resetPhoto(event) {
        event.stopPropagation();

        // Reset input file
        const input = document.getElementById('photo-input');
        input.value = '';

        // Tampilkan kembali placeholder
        document.getElementById('upload-placeholder').classList.remove('hidden');

        // Sembunyikan preview
        document.getElementById('preview-container').classList.add('hidden');
        document.getElementById('preview-img').src = '';
    }
</script>
@endpush