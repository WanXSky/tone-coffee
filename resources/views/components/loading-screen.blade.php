{{-- Loading Screen Component --}}
<div id="loading-screen"
     class="fixed inset-0 z-[9999] flex flex-col items-center justify-center
            bg-white transition-opacity duration-500">

    <style>
        /* ── Gelas ───────────────────────────────────────────── */
        .glass-wrapper {
            position: relative;
            width: 90px;
            height: 120px;
        }

        /* Body gelas */
        .glass-body {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 70px;
            height: 100px;
            border: 4px solid #dc2626;
            border-top: none;
            border-radius: 0 0 22px 22px;
            overflow: hidden;
            background: white;
        }

        /* Bibir gelas atas */
        .glass-top {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            width: 78px;
            height: 8px;
            border: 4px solid #dc2626;
            border-radius: 4px;
            background: white;
            z-index: 2;
        }

        /* Gagang gelas */
        .glass-handle {
            position: absolute;
            right: -18px;
            top: 20px;
            width: 18px;
            height: 36px;
            border: 4px solid #dc2626;
            border-left: none;
            border-radius: 0 12px 12px 0;
        }

        /* Cairan kopi */
        .liquid {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: linear-gradient(to bottom, #c2410c, #dc2626);
            border-radius: 0 0 18px 18px;
            animation: fill-up 2.4s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        @keyframes fill-up {
            0%   { height: 0%; }
            100% { height: 88%; }
        }

        /* Gelombang di atas cairan */
        .wave {
            position: absolute;
            top: -8px;
            left: -20%;
            width: 140%;
            height: 16px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 20'%3E%3Cpath d='M0,10 C30,0 70,20 100,10 C130,0 170,20 200,10 L200,20 L0,20 Z' fill='%23dc2626'/%3E%3C/svg%3E") repeat-x;
            background-size: 100px 16px;
            animation: wave-move 1.2s linear infinite;
            opacity: 0.8;
        }

        @keyframes wave-move {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-100px); }
        }

        /* Busa / crema di atas */
        .foam {
            position: absolute;
            top: -14px;
            left: 5%;
            width: 90%;
            height: 14px;
            background: linear-gradient(to bottom, #fef3c7, #fde68a);
            border-radius: 50% 50% 0 0 / 100% 100% 0 0;
            animation: foam-appear 0.4s ease forwards;
            animation-delay: 2s;
            opacity: 0;
        }

        @keyframes foam-appear {
            0%   { opacity: 0; transform: scaleX(0.5); }
            100% { opacity: 1; transform: scaleX(1); }
        }

        /* Gelembung-gelembung kecil */
        .bubble {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.35);
            animation: bubble-rise linear infinite;
        }

        @keyframes bubble-rise {
            0%   { transform: translateY(0) scale(1); opacity: 0.6; }
            100% { transform: translateY(-60px) scale(0.3); opacity: 0; }
        }

        /* Steam / uap */
        .steam-line {
            position: absolute;
            bottom: 100%;
            width: 4px;
            border-radius: 2px;
            background: linear-gradient(to top, #fca5a5, transparent);
            animation: steam-rise 1.8s ease-in-out infinite;
            opacity: 0;
        }

        .steam-line:nth-child(1) { left: 18px; animation-delay: 2.1s; height: 28px; }
        .steam-line:nth-child(2) { left: 30px; animation-delay: 2.4s; height: 20px; }
        .steam-line:nth-child(3) { left: 42px; animation-delay: 2.6s; height: 24px; }

        @keyframes steam-rise {
            0%   { opacity: 0; transform: translateY(0) scaleX(1); }
            30%  { opacity: 0.7; }
            100% { opacity: 0; transform: translateY(-30px) scaleX(0.3); }
        }

        /* Piring / alas */
        .saucer {
            width: 88px;
            height: 10px;
            background: linear-gradient(to bottom, #e5e7eb, #d1d5db);
            border-radius: 50%;
            margin-top: 4px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }

        /* Progress bar bawah */
        .progress-track {
            width: 160px;
            height: 4px;
            background: #fee2e2;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 28px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #dc2626, #ef4444, #dc2626);
            background-size: 200% 100%;
            border-radius: 4px;
            animation:
                progress-grow 2.4s cubic-bezier(0.4, 0, 0.2, 1) forwards,
                shimmer 1.2s linear infinite;
        }

        @keyframes progress-grow {
            0%   { width: 0%; }
            100% { width: 100%; }
        }

        @keyframes shimmer {
            0%   { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Teks loading dots */
        .loading-dot {
            display: inline-block;
            animation: dot-bounce 1.2s ease-in-out infinite;
        }
        .loading-dot:nth-child(2) { animation-delay: 0.2s; }
        .loading-dot:nth-child(3) { animation-delay: 0.4s; }

        @keyframes dot-bounce {
            0%, 80%, 100% { transform: translateY(0); }
            40%            { transform: translateY(-5px); }
        }

        /* Fade out loading screen */
        #loading-screen.fade-out {
            opacity: 0;
            pointer-events: none;
        }

        /* Partikel kopi */
        .coffee-particle {
            position: absolute;
            font-size: 18px;
            animation: particle-float linear infinite;
            opacity: 0;
        }

        @keyframes particle-float {
            0%   { transform: translateY(0) rotate(0deg); opacity: 0; }
            10%  { opacity: 0.8; }
            90%  { opacity: 0.6; }
            100% { transform: translateY(-80px) rotate(360deg); opacity: 0; }
        }
    </style>

    {{-- Partikel mengambang --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        @foreach([
            ['☕', '10%', '20%', '3s', '0s'],
            ['🫘', '85%', '15%', '4s', '0.5s'],
            ['✨', '20%', '70%', '3.5s', '1s'],
            ['🫧', '75%', '65%', '4.5s', '0.3s'],
            ['☕', '50%', '80%', '3.2s', '1.5s'],
            ['🫘', '40%', '10%', '4.2s', '0.8s'],
            ['✨', '90%', '40%', '3.8s', '0.2s'],
            ['🫧', '5%', '50%', '4.8s', '1.2s'],
        ] as $p)
        <div class="coffee-particle"
             style="left:{{ $p[0] }};top:{{ $p[1] }};animation-duration:{{ $p[2] }};animation-delay:{{ $p[3] }}">
            {{ $p[0] === '☕' || $p[0] === '🫘' || $p[0] === '✨' || $p[0] === '🫧' ? $p[0] : '☕' }}
        </div>
        @endforeach
        <div class="coffee-particle" style="left:10%;top:20%;animation-duration:3s;animation-delay:0s">☕</div>
        <div class="coffee-particle" style="left:85%;top:15%;animation-duration:4s;animation-delay:0.5s">🫘</div>
        <div class="coffee-particle" style="left:20%;top:70%;animation-duration:3.5s;animation-delay:1s">✨</div>
        <div class="coffee-particle" style="left:75%;top:65%;animation-duration:4.5s;animation-delay:0.3s">🫧</div>
        <div class="coffee-particle" style="left:50%;top:80%;animation-duration:3.2s;animation-delay:1.5s">☕</div>
        <div class="coffee-particle" style="left:40%;top:10%;animation-duration:4.2s;animation-delay:0.8s">🫘</div>
        <div class="coffee-particle" style="left:90%;top:40%;animation-duration:3.8s;animation-delay:0.2s">✨</div>
        <div class="coffee-particle" style="left:5%;top:50%;animation-duration:4.8s;animation-delay:1.2s">🫧</div>
    </div>

    {{-- Konten utama --}}
    <div class="flex flex-col items-center relative z-10">

        {{-- Logo --}}
        <div class="flex items-center gap-3 mb-10">
            <div class="bg-red-600 text-white rounded-2xl px-4 py-2 shadow-lg">
                <span class="font-black text-3xl tracking-tight">ONE</span>
            </div>
            <div class="text-left">
                <p class="font-black text-3xl text-gray-900 leading-none">T.O</p>
                <p class="text-red-600 text-xs font-bold tracking-widest uppercase">Coffee</p>
            </div>
        </div>

        {{-- Animasi gelas kopi --}}
        <div class="glass-wrapper mb-1">
            {{-- Uap / steam --}}
            <div class="steam-line" style="left:20px"></div>
            <div class="steam-line" style="left:33px"></div>
            <div class="steam-line" style="left:46px"></div>

            {{-- Bibir atas gelas --}}
            <div class="glass-top"></div>

            {{-- Body gelas --}}
            <div class="glass-body">
                {{-- Cairan --}}
                <div class="liquid">
                    {{-- Gelombang --}}
                    <div class="wave"></div>
                    {{-- Busa --}}
                    <div class="foam"></div>
                    {{-- Gelembung --}}
                    <div class="bubble" style="width:6px;height:6px;left:15%;bottom:10%;animation-duration:2.1s;animation-delay:0.3s"></div>
                    <div class="bubble" style="width:4px;height:4px;left:45%;bottom:20%;animation-duration:1.8s;animation-delay:0.7s"></div>
                    <div class="bubble" style="width:5px;height:5px;left:70%;bottom:8%;animation-duration:2.4s;animation-delay:0.1s"></div>
                    <div class="bubble" style="width:3px;height:3px;left:30%;bottom:30%;animation-duration:1.6s;animation-delay:1s"></div>
                    <div class="bubble" style="width:4px;height:4px;left:60%;bottom:15%;animation-duration:2s;animation-delay:0.5s"></div>
                </div>
            </div>

            {{-- Gagang --}}
            <div class="glass-handle"></div>
        </div>

        {{-- Piring --}}
        <div class="saucer"></div>

        {{-- Progress bar --}}
        <div class="progress-track">
            <div class="progress-fill" id="loading-progress"></div>
        </div>

        {{-- Teks loading --}}
        <p class="text-gray-500 text-sm font-medium mt-4" id="loading-text">
            Menyeduh kopi untuk kamu
            <span class="loading-dot">.</span>
            <span class="loading-dot">.</span>
            <span class="loading-dot">.</span>
        </p>

        {{-- Teks berganti --}}
        <p class="text-gray-300 text-xs mt-1" id="loading-sub">
            Sebentar ya, hampir siap!
        </p>

    </div>

    <script>
        // ── Teks loading yang berganti-ganti ──────────────────────
        const loadingTexts = [
            'Menyeduh kopi untuk kamu',
            'Meracik minuman segar',
            'Menyiapkan menu terbaik',
            'Hampir siap dihidangkan',
        ];

        const subTexts = [
            'Sebentar ya, hampir siap!',
            'ONE T.O Coffee siap melayani',
            'Kopi terbaik untukmu ☕',
            'Tinggal sebentar lagi...',
        ];

        let textIndex = 0;

        const textInterval = setInterval(() => {
            textIndex = (textIndex + 1) % loadingTexts.length;
            const el    = document.getElementById('loading-text');
            const subEl = document.getElementById('loading-sub');

            if (el) {
                el.style.opacity = '0';
                el.style.transition = 'opacity 0.3s';

                setTimeout(() => {
                    el.innerHTML = loadingTexts[textIndex] +
                        ' <span class="loading-dot">.</span>' +
                        '<span class="loading-dot">.</span>' +
                        '<span class="loading-dot">.</span>';
                    if (subEl) subEl.textContent = subTexts[textIndex];
                    el.style.opacity = '1';
                }, 300);
            }
        }, 800);

        // ── Sembunyikan loading screen saat halaman siap ──────────
        window.addEventListener('load', function () {
            clearInterval(textInterval);

            setTimeout(() => {
                const screen = document.getElementById('loading-screen');
                if (screen) {
                    screen.style.transition = 'opacity 0.6s ease';
                    screen.style.opacity    = '0';

                    setTimeout(() => {
                        screen.style.display = 'none';
                        document.body.style.overflow = 'auto';
                    }, 600);
                }
            }, 800); // Minimal tampil 800ms setelah load
        });

        // ── Paksa hilang setelah 5 detik (failsafe) ──────────────
        setTimeout(() => {
            const screen = document.getElementById('loading-screen');
            if (screen && screen.style.display !== 'none') {
                screen.style.transition = 'opacity 0.4s ease';
                screen.style.opacity    = '0';
                setTimeout(() => { screen.style.display = 'none'; }, 400);
            }
        }, 5000);
    </script>

</div>