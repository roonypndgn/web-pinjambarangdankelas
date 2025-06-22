<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>pinjamFikom - Sistem Peminjaman Barang Fakultas Ilmu Komputer</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg-color: #ffffff;
      --text-color: #333333;
      --hover-color: #e7f1ff;
      --primary-color: #0d6efd;
      --secondary-color: #6c757d;
    }

    body.dark {
      --bg-color: #1e1e2f;
      --text-color: #ffffff;
      --hover-color: #2c2c3c;
      --primary-color: #66b2ff;
      --secondary-color: #adb5bd;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: var(--bg-color);
      color: var(--text-color);
      transition: all 0.3s ease;
    }

    .navbar {
      background-color: var(--bg-color);
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .navbar-brand {
      font-weight: 700;
      color: var(--primary-color);
      font-size: 1.5rem;
      display: flex;
      align-items: center;
    }

    .navbar-brand img {
      height: 40px;
      margin-right: 10px;
    }

    .navbar-brand span {
      color: var(--text-color);
    }

    .nav-link {
      color: var(--text-color);
      font-weight: 500;
      transition: color 0.3s;
    }

    .nav-link:hover {
      color: var(--primary-color);
    }

    .btn-primary {
      background-color: var(--primary-color);
      border: none;
      padding: 10px 20px;
      font-weight: 500;
      transition: all 0.3s;
    }

    .btn-primary:hover {
      background-color: #0b5ed7;
      transform: translateY(-2px);
    }

    .btn-outline-primary {
      color: var(--primary-color);
      border-color: var(--primary-color);
    }

    .btn-outline-primary:hover {
      background-color: var(--primary-color);
      color: white;
    }

    .hero-section {
      min-height: 90vh;
      display: flex;
      align-items: center;
      background-color: var(--bg-color);
      position: relative;
      overflow: hidden;
    }

    .hero-content h1 {
      font-weight: 700;
      font-size: 3rem;
      margin-bottom: 1.5rem;
    }

    .hero-content p {
      font-size: 1.2rem;
      color: var(--secondary-color);
      margin-bottom: 2rem;
    }

    .hero-image {
      max-width: 100%;
      height: auto;
      border-radius: 10px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .features-section {
      padding: 80px 0;
      background-color: rgba(13, 110, 253, 0.03);
    }

    .section-title {
      font-weight: 700;
      color: var(--text-color);
      margin-bottom: 1rem;
    }

    .section-subtitle {
      color: var(--secondary-color);
      margin-bottom: 3rem;
    }

    .feature-card {
      background-color: var(--bg-color);
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      transition: all 0.3s;
      height: 100%;
      border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .feature-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .feature-icon {
      font-size: 2.5rem;
      color: var(--primary-color);
      margin-bottom: 20px;
    }

    .feature-title {
      font-weight: 600;
      margin-bottom: 15px;
    }

    .feature-desc {
      color: var(--secondary-color);
    }

    .how-it-works {
      padding: 80px 0;
      background-color: var(--bg-color);
    }

    .step-card {
      position: relative;
      padding-left: 80px;
      margin-bottom: 40px;
    }

    .step-number {
      position: absolute;
      left: 0;
      top: 0;
      width: 60px;
      height: 60px;
      background-color: var(--primary-color);
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 1.5rem;
    }

    .testimonials {
      padding: 80px 0;
      background-color: rgba(13, 110, 253, 0.03);
    }

    .testimonial-card {
      background-color: var(--bg-color);
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .testimonial-text {
      font-style: italic;
      color: var(--secondary-color);
      margin-bottom: 20px;
    }

    .user-info {
      display: flex;
      align-items: center;
    }

    .user-avatar {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 15px;
    }

    .user-name {
      font-weight: 600;
      margin-bottom: 0;
    }

    .user-role {
      color: var(--secondary-color);
      font-size: 0.9rem;
    }

    .cta-section {
      padding: 80px 0;
      background-color: var(--primary-color);
      color: white;
      text-align: center;
    }

    .cta-title {
      font-weight: 700;
      margin-bottom: 1.5rem;
    }

    .cta-subtitle {
      opacity: 0.9;
      margin-bottom: 3rem;
      font-size: 1.1rem;
    }

    .btn-light {
      background-color: white;
      color: var(--primary-color);
      border-radius: 50px;
      padding: 12px 30px;
      font-weight: 600;
    }

    footer {
      background-color: var(--bg-color);
      color: var(--text-color);
      padding: 60px 0 30px;
      border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    .footer-logo {
      display: flex;
      align-items: center;
      font-weight: 700;
      font-size: 1.5rem;
      color: var(--primary-color);
      margin-bottom: 20px;
    }

    .footer-logo img {
      height: 40px;
      margin-right: 10px;
    }

    .footer-links h5 {
      font-weight: 600;
      margin-bottom: 20px;
    }

    .footer-links ul {
      list-style: none;
      padding-left: 0;
    }

    .footer-links li {
      margin-bottom: 10px;
    }

    .footer-links a {
      color: var(--secondary-color);
      text-decoration: none;
      transition: color 0.3s;
    }

    .footer-links a:hover {
      color: var(--primary-color);
    }

    .social-icons a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      background-color: rgba(13, 110, 253, 0.1);
      border-radius: 50%;
      color: var(--primary-color);
      margin-right: 10px;
      transition: all 0.3s;
    }

    .social-icons a:hover {
      background-color: var(--primary-color);
      color: white;
    }

    .copyright {
      border-top: 1px solid rgba(0, 0, 0, 0.1);
      padding-top: 30px;
      margin-top: 50px;
      color: var(--secondary-color);
      font-size: 0.9rem;
    }

    .theme-toggle {
      background-color: transparent;
      border: none;
      font-size: 1.5rem;
      color: var(--primary-color);
      cursor: pointer;
      position: absolute;
      top: 20px;
      right: 20px;
      z-index: 1000;
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
      .hero-content h1 {
        font-size: 2.5rem;
      }
    }

    @media (max-width: 768px) {
      .hero-content h1 {
        font-size: 2rem;
      }
      
      .hero-content p {
        font-size: 1rem;
      }
      
      .section-title {
        font-size: 1.8rem;
      }
    }
  </style>
</head>
<body>
  <!-- Theme Toggle -->
  <button class="theme-toggle" id="themeToggle" title="Ganti Tema">
    <i class="bi bi-moon-fill" id="themeIcon"></i>
  </button>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="https://admin.methodist.ac.id/cdn/Image/LOGO/komputer.png" alt="Logo UMI Fikom">
        <span>pinjamFikom</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="#features">Fitur</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#how-it-works">Cara Kerja</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#testimonials">Testimoni</a>
          </li>
          <li class="nav-item ms-lg-2">
            <a class="btn btn-primary" href="{{ route('login') }}">Masuk</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <div class="hero-content">
            <h1>Pinjam Barang Fikom Lebih Mudah</h1>
            <p>Sistem peminjaman barang digital Fakultas Ilmu Komputer UMI. Proses cepat, praktis, dan efisien untuk semua kebutuhan akademik Anda.</p>
            <div class="d-flex gap-3">
              <a href="{{ route('login') }}" class="btn btn-primary">Mulai Sekarang</a>
              <a href="#how-it-works" class="btn btn-outline-primary">Pelajari Lebih Lanjut</a>
            </div>
          </div>
        </div>
        <div class="col-lg-6 d-none d-lg-block">
          <img src="https://admin.methodist.ac.id/cdn/Image/fakultas/fik.jpg" alt="Hero Illustration" class="hero-image">
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="features-section" id="features">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="section-title">Fitur Unggulan</h2>
        <p class="section-subtitle">Kemudahan dalam setiap langkah peminjaman barang</p>
      </div>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-lightning-charge"></i>
            </div>
            <h4 class="feature-title">Proses Cepat</h4>
            <p class="feature-desc">Peminjaman barang disetujui dalam hitungan menit tanpa antri panjang.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-phone"></i>
            </div>
            <h4 class="feature-title">Akses Mobile</h4>
            <p class="feature-desc">Bisa diakses dari smartphone kapan saja dan di mana saja.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-bell"></i>
            </div>
            <h4 class="feature-title">Notifikasi Real-time</h4>
            <p class="feature-desc">Dapatkan pemberitahuan langsung status peminjaman Anda.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- How It Works Section -->
  <section class="how-it-works" id="how-it-works">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-5">
          <h2 class="section-title">Cara Meminjam Barang</h2>
          <p class="section-subtitle">Hanya butuh 3 langkah mudah untuk meminjam barang yang Anda butuhkan</p>
          <img src="" alt="Illustration" class="img-fluid d-none d-lg-block">
        </div>
        <div class="col-lg-7">
          <div class="step-card">
            <div class="step-number">1</div>
            <h4>Login ke Sistem</h4>
            <p>Gunakan akun mahasiswa Anda untuk masuk ke sistem pinjamFikom.</p>
          </div>
          <div class="step-card">
            <div class="step-number">2</div>
            <h4>Pilih Barang</h4>
            <p>Cari dan pilih barang yang ingin Anda pinjam dari katalog kami.</p>
          </div>
          <div class="step-card">
            <div class="step-number">3</div>
            <h4>Konfirmasi Peminjaman</h4>
            <p>Isi form peminjaman dan tunggu konfirmasi dari admin.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials Section -->
  <section class="testimonials" id="testimonials">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="section-title">Apa Kata Mereka?</h2>
        <p class="section-subtitle">Testimoni dari pengguna pinjamFikom</p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="testimonial-card">
            <p class="testimonial-text">"Sangat memudahkan untuk meminjam proyektor saat presentasi. Tidak perlu lagi mengisi form manual."</p>
            <div class="user-info">
              <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MDAiIGhlaWdodD0iNTAwIiB2aWV3Qm94PSIwIDAgMjQgMjQiIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzBkNmVmZCIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiPjxjaXJjbGUgY3g9IjEyIiBjeT0iMTIiIHI9IjEwIi8+PHBhdGggZD0iTTEyIDE2di0yIi8+PHBhdGggZD0iTTEyIDhoLjAxIi8+PC9zdmc+" alt="User" class="user-avatar">
              <div>
                <h6 class="user-name">Ronny Hartono Pandiangan</h6>
                <p class="user-role">Mahasiswa Sistem Informasi</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="testimonial-card">
            <p class="testimonial-text">"Sistemnya sangat user friendly. Proses peminjaman laptop untuk praktikum jadi lebih efisien."</p>
            <div class="user-info">
              <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MDAiIGhlaWdodD0iNTAwIiB2aWV3Qm94PSIwIDAgMjQgMjQiIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzBkNmVmZCIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiPjxjaXJjbGUgY3g9IjEyIiBjeT0iMTIiIHI9IjEwIi8+PHBhdGggZD0iTTEyIDE2di0yIi8+PHBhdGggZD0iTTEyIDhoLjAxIi8+PC9zdmc+" alt="User" class="user-avatar">
              <div>
                <h6 class="user-name">Jetli Rikardo Manik</h6>
                <p class="user-role">Mahasiswa Sistem Informasi</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="testimonial-card">
            <p class="testimonial-text">"Notifikasi pengembalian sangat membantu. Tidak ada lagi denda karena lupa mengembalikan barang."</p>
            <div class="user-info">
              <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MDAiIGhlaWdodD0iNTAwIiB2aWV3Qm94PSIwIDAgMjQgMjQiIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzBkNmVmZCIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiPjxjaXJjbGUgY3g9IjEyIiBjeT0iMTIiIHI9IjEwIi8+PHBhdGggZD0iTTEyIDE2di0yIi8+PHBhdGggZD0iTTEyIDhoLjAxIi8+PC9zdmc+" alt="User" class="user-avatar">
              <div>
                <h6 class="user-name">Afri Domeniko Tarigan</h6>
                <p class="user-role">Mahasiswa Sistem Informasi</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="cta-section">
    <div class="container">
      <h2 class="cta-title">Siap Meminjam Barang dan Ruangan Kelas dengan Cara yang Lebih Mudah?</h2>
      <p class="cta-subtitle">pinjamFikom menjadi solusi kemudahan anda</p>
      <a href="{{ route('login') }}" class="btn btn-light">Rasakan Sekarang</a>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-4 mb-5 mb-lg-0">
          <div class="footer-logo">
            <img src="https://admin.methodist.ac.id/cdn/Image/LOGO/komputer.png" alt="Logo UMI Fikom">
            <span>pinjamFikom</span>
          </div>
          <p>Sistem peminjaman barang digital Fakultas Ilmu Komputer UMI. Dirancang untuk memudahkan proses peminjaman barang akademik.</p>
          <div class="social-icons mt-4">
            <a href="#"><i class="bi bi-instagram"></i></a>
            <a href="#"><i class="bi bi-twitter"></i></a>
            <a href="#"><i class="bi bi-facebook"></i></a>
          </div>
        </div>
        <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
          <div class="footer-links">
            <h5>Menu</h5>
            <ul>
              <li><a href="#">Beranda</a></li>
              <li><a href="#features">Fitur</a></li>
              <li><a href="#how-it-works">Cara Kerja</a></li>
              <li><a href="#testimonials">Testimoni</a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
          <div class="footer-links">
            <h5>Layanan</h5>
            <ul>
              <li><a href="{{ route('login') }}">Peminjaman Barang</a></li>
              <li><a href="{{ route('login') }}">Daftar Barang</a></li>
              <li><a href="{{ route('login') }}">Status Peminjaman</a></li>
              
            </ul>
          </div>
        </div>
        <div class="col-lg-4 col-md-4">
          <div class="footer-links">
            <h5>Kontak</h5>
            <ul>
              <li><i class="bi bi-geo-alt me-2"></i> Fakultas Ilmu Komputer, Universitas Methodist Indonesia</li>
              <li><i class="bi bi-telephone me-2"></i> (061) 4536735</li>
              <li><i class="bi bi-envelope me-2"></i> info@pinjamfikom.ac.id</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="copyright text-center">
        <p>&copy; 2025 pinjamFikom. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Theme toggle functionality
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');

    themeToggle.addEventListener('click', () => {
      document.body.classList.toggle('dark');
      if (document.body.classList.contains('dark')) {
        themeIcon.classList.remove('bi-moon-fill');
        themeIcon.classList.add('bi-sun-fill');
      } else {
        themeIcon.classList.remove('bi-sun-fill');
        themeIcon.classList.add('bi-moon-fill');
      }
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        
        document.querySelector(this.getAttribute('href')).scrollIntoView({
          behavior: 'smooth'
        });
      });
    });
  </script>
</body>
</html>