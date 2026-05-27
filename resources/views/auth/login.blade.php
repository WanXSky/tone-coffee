<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — T.ONE Coffee</title>
    @vite(['resources/css/app.css'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        body { font-family: 'Poppins', sans-serif; }

        .bg-pattern {
            background-color: #dc2626;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(255,255,255,0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255,255,255,0.08) 0%, transparent 40%),
                radial-gradient(circle at 60% 80%, rgba(0,0,0,0.1) 0%, transparent 40%);
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-10px); }
        }

        .input-field:focus {
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15);
        }

        /* Dekorasi lingkaran */
        .circle-deco {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }
    </style>
</head>
<body class="h-screen overflow-hidden flex">

    {{-- ── KIRI: Branding panel ── --}}
    <div class="hidden lg:flex lg:w-1/2 bg-pattern relative overflow-hidden
                flex-col items-center justify-center text-white p-12">

        {{-- Dekorasi lingkaran --}}
        <div class="circle-deco w-96 h-96 -top-24 -left-24"></div>
        <div class="circle-deco w-64 h-64 bottom-10 -right-16"></div>
        <div class="circle-deco w-32 h-32 top-1/2 right-10"></div>

        {{-- Logo --}}
        <div class="floating relative z-10 text-center mb-10">
            <img src="{{ asset('storage/logo.png') }}"
                alt="T.ONE Coffee Logo"
                class="w-28 drop-shadow-2xl mx-auto">
        </div>

        {{-- Tagline --}}
        <div class="relative z-10 text-center max-w-sm">
            <h2 class="text-3xl font-black leading-tight mb-4">
                Selamat Datang<br>
                <span class="text-red-200">Kembali! ☕</span>
            </h2>
            <p class="text-red-100 text-sm leading-relaxed">
                Masuk ke akunmu dan nikmati minuman segar T.ONE Coffee.
                Pesan kapan saja, di mana saja!
            </p>
        </div>

        {{-- Menu highlight cards --}}
        <div class="relative z-10 mt-10 grid grid-cols-3 gap-3 w-full max-w-sm">
            @foreach([
                ['☕', 'Kopi Aren', 'Rp15.000'],
                ['🧋', 'Taro Boba', 'Rp13.000'],
                ['🍵', 'Matcha', 'Rp18.000'],
            ] as $item)
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-3 text-center border border-white/20">
                <div class="text-2xl mb-1">{{ $item[0] }}</div>
                <p class="text-xs font-semibold text-white leading-tight">{{ $item[1] }}</p>
                <p class="text-xs text-red-200 mt-0.5">{{ $item[2] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Bintang dekoratif --}}
        <div class="absolute bottom-6 left-6 text-white/20 text-6xl font-black select-none">✦</div>
        <div class="absolute top-10 right-8 text-white/10 text-4xl font-black select-none">✦</div>
    </div>

    {{-- ── KANAN: Form login ── --}}
    <div class="w-full lg:w-1/2 flex items-start justify-center
                bg-gray-50 px-6 py-12 relative
                h-screen overflow-y-auto scroll-smooth">

        {{-- Background subtle --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-10 -right-10 w-64 h-64 bg-red-50 rounded-full opacity-60"></div>
            <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-red-50 rounded-full opacity-40"></div>
        </div>

        <div class="w-full max-w-md relative animate__animated animate__fadeInUp">

            {{-- Logo mobile --}}
            <div class="lg:hidden text-center mb-8">
                <img src="{{ asset('storage/logo.png') }}"
                    alt="T.ONE Coffee Logo"
                    class="w-36 mx-auto">
            </div>

            {{-- Card form --}}
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 relative">

                {{-- Tombol kembali --}}
                <a href="{{ url('/') }}"
                class="inline-flex items-center gap-2 text-gray-500 hover:text-red-600
                        transition mb-5 text-sm font-semibold">
                    <span class="text-lg">←</span>
                    <span>Kembali</span>
                </a>

                {{-- Heading --}}
                <div class="mb-8">
                    <h1 class="text-2xl font-black text-gray-900">Masuk ke Akun</h1>
                    <p class="text-gray-500 text-sm mt-1">
                        Belum punya akun?
                        <a href="{{ route('register') }}"
                           class="text-red-600 font-semibold hover:underline">
                            Daftar sekarang
                        </a>
                    </p>
                </div>

                {{-- Error message --}}
                @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 mb-5
                            flex items-start gap-2 animate__animated animate__shakeX">
                    <span class="text-red-500 mt-0.5 flex-shrink-0">⚠</span>
                    <div>
                        @foreach ($errors->all() as $error)
                        <p class="text-red-600 text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Session status --}}
                @if (session('status'))
                <div class="bg-green-50 border border-green-200 rounded-xl px-4 py-3 mb-5">
                    <p class="text-green-600 text-sm font-medium">✅ {{ session('status') }}</p>
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-5">
                        <label for="email"
                               class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                ✉️
                            </span>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email') }}"
                                   required autofocus autocomplete="username"
                                   placeholder="nama@email.com"
                                   class="input-field w-full border border-gray-200 rounded-xl
                                          pl-11 pr-4 py-3 text-sm text-gray-900
                                          focus:outline-none focus:border-red-500
                                          transition placeholder-gray-400
                                          @error('email') border-red-400 bg-red-50 @enderror">
                        </div>
                    </div>

                {{-- Password --}}
                <div class="mb-5">
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password"
                            class="text-sm font-semibold text-gray-700">
                            Password
                        </label>

                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                        class="text-xs text-red-600 hover:underline font-medium">
                            Lupa password?
                        </a>
                        @endif
                    </div>

                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                            🔒
                        </span>

                        <input type="password"
                            id="password-input"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Masukkan password"
                            class="input-field w-full border border-gray-200 rounded-xl
                                    pl-11 pr-12 py-3 text-sm text-gray-900
                                    focus:outline-none focus:border-red-500
                                    transition placeholder-gray-400
                                    @error('password') border-red-400 bg-red-50 @enderror">

                        {{-- Toggle password --}}
                        <button type="button"
                                onclick="togglePassword()"
                                class="absolute right-4 top-1/2 -translate-y-1/2
                                    text-gray-400 hover:text-gray-600 transition">
                            <span id="toggleIcon">👁️</span>
                        </button>
                    </div>
                </div>

                    {{-- Remember me --}}
                    <div class="flex items-center gap-2 mb-6">
                        <input type="checkbox" id="remember_me" name="remember"
                               class="w-4 h-4 rounded border-gray-300 text-red-600
                                      focus:ring-red-500 cursor-pointer">
                        <label for="remember_me"
                               class="text-sm text-gray-600 cursor-pointer select-none">
                            Ingat saya selama 30 hari
                        </label>
                    </div>

                    {{-- Tombol login --}}
                    <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 active:scale-95
                                   text-white font-black py-3.5 rounded-xl text-base
                                   transition shadow-lg shadow-red-200
                                   flex items-center justify-center gap-2">
                        <span>Masuk Sekarang</span>
                        <span>→</span>
                    </button>

                </form>

                {{-- Divider --}}
                <div class="flex items-center gap-3 my-6">
                    <hr class="flex-1 border-gray-200">
                    <span class="text-xs text-gray-400 font-medium">atau</span>
                    <hr class="flex-1 border-gray-200">
                </div>

                {{-- Link daftar --}}
                <a href="{{ route('register') }}"
                   class="w-full border-2 border-red-600 text-red-600 hover:bg-red-600
                          hover:text-white font-bold py-3 rounded-xl transition
                          flex items-center justify-center gap-2 text-sm">
                    <span>🆕</span>
                    <span>Buat Akun Baru</span>
                </a>

            </div>

            {{-- Footer --}}
            <p class="text-center text-xs text-gray-400 mt-6">
                © {{ date('Y') }} T.ONE Coffee · Batam, Kepulauan Riau
            </p>

        </div>
    </div>

</body>

<script>
function togglePassword() {
    const input = document.getElementById('password-input');
    const icon  = document.getElementById('toggleIcon');

    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = '🙈';
    } else {
        input.type = 'password';
        icon.textContent = '👁️';
    }
}
</script>
</html>