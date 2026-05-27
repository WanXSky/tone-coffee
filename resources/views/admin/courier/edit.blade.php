@extends('layouts.admin')
@section('title', 'Edit Kurir - ' . $courier->name)

@section('content')
<div class="max-w-2xl">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <a href="{{ route('admin.couriers.index') }}"
           class="hover:text-red-600 transition">
            Kurir
        </a>
        <span>/</span>
        <span class="text-gray-600 font-medium">Edit {{ $courier->name }}</span>
    </div>

    {{-- Card form --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Header --}}
        <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600
                        flex items-center justify-center font-black text-xl">
                {{ substr($courier->name, 0, 1) }}
            </div>
            <div>
                <h2 class="font-black text-gray-900">Edit Data Kurir</h2>
                <p class="text-gray-400 text-sm">Perbarui informasi kurir {{ $courier->name }}</p>
            </div>
            {{-- Badge status saat ini --}}
            <span class="ml-auto px-3 py-1.5 rounded-full text-xs font-bold
                {{ $courier->status === 'online'
                    ? 'bg-green-100 text-green-700'
                    : 'bg-gray-100 text-gray-500' }}">
                {{ $courier->status === 'online' ? '🟢 Online' : '⚫ Offline' }}
            </span>
        </div>

        {{-- Form --}}
        <form action="{{ route('admin.couriers.update', $courier) }}"
              method="POST"
              enctype="multipart/form-data"
              class="p-6">
            @csrf
            @method('PUT')

            <div class="space-y-5">

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $courier->name) }}"
                           required
                           placeholder="Masukkan nama lengkap kurir"
                           class="w-full border rounded-xl px-4 py-3 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent
                                  @error('name') border-red-400 bg-red-50 @else border-gray-200 @enderror">
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
                               value="{{ old('phone', $courier->phone) }}"
                               required
                               placeholder="08xxxxxxxxxx"
                               class="w-full border rounded-xl pl-10 pr-4 py-3 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent
                                      @error('phone') border-red-400 bg-red-50 @else border-gray-200 @enderror">
                    </div>
                    @error('phone')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        <span>⚠</span> {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Nomor kendaraan --}}
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
                               value="{{ old('vehicle_number', $courier->vehicle_number) }}"
                               required
                               placeholder="Contoh: BP 1234 AB"
                               class="w-full border rounded-xl pl-10 pr-4 py-3 text-sm uppercase
                                      focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent
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
                        Status Kurir <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-3">

                        {{-- Online --}}
                        <label for="status-online"
                               class="relative border-2 rounded-xl p-4 cursor-pointer transition
                                      hover:border-green-400
                                      has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                            <input type="radio"
                                   id="status-online"
                                   name="status"
                                   value="online"
                                   class="sr-only"
                                   {{ old('status', $courier->status) === 'online' ? 'checked' : '' }}>
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">🟢</span>
                                <div>
                                    <p class="font-bold text-gray-900 text-sm">Online</p>
                                    <p class="text-gray-400 text-xs">Siap menerima order</p>
                                </div>
                            </div>
                            {{-- Centang aktif --}}
                            <span class="absolute top-3 right-3 w-4 h-4 rounded-full
                                         bg-green-500 text-white text-xs
                                         items-center justify-center font-bold hidden
                                         has-[:checked]:flex">✓</span>
                        </label>

                        {{-- Offline --}}
                        <label for="status-offline"
                               class="relative border-2 rounded-xl p-4 cursor-pointer transition
                                      hover:border-gray-400
                                      has-[:checked]:border-gray-500 has-[:checked]:bg-gray-50">
                            <input type="radio"
                                   id="status-offline"
                                   name="status"
                                   value="offline"
                                   class="sr-only"
                                   {{ old('status', $courier->status) === 'offline' ? 'checked' : '' }}>
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

                {{-- Foto kurir --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Foto Kurir
                        <span class="text-gray-400 font-normal">(Opsional)</span>
                    </label>

                    {{-- Preview foto saat ini --}}
                    @if($courier->photo)
                    <div class="flex items-center gap-4 mb-3 p-3 bg-gray-50 rounded-xl border border-gray-200">
                        <img src="{{ asset('storage/' . $courier->photo) }}"
                             alt="{{ $courier->name }}"
                             id="current-photo"
                             class="w-16 h-16 rounded-xl object-cover border border-gray-200">
                        <div>
                            <p class="text-sm font-medium text-gray-700">Foto saat ini</p>
                            <p class="text-xs text-gray-400">Upload foto baru untuk mengganti</p>
                        </div>
                    </div>
                    @else
                    <div class="flex items-center gap-4 mb-3 p-3 bg-gray-50 rounded-xl border border-gray-200">
                        <div class="w-16 h-16 rounded-xl bg-red-100 text-red-600
                                    flex items-center justify-center font-black text-2xl">
                            {{ substr($courier->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Belum ada foto</p>
                            <p class="text-xs text-gray-400">Upload foto kurir di bawah</p>
                        </div>
                    </div>
                    @endif

                    {{-- Area upload --}}
                    <div class="border-2 border-dashed border-gray-300 rounded-xl
                                hover:border-red-400 transition cursor-pointer"
                         id="upload-area"
                         onclick="document.getElementById('photo-input').click()">
                        <input type="file"
                               name="photo"
                               id="photo-input"
                               accept="image/jpeg,image/png,image/jpg"
                               class="sr-only"
                               onchange="previewPhoto(this)">

                        <div class="p-6 text-center" id="upload-placeholder">
                            <div class="text-3xl mb-2">📷</div>
                            <p class="text-gray-600 font-medium text-sm">
                                Klik untuk pilih foto baru
                            </p>
                            <p class="text-gray-400 text-xs mt-1">
                                JPG, PNG · Maksimal 1MB
                            </p>
                        </div>

                        {{-- Preview foto baru --}}
                        <div class="hidden p-4" id="preview-container">
                            <img id="preview-img"
                                 class="w-full max-h-48 object-contain rounded-xl mx-auto">
                            <p class="text-center text-green-600 text-xs font-semibold mt-2">
                                ✓ Foto siap diupload
                            </p>
                        </div>
                    </div>

                    @error('photo')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        <span>⚠</span> {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Info tambahan (readonly) --}}
                <div class="grid grid-cols-2 gap-4 pt-2">
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <p class="text-xs text-gray-400 mb-1">Bergabung Sejak</p>
                        <p class="font-semibold text-gray-700 text-sm">
                            {{ $courier->created_at->isoFormat('D MMMM Y') }}
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <p class="text-xs text-gray-400 mb-1">Total Pesanan Diantar</p>
                        <p class="font-semibold text-gray-700 text-sm">
                            {{ $courier->orders()->count() }} pesanan
                        </p>
                    </div>
                </div>

            </div>

            {{-- Tombol aksi --}}
            <div class="flex gap-3 mt-8 pt-6 border-t border-gray-100">
                <button type="submit"
                        class="flex-1 bg-red-600 hover:bg-red-700 active:scale-95
                               text-white font-bold py-3 rounded-xl transition
                               flex items-center justify-center gap-2">
                    <span>💾</span> Simpan Perubahan
                </button>
                <a href="{{ route('admin.couriers.index') }}"
                   class="px-6 py-3 border-2 border-gray-200 hover:border-gray-300
                          text-gray-600 font-semibold rounded-xl transition text-center">
                    Batal
                </a>
            </div>

        </form>
    </div>

    {{-- Card hapus kurir --}}
    <div class="mt-5 bg-white rounded-2xl shadow-sm border border-red-100 p-5">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-bold text-red-600 text-sm">Hapus Kurir</h3>
                <p class="text-gray-400 text-xs mt-0.5">
                    Tindakan ini tidak bisa dibatalkan. Data kurir akan dihapus permanen.
                </p>
            </div>
            <form action="{{ route('admin.couriers.destroy', $courier) }}"
                  method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus kurir {{ $courier->name }}? Tindakan ini tidak bisa dibatalkan.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-50 hover:bg-red-600 text-red-600 hover:text-white
                               border border-red-200 hover:border-red-600
                               font-bold text-sm px-4 py-2 rounded-xl transition">
                    🗑️ Hapus
                </button>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function previewPhoto(input) {
        if (!input.files || !input.files[0]) return;

        const file = input.files[0];

        // Validasi ukuran file (max 1MB)
        if (file.size > 1024 * 1024) {
            alert('Ukuran foto maksimal 1MB. Silakan pilih foto yang lebih kecil.');
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

            // Jika ada foto lama, buat semi-transparan
            const currentPhoto = document.getElementById('current-photo');
            if (currentPhoto) {
                currentPhoto.style.opacity = '0.4';
            }
        };

        reader.readAsDataURL(file);
    }
</script>
@endpush