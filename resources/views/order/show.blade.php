@extends('layouts.app')
@section('title', 'Pesanan ' . $order->order_number)

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- ── Header ── --}}
        <div class="bg-gradient-to-r from-red-600 to-red-700 text-white p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-red-200 text-sm">No. Pesanan</p>
                    <h1 class="text-xl font-black mt-0.5">{{ $order->order_number }}</h1>
                    {{-- Badge tipe order --}}
                    <span class="mt-2 inline-block px-2.5 py-1 rounded-full text-xs font-bold
                        {{ $order->isTakeaway()
                            ? 'bg-green-400 text-green-900'
                            : 'bg-blue-400 text-blue-900' }}">
                        {{ $order->isTakeaway() ? '🥤 Take Away' : '🛵 Delivery' }}
                    </span>
                </div>
                {{-- Badge status — diupdate live --}}
                <span id="live-status-badge"
                      class="px-3 py-1.5 rounded-full text-sm font-bold flex-shrink-0
                      {{ match($order->status) {
                          'pending'    => 'bg-yellow-400 text-yellow-900',
                          'processing' => 'bg-blue-400 text-blue-900',
                          'shipped'    => 'bg-purple-400 text-purple-900',
                          'ready'      => 'bg-orange-400 text-orange-900',
                          'completed'  => 'bg-green-400 text-green-900',
                          'cancelled'  => 'bg-red-400 text-white',
                          default      => 'bg-gray-400 text-white',
                      } }}">
                    {{ $order->status_label }}
                </span>
            </div>
            <p class="text-red-200 text-xs mt-2">
                Dipesan {{ $order->created_at->diffForHumans() }}
            </p>
        </div>

        <div class="p-6">

            {{-- ── Progress tracking — diupdate live ── --}}
            @php
                // Status berbeda untuk takeaway vs delivery
                $allStatuses = $order->isTakeaway()
                    ? ['pending', 'processing', 'ready', 'completed']
                    : ['pending', 'processing', 'shipped', 'completed'];

                $currentIdx = array_search($order->status, $allStatuses);

                $statusLabels = $order->isTakeaway()
                    ? [
                        'pending'    => ['icon' => '⏳', 'label' => 'Menunggu',   'desc' => 'Pesanan diterima'],
                        'processing' => ['icon' => '👨‍🍳', 'label' => 'Diproses',   'desc' => 'Sedang dibuat'],
                        'ready'      => ['icon' => '🔔', 'label' => 'Siap Ambil', 'desc' => 'Silakan ambil'],
                        'completed'  => ['icon' => '✅', 'label' => 'Selesai',    'desc' => 'Sudah diambil'],
                      ]
                    : [
                        'pending'    => ['icon' => '⏳', 'label' => 'Menunggu',  'desc' => 'Pesanan diterima'],
                        'processing' => ['icon' => '👨‍🍳', 'label' => 'Diproses',  'desc' => 'Sedang dibuat'],
                        'shipped'    => ['icon' => '🚴', 'label' => 'Dikirim',   'desc' => 'Dalam perjalanan'],
                        'completed'  => ['icon' => '✅', 'label' => 'Selesai',   'desc' => 'Sudah diterima'],
                      ];

                $statusMessages = $order->isTakeaway()
                    ? [
                        'pending'    => '⏳ Pesananmu sedang menunggu konfirmasi dari admin...',
                        'processing' => '👨‍🍳 Minumanmu sedang diracik oleh tim kami!',
                        'ready'      => '🔔 Minumanmu sudah siap! Silakan ambil di toko.',
                        'completed'  => '✅ Pesanan selesai. Selamat menikmati!',
                      ]
                    : [
                        'pending'    => '⏳ Pesananmu sedang menunggu konfirmasi dari admin...',
                        'processing' => '👨‍🍳 Pesananmu sedang diracik oleh tim kami!',
                        'shipped'    => '🚴 Kurir sedang dalam perjalanan menuju lokasimu!',
                        'completed'  => '✅ Pesanan telah sampai. Selamat menikmati!',
                      ];
            @endphp

            {{-- Wrapper progress bar --}}
            <div id="live-tracking-section"
                 class="mb-8 {{ $order->status === 'cancelled' ? 'hidden' : '' }}">
                <h3 class="font-bold text-gray-900 mb-5">Status Pesanan</h3>

                <div class="relative">
                    {{-- Garis background --}}
                    <div class="absolute top-5 left-5 right-5 h-0.5 bg-gray-200 z-0">
                        {{-- Garis aktif --}}
                        <div id="live-progress-line"
                             class="h-full bg-red-500 transition-all duration-700"
                             style="width: {{ $currentIdx !== false && $currentIdx > 0
                                ? ($currentIdx / (count($allStatuses) - 1)) * 100
                                : 0 }}%">
                        </div>
                    </div>

                    {{-- Step circles --}}
                    <div class="relative z-10 flex justify-between">
                        @foreach($allStatuses as $i => $status)
                        @php $isDone = $currentIdx !== false && $i <= $currentIdx; @endphp
                        <div class="flex flex-col items-center gap-2 w-20" id="step-{{ $i }}">
                            <div class="step-circle w-10 h-10 rounded-full flex items-center
                                        justify-center text-lg font-bold border-2
                                        transition-all duration-500
                                        {{ $isDone
                                            ? 'bg-red-600 border-red-600 text-white shadow-md shadow-red-200'
                                            : 'bg-white border-gray-300 text-gray-400' }}">
                                {{ $isDone
                                    ? ($i < $currentIdx ? '✓' : $statusLabels[$status]['icon'])
                                    : ($i + 1) }}
                            </div>
                            <span class="step-label text-xs font-semibold text-center
                                         {{ $isDone ? 'text-red-600' : 'text-gray-400' }}">
                                {{ $statusLabels[$status]['label'] }}
                            </span>
                            <span class="text-xs text-gray-400 text-center hidden sm:block">
                                {{ $statusLabels[$status]['desc'] }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Pesan status --}}
                <div id="live-status-message"
                     class="mt-6 rounded-xl p-4 text-center text-sm font-medium
                     {{ match($order->status) {
                         'pending'    => 'bg-yellow-50 text-yellow-700 border border-yellow-200',
                         'processing' => 'bg-blue-50 text-blue-700 border border-blue-200',
                         'shipped'    => 'bg-purple-50 text-purple-700 border border-purple-200',
                         'ready'      => 'bg-orange-50 text-orange-700 border border-orange-200',
                         'completed'  => 'bg-green-50 text-green-700 border border-green-200',
                         default      => 'bg-gray-50 text-gray-600 border border-gray-200',
                     } }}">
                    {{ $statusMessages[$order->status] ?? 'Memuat status...' }}
                </div>
            </div>

            {{-- Cancelled notice --}}
            <div id="live-cancelled-section"
                 class="{{ $order->status !== 'cancelled' ? 'hidden' : '' }}
                        bg-red-50 border border-red-200 rounded-xl p-4 mb-6 text-center">
                <div class="text-3xl mb-2">❌</div>
                <p class="text-red-700 font-bold">Pesanan Dibatalkan</p>
                <p class="text-red-500 text-sm mt-1">Silakan hubungi kami jika ada pertanyaan</p>
            </div>

            {{-- Indikator live update --}}
            <div class="flex items-center justify-center gap-2 mb-6" id="live-indicator">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                <span class="text-xs text-gray-400" id="live-indicator-text">
                    Memantau status secara live...
                </span>
            </div>

            {{-- ── Info takeaway atau delivery ── --}}
            @if($order->isTakeaway())
            {{-- Info Take Away --}}
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                <h4 class="font-bold text-green-800 text-sm mb-3">🥤 Informasi Take Away</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-green-600">Nama Pengambil</span>
                        <span class="font-semibold text-green-800">{{ $order->pickup_name }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-green-600">Estimasi Ambil</span>
                        <span class="font-semibold text-green-800">
                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $order->pickup_time)->format('H:i') }} WIB
                        </span>
                    </div>
                    <hr class="border-green-200">
                    <div class="flex justify-between items-center">
                        <span class="text-green-600">Lokasi Toko</span>
                        <span class="font-semibold text-green-800 text-right">
                            Jl. Contoh No. 123, Batam
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-green-600">Jam Buka</span>
                        <span class="font-semibold text-green-800">08:00 - 22:00 WIB</span>
                    </div>
                </div>

                {{-- Alert jika status ready --}}
                @if($order->status === 'ready')
                <div class="mt-3 bg-green-600 text-white rounded-xl p-3 text-center animate-pulse">
                    <p class="font-black">🔔 Minumanmu sudah siap diambil!</p>
                    <p class="text-sm text-green-100 mt-0.5">Segera ambil di toko ya</p>
                </div>
                @endif
            </div>

            @else
            {{-- Info Delivery --}}
            @if($order->courier)
            <div class="bg-gray-50 rounded-xl p-4 mb-6">
                <h4 class="font-bold text-gray-900 text-sm mb-3">Informasi Kurir</h4>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-red-600 text-white
                                flex items-center justify-center font-bold flex-shrink-0">
                        {{ substr($order->courier->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-gray-900">{{ $order->courier->name }}</p>
                        <p class="text-gray-500 text-xs">{{ $order->courier->vehicle_number }}</p>
                    </div>
                    <a href="tel:{{ $order->courier->phone }}"
                       class="ml-auto bg-green-100 text-green-700 text-sm font-bold
                              px-3 py-1.5 rounded-full hover:bg-green-200 transition flex-shrink-0">
                        📞 Hubungi
                    </a>
                </div>
            </div>
            @endif

            <div class="bg-gray-50 rounded-xl p-4 mb-6">
                <h4 class="font-bold text-gray-900 text-sm mb-2">🛵 Alamat Pengiriman</h4>
                <p class="text-gray-700 font-medium text-sm">{{ $order->delivery_name }}</p>
                <p class="text-gray-500 text-sm">{{ $order->delivery_phone }}</p>
                <p class="text-gray-600 text-sm mt-1">{{ $order->delivery_address }}</p>
                @if($order->notes)
                <p class="text-gray-400 text-xs mt-2 italic">📝 {{ $order->notes }}</p>
                @endif
            </div>
            @endif

            {{-- Catatan (untuk takeaway) --}}
            @if($order->isTakeaway() && $order->notes)
            <div class="bg-gray-50 rounded-xl p-3 mb-6 text-sm text-gray-500 italic">
                📝 Catatan: {{ $order->notes }}
            </div>
            @endif

            {{-- ── Item pesanan ── --}}
            <h4 class="font-bold text-gray-900 text-sm mb-3">Item Pesanan</h4>
            <div class="space-y-2 mb-6">
                @foreach($order->items as $item)
                <div class="flex justify-between items-center text-sm py-2
                            border-b border-gray-100 last:border-0">
                    <div>
                        <span class="font-medium text-gray-900">{{ $item->menu_name }}</span>
                        <span class="text-gray-400 ml-1">×{{ $item->quantity }}</span>
                        @if($item->notes)
                        <span class="text-xs text-gray-400 block italic">{{ $item->notes }}</span>
                        @endif
                    </div>
                    <span class="font-semibold flex-shrink-0">
                        Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                    </span>
                </div>
                @endforeach

                <div class="flex justify-between text-sm text-gray-500 pt-1">
                    <span>Ongkos kirim</span>
                    <span>
                        @if($order->delivery_fee == 0)
                            <span class="text-green-600 font-semibold">GRATIS</span>
                        @else
                            Rp{{ number_format($order->delivery_fee, 0, ',', '.') }}
                        @endif
                    </span>
                </div>
                <div class="flex justify-between font-black text-base pt-1">
                    <span>Total</span>
                    <span class="text-red-600">
                        Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- ── Pembayaran ── --}}
            @if($order->payment)
            <div id="payment-section"
                 class="bg-gray-50 rounded-xl p-4 flex justify-between items-center mb-6">
                <div>
                    <p class="text-xs text-gray-500">Metode Bayar</p>
                    <p class="font-bold text-gray-900 uppercase">{{ $order->payment->method }}</p>
                    @if($order->isTakeaway() && $order->payment->method === 'cash')
                    <p class="text-xs text-gray-400">Bayar di kasir toko</p>
                    @endif
                </div>
                <span id="live-payment-status"
                      class="px-3 py-1 rounded-full text-xs font-bold
                      {{ $order->payment->status === 'success'
                          ? 'bg-green-100 text-green-700'
                          : ($order->payment->status === 'failed'
                              ? 'bg-red-100 text-red-700'
                              : 'bg-yellow-100 text-yellow-700') }}">
                    {{ match($order->payment->status) {
                        'success' => '✓ Lunas',
                        'failed'  => '✗ Ditolak',
                        default   => '⏳ Menunggu',
                    } }}
                </span>
            </div>
            @endif

            {{-- ── Action buttons ── --}}
            <div id="action-buttons" class="flex flex-col gap-3">

                @if($order->payment &&
                    $order->payment->method === 'qris' &&
                    $order->payment->status === 'pending')
                <a href="{{ route('payment.show', $order) }}"
                   class="w-full bg-red-600 hover:bg-red-700 text-white
                          font-bold py-3 rounded-xl transition text-center">
                    💳 Lanjutkan Pembayaran
                </a>
                @endif

                @if($order->canBeCancelled())
                <form action="{{ route('order.cancel', $order) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                    @csrf
                    <button type="submit"
                            class="w-full border-2 border-red-300 text-red-500
                                   hover:bg-red-50 font-semibold py-3 rounded-xl transition">
                        Batalkan Pesanan
                    </button>
                </form>
                @endif

                <a href="{{ route('orders') }}"
                   class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700
                          font-semibold py-3 rounded-xl transition text-center">
                    ← Semua Pesanan
                </a>

            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // ── Konfigurasi ──────────────────────────────────────────────
    const STATUS_URL    = '{{ route("order.status", $order) }}';
    const POLL_INTERVAL = 5000;
    const MAX_POLL      = 720;
    const ORDER_TYPE    = '{{ $order->order_type }}';

    // ── Status sesuai tipe order ─────────────────────────────────
    const ALL_STATUSES = ORDER_TYPE === 'takeaway'
        ? ['pending', 'processing', 'ready', 'completed']
        : ['pending', 'processing', 'shipped', 'completed'];

    const STATUS_ICONS = ORDER_TYPE === 'takeaway'
        ? { pending: '⏳', processing: '👨‍🍳', ready: '🔔', completed: '✅' }
        : { pending: '⏳', processing: '👨‍🍳', shipped: '🚴', completed: '✅' };

    const STATUS_LABELS = ORDER_TYPE === 'takeaway'
        ? { pending: 'Menunggu', processing: 'Diproses', ready: 'Siap Ambil', completed: 'Selesai', cancelled: 'Dibatalkan' }
        : { pending: 'Menunggu', processing: 'Diproses', shipped: 'Dikirim',   completed: 'Selesai', cancelled: 'Dibatalkan' };

    const STATUS_MESSAGES = ORDER_TYPE === 'takeaway'
        ? {
            pending:    '⏳ Pesananmu sedang menunggu konfirmasi dari admin...',
            processing: '👨‍🍳 Minumanmu sedang diracik oleh tim kami!',
            ready:      '🔔 Minumanmu sudah siap! Silakan ambil di toko.',
            completed:  '✅ Pesanan selesai. Selamat menikmati!',
            cancelled:  '❌ Pesanan ini telah dibatalkan.',
          }
        : {
            pending:    '⏳ Pesananmu sedang menunggu konfirmasi dari admin...',
            processing: '👨‍🍳 Pesananmu sedang diracik oleh tim kami!',
            shipped:    '🚴 Kurir sedang dalam perjalanan menuju lokasimu!',
            completed:  '✅ Pesanan telah sampai. Selamat menikmati!',
            cancelled:  '❌ Pesanan ini telah dibatalkan.',
          };

    const STATUS_MESSAGE_CLASSES = {
        pending:    'bg-yellow-50 text-yellow-700 border border-yellow-200',
        processing: 'bg-blue-50 text-blue-700 border border-blue-200',
        shipped:    'bg-purple-50 text-purple-700 border border-purple-200',
        ready:      'bg-orange-50 text-orange-700 border border-orange-200',
        completed:  'bg-green-50 text-green-700 border border-green-200',
        cancelled:  'bg-red-50 text-red-700 border border-red-200',
    };

    const BADGE_CLASSES = {
        pending:    'bg-yellow-400 text-yellow-900',
        processing: 'bg-blue-400 text-blue-900',
        shipped:    'bg-purple-400 text-purple-900',
        ready:      'bg-orange-400 text-orange-900',
        completed:  'bg-green-400 text-green-900',
        cancelled:  'bg-red-400 text-white',
    };

    const PAYMENT_STATUS = {
        success: { text: '✓ Lunas',    cls: 'bg-green-100 text-green-700' },
        failed:  { text: '✗ Ditolak',  cls: 'bg-red-100 text-red-700' },
        pending: { text: '⏳ Menunggu', cls: 'bg-yellow-100 text-yellow-700' },
    };

    // ── State ────────────────────────────────────────────────────
    let currentStatus = '{{ $order->status }}';
    let pollCount     = 0;
    let pollTimer     = null;
    let isPolling     = false;

    // ── Update UI ────────────────────────────────────────────────
    function updateTrackingUI(data) {
        const { status, current_index, is_cancelled, payment } = data;

        // 1. Badge status
        const badge = document.getElementById('live-status-badge');
        if (badge) {
            badge.textContent = STATUS_LABELS[status] || status;
            badge.className   = `px-3 py-1.5 rounded-full text-sm font-bold flex-shrink-0 ${BADGE_CLASSES[status] || ''}`;
        }

        // 2. Progress line
        const progressLine = document.getElementById('live-progress-line');
        if (progressLine && current_index >= 0) {
            const pct = current_index > 0
                ? (current_index / (ALL_STATUSES.length - 1)) * 100
                : 0;
            progressLine.style.width = pct + '%';
        }

        // 3. Step circles
        ALL_STATUSES.forEach((s, i) => {
            const stepEl   = document.getElementById('step-' + i);
            if (!stepEl) return;
            const isDone   = i <= current_index;
            const isPast   = i < current_index;
            const circleEl = stepEl.querySelector('.step-circle');
            const labelEl  = stepEl.querySelector('.step-label');

            if (circleEl) {
                circleEl.className   = `step-circle w-10 h-10 rounded-full flex items-center justify-center text-lg font-bold border-2 transition-all duration-500 ${isDone ? 'bg-red-600 border-red-600 text-white shadow-md shadow-red-200' : 'bg-white border-gray-300 text-gray-400'}`;
                circleEl.textContent = isDone ? (isPast ? '✓' : (STATUS_ICONS[s] || i + 1)) : (i + 1);
            }

            if (labelEl) {
                labelEl.className = `step-label text-xs font-semibold text-center ${isDone ? 'text-red-600' : 'text-gray-400'}`;
            }
        });

        // 4. Pesan status
        const msgEl = document.getElementById('live-status-message');
        if (msgEl) {
            msgEl.textContent = STATUS_MESSAGES[status] || '';
            msgEl.className   = `mt-6 rounded-xl p-4 text-center text-sm font-medium ${STATUS_MESSAGE_CLASSES[status] || ''}`;
        }

        // 5. Tracking vs cancelled
        const trackingSection  = document.getElementById('live-tracking-section');
        const cancelledSection = document.getElementById('live-cancelled-section');
        if (is_cancelled) {
            trackingSection?.classList.add('hidden');
            cancelledSection?.classList.remove('hidden');
        } else {
            trackingSection?.classList.remove('hidden');
            cancelledSection?.classList.add('hidden');
        }

        // 6. Status pembayaran
        if (payment) {
            const payEl = document.getElementById('live-payment-status');
            if (payEl) {
                const ps      = PAYMENT_STATUS[payment.status] || PAYMENT_STATUS.pending;
                payEl.textContent = ps.text;
                payEl.className   = `px-3 py-1 rounded-full text-xs font-bold ${ps.cls}`;
            }
        }

        // 7. Notifikasi perubahan status
        if (status !== currentStatus) {
            showStatusChangeNotification(status);
            currentStatus = status;

            // Flash effect
            const card = document.querySelector('.bg-white.rounded-2xl');
            if (card) {
                card.style.boxShadow = '0 0 0 3px #dc2626';
                setTimeout(() => card.style.boxShadow = '', 1500);
            }
        }

        // 8. Stop jika selesai/dibatalkan
        if (status === 'completed' || status === 'cancelled') {
            stopPolling();
            updateIndicator(false, status === 'completed' ? '✅ Pesanan selesai' : '❌ Pesanan dibatalkan');
        }
    }

    // ── Notifikasi perubahan status ──────────────────────────────
    function showStatusChangeNotification(newStatus) {
        const messages = ORDER_TYPE === 'takeaway'
            ? {
                processing: '🎉 Pesananmu mulai diproses!',
                ready:      '🔔 Minumanmu siap diambil di toko!',
                completed:  '✅ Pesanan selesai. Terima kasih!',
                cancelled:  '❌ Pesanan dibatalkan.',
              }
            : {
                processing: '🎉 Pesananmu mulai diproses!',
                shipped:    '🚴 Kurir sedang menuju lokasimu!',
                completed:  '✅ Pesanan telah sampai!',
                cancelled:  '❌ Pesanan dibatalkan.',
              };

        const msg = messages[newStatus];
        if (!msg) return;

        showToast(msg, newStatus === 'cancelled' ? 'error' : 'success');

        if ('Notification' in window && Notification.permission === 'granted') {
            new Notification('ONE T.O Coffee', { body: msg, icon: '/favicon.ico' });
        }
    }

    // ── Indikator live ───────────────────────────────────────────
    function updateIndicator(isActive, text = null) {
        const dot    = document.querySelector('#live-indicator span:first-child');
        const textEl = document.getElementById('live-indicator-text');
        if (dot) {
            dot.className = isActive
                ? 'w-2 h-2 rounded-full bg-green-500 animate-pulse'
                : 'w-2 h-2 rounded-full bg-gray-400';
        }
        if (textEl) {
            textEl.textContent = text || `Diperbarui ${new Date().toLocaleTimeString('id-ID')}`;
        }
    }

    // ── Polling ──────────────────────────────────────────────────
    async function pollStatus() {
        if (isPolling) return;
        isPolling = true;
        try {
            const res  = await fetch(STATUS_URL, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            if (!res.ok) throw new Error('HTTP ' + res.status);
            const data = await res.json();
            updateTrackingUI(data);
            updateIndicator(true);
            pollCount++;
        } catch (err) {
            console.error('Polling error:', err);
            updateIndicator(false, '⚠ Koneksi terputus, mencoba lagi...');
        } finally {
            isPolling = false;
        }
        if (pollCount >= MAX_POLL) {
            stopPolling();
            updateIndicator(false, 'Pemantauan dihentikan (timeout)');
        }
    }

    function startPolling() { pollTimer = setInterval(pollStatus, POLL_INTERVAL); }
    function stopPolling()  { if (pollTimer) { clearInterval(pollTimer); pollTimer = null; } }

    // ── Init ─────────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', function () {
        if (currentStatus === 'completed' || currentStatus === 'cancelled') {
            updateIndicator(false, currentStatus === 'completed' ? '✅ Pesanan selesai' : '❌ Pesanan dibatalkan');
            return;
        }

        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }

        pollStatus();
        startPolling();

        document.addEventListener('visibilitychange', function () {
            if (document.hidden) {
                stopPolling();
            } else {
                pollStatus();
                startPolling();
            }
        });
    });
</script>
@endpush