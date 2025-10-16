<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Register - SIBAVET</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">SIBAVET</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Beranda<br></a></li>
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

    <!-- Registration Section -->
    <section id="register" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Pendaftaran</h2>
        <p>Silakan isi formulir pendaftaran berikut</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4 justify-content-center">
          <div class="col-lg-10">
            <form action="#" method="POST" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
              @csrf

              <div class="row gy-4">
                <div class="col-md-6">
                  <label for="kode" class="form-label">Kode</label>
                  <input type="text" id="kode" name="kode" class="form-control" placeholder="Kode" required>
                </div>

                <div class="col-md-6">
                  <label for="nama" class="form-label">Nama</label>
                  <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama lengkap" required>
                </div>

                <div class="col-md-12">
                  <label for="alamat" class="form-label">Alamat</label>
                  <input type="text" id="alamat" name="alamat" class="form-control" placeholder="Alamat" required>
                </div>

                <div class="col-md-6">
                  <label for="telepon" class="form-label">Telepon</label>
                  <input type="tel" id="telepon" name="telepon" class="form-control" placeholder="Nomor telepon" required>
                </div>

                <div class="col-md-6">
                  <label for="nomor_ktp" class="form-label">Nomor KTP</label>
                  <input type="text" id="nomor_ktp" name="nomor_ktp" class="form-control" placeholder="Nomor KTP" required>
                </div>

                <div class="col-md-6">
                  <label for="nama_hewan" class="form-label">Nama Hewan</label>
                  <input type="text" id="nama_hewan" name="nama_hewan" class="form-control" placeholder="Nama hewan" required>
                </div>

                <div class="col-md-3">
                  <label for="jenis_hewan" class="form-label">Jenis Hewan</label>
                  <select id="jenis_hewan" name="jenis_hewan" class="form-select" required>
                    <option value="" selected disabled>Pilih jenis</option>
                    <option value="kucing">Kucing</option>
                    <option value="anjing">Anjing</option>
                    <option value="burung">Burung</option>
                    <option value="lainnya">Lainnya</option>
                  </select>
                </div>

                <div class="col-md-3">
                  <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                  <select id="jenis_kelamin" name="jenis_kelamin" class="form-select" required>
                    <option value="" selected disabled>Pilih kelamin</option>
                    <option value="jantan">Jantan</option>
                    <option value="betina">Betina</option>
                  </select>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading d-none">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message d-none">Pendaftaran berhasil. Terima kasih!</div>

                  <button type="submit" class="btn btn-primary">Daftar</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

    </section><!-- /Registration Section -->

  </main>

  <footer id="footer" class="footer light-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-5 col-md-12 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">SIBAVET</span>
          </a>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Et quasi dolorem molestiae maiores illo, cum repellendus! Vitae officiis rem officia? Excepturi, quis! Atque nobis molestiae dignissimos alias consequatur amet ad.</p>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-6 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Terms of service</a></li>
            <li><a href="#">Privacy policy</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-6 footer-links">
          <h4>Our Services</h4>
          <ul>
            <li><a href="#">Web Design</a></li>
            <li><a href="#">Web Development</a></li>
            <li><a href="#">Product Management</a></li>
            <li><a href="#">Marketing</a></li>
            <li><a href="#">Graphic Design</a></li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
          <h4>Contact Us</h4>
          <p>A108 Adam Street</p>
          <p>New York, NY 535022</p>
          <p>United States</p>
          <p class="mt-4"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
          <p><strong>Email:</strong> <span>info@example.com</span></p>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">SIBAVET</strong> <span>All Rights Reserved</span></p>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>