<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password — ONE T.O Coffee</title>
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

        .circle-deco {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }

        .input-field:focus {
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15);
        }

        /* Animasi amplop */
        @keyframes envelope-bounce {
            0%, 100% { transform: translateY(0) rotate(-2deg); }
            50%       { transform: translateY(-8px) rotate(2deg); }
        }
        .envelope-anim {
            animation: envelope-bounce 2.5s ease-in-out infinite;
        }

        /* Progress dots */
        .step-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            transition: all 0.3s;
        }
    </style>
</head>
<body class="h-screen overflow-hidden flex">

    {{-- ── KIRI: Branding panel ── --}}
    <div class="hidden lg:flex lg:w-1/2 h-screen sticky top-0
                bg-pattern relative overflow-hidden
                flex-col items-center justify-center text-white p-12">

        {{-- Dekorasi lingkaran --}}
        <div class="circle-deco w-96 h-96 -top-24 -left-24"></div>
        <div class="circle-deco w-64 h-64 bottom-10 -right-16"></div>
        <div class="circle-deco w-32 h-32 top-1/2 right-10"></div>

        {{-- Logo --}}

        {{-- Ilustrasi reset --}}
        <div class="relative z-10 text-center max-w-sm">
            {{-- Icon amplop animasi --}}
            <div class="envelope-anim text-8xl mb-6">📧</div>

            <h2 class="text-3xl font-black leading-tight mb-4">
                Lupa Password?<br>
                <span class="text-red-200">Tenang aja! 😊</span>
            </h2>
            <p class="text-red-100 text-sm leading-relaxed">
                Kami akan kirimkan link reset password ke emailmu.
                Ikuti langkahnya dan kamu bisa masuk kembali dalam hitungan menit.
            </p>
        </div>

        {{-- Step cards --}}
        <div class="relative z-10 mt-10 space-y-3 w-full max-w-sm">
            @foreach([
                ['1', '✉️', 'Masukkan Email', 'Ketik email yang terdaftar di akun kamu'],
                ['2', '📬', 'Cek Inbox Email', 'Kami kirim link reset ke emailmu'],
                ['3', '🔑', 'Buat Password Baru', 'Klik link dan buat password baru'],
            ] as $step)
            <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm
                        rounded-xl px-4 py-3 border border-white/20">
                <div class="w-7 h-7 rounded-full bg-white/20 flex items-center
                             justify-center text-xs font-black flex-shrink-0">
                    {{ $step[0] }}
                </div>
                <span class="text-xl flex-shrink-0">{{ $step[1] }}</span>
                <div>
                    <p class="font-bold text-sm text-white">{{ $step[2] }}</p>
                    <p class="text-xs text-red-200">{{ $step[3] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Dekorasi bintang --}}
        <div class="absolute bottom-6 left-6 text-white/20 text-6xl font-black select-none">✦</div>
        <div class="absolute top-10 right-8 text-white/10 text-4xl font-black select-none">✦</div>
    </div>

    {{-- ── KANAN: Form lupa password ── --}}
    <div class="w-full lg:w-1/2 flex items-start justify-center
                bg-gray-50 px-6 pt-10 pb-12 relative
                h-screen overflow-y-auto scroll-smooth">

        {{-- Background subtle --}}
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

            {{-- Card form --}}
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8">

                {{-- Icon & Heading --}}
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center
                                w-20 h-20 rounded-full bg-red-50
                                border-4 border-red-100 text-4xl mb-4
                                animate__animated animate__bounceIn">
                        🔑
                    </div>
                    <h1 class="text-2xl font-black text-gray-900">Lupa Password</h1>
                    <p class="text-gray-500 text-sm mt-2 leading-relaxed">
                        Masukkan alamat email yang terdaftar.<br>
                        Kami akan kirimkan link untuk reset password.
                    </p>
                </div>

                {{-- Success message setelah kirim --}}
                @if (session('status'))
                <div class="bg-green-50 border border-green-200 rounded-2xl p-5 mb-6
                            animate__animated animate__fadeIn text-center">
                    <div class="text-4xl mb-3">📬</div>
                    <p class="text-green-700 font-bold text-sm">Email Terkirim!</p>
                    <p class="text-green-600 text-xs mt-1 leading-relaxed">
                        {{ session('status') }}
                    </p>
                    <div class="mt-4 bg-green-100 rounded-xl p-3">
                        <p class="text-green-600 text-xs">
                            💡 Tidak menerima email? Cek folder
                            <strong>Spam</strong> atau <strong>Junk</strong> kamu
                        </p>
                    </div>
                </div>
                @endif

                {{-- Error message --}}
                @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 mb-5
                            animate__animated animate__shakeX">
                    <div class="flex items-start gap-2">
                        <span class="text-red-500 flex-shrink-0">⚠</span>
                        <div>
                            @foreach ($errors->all() as $error)
                            <p class="text-red-600 text-sm">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('password.email') }}" id="forgot-form">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-6">
                        <label for="email"
                               class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                ✉️
                            </span>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus
                                   placeholder="nama@email.com"
                                   class="input-field w-full border border-gray-200 rounded-xl
                                          pl-11 pr-4 py-3 text-sm text-gray-900
                                          focus:outline-none focus:border-red-500 transition
                                          placeholder-gray-400
                                          @error('email') border-red-400 bg-red-50 @enderror">
                        </div>

                        {{-- Info tambahan --}}
                        <p class="text-gray-400 text-xs mt-2 flex items-center gap-1">
                            <span>ℹ️</span>
                            Gunakan email yang sama saat mendaftar akun
                        </p>
                    </div>

                    {{-- Tombol kirim --}}
                    <button type="submit"
                            id="submit-btn"
                            onclick="handleSubmit()"
                            class="w-full bg-red-600 hover:bg-red-700 active:scale-95
                                   text-white font-black py-3.5 rounded-xl text-base
                                   transition shadow-lg shadow-red-200
                                   flex items-center justify-center gap-2">
                        <span id="btn-icon">📧</span>
                        <span id="btn-text">Kirim Link Reset Password</span>
                    </button>

                </form>

                {{-- Divider --}}
                <div class="flex items-center gap-3 my-6">
                    <hr class="flex-1 border-gray-200">
                    <span class="text-xs text-gray-400 font-medium">atau</span>
                    <hr class="flex-1 border-gray-200">
                </div>

                {{-- Link kembali login --}}
                <a href="{{ route('login') }}"
                   class="w-full border-2 border-gray-200 hover:border-red-400
                          hover:text-red-600 text-gray-600 font-bold py-3 rounded-xl
                          transition flex items-center justify-center gap-2 text-sm">
                    <span>←</span>
                    <span>Kembali ke Halaman Login</span>
                </a>

                {{-- Info bantuan --}}
                <div class="mt-6 bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <p class="text-xs font-semibold text-gray-600 mb-2">
                        💬 Butuh bantuan?
                    </p>
                    <p class="text-xs text-gray-400 leading-relaxed">
                        Jika kamu masih kesulitan, hubungi kami melalui WhatsApp di
                        <a href="https://wa.me/6281342674884?text=Halo%20Twenty%20One%20Coffee%2C%20saya%20butuh%20bantuan%20untuk%20reset%20password%20saya."
                           target="_blank"
                           class="text-red-500 font-semibold hover:underline">
                            0813-4267-4884
                        </a>
                    </p>
                </div>

            </div>

            {{-- Footer --}}
            <p class="text-center text-xs text-gray-400 mt-6">
                © {{ date('Y') }} ONE T.O Coffee · Batam, Kepulauan Riau
            </p>

        </div>
    </div>

</body>

<script>
    // ── Animasi tombol saat submit ────────────────────────────────
    function handleSubmit() {
        const btn     = document.getElementById('submit-btn');
        const btnIcon = document.getElementById('btn-icon');
        const btnText = document.getElementById('btn-text');

        // Validasi email dulu
        const email = document.getElementById('email').value;
        if (!email || !email.includes('@')) return;

        // Ubah tampilan tombol jadi loading
        btn.disabled         = true;
        btn.classList.remove('bg-red-600', 'hover:bg-red-700');
        btn.classList.add('bg-red-400', 'cursor-not-allowed');
        btnIcon.textContent  = '⏳';
        btnText.textContent  = 'Mengirim email...';

        // Submit form
        document.getElementById('forgot-form').submit();
    }

    // ── Animasi input saat focus ──────────────────────────────────
    document.getElementById('email').addEventListener('focus', function () {
        this.parentElement.querySelector('span').textContent = '✉️';
    });
</script>
</html>