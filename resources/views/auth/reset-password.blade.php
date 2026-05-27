<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — ONE T.O Coffee</title>
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .bg-pattern {
            background-color: #dc2626;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(255,255,255,0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255,255,255,0.08) 0%, transparent 40%);
        }
        .floating { animation: floating 3s ease-in-out infinite; }
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-10px); }
        }
        .circle-deco {
            position: absolute; border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }
        .input-field:focus { box-shadow: 0 0 0 3px rgba(220,38,38,0.15); }
        .strength-bar { height: 3px; border-radius: 2px; transition: all 0.3s; }
    </style>
</head>
<body class="min-h-screen flex">

    {{-- ── KIRI: Branding ── --}}
    <div class="hidden lg:flex lg:w-1/2 bg-pattern relative overflow-hidden
                flex-col items-center justify-center text-white p-12">

        <div class="circle-deco w-96 h-96 -top-24 -left-24"></div>
        <div class="circle-deco w-64 h-64 bottom-10 -right-16"></div>

        <div class="floating relative z-10 text-center mb-10">
            <div class="inline-flex items-center gap-3 mb-6">
                <div class="bg-white rounded-2xl px-4 py-2 shadow-2xl">
                    <span class="font-black text-red-600 text-4xl">ONE</span>
                </div>
                <div>
                    <p class="font-black text-5xl leading-none">T.O</p>
                    <p class="text-red-200 text-sm font-medium tracking-widest uppercase">Coffee</p>
                </div>
            </div>
        </div>

        <div class="relative z-10 text-center max-w-sm">
            <div class="text-8xl mb-6">🔐</div>
            <h2 class="text-3xl font-black leading-tight mb-4">
                Buat Password<br>
                <span class="text-red-200">yang Kuat! 💪</span>
            </h2>
            <p class="text-red-100 text-sm leading-relaxed">
                Buat password baru yang aman untuk melindungi akunmu.
                Gunakan kombinasi huruf, angka, dan simbol.
            </p>
        </div>

        {{-- Tips password --}}
        <div class="relative z-10 mt-10 space-y-3 w-full max-w-sm">
            @foreach([
                ['✅', 'Minimal 8 karakter'],
                ['✅', 'Kombinasi huruf besar & kecil'],
                ['✅', 'Sertakan angka atau simbol'],
                ['❌', 'Jangan gunakan tanggal lahir'],
            ] as $tip)
            <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm
                        rounded-xl px-4 py-2.5 border border-white/20">
                <span class="text-base">{{ $tip[0] }}</span>
                <p class="text-sm text-white">{{ $tip[1] }}</p>
            </div>
            @endforeach
        </div>

        <div class="absolute bottom-6 left-6 text-white/20 text-6xl font-black select-none">✦</div>
        <div class="absolute top-10 right-8 text-white/10 text-4xl font-black select-none">✦</div>
    </div>

    {{-- ── KANAN: Form reset ── --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center
                bg-gray-50 px-6 py-12 relative">

        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-10 -right-10 w-64 h-64 bg-red-50 rounded-full opacity-60"></div>
            <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-red-50 rounded-full opacity-40"></div>
        </div>

        <div class="w-full max-w-md relative animate__animated animate__fadeInUp">

            {{-- Logo mobile --}}
            <div class="lg:hidden text-center mb-8">
                <div class="inline-flex items-center gap-2">
                    <div class="bg-red-600 text-white rounded-xl px-3 py-1.5">
                        <span class="font-black text-xl">ONE</span>
                    </div>
                    <span class="font-black text-xl text-gray-900">T.O Coffee</span>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8">

                {{-- Heading --}}
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-20 h-20
                                rounded-full bg-red-50 border-4 border-red-100
                                text-4xl mb-4 animate__animated animate__bounceIn">
                        🔑
                    </div>
                    <h1 class="text-2xl font-black text-gray-900">Buat Password Baru</h1>
                    <p class="text-gray-500 text-sm mt-2">
                        Masukkan password baru untuk akunmu
                    </p>
                </div>

                {{-- Error --}}
                @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 mb-5
                            animate__animated animate__shakeX">
                    @foreach ($errors->all() as $error)
                    <p class="text-red-600 text-sm flex items-center gap-1">
                        <span>⚠</span> {{ $error }}
                    </p>
                    @endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    {{-- Email (readonly) --}}
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Email
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">✉️</span>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email', $request->email) }}"
                                   required
                                   readonly
                                   class="w-full border border-gray-100 bg-gray-50 rounded-xl
                                          pl-11 pr-4 py-3 text-sm text-gray-500 cursor-not-allowed">
                        </div>
                    </div>

                    {{-- Password baru --}}
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Password Baru <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">🔒</span>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   required
                                   autocomplete="new-password"
                                   placeholder="Minimal 8 karakter"
                                   oninput="checkStrength(this.value)"
                                   class="input-field w-full border border-gray-200 rounded-xl
                                          pl-11 pr-12 py-3 text-sm
                                          focus:outline-none focus:border-red-500 transition
                                          placeholder-gray-400
                                          @error('password') border-red-400 bg-red-50 @enderror">
                            <button type="button"
                                    onclick="togglePw('password', 'eye1')"
                                    id="eye1"
                                    class="absolute right-4 top-1/2 -translate-y-1/2
                                           text-gray-400 hover:text-gray-600 transition">
                                👁️
                            </button>
                        </div>

                        {{-- Strength bars --}}
                        <div class="flex gap-1 mt-2">
                            <div class="strength-bar flex-1 bg-gray-200" id="s1"></div>
                            <div class="strength-bar flex-1 bg-gray-200" id="s2"></div>
                            <div class="strength-bar flex-1 bg-gray-200" id="s3"></div>
                            <div class="strength-bar flex-1 bg-gray-200" id="s4"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1" id="strength-text">
                            Masukkan password baru kamu
                        </p>
                    </div>

                    {{-- Konfirmasi password --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">🔐</span>
                            <input type="password"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   required
                                   autocomplete="new-password"
                                   placeholder="Ulangi password baru"
                                   oninput="checkMatch()"
                                   class="input-field w-full border border-gray-200 rounded-xl
                                          pl-11 pr-12 py-3 text-sm
                                          focus:outline-none focus:border-red-500 transition
                                          placeholder-gray-400">
                            <button type="button"
                                    onclick="togglePw('password_confirmation', 'eye2')"
                                    id="eye2"
                                    class="absolute right-4 top-1/2 -translate-y-1/2
                                           text-gray-400 hover:text-gray-600 transition">
                                👁️
                            </button>
                        </div>
                        <p class="text-xs mt-1 hidden" id="match-msg"></p>
                    </div>

                    {{-- Tombol --}}
                    <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 active:scale-95
                                   text-white font-black py-3.5 rounded-xl text-base
                                   transition shadow-lg shadow-red-200
                                   flex items-center justify-center gap-2">
                        <span>🔑</span>
                        <span>Simpan Password Baru</span>
                    </button>

                </form>

                {{-- Link login --}}
                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}"
                       class="text-gray-400 hover:text-red-600 text-sm transition">
                        ← Kembali ke Login
                    </a>
                </div>

            </div>

            <p class="text-center text-xs text-gray-400 mt-6">
                © {{ date('Y') }} ONE T.O Coffee · Batam, Kepulauan Riau
            </p>
        </div>
    </div>

</body>
<script>
    function togglePw(inputId, btnId) {
        const input = document.getElementById(inputId);
        const btn   = document.getElementById(btnId);
        input.type      = input.type === 'password' ? 'text' : 'password';
        btn.textContent = input.type === 'password' ? '👁️' : '🙈';
    }

    function checkStrength(pw) {
        const bars = ['s1','s2','s3','s4'].map(id => document.getElementById(id));
        const txt  = document.getElementById('strength-text');
        bars.forEach(b => b.style.background = '#e5e7eb');
        if (!pw) { txt.textContent = 'Masukkan password baru kamu'; txt.className = 'text-xs text-gray-400 mt-1'; return; }
        let score = 0;
        if (pw.length >= 8)           score++;
        if (/[A-Z]/.test(pw))         score++;
        if (/[0-9]/.test(pw))         score++;
        if (/[^A-Za-z0-9]/.test(pw))  score++;
        const levels = [
            { c: '#ef4444', t: '😟 Terlalu lemah',  cls: 'text-xs text-red-500 mt-1' },
            { c: '#f97316', t: '😐 Cukup',          cls: 'text-xs text-orange-500 mt-1' },
            { c: '#eab308', t: '🙂 Lumayan kuat',   cls: 'text-xs text-yellow-600 mt-1' },
            { c: '#22c55e', t: '💪 Sangat kuat!',   cls: 'text-xs text-green-600 mt-1' },
        ];
        const lv = levels[score - 1] || levels[0];
        for (let i = 0; i < score; i++) bars[i].style.background = lv.c;
        txt.textContent = lv.t;
        txt.className   = lv.cls;
    }

    function checkMatch() {
        const pw  = document.getElementById('password').value;
        const c   = document.getElementById('password_confirmation');
        const msg = document.getElementById('match-msg');
        msg.classList.remove('hidden');
        if (pw === c.value) {
            msg.textContent = '✓ Password cocok';
            msg.className   = 'text-xs mt-1 text-green-600';
            c.style.borderColor = '#22c55e';
        } else {
            msg.textContent = '✗ Password tidak cocok';
            msg.className   = 'text-xs mt-1 text-red-500';
            c.style.borderColor = '#ef4444';
        }
    }
</script>
</html>