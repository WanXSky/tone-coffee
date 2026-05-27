<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — T.ONE Coffee</title>
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

        .circle-deco {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }

        /* Password strength bar */
        .strength-bar {
            height: 3px;
            border-radius: 2px;
            transition: all 0.3s;
        }
    </style>
</head>
<body class="h-screen overflow-hidden flex">

    {{-- ── KIRI: Branding panel ── --}}
    <div class="hidden lg:flex lg:w-1/2 bg-pattern relative overflow-hidden
                flex-col items-center justify-center text-white p-12">

        {{-- Dekorasi --}}
        <div class="circle-deco w-80 h-80 -top-20 -left-20"></div>
        <div class="circle-deco w-56 h-56 bottom-10 -right-14"></div>
        <div class="circle-deco w-28 h-28 top-1/2 right-12"></div>

        {{-- Logo --}}
        <div class="floating relative z-10 text-center mb-6 mt-6">
            <img src="{{ asset('storage/logo.png') }}"
                alt="T.ONE Coffee Logo"
                class="max-h-40 w-auto object-contain mx-auto drop-shadow-2xl">
        </div>

        {{-- Tagline --}}
        <div class="relative z-10 text-center max-w-sm">
            <h2 class="text-3xl font-black leading-tight mb-4">
                Bergabung dan<br>
                <span class="text-red-200">Nikmati Promo! 🎉</span>
            </h2>
            <p class="text-red-100 text-sm leading-relaxed">
                Daftar sekarang dan dapatkan kemudahan memesan minuman favoritmu
                langsung dari genggamanmu.
            </p>
        </div>

        {{-- Keuntungan daftar --}}
        <div class="relative z-10 mt-10 space-y-3 w-full max-w-sm">
            @foreach([
                ['📦', 'Pantau pesanan', 'Tracking real-time'],
                ['🏷️', 'Riwayat lengkap', 'Semua pesananmu tercatat'],
            ] as $benefit)
            <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm
                        rounded-xl px-4 py-3 border border-white/20">
                <span class="text-2xl">{{ $benefit[0] }}</span>
                <div>
                    <p class="font-bold text-sm text-white">{{ $benefit[1] }}</p>
                    <p class="text-xs text-red-200">{{ $benefit[2] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="absolute bottom-6 left-6 text-white/20 text-6xl font-black select-none">✦</div>
        <div class="absolute top-10 right-8 text-white/10 text-4xl font-black select-none">✦</div>
    </div>

    {{-- ── KANAN: Form register ── --}}
    <div class="w-full lg:w-1/2 flex items-start justify-center
                bg-gray-50 px-6 pt-10 pb-12 relative
                h-screen overflow-y-auto scroll-smooth">

        {{-- Background subtle --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-10 -right-10 w-64 h-64 bg-red-50 rounded-full opacity-60"></div>
            <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-red-50 rounded-full opacity-40"></div>
        </div>

        <div class="w-full max-w-md relative animate__animated animate__fadeInUp py-4">

            {{-- Logo mobile --}}
            <div class="lg:hidden text-center mb-6">
                <img src="{{ asset('storage/logo.png') }}"
                    alt="T.ONE Coffee Logo"
                    class="w-28 mx-auto">
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
                <div class="mb-6">
                    <h1 class="text-2xl font-black text-gray-900">Buat Akun Baru</h1>
                    <p class="text-gray-500 text-sm mt-1">
                        Sudah punya akun?
                        <a href="{{ route('login') }}"
                           class="text-red-600 font-semibold hover:underline">
                            Masuk di sini
                        </a>
                    </p>
                </div>

                {{-- Error messages --}}
                @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 mb-5
                            animate__animated animate__shakeX">
                    <p class="text-red-600 text-xs font-semibold mb-1">⚠ Mohon perbaiki:</p>
                    @foreach ($errors->all() as $error)
                    <p class="text-red-500 text-xs">• {{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Nama --}}
                    <div class="mb-4">
                        <label for="name"
                               class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nama Lengkap
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                                👤
                            </span>
                            <input type="text" id="name" name="name"
                                   value="{{ old('name') }}"
                                   required autofocus autocomplete="name"
                                   placeholder="Nama lengkap kamu"
                                   class="input-field w-full border border-gray-200 rounded-xl
                                          pl-11 pr-4 py-3 text-sm
                                          focus:outline-none focus:border-red-500 transition
                                          placeholder-gray-400
                                          @error('name') border-red-400 bg-red-50 @enderror">
                        </div>
                        @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label for="email"
                               class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                                ✉️
                            </span>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email') }}"
                                   required autocomplete="username"
                                   placeholder="nama@email.com"
                                   class="input-field w-full border border-gray-200 rounded-xl
                                          pl-11 pr-4 py-3 text-sm
                                          focus:outline-none focus:border-red-500 transition
                                          placeholder-gray-400
                                          @error('email') border-red-400 bg-red-50 @enderror">
                        </div>
                        @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- No HP --}}
                    <div class="mb-4">
                        <label for="phone"
                               class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nomor HP
                            <span class="text-gray-400 font-normal">(Opsional)</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                                📱
                            </span>
                            <input type="tel" id="phone" name="phone"
                                   value="{{ old('phone') }}"
                                   placeholder="08xxxxxxxxxx"
                                   class="input-field w-full border border-gray-200 rounded-xl
                                          pl-11 pr-4 py-3 text-sm
                                          focus:outline-none focus:border-red-500 transition
                                          placeholder-gray-400">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="mb-4">
                        <label for="password"
                               class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Password
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                                🔒
                            </span>
                            <input type="password"
                                id="password-input"
                                name="password"
                                required
                                autocomplete="new-password"
                                placeholder="Minimal 8 karakter"
                                oninput="checkPasswordStrength(this.value)"
                                class="input-field w-full border border-gray-200 rounded-xl
                                        pl-11 pr-12 py-3 text-sm
                                        focus:outline-none focus:border-red-500 transition
                                        placeholder-gray-400
                                        @error('password') border-red-400 bg-red-50 @enderror">
                            <button type="button"
                                    onclick="togglePassword('password-input', 'pw-eye')"
                                    class="absolute right-4 top-1/2 -translate-y-1/2
                                           text-gray-400 hover:text-gray-600 transition"
                                    id="pw-eye">
                                👁️
                            </button>
                        </div>

                        {{-- Password strength indicator --}}
                        <div class="flex gap-1 mt-2" id="strength-bars">
                            <div class="strength-bar flex-1 bg-gray-200" id="bar-1"></div>
                            <div class="strength-bar flex-1 bg-gray-200" id="bar-2"></div>
                            <div class="strength-bar flex-1 bg-gray-200" id="bar-3"></div>
                            <div class="strength-bar flex-1 bg-gray-200" id="bar-4"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1" id="strength-text">
                            Masukkan password untuk cek kekuatannya
                        </p>

                        @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="mb-6">
                        <label for="password_confirmation"
                               class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Konfirmasi Password
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                                🔐
                            </span>
                            <input type="password"
                                id="password-confirm-input"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="Ulangi password"
                                oninput="checkPasswordMatch()"
                                class="input-field w-full border border-gray-200 rounded-xl
                                        pl-11 pr-12 py-3 text-sm
                                        focus:outline-none focus:border-red-500 transition
                                        placeholder-gray-400">
                            <button type="button"
                                    onclick="togglePassword('password-confirm-input', 'confirm-eye')"
                                    class="absolute right-4 top-1/2 -translate-y-1/2
                                           text-gray-400 hover:text-gray-600 transition"
                                    id="confirm-eye">
                                👁️
                            </button>
                        </div>
                        <p class="text-xs mt-1 hidden" id="match-text"></p>
                    </div>

                    {{-- Tombol daftar --}}
                    <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 active:scale-95
                                   text-white font-black py-3.5 rounded-xl text-base
                                   transition shadow-lg shadow-red-200
                                   flex items-center justify-center gap-2">
                        <span>🎉</span>
                        <span>Buat Akun Sekarang</span>
                    </button>

                    {{-- Syarat --}}
                    <p class="text-xs text-gray-400 text-center mt-4">
                        Dengan mendaftar, kamu menyetujui
                        <span class="text-red-500 font-medium">Syarat & Ketentuan</span>
                        T.ONE Coffee
                    </p>

                </form>

                {{-- Divider --}}
                <div class="flex items-center gap-3 my-5">
                    <hr class="flex-1 border-gray-200">
                    <span class="text-xs text-gray-400 font-medium">sudah punya akun?</span>
                    <hr class="flex-1 border-gray-200">
                </div>

                {{-- Link login --}}
                <a href="{{ route('login') }}"
                   class="w-full border-2 border-red-600 text-red-600 hover:bg-red-600
                          hover:text-white font-bold py-3 rounded-xl transition
                          flex items-center justify-center gap-2 text-sm">
                    <span>→</span>
                    <span>Masuk ke Akun</span>
                </a>

            </div>

            {{-- Footer --}}
            <p class="text-center text-xs text-gray-400 mt-5">
                © {{ date('Y') }} T.ONE Coffee · Batam, Kepulauan Riau
            </p>

        </div>
    </div>

</body>

<script>
    // ── Toggle show/hide password ──────────────────────────────
    function togglePassword(inputId, btnId) {
        const input = document.getElementById(inputId);
        const btn   = document.getElementById(btnId);
        if (input.type === 'password') {
            input.type      = 'text';
            btn.textContent = '🙈';
        } else {
            input.type      = 'password';
            btn.textContent = '👁️';
        }
    }

    // ── Cek kekuatan password ──────────────────────────────────
    function checkPasswordStrength(password) {
        const bars      = [
            document.getElementById('bar-1'),
            document.getElementById('bar-2'),
            document.getElementById('bar-3'),
            document.getElementById('bar-4'),
        ];
        const strengthText = document.getElementById('strength-text');

        // Reset
        bars.forEach(b => b.style.background = '#e5e7eb');

        if (!password) {
            strengthText.textContent = 'Masukkan password untuk cek kekuatannya';
            strengthText.className   = 'text-xs text-gray-400 mt-1';
            return;
        }

        let score = 0;
        if (password.length >= 8)                        score++;
        if (/[A-Z]/.test(password))                      score++;
        if (/[0-9]/.test(password))                      score++;
        if (/[^A-Za-z0-9]/.test(password))              score++;

        const levels = [
            { color: '#ef4444', text: '😟 Terlalu lemah',   cls: 'text-xs text-red-500 mt-1' },
            { color: '#f97316', text: '😐 Cukup',           cls: 'text-xs text-orange-500 mt-1' },
            { color: '#eab308', text: '🙂 Lumayan kuat',    cls: 'text-xs text-yellow-600 mt-1' },
            { color: '#22c55e', text: '💪 Sangat kuat!',    cls: 'text-xs text-green-600 mt-1' },
        ];

        const level = levels[score - 1] || levels[0];

        for (let i = 0; i < score; i++) {
            bars[i].style.background = level.color;
        }

        strengthText.textContent = level.text;
        strengthText.className   = level.cls;
    }

    // ── Cek kecocokan password ─────────────────────────────────
    function checkPasswordMatch() {
        const pw      = document.getElementById('password-input').value;
        const confirm = document.getElementById('password-confirm-input').value;
        const matchEl = document.getElementById('match-text');
        const input   = document.getElementById('password-confirm-input');

        if (!confirm) {
            matchEl.classList.add('hidden');
            return;
        }

        matchEl.classList.remove('hidden');

        if (pw === confirm) {
            matchEl.textContent = '✓ Password cocok';
            matchEl.className   = 'text-xs mt-1 text-green-600';
            input.style.borderColor = '#22c55e';
        } else {
            matchEl.textContent = '✗ Password tidak cocok';
            matchEl.className   = 'text-xs mt-1 text-red-500';
            input.style.borderColor = '#ef4444';
        }
    }
</script>
</html>