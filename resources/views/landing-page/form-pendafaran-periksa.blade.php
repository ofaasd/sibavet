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
        <!-- Pendaftaran Periksa Section -->
        <section id="pendaftaran-periksa" class="contact section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Pendaftaran Periksa</h2>
                <p>Silakan isi formulir pendaftaran pemeriksaan</p>
            </div>

            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-4 justify-content-center">
                    <div class="col-lg-10">
                        <form action="#" method="POST" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
                            @csrf

                            <!-- Header: User & Klinik -->
                            {{-- <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="user_id" class="form-label">User</label>
                                    <select id="user_id" name="user_id" class="form-select" required>
                                        <option value="" selected disabled>Pilih user</option>
                                        <option value="1">Admin</option>
                                        <option value="2">Resepsionis</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="nama_klinik" class="form-label">Nama Klinik</label>
                                    <input type="text" id="nama_klinik" name="nama_klinik" class="form-control" placeholder="Nama klinik" required>
                                </div>
                            </div> --}}

                            <!-- Data Pemilik -->
                            <h5 class="mb-3">Data Pemilik</h5>
                            <div class="row gy-3 mb-4">
                                <div class="col-md-6">
                                    <label for="pemilik_id" class="form-label">Pemilik</label>
                                    <select id="pemilik_id" name="pemilik_id" class="form-select" required>
                                        <option value="" selected disabled>Pilih pemilik</option>
                                        <option value="1">Budi</option>
                                        <option value="2">Siti</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <input type="text" id="alamat" name="alamat" class="form-control" placeholder="Alamat pemilik" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="telepon" class="form-label">Telepon</label>
                                    <input type="tel" id="telepon" name="telepon" class="form-control" placeholder="Nomor telepon" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="nomor_periksa" class="form-label">Nomor Periksa</label>
                                    <input type="text" id="nomor_periksa" name="nomor_periksa" class="form-control" placeholder="Nomor periksa" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="tanggal_periksa" class="form-label">Tanggal Periksa</label>
                                    <input type="date" id="tanggal_periksa" name="tanggal_periksa" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="pemeriksa_id" class="form-label">Pemeriksa</label>
                                    <select id="pemeriksa_id" name="pemeriksa_id" class="form-select" required>
                                        <option value="" selected disabled>Pilih pemeriksa</option>
                                        <option value="1">Dr. Ahmad</option>
                                        <option value="2">Dr. Lina</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="keluhan" class="form-label">Keluhan</label>
                                    <textarea id="keluhan" name="keluhan" class="form-control" rows="2" placeholder="Keluhan / catatan" required></textarea>
                                </div>
                            </div>

                            <!-- Data Pasien -->
                            <h5 class="mb-3">Data Pasien</h5>
                            <div class="row gy-3 mb-4">
                                <div class="col-md-6">
                                    <label for="nama_hewan_id" class="form-label">Nama Hewan</label>
                                    <select id="nama_hewan_id" name="nama_hewan_id" class="form-select" required>
                                        <option value="" selected disabled>Pilih nama hewan</option>
                                        <option value="1">Kucing - Milo</option>
                                        <option value="2">Anjing - Coco</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="no_rm" class="form-label">No. RM</label>
                                    <input type="text" id="no_rm" name="no_rm" class="form-control" placeholder="Nomor rekam medis" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="jenis_hewan" class="form-label">Jenis Hewan</label>
                                    <select id="jenis_hewan" name="jenis_hewan" class="form-select" required>
                                        <option value="" selected disabled>Pilih jenis</option>
                                        <option value="kucing">Kucing</option>
                                        <option value="anjing">Anjing</option>
                                        <option value="burung">Burung</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-select" required>
                                        <option value="" selected disabled>Pilih kelamin</option>
                                        <option value="jantan">Jantan</option>
                                        <option value="betina">Betina</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="umur" class="form-label">Umur (tahun)</label>
                                    <input type="number" id="umur" name="umur" class="form-control" min="0" placeholder="Umur" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-center">
                                    <div class="loading d-none">Loading</div>
                                    <div class="error-message"></div>
                                    <div class="sent-message d-none">Pendaftaran periksa berhasil. Terima kasih!</div>

                                    <button type="submit" class="btn btn-primary me-2">Daftar</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Pendaftaran Periksa Section -->
    </main>

    <footer id="footer" class="footer light-background">
        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-5 col-md-12 footer-about">
                    <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                        <span class="sitename">SIBAVET</span>
                    </a>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ea maiores esse molestiae laboriosam eaque eius iusto consectetur voluptatem neque libero nisi accusantium voluptas, vel dignissimos corrupti veritatis itaque reiciendis nostrum.</p>
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
