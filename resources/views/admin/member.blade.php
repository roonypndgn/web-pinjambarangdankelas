<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Member - Sistem Peminjaman Barang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
    }

    .navbar {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      background: linear-gradient(90deg, #0d6efd, #6610f2);
    }

    .navbar-brand, .nav-link, .navbar-toggler {
      color: #fff !important;
    }

    .nav-link:hover {
      color: #ffd700 !important;
    }

    .hero-section {
      padding: 80px 20px;
      background-color: #f8f9fa;
      text-align: center;
    }

    .hero-section h1 {
      font-weight: bold;
      color: #343a40;
    }

    .hero-section p {
      font-size: 1.1rem;
      color: #6c757d;
    }

    .card-custom {
      border: none;
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }

    .card-custom:hover {
      transform: translateY(-5px);
    }

    footer {
      background-color: #0d6efd;
      color: #fff;
      text-align: center;
      padding: 20px 0;
      margin-top: 60px;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
      <a class="navbar-brand" href="#"><i class="bi bi-person-circle"></i> Member</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="bi bi-list"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="#">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Peminjaman</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Riwayat</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Profil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-warning" href="/logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="container">
      <h1>Selamat Datang, Anggota!</h1>
      <p>Akses peminjaman barang dengan mudah dan cepat melalui portal ini.</p>
    </div>
  </section>

  <!-- Card Section -->
  <div class="container my-5">
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card card-custom p-4 text-center">
          <i class="bi bi-book fs-2 text-primary mb-2"></i>
          <h5>Barang Tersedia</h5>
          <p class="text-muted">Lihat koleksi barang yang bisa dipinjam.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-custom p-4 text-center">
          <i class="bi bi-clock-history fs-2 text-success mb-2"></i>
          <h5>Riwayat Peminjaman</h5>
          <p class="text-muted">Lihat data peminjaman dan pengembalian kamu.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-custom p-4 text-center">
          <i class="bi bi-person-lines-fill fs-2 text-danger mb-2"></i>
          <h5>Profil</h5>
          <p class="text-muted">Kelola informasi akunmu dengan mudah.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <div class="container">
      <small>&copy; 2025 pinjamFIKOM | Universitas Methodist Indonesia</small>
    </div>
  </footer>

  <!-- Script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
