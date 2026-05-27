{{-- ============================================================ --}}
{{-- FILE: resources/views/layouts/admin.blade.php                --}}
{{-- ============================================================ --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - Twenty One Coffee | @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
body {
    font-family: 'Poppins', sans-serif;
}

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

/* supaya tidak ketutup sidebar */
.swal2-container {
    z-index: 99999 !important;
}
</style>
</head>
<body x-data="{ open: false }" class="bg-gray-100 text-gray-900">
    {{-- Loading Screen --}}
    @include('components.loading-screen')

    <style>
        body { overflow: hidden; }
    </style>
    <div class="flex h-screen overflow-hidden relative">
    <div x-show="open" 
     @click="open = false"
     class="fixed inset-0 bg-black/50 z-30 lg:hidden"></div>
        {{-- SIDEBAR --}}
        <aside 
        :class="open ? 'translate-x-0' : '-translate-x-full'"
        class="fixed z-40 inset-y-0 left-0 w-64 bg-gray-900 text-white flex flex-col
            transform transition-transform duration-300
            lg:translate-x-0 lg:static lg:inset-0">

            {{-- Logo --}}
            <div class="p-5 border-b border-gray-800">
                <div class="flex items-center gap-3">

                    {{-- Logo --}}
                    <img src="{{ asset('storage/logo.png') }}"
                        alt="Logo"
                        class="h-9 w-auto object-contain">

                    {{-- Text --}}
                    <div class="leading-tight">
                        <p class="font-extrabold text-white text-base">T.O Coffee</p>
                        <p class="text-gray-400 text-xs">Admin Panel</p>
                    </div>

                </div>
            </div>
 
            {{-- Navigation --}}
            <nav class="flex-1 p-4 space-y-1">
                @php
                    $navItems = [
                        ['route' => 'admin.dashboard',      'icon' => '🎛️',  'label' => 'Dashboard'],
                        ['route' => 'admin.orders.index',   'icon' => '📦',  'label' => 'Pesanan'],
                        ['route' => 'admin.menus.index',    'icon' => '☕',  'label' => 'Menu'],
                        ['route' => 'admin.couriers.index', 'icon' => '🚴',  'label' => 'Kurir'],
                        ['route' => 'admin.payments.index', 'icon' => '💳',  'label' => 'Pembayaran'],
                    ];
                @endphp
                @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-medium text-sm transition
                          {{ request()->routeIs($item['route']) ? 'bg-red-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <span>{{ $item['icon'] }}</span>
                    {{ $item['label'] }}
                </a>
                @endforeach
            </nav>
 
            {{-- Footer sidebar --}}
            <div class="p-4 border-t border-gray-800">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-8 h-8 rounded-full bg-red-600 flex items-center justify-center font-bold text-sm">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400">Administrator</p>
                    </div>
                </div>
                <form id="logoutForm" method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="button"
                        onclick="confirmLogout()"
                        class="w-full text-left text-gray-400 hover:text-red-400 text-sm flex items-center gap-2 transition">
                        🚪 Keluar
                    </button>
                </form>
            </div>
        </aside>
 
        {{-- MAIN AREA --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Top bar --}}
            <header class="bg-white shadow-sm px-4 py-4 flex items-center justify-between">

                {{-- LEFT --}}
                <div class="flex items-center gap-3">
                    {{-- Hamburger --}}
                    <button @click="open = true" class="lg:hidden text-2xl">
                        ☰
                    </button>

                    <h1 class="text-lg font-black text-gray-900">
                        @yield('title', 'Dashboard')
                    </h1>
                </div>

                {{-- RIGHT --}}
                <div class="hidden sm:flex items-center gap-3 text-sm text-gray-500">
                    <span>{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
                    <a href="{{ route('home') }}" target="_blank" class="text-red-600 hover:underline">
                        Lihat Website →
                    </a>
                </div>

            </header>
 
            {{-- Flash messages --}}
            @if(session('success'))
            <div class="mx-6 mt-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <p class="text-green-700 font-medium text-sm">✅ {{ session('success') }}</p>
            </div>
            @endif
            @if(session('error'))
            <div class="mx-6 mt-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                <p class="text-red-700 font-medium text-sm">❌ {{ session('error') }}</p>
            </div>
            @endif
 
            {{-- Page content --}}
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function confirmLogout() {
        Swal.fire({
            title: "Yakin ingin keluar?",
            text: "Kamu akan logout dari sistem admin",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ef4444",
            cancelButtonColor: "#6b7280",
            confirmButtonText: "Ya, Logout",
            cancelButtonText: "Batal"
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