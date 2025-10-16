<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale() ?? 'en') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIBAVET - Pendaftaran Periksa</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Raleway:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">
            <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto">
                <h1 class="sitename">SIBAVET</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Beranda</a></li>
                    <li><a href="#tentang">Tentang Kami</a></li>
                    <li><a href="#layanan">Layanan</a></li>
                    <li><a href="#kontak">Kontak</a></li>
                    <li><a href="#">Masuk</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>
    </header>

    <main class="main">
        <!-- Halaman Antrian -->
        <section id="halaman-antrian" class="contact section min-vh-50 d-flex flex-column justify-content-center" style="min-height:60vh;">
            <div class="container section-title" data-aos="fade-up">
            <h2>Antrian Klinik</h2>
            <p>Lihat posisi antrian Anda dan status antrian saat ini</p>
            </div>

            <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4 justify-content-center">
            <div class="col-lg-8">
            <!-- Ringkasan Antrian -->
            <div class="card mb-4 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-6 text-center text-md-start">
                            <div class="p-3 bg-primary text-white rounded-3 d-inline-block" style="min-width:160px">
                                <div class="small">Nomor Antrian Anda</div>
                                <div id="user-queue" class="h1 mb-0">{{ $userQueue ?? '10' }}</div>
                            </div>

                            <div class="mt-3 text-muted small">
                                <div>Nama Dokter: <strong class="text-dark">{{ $clinicName ?? 'Klinik Utama' }}</strong></div>
                                <div>Nama Pemilik: <strong class="text-dark">{{ $ownerName ?? 'Faiz' }}</strong></div>
                            </div>
                        </div>

                        <div class="col-md-6 text-center text-md-end">
                            <div class="small text-muted">Sedang Dilayani</div>
                            <div id="current-queue" class="display-6 fw-bold">{{ $currentQueue ?? '5' }}</div>

                            <!-- Estimasi disembunyikan; elemen tetap ada (d-none) agar skrip tidak error -->
                            <span id="estimated-wait" class="d-none">{{ $estimatedWait ?? '' }}</span>

                            <div class="mt-3 d-flex justify-content-center justify-content-md-end">
                                <div style="width:220px">
                                    <div class="d-flex justify-content-between small text-muted mb-1">
                                        <span>Posisi Anda</span>
                                        <span id="position-text">—</span>
                                    </div>
                                    <div class="progress" style="height:8px; background:linear-gradient(90deg,#e9f7ef,#fff); border-radius:8px;">
                                        <div id="queue-progress" class="progress-bar" role="progressbar" style="width:0%; background:linear-gradient(90deg,#28a745,#20c997);" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ambil Nomor & QR -->
            {{-- <div class="card mb-4">
                <div class="card-body">
                <div class="row gy-3 align-items-center">
                <div class="col-md-6 text-center text-md-start">
                <form id="ambil-antrian-form" action="#" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->id() ?? '' }}">
                    <button type="submit" class="btn btn-success me-2">Ambil Nomor Antrian</button>
                    <button type="button" id="copy-btn" class="btn btn-outline-secondary">Salin Nomor</button>
                </form>

                <p class="mt-2 text-muted small">Atau refresh untuk memperbarui status antrian.</p>
                </div>

                <div class="col-md-6 text-center">
                <div id="qr-placeholder" style="display:inline-block; padding:10px; border:1px solid #eee; border-radius:6px;">
                    <!-- Simple QR placeholder (server can inject QR image URL) -->
                    @if(!empty($ticketQrUrl))
                    <img src="{{ $ticketQrUrl }}" alt="QR Tiket" style="max-width:120px;">
                    @else
                    <div style="width:120px;height:120px;display:flex;align-items:center;justify-content:center;color:#999;">
                    QR
                    </div>
                    @endif
                </div>
                </div>
                </div>
                </div>
            </div> --}}

            <!-- Daftar Antrian Terbaru -->
            {{-- <div class="card">
                <div class="card-body">
                <h6 class="mb-3">Daftar Antrian (terbaru)</h6>
                <div id="recent-list" class="list-group">
                @if(!empty($recentQueues) && count($recentQueues))
                @foreach($recentQueues as $q)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                    <strong>{{ $q['number'] }}</strong> — {{ $q['owner'] ?? 'Pemilik' }}
                    <div class="text-muted small">{{ $q['time'] ?? '24' }}</div>
                    </div>
                    <span class="badge bg-{{ $q['number'] == ($currentQueue ?? null) ? 'primary' : 'light' }}">
                    {{ $q['status'] ?? 'menunggu' }}
                    </span>
                    </div>
                @endforeach
                @else
                <div class="list-group-item text-center text-muted">Belum ada data antrian</div>
                @endif
                </div>
                </div>
            </div> --}}

            </div>
            </div>
            </div>

            <!-- Client-side polling & helpers -->
            <script>
            (function () {
            const userQueueEl = document.getElementById('user-queue');
            const currentQueueEl = document.getElementById('current-queue');
            const estimatedWaitEl = document.getElementById('estimated-wait');
            const progressEl = document.getElementById('queue-progress');
            const positionText = document.getElementById('position-text');
            const recentList = document.getElementById('recent-list');

            const refreshBtn = document.getElementById('refresh-btn');
            const printBtn = document.getElementById('print-btn');
            const copyBtn = document.getElementById('copy-btn');

            async function fetchStatus() {
            try {
                const res = await fetch('{{ url('/antrian/status') }}', { cache: 'no-store' });
                if (!res.ok) throw new Error('Network response was not ok');
                const data = await res.json();

                // expected data: { current: 5, user_queue: 12, last: 25, estimated_wait: '00:20', recent: [...] }
                const current = data.current ?? null;
                const userQueue = data.user_queue ?? null;
                const last = data.last ?? null;
                const estimated = data.estimated_wait ?? '—';
                const recent = data.recent ?? [];

                currentQueueEl.textContent = current ?? '-';
                userQueueEl.textContent = userQueue ?? '-';
                estimatedWaitEl.textContent = estimated;

                // position & progress calculation
                let positionTextVal = '—';
                let progressPct = 67;
                if (userQueue && current) {
                const position = Math.max(0, userQueue - current);
                positionTextVal = position === 0 ? 'Sedang dipanggil' : position + ' orang lagi';
                if (last && last > current) {
                progressPct = Math.min(100, ((userQueue - current) / (last - current)) * 100);
                } else {
                progressPct = position === 0 ? 100 : 10;
                }
                }
                positionText.textContent = positionTextVal;
                progressEl.style.width = progressPct + '%';
                progressEl.setAttribute('aria-valuenow', Math.round(progressPct));

                // rebuild recent list
                if (recentList && Array.isArray(recent)) {
                recentList.innerHTML = recent.map(q => {
                const active = q.number == current ? 'bg-primary text-white' : 'bg-light';
                const status = q.number == current ? 'sedang' : (q.status || 'menunggu');
                return `<div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                    <strong>${q.number}</strong> — ${q.owner ?? 'Pemilik'}
                    <div class="text-muted small">${q.time ?? ''}</div>
                    </div>
                    <span class="badge ${active}">${status}</span>
                    </div>`;
                }).join('');
                }
            } catch (err) {
                console.error('Gagal mengambil status antrian', err);
            }
            }

            // initial fetch + interval polling
            fetchStatus();
            const poll = setInterval(fetchStatus, 5000);

            // UI actions
            refreshBtn && refreshBtn.addEventListener('click', fetchStatus);
            printBtn && printBtn.addEventListener('click', function () {
            window.print();
            });
            copyBtn && copyBtn.addEventListener('click', function () {
            const text = userQueueEl.textContent || '';
            if (!text || text === '-') return;
            navigator.clipboard?.writeText(text).then(() => {
                alert('Nomor antrian disalin: ' + text);
            }).catch(() => {
                alert('Gagal menyalin nomor antrian.');
            });
            });
            })();
            </script>
        </section>
        <!-- End Halaman Antrian -->
    </main>

    <footer id="footer" class="footer light-background">
        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-5 col-md-12 footer-about">
                    <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                        <span class="sitename">SIBAVET</span>
                    </a>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illo nulla non quisquam deserunt tempore omnis sit quo sequi, necessitatibus inventore sunt voluptas adipisci expedita eaque rerum repellat modi commodi provident!</p>
                    <div class="social-links d-flex mt-4">
                        <a href="#"><i class="bi bi-twitter-x"></i></a>
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-6 footer-links">
                    <h4>Link Berguna</h4>
                    <ul>
                        <li><a href="#beranda">Beranda</a></li>
                        <li><a href="#tentang">Tentang Kami</a></li>
                        <li><a href="#layanan">Layanan</a></li>
                        {{-- <li><a href="#">Terms of service</a></li> --}}
                        {{-- <li><a href="#">Privacy policy</a></li> --}}
                    </ul>
                </div>

                <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                    <h4>Kontak Kami</h4>
                    <p>A108 Adam Street</p>
                    <p>New York, NY 535022</p>
                    <p>United States</p>
                    <p class="mt-4"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
                    <p><strong>Email:</strong> <span>info@example.com</span></p>
                </div>
            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <strong class="px-1 sitename">SIBAVET</strong> All Rights Reserved</p>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
