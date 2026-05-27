@extends('layouts.app')
@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-black text-gray-900">🛒 Keranjang Belanja</h1>
        {{-- Tombol hapus terpilih — muncul jika ada yang dicentang --}}
        <button id="btn-delete-selected"
                onclick="deleteSelected()"
                class="hidden items-center gap-2 bg-red-600 hover:bg-red-700
                    text-white font-bold px-5 py-2.5 rounded-xl transition
                    animate__animated animate__fadeIn">
            🗑️ Hapus Terpilih (<span id="selected-count">0</span>)
        </button>
    </div>

    @if(empty($cart))
    {{-- Kosong --}}
    <div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="text-7xl mb-4">🛒</div>
        <h3 class="text-xl font-bold text-gray-700 mb-2">Keranjang kamu kosong</h3>
        <p class="text-gray-400 mb-6">Yuk tambahkan minuman favoritmu!</p>
        <a href="{{ route('menu') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-3 rounded-full transition inline-block">
            Lihat Menu
        </a>
    </div>

    @else
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- ── Daftar item cart ── --}}
        <div class="lg:col-span-2 space-y-4">

            {{-- Toolbar checkbox --}}
            <div class="flex items-center gap-3 bg-white rounded-xl border border-gray-100
                        px-4 py-3 shadow-sm">
                <input type="checkbox" id="check-all"
                    onchange="toggleCheckAll(this)"
                    class="w-4 h-4 rounded border-gray-300 text-red-600
                            focus:ring-red-500 cursor-pointer">
                <label for="check-all" class="text-sm font-medium text-gray-600 cursor-pointer select-none">
                    Pilih Semua
                </label>
                <span class="text-gray-300">|</span>
                <span class="text-xs text-gray-400" id="check-info">
                    0 dari {{ count($cart) }} item dipilih
                </span>
            </div>

            @foreach($cart as $menuId => $item)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4
                        flex items-center gap-4 animate__animated animate__fadeIn
                        transition-all duration-200"
                id="cart-item-{{ $menuId }}">

                {{-- Checkbox pilih item --}}
                <input type="checkbox"
                    class="item-checkbox w-4 h-4 rounded border-gray-300 text-red-600
                            focus:ring-red-500 cursor-pointer flex-shrink-0"
                    value="{{ $menuId }}"
                    onchange="onCheckboxChange()">

                <img src="{{ $item['image'] }}"
                    class="w-20 h-20 rounded-xl object-cover flex-shrink-0"
                    onerror="this.src='https://placehold.co/80x80/dc2626/ffffff?text=🍹'">

                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-gray-900 truncate">{{ $item['name'] }}</h4>
                    <p class="text-red-600 font-semibold text-sm">
                        Rp{{ number_format($item['price'], 0, ',', '.') }}
                    </p>
                    @if(!empty($item['notes']))
                    <p class="text-gray-400 text-xs mt-0.5">Catatan: {{ $item['notes'] }}</p>
                    @endif
                </div>

                {{-- Kontrol qty --}}
                <div class="flex items-center gap-2 flex-shrink-0">
                    <button onclick="decreaseQty({{ $menuId }})"
                            id="btn-minus-{{ $menuId }}"
                            class="w-8 h-8 rounded-full font-bold transition
                                flex items-center justify-center text-lg leading-none
                                {{ $item['qty'] <= 1
                                    ? 'bg-gray-100 text-gray-300 cursor-not-allowed'
                                    : 'bg-red-100 text-red-600 hover:bg-red-600 hover:text-white' }}"
                            {{ $item['qty'] <= 1 ? 'disabled' : '' }}>
                        −
                    </button>

                    <span class="w-8 text-center font-bold text-gray-900 text-base"
                        id="qty-{{ $menuId }}">{{ $item['qty'] }}</span>

                    <button onclick="increaseQty({{ $menuId }})"
                            id="btn-plus-{{ $menuId }}"
                            class="w-8 h-8 rounded-full font-bold transition
                                flex items-center justify-center text-lg leading-none
                                {{ $item['qty'] >= 20
                                    ? 'bg-gray-100 text-gray-300 cursor-not-allowed'
                                    : 'bg-red-600 text-white hover:bg-red-700' }}"
                            {{ $item['qty'] >= 20 ? 'disabled' : '' }}>
                        +
                    </button>
                </div>

                {{-- Subtotal & hapus --}}
                <div class="text-right flex-shrink-0">
                    <p class="font-black text-gray-900" id="sub-{{ $menuId }}">
                        Rp{{ number_format($item['subtotal'], 0, ',', '.') }}
                    </p>
                    <button onclick="removeFromCart({{ $menuId }})"
                            class="text-red-400 hover:text-red-600 text-xs mt-1 transition underline">
                        Hapus
                    </button>
                </div>

            </div>
            @endforeach

            {{-- Tombol kosongkan --}}
            <div class="flex justify-end">
                <form action="{{ route('cart.clear') }}" method="POST"
                    onsubmit="return confirm('Kosongkan seluruh keranjang?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="text-sm text-gray-400 hover:text-red-500 transition underline">
                        Kosongkan keranjang
                    </button>
                </form>
            </div>

        </div>

        {{-- ── Ringkasan order ── --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <h3 class="font-black text-lg text-gray-900 mb-4">Ringkasan</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span id="subtotal-display">Rp{{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600" id="sidebar-ongkir-row">
                        <span>Ongkos kirim</span>
                        <span id="sidebar-ongkir-amount">Rp10.000</span>
                    </div>
                    <hr class="border-gray-100">
                    <div class="flex justify-between font-black text-gray-900 text-base">
                        <span>Total</span>
                        <span id="total-display" class="text-red-600">
                            Rp{{ number_format($total + 10000, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
                <a href="#checkout"
                   class="mt-6 w-full bg-red-600 hover:bg-red-700 text-white font-bold
                          py-3 rounded-xl transition block text-center">
                    Lanjut Checkout →
                </a>
                <a href="{{ route('menu') }}"
                   class="mt-3 w-full text-gray-500 hover:text-red-600 text-sm
                          font-medium text-center block transition">
                    + Tambah Pesanan
                </a>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════════════ --}}
    {{-- FORM CHECKOUT                                  --}}
    {{-- ══════════════════════════════════════════════ --}}
    <div id="checkout" class="mt-10 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        <h2 class="text-xl font-black text-gray-900 mb-6">📋 Detail Pesanan</h2>

        {{-- Validasi error --}}
        @if ($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-5">
            <ul class="text-red-600 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('order.store') }}" method="POST" id="checkout-form">
            @csrf

            {{-- ── PILIH TIPE ORDER ── --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Tipe Pesanan <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 gap-4">

                    {{-- Delivery --}}
                    <label for="type-delivery"
                           class="relative border-2 rounded-xl p-4 cursor-pointer transition
                                  hover:border-red-400
                                  has-[:checked]:border-red-600 has-[:checked]:bg-red-50">
                        <input type="radio" id="type-delivery" name="order_type"
                               value="delivery" class="sr-only"
                               {{ old('order_type', 'delivery') === 'delivery' ? 'checked' : '' }}
                               onchange="switchOrderType('delivery')">
                        <div class="text-center">
                            <div class="text-4xl mb-2">🛵</div>
                            <p class="font-bold text-gray-900">Delivery</p>
                            <p class="text-xs text-gray-500 mt-1">Diantar ke alamatmu</p>
                            <p class="text-xs text-red-500 font-semibold mt-1">+ Rp10.000 ongkir</p>
                        </div>
                    </label>

                    {{-- Take Away --}}
                    <label for="type-takeaway"
                           class="relative border-2 rounded-xl p-4 cursor-pointer transition
                                  hover:border-red-400
                                  has-[:checked]:border-red-600 has-[:checked]:bg-red-50">
                        <input type="radio" id="type-takeaway" name="order_type"
                               value="takeaway" class="sr-only"
                               {{ old('order_type') === 'takeaway' ? 'checked' : '' }}
                               onchange="switchOrderType('takeaway')">
                        <div class="text-center">
                            <div class="text-4xl mb-2">🥤</div>
                            <p class="font-bold text-gray-900">Take Away</p>
                            <p class="text-xs text-gray-500 mt-1">Ambil sendiri di toko</p>
                            <p class="text-xs text-green-600 font-semibold mt-1">Gratis ongkir!</p>
                        </div>
                    </label>

                </div>
            </div>

            {{-- ── FORM DELIVERY ── --}}
            <div id="form-delivery">
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 mb-4 flex items-center gap-2">
                    <span class="text-blue-500">🛵</span>
                    <p class="text-blue-700 text-sm font-medium">Isi alamat pengiriman kamu</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nama Penerima <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="delivery_name"
                               value="{{ old('delivery_name', auth()->user()->name) }}"
                               placeholder="Nama lengkap penerima"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3
                                      focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent
                                      @error('delivery_name') border-red-400 @enderror">
                        @error('delivery_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nomor HP <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" name="delivery_phone"
                               value="{{ old('delivery_phone', auth()->user()->phone) }}"
                               placeholder="08xxxxxxxxxx"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3
                                      focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent
                                      @error('delivery_phone') border-red-400 @enderror">
                        @error('delivery_phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Alamat Lengkap <span class="text-red-500">*</span>
                        </label>
                        <textarea name="delivery_address" rows="3"
                                  placeholder="Nama jalan, nomor rumah, RT/RW, Kelurahan, Kecamatan..."
                                  class="w-full border border-gray-200 rounded-xl px-4 py-3 resize-none
                                         focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent
                                         @error('delivery_address') border-red-400 @enderror">{{ old('delivery_address', auth()->user()->address) }}</textarea>
                        @error('delivery_address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ── FORM TAKE AWAY ── --}}
            <div id="form-takeaway" class="hidden">
                {{-- Info lokasi toko --}}
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-4">
                    <p class="text-green-700 font-bold text-sm mb-1">📍 Lokasi Toko ONE T.O Coffee</p>
                    <p class="text-green-600 text-sm">Jl. Contoh No. 123, Batam, Kepulauan Riau</p>
                    <p class="text-green-500 text-xs mt-1">🕐 Buka: 08.00 - 22.00 WIB</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nama Pengambil <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="pickup_name"
                               value="{{ old('pickup_name', auth()->user()->name) }}"
                               placeholder="Nama yang akan mengambil"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3
                                      focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent
                                      @error('pickup_name') border-red-400 @enderror">
                        @error('pickup_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Estimasi Waktu Ambil <span class="text-red-500">*</span>
                        </label>
                        <input type="time" name="pickup_time"
                               value="{{ old('pickup_time') }}"
                               min="08:00" max="22:00"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3
                                      focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent
                                      @error('pickup_time') border-red-400 @enderror">
                        <p class="text-gray-400 text-xs mt-1">Toko buka 08:00 - 22:00 WIB</p>
                        @error('pickup_time')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Info estimasi siap --}}
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-3 mt-4 flex items-center gap-2">
                    <span>⏱️</span>
                    <p class="text-yellow-700 text-sm">
                        Estimasi minuman siap: <strong>10-15 menit</strong> setelah pesanan dikonfirmasi
                    </p>
                </div>
            </div>

            {{-- ── CATATAN ── --}}
            <div class="mt-5">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Catatan Tambahan
                </label>
                <textarea name="notes" rows="2"
                          placeholder="Misal: jangan terlalu manis, tambah es, dll."
                          class="w-full border border-gray-200 rounded-xl px-4 py-3 resize-none
                                 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">{{ old('notes') }}</textarea>
            </div>

            {{-- ── RINGKASAN HARGA DINAMIS ── --}}
            <div class="mt-5 bg-gray-50 rounded-xl p-4 border border-gray-100">
                <h4 class="font-bold text-gray-900 text-sm mb-3">Ringkasan Pembayaran</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600" id="ongkir-row">
                        <span>Ongkos kirim</span>
                        <span id="ongkir-amount">Rp10.000</span>
                    </div>
                    <hr class="border-gray-200">
                    <div class="flex justify-between font-black text-base">
                        <span>Total Bayar</span>
                        <span id="grand-total-display" class="text-red-600">
                            Rp{{ number_format($total + 10000, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- ── METODE PEMBAYARAN ── --}}
            <div class="mt-6">
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Metode Pembayaran <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 gap-4">
                    <label for="pay-cash"
                           class="border-2 border-gray-200 rounded-xl p-4 cursor-pointer
                                  hover:border-red-400 transition
                                  has-[:checked]:border-red-600 has-[:checked]:bg-red-50">
                        <input type="radio" id="pay-cash" name="payment_method"
                               value="cash" class="sr-only" required
                               {{ old('payment_method', 'cash') === 'cash' ? 'checked' : '' }}>
                        <div class="text-center">
                            <div class="text-3xl mb-2">💵</div>
                            <p class="font-bold text-gray-900">Tunai</p>
                            <p class="text-xs text-gray-500 mt-0.5" id="cash-desc">Bayar ke kurir</p>
                        </div>
                    </label>
                    <label for="pay-qris"
                           class="border-2 border-gray-200 rounded-xl p-4 cursor-pointer
                                  hover:border-red-400 transition
                                  has-[:checked]:border-red-600 has-[:checked]:bg-red-50">
                        <input type="radio" id="pay-qris" name="payment_method"
                               value="qris" class="sr-only"
                               {{ old('payment_method') === 'qris' ? 'checked' : '' }}>
                        <div class="text-center">
                            <div class="text-3xl mb-2">📱</div>
                            <p class="font-bold text-gray-900">QRIS</p>
                            <p class="text-xs text-gray-500 mt-0.5">Scan & bayar</p>
                        </div>
                    </label>
                </div>
            </div>

            {{-- ── TOMBOL SUBMIT ── --}}
            <button type="submit" id="submit-btn"
                    class="mt-8 w-full bg-red-600 hover:bg-red-700 active:scale-95
                           text-white font-black py-4 rounded-xl text-lg transition
                           shadow-lg shadow-red-200">
                🛵 Pesan & Antar Sekarang
            </button>

        </form>
    </div>

    @endif
</div>
@endsection

@push('scripts')
<script>
    // ── Konstanta ─────────────────────────────────────────────────
    const MAX_QTY  = 20;
    const MIN_QTY  = 1;
    const SUBTOTAL = {{ $total ?? 0 }};
    const ONGKIR   = 10000;

    // ── Switch tipe order: delivery / takeaway ────────────────────
    function switchOrderType(type) {
        const formDelivery      = document.getElementById('form-delivery');
        const formTakeaway      = document.getElementById('form-takeaway');
        const ongkirAmount      = document.getElementById('ongkir-amount');
        const grandTotal        = document.getElementById('grand-total-display');
        const submitBtn         = document.getElementById('submit-btn');
        const cashDesc          = document.getElementById('cash-desc');
        const sidebarOngkir     = document.getElementById('sidebar-ongkir-amount');
        const sidebarTotalEl    = document.getElementById('total-display');

        if (type === 'delivery') {

            formDelivery.classList.remove('hidden');
            formTakeaway.classList.add('hidden');

            ongkirAmount.textContent = 'Rp10.000';

            if (sidebarOngkir) {
                sidebarOngkir.textContent = 'Rp10.000';
            }

            const total = SUBTOTAL + ONGKIR;

            grandTotal.textContent =
                'Rp' + total.toLocaleString('id-ID');

            if (sidebarTotalEl) {
                sidebarTotalEl.textContent =
                    'Rp' + total.toLocaleString('id-ID');
            }

            submitBtn.innerHTML =
                '🛵 Pesan & Antar Sekarang';

            cashDesc.textContent =
                'Bayar ke kurir';

        } else {

            formDelivery.classList.add('hidden');
            formTakeaway.classList.remove('hidden');

            ongkirAmount.innerHTML =
                '<span class="line-through text-gray-300">Rp10.000</span> <span class="text-green-600 font-bold ml-1">GRATIS</span>';

            if (sidebarOngkir) {
                sidebarOngkir.innerHTML =
                    '<span class="text-green-600 font-bold">GRATIS</span>';
            }

            grandTotal.textContent =
                'Rp' + SUBTOTAL.toLocaleString('id-ID');

            if (sidebarTotalEl) {
                sidebarTotalEl.textContent =
                    'Rp' + SUBTOTAL.toLocaleString('id-ID');
            }

            submitBtn.innerHTML =
                '🥤 Pesan Take Away Sekarang';

            cashDesc.textContent =
                'Bayar di kasir';
        }
    }

    // ── Checkbox pilih semua ──────────────────────────────────────
    function toggleCheckAll(masterCheckbox) {

        const itemCheckboxes =
            document.querySelectorAll('.item-checkbox');

        itemCheckboxes.forEach(cb => {

            cb.checked = masterCheckbox.checked;

            highlightRow(cb.value, masterCheckbox.checked);
        });

        updateDeleteButton();
    }

    // ── Checkbox satu item ────────────────────────────────────────
    function onCheckboxChange() {

        const itemCheckboxes =
            document.querySelectorAll('.item-checkbox');

        const masterCheckbox =
            document.getElementById('check-all');

        const checkedBoxes =
            document.querySelectorAll('.item-checkbox:checked');

        if (checkedBoxes.length === 0) {

            masterCheckbox.checked = false;
            masterCheckbox.indeterminate = false;

        } else if (checkedBoxes.length === itemCheckboxes.length) {

            masterCheckbox.checked = true;
            masterCheckbox.indeterminate = false;

        } else {

            masterCheckbox.checked = false;
            masterCheckbox.indeterminate = true;
        }

        itemCheckboxes.forEach(cb => {
            highlightRow(cb.value, cb.checked);
        });

        updateDeleteButton();
    }

    // ── Highlight row ─────────────────────────────────────────────
    function highlightRow(menuId, isChecked) {

        const row =
            document.getElementById('cart-item-' + menuId);

        if (!row) return;

        if (isChecked) {

            row.classList.add('border-red-300', 'bg-red-50');
            row.classList.remove('border-gray-100');

        } else {

            row.classList.remove('border-red-300', 'bg-red-50');
            row.classList.add('border-gray-100');
        }
    }

    // ── Update tombol delete ──────────────────────────────────────
    function updateDeleteButton() {

        const checkedBoxes =
            document.querySelectorAll('.item-checkbox:checked');

        const btnDelete =
            document.getElementById('btn-delete-selected');

        const countEl =
            document.getElementById('selected-count');

        const infoEl =
            document.getElementById('check-info');

        const itemCheckboxes =
            document.querySelectorAll('.item-checkbox');

        const selectedCount = checkedBoxes.length;
        const totalCount    = itemCheckboxes.length;

        if (selectedCount > 0) {

            btnDelete.classList.remove('hidden');
            btnDelete.classList.add('flex');

        } else {

            btnDelete.classList.add('hidden');
            btnDelete.classList.remove('flex');
        }

        if (countEl) {
            countEl.textContent = selectedCount;
        }

        if (infoEl) {
            infoEl.textContent =
                `${selectedCount} dari ${totalCount} item dipilih`;
        }
    }

    // ── DELETE SELECTED FIX ───────────────────────────────────────
    async function deleteSelected() {

        const checkedBoxes =
            document.querySelectorAll('.item-checkbox:checked');

        if (checkedBoxes.length === 0) return;

        const names   = [];
        const menuIds = [];

        checkedBoxes.forEach(cb => {

            menuIds.push(cb.value);

            const nameEl =
                document.querySelector(`#cart-item-${cb.value} h4`);

            if (nameEl) {
                names.push(nameEl.textContent.trim());
            }
        });

        const confirmMsg = checkedBoxes.length === 1
            ? `Hapus "${names[0]}" dari keranjang?`
            : `Hapus ${checkedBoxes.length} item dari keranjang?\n\n${names.join('\n')}`;

        if (!confirm(confirmMsg)) return;

        const btnDelete =
            document.getElementById('btn-delete-selected');

        btnDelete.disabled = true;
        btnDelete.innerHTML = 'Menghapus...';

        try {

            // HAPUS SATU PERSATU
            for (const menuId of menuIds) {

                const res = await fetch('{{ route("cart.remove") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        menu_id: menuId
                    }),
                });

                const data = await res.json();

                if (data.success) {

                    const el =
                        document.getElementById('cart-item-' + menuId);

                    if (el) {

                        el.style.opacity = '0';
                        el.style.transform = 'translateX(30px)';
                        el.style.transition = 'all 0.3s ease';

                        setTimeout(() => {
                            el.remove();
                        }, 300);
                    }

                    updateCartBadge(data.cart_count);
                }
            }

            setTimeout(() => {
                location.reload();
            }, 500);

            showToast(
                `${menuIds.length} item berhasil dihapus`,
                'success'
            );

        } catch (err) {

            console.error(err);

            showToast(
                'Gagal menghapus item',
                'error'
            );

            btnDelete.disabled = false;

            btnDelete.innerHTML =
                `🗑️ Hapus Terpilih (${menuIds.length})`;
        }
    }

    // ── Tambah qty ────────────────────────────────────────────────
    function increaseQty(menuId) {

        const qtyEl =
            document.getElementById('qty-' + menuId);

        const currentQty =
            parseInt(qtyEl.textContent);

        if (currentQty >= MAX_QTY) return;

        updateCart(menuId, currentQty + 1);
    }

    // ── Kurang qty ────────────────────────────────────────────────
    function decreaseQty(menuId) {

        const qtyEl =
            document.getElementById('qty-' + menuId);

        const currentQty =
            parseInt(qtyEl.textContent);

        if (currentQty <= MIN_QTY) return;

        updateCart(menuId, currentQty - 1);
    }

    // ── Update cart ───────────────────────────────────────────────
    async function updateCart(menuId, newQty) {

        if (newQty < MIN_QTY || newQty > MAX_QTY) return;

        try {

            const res = await fetch('{{ route("cart.update") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    menu_id: menuId,
                    qty: newQty
                }),
            });

            const data = await res.json();

            if (data.success) {

                const qtyEl =
                    document.getElementById('qty-' + menuId);

                if (qtyEl) {
                    qtyEl.textContent = newQty;
                }

                const subEl =
                    document.getElementById('sub-' + menuId);

                if (subEl) {
                    subEl.textContent = data.item_subtotal_fmt;
                }

                updateButtonStates(menuId, newQty);

                const subtotalEl =
                    document.getElementById('subtotal-display');

                if (subtotalEl) {
                    subtotalEl.textContent = data.total_fmt;
                }

                const selectedType =
                    document.querySelector('input[name="order_type"]:checked')?.value || 'delivery';

                const sidebarTotal =
                    document.getElementById('total-display');

                const grandTotalEl =
                    document.getElementById('grand-total-display');

                if (selectedType === 'delivery') {

                    if (sidebarTotal) {
                        sidebarTotal.textContent = data.grand_fmt;
                    }

                    if (grandTotalEl) {
                        grandTotalEl.textContent = data.grand_fmt;
                    }

                } else {

                    if (sidebarTotal) {
                        sidebarTotal.textContent = data.total_fmt;
                    }

                    if (grandTotalEl) {
                        grandTotalEl.textContent = data.total_fmt;
                    }
                }

                updateCartBadge(data.cart_count);

            } else {

                showToast(
                    data.message || 'Gagal mengupdate',
                    'error'
                );
            }

        } catch (e) {

            console.error(e);

            showToast(
                'Terjadi kesalahan, coba lagi.',
                'error'
            );
        }
    }

    // ── State tombol qty ──────────────────────────────────────────
    function updateButtonStates(menuId, qty) {

        const btnMinus =
            document.getElementById('btn-minus-' + menuId);

        const btnPlus =
            document.getElementById('btn-plus-' + menuId);

        if (btnMinus) {

            if (qty <= MIN_QTY) {

                btnMinus.disabled = true;

                btnMinus.className =
                    'w-8 h-8 rounded-full font-bold transition flex items-center justify-center text-lg leading-none bg-gray-100 text-gray-300 cursor-not-allowed';

            } else {

                btnMinus.disabled = false;

                btnMinus.className =
                    'w-8 h-8 rounded-full font-bold transition flex items-center justify-center text-lg leading-none bg-red-100 text-red-600 hover:bg-red-600 hover:text-white';
            }
        }

        if (btnPlus) {

            if (qty >= MAX_QTY) {

                btnPlus.disabled = true;

                btnPlus.className =
                    'w-8 h-8 rounded-full font-bold transition flex items-center justify-center text-lg leading-none bg-gray-100 text-gray-300 cursor-not-allowed';

            } else {

                btnPlus.disabled = false;

                btnPlus.className =
                    'w-8 h-8 rounded-full font-bold transition flex items-center justify-center text-lg leading-none bg-red-600 text-white hover:bg-red-700';
            }
        }
    }

    // ── Hapus satu item ───────────────────────────────────────────
    async function removeFromCart(menuId) {

        if (!confirm('Hapus item ini dari keranjang?')) return;

        try {

            const res = await fetch('{{ route("cart.remove") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    menu_id: menuId
                }),
            });

            const data = await res.json();

            if (data.success) {

                const el =
                    document.getElementById('cart-item-' + menuId);

                if (el) {

                    el.style.opacity = '0';
                    el.style.transform = 'translateX(20px)';
                    el.style.transition = 'all 0.3s ease';

                    setTimeout(() => {

                        el.remove();

                        updateCartBadge(data.cart_count);

                        if (data.cart_count === 0) {
                            location.reload();
                        }

                    }, 300);
                }
            }

        } catch (e) {

            showToast(
                'Gagal menghapus item',
                'error'
            );
        }
    }

    // ── Init ──────────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', function () {

        const checkedType =
            document.querySelector('input[name="order_type"]:checked');

        if (checkedType) {
            switchOrderType(checkedType.value);
        }
    });
</script>
@endpush