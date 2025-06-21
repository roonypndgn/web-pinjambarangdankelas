<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title') | Admin Peminjaman Buku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    :root {
      --bg-color: #ffffff;
      --text-color: #333333;
      --hover-color: #e7f1ff;
      --primary-color: #0d6efd;
    }

    body.dark {
      --bg-color: #1e1e2f;
      --text-color: #ffffff;
      --hover-color: #2c2c3c;
      --primary-color: #66b2ff;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: var(--bg-color);
      color: var(--text-color);
      margin: 0;
      padding: 0;
      transition: all 0.3s ease;
    }

    .sidebar {
      height: 100vh;
      width: 250px;
      position: fixed;
      top: 0;
      left: 0;
      background-color: var(--bg-color);
      border-right: 1px solid #dee2e6;
      padding-top: 60px;
      transition: transform 0.3s ease, background-color 0.3s ease;
      z-index: 1050;
    }

    .sidebar.hidden {
      transform: translateX(-100%);
    }

    .sidebar a {
      color: var(--text-color);
      text-decoration: none;
      display: block;
      padding: 15px 25px;
      font-size: 1rem;
      transition: background 0.2s ease;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: var(--hover-color);
      color: var(--primary-color);
    }

    .sidebar h4 {
      text-align: center;
      font-weight: bold;
      margin-bottom: 2rem;
      color: var(--primary-color);
    }

    .main-content {
      margin-left: 250px;
      padding: 30px;
      transition: margin-left 0.3s ease;
    }

    .main-content.full {
      margin-left: 0;
    }

    .sidebar-toggle, .theme-toggle {
      background-color: transparent;
      border: none;
      font-size: 1.8rem;
      position: fixed;
      top: 15px;
      z-index: 1100;
      color: var(--primary-color);
      cursor: pointer;
    }

    .sidebar-toggle {
      left: 15px;
    }

    .theme-toggle {
      right: 15px;
    }

    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
      }

      .sidebar.show {
        transform: translateX(0);
      }

      .main-content {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>

  <!-- Tombol Toggle Sidebar -->
  <button class="sidebar-toggle" id="sidebarToggle" title="Buka/Tutup Menu">
    <i class="bi bi-list"></i>
  </button>

  <!-- Tombol Toggle Tema -->
  <button class="theme-toggle" id="themeToggle" title="Ganti Tema">
    <i class="bi bi-moon-fill" id="themeIcon"></i>
  </button>

  <!-- Sidebar -->
  <div class="sidebar hidden" id="sidebar">
    <h4><i class="bi bi-book-half"></i> Admin</h4>
    <a href="{{ route('admin.dashboard.admin') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <i class="bi bi-speedometer2"></i> Dashboard
    </a>
    <a href="{{ route('admin.kategori.index') }}" class="{{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
      <i class="bi bi-tags"></i> Kategori Barang
    </a>
    <a href="{{ route('admin.barang.index') }}" class="{{ request()->routeIs('admin.barang.*') ? 'active' : '' }}">
      <i class="bi bi-box-seam"></i> Barang
    </a>
    <a href="{{ route('admin.peminjaman.index') }}" class="{{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">
      <i class="bi bi-clipboard-check"></i> Peminjaman
    </a>
    <a href="{{ route('admin.pengembalian.index') }}" class="{{ request()->routeIs('admin.pengembalian.*') ? 'active' : '' }}">
      <i class="bi bi-arrow-counterclockwise"></i> Pengembalian
    </a>
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
      @csrf
      <button type="submit" class="btn btn-link text-decoration-none w-100 text-start" style="color: var(--text-color);">
        <i class="bi bi-box-arrow-right"></i> Logout
      </button>
    </form>
  </div>

  <!-- Main Content -->
  <div class="main-content full" id="mainContent">
    @yield('content')
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    const content = document.getElementById('mainContent');
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');

    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('hidden');
      content.classList.toggle('full');
    });

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
  </script>
</body>
</html>
