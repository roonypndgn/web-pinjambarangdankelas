<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title') | Admin Peminjaman Buku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f9fa;
    }

    .sidebar {
      height: 100vh;
      width: 250px;
      position: fixed;
      top: 0;
      left: 0;
      background: linear-gradient(180deg, #0d6efd, #0a58ca);
      color: white;
      padding-top: 60px;
      z-index: 1000;
    }

    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      padding: 15px 25px;
      font-size: 1rem;
    }

    .sidebar a:hover {
      background-color: rgba(255, 255, 255, 0.1);
      border-left: 4px solid #fff;
    }

    .sidebar a.active {
      background-color: rgba(255, 255, 255, 0.2);
      border-left: 4px solid #fff;
    }

    .sidebar h4 {
      text-align: center;
      font-weight: bold;
      margin-bottom: 2rem;
    }

    .main-content {
      margin-left: 250px;
      padding: 30px;
    }

    .card-custom {
      border: none;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }

    .card-custom:hover {
      transform: translateY(-3px);
    }

    .card-icon {
      font-size: 2.5rem;
      color: #0d6efd;
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 100%;
        height: auto;
        position: relative;
      }

      .main-content {
        margin-left: 0;
      }
    }
  </style>
  @stack('styles')
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h4><i class="bi bi-book-half"></i> Admin</h4>
    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <i class="bi bi-speedometer2"></i> Dashboard
    </a>
    <a href="{{ route('kategori.index') }}" class="{{ request()->routeIs('kategori.*') ? 'active' : '' }}">
      <i class="bi bi-tags"></i> Kategori Barang
    </a>
    <a href="{{ route('barang.index') }}" class="{{ request()->routeIs('barang.*') ? 'active' : '' }}">
      <i class="bi bi-box-seam"></i> Barang
    </a>
    <a href="{{ route('peminjaman.index') }}" class="{{ request()->routeIs('peminjaman.*') ? 'active' : '' }}">
      <i class="bi bi-clipboard-check"></i> Peminjaman
    </a>
    <a href="{{ route('pengembalian.index') }}" class="{{ request()->routeIs('pengembalian.*') ? 'active' : '' }}">
      <i class="bi bi-arrow-counterclockwise"></i> Pengembalian
    </a>
    
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
      @csrf
      <button type="submit" class="btn btn-link text-white text-decoration-none w-100 text-start">
        <i class="bi bi-box-arrow-right"></i> Logout
      </button>
    </form>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    @yield('content')
  </div>

  <!-- Script Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>