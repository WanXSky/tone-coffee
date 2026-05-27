{{-- ============================================================ --}}
{{-- FILE: resources/views/layouts/app.blade.php               --}}
{{-- ============================================================ --}}
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TWENTY ONE Coffee - @yield('title', 'Minuman Segar Palopo')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .cart-badge { animation: pulse 1.5s infinite; }
        @keyframes pulse { 0%,100%{transform:scale(1)} 50%{transform:scale(1.15)} }
        .btn-add { transition: all .2s; }
        .btn-add:active { transform: scale(.95); }
        .toast-container { position:fixed; bottom:24px; right:24px; z-index:9999; }
        .toast { animation: slideUp .3s ease; }
        @keyframes slideUp { from{transform:translateY(30px);opacity:0} to{transform:translateY(0);opacity:1} }
    </style>
    <style>
/* SWEETALERT BUTTON */
.swal2-confirm {
    background-color: #dc2626 !important;
    color: white !important;
    transition: all 0.2s ease !important;
}

.swal2-confirm:hover {
    background-color: #b91c1c !important;
    transform: translateY(-1px);
}

.swal2-cancel {
    background-color: #6b7280 !important;
    color: white !important;
    transition: all 0.2s ease !important;
}

.swal2-cancel:hover {
    background-color: #4b5563 !important;
    transform: translateY(-1px);
}

.swal2-actions button {
    padding: 10px 18px !important;
    border-radius: 10px !important;
    font-weight: 600 !important;
    box-shadow: 0 2px 6px rgba(0,0,0,0.12);
}

.swal2-container {
    z-index: 99999 !important;
}
</style>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900">
    {{-- Loading Screen --}}
    @include('components.loading-screen')

    {{-- Sembunyikan scroll saat loading --}}
    <style>
        body { overflow: hidden; }
    </style>
 
    {{-- NAVBAR --}}
    <nav class="bg-red-600 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    
                    <img src="{{ asset('storage/logo.png') }}" 
                        class="h-11 w-auto object-contain">

                    <span class="text-lg font-extrabold tracking-wide">
                        <span class="text-white">Twenty</span>
                        <span class="text-yellow-300">One</span>
                        <span class="text-red-200 text-sm font-medium ml-1">Coffee</span>
                    </span>

                </a>
 
                {{-- Menu nav --}}
 
                {{-- Right side --}}
                <div class="flex items-center gap-3">
                    {{-- Cart --}}
                    @auth
                    <a href="{{ route('cart') }}" class="relative p-2 rounded-full hover:bg-red-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span id="cart-count" class="absolute -top-1 -right-1 bg-yellow-400 text-gray-900 text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center cart-badge">
                            {{ collect(session('cart', []))->sum('qty') }}
                        </span>
                    </a>
 
                    {{-- User dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 hover:bg-red-700 rounded-full px-3 py-1.5 transition">
                            <div class="w-7 h-7 rounded-full bg-red-800 flex items-center justify-center text-sm font-bold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="hidden sm:block text-sm">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" @click.away="open=false"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50"
                             x-transition>
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600">
                                🎛️ Admin Panel
                            </a>
                            <hr class="my-1">
                            @endif
                            <a href="{{ route('orders') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600">
                                📦 Pesanan Saya
                            </a>
                            <hr class="my-1">
                            <form id="logoutForm" method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button type="button"
                                    onclick="confirmLogout()"
                                    class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-gray-700 hover:text-red-600 hover:bg-red-50 transition rounded-lg">
                                    🚪 Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="text-red-100 hover:text-white font-medium text-sm transition">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-white text-red-600 hover:bg-red-50 font-semibold text-sm px-4 py-2 rounded-full transition">Daftar</a>
                    @endauth
 
                    {{-- Mobile menu button --}}
                </div>
            </div>
        </div>
 
        {{-- Mobile menu --}}
    </nav>
 
    {{-- FLASH MESSAGE --}}
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 max-w-7xl mx-auto mt-4 rounded-lg animate__animated animate__fadeInDown">
        <p class="text-green-700 font-medium">✅ {{ session('success') }}</p>
    </div>
    @endif
    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-4 max-w-7xl mx-auto mt-4 rounded-lg animate__animated animate__fadeInDown">
        <p class="text-red-700 font-medium">❌ {{ session('error') }}</p>
    </div>
    @endif
 
    {{-- MAIN CONTENT --}}
    <main class="min-h-screen">
        @yield('content')
    </main>
 
    {{-- FOOTER --}}
    <footer class="bg-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        
                        {{-- Logo --}}
                        <img src="{{ asset('storage/logo.png') }}" 
                            alt="Logo" 
                            class="h-12 w-auto object-contain">

                        {{-- Text --}}
                        <div class="leading-tight">
                            <h1 class="text-sm font-bold text-white">Twenty One</h1>
                            <p class="text-xs text-gray-400">Coffee</p>
                        </div>

                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">Nikmati minuman segar berkualitas dengan harga terjangkau. Pesan sekarang, dikirim ke pintu rumahmu!</p>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4">Menu Unggulan</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li>☕ Coffee Series</li>
                        <li>🧋 Non Coffee</li>
                        <li>🟤 Boba Gacor</li>
                        <li>🍵 Matcha Series</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li>📍 Palopo, Sulawesi Selatan</li>
                        <li>📱 WhatsApp: 08XXXXXXXXXX</li>
                        <li>🕐 Buka: 09.00 - 00.00 WITA</li>
                    </ul>
                </div>
            </div>
            <hr class="border-gray-800 my-8">
            <p class="text-center text-gray-500 text-sm">&copy; {{ date('Y') }} TWENTY ONE Coffee. All rights reserved.</p>
        </div>
    </footer>
 
    {{-- TOAST CONTAINER --}}
    <div class="toast-container" id="toast-container"></div>
 
    {{-- ALPINE JS untuk dropdown --}}
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 
    {{-- GLOBAL JS --}}
    <script>
        // Toast notification
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const colors = {
                success: 'bg-green-600',
                error:   'bg-red-600',
                info:    'bg-blue-600',
            };
            const toast = document.createElement('div');
            toast.className = `toast ${colors[type] || colors.success} text-white px-5 py-3 rounded-xl shadow-lg mb-3 text-sm font-medium max-w-xs`;
            toast.textContent = message;
            container.appendChild(toast);
            setTimeout(() => { toast.style.opacity = '0'; toast.style.transition = 'opacity .3s'; setTimeout(() => toast.remove(), 300); }, 3000);
        }
 
        // Update cart count badge
        function updateCartBadge(count) {
            const badge = document.getElementById('cart-count');
            if (badge) { badge.textContent = count; }
        }
 
        // Add to cart
        async function addToCart(menuId, menuName, qty = 1, notes = '') {
            try {
                const res = await fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ menu_id: menuId, qty, notes }),
                });
                const data = await res.json();
                if (data.success) {
                    showToast(data.message, 'success');
                    updateCartBadge(data.cart_count);
                } else {
                    showToast(data.message, 'error');
                }
            } catch (e) {
                showToast('Gagal menambahkan ke keranjang', 'error');
            }
        }

        function confirmLogout() {
            Swal.fire({
                title: "Yakin ingin keluar?",
                text: "Kamu akan logout dari akun",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Logout",
                cancelButtonText: "Batal",
                confirmButtonColor: "#dc2626",
                cancelButtonColor: "#6b7280",
                backdrop: true,
                allowOutsideClick: false,
                heightAuto: false
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        }
    </script>
    @stack('scripts')
</body>
</html>