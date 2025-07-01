<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title') | Member Peminjaman Barang</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo-umi.jpg') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

  <style>
    :root {
      --bg-color: #f8f9fa;
      --text-color: #2d3748;
      --hover-color: #e2e8f0;
      --primary-color: #3b82f6;
      --secondary-color: #10b981;
      --navbar-color: #ffffff;
      --card-bg: #ffffff;
      --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    body.dark {
      --bg-color: #1a202c;
      --text-color: #f7fafc;
      --hover-color: #2d3748;
      --primary-color: #63b3ed;
      --secondary-color: #68d391;
      --navbar-color: #2d3748;
      --card-bg: #2d3748;
      --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2);
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      background-color: var(--bg-color);
      color: var(--text-color);
      margin: 0;
      padding: 0;
      transition: all 0.3s ease;
      min-height: 100vh;
    }

    /* Navbar */
    .navbar {
      background-color: var(--navbar-color);
      box-shadow: var(--shadow);
      padding: 0.5rem 1rem;
      transition: all 0.3s ease;
    }

    .navbar-brand {
      font-weight: 700;
      color: var(--primary-color) !important;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .navbar-brand img {
      height: 32px;
      width: auto;
      transition: transform 0.3s ease;
    }

    .navbar-brand:hover img {
      transform: rotate(-10deg);
    }

    .nav-link {
      color: var(--text-color) !important;
      padding: 0.5rem 1rem;
      margin: 0 0.2rem;
      border-radius: 8px;
      transition: all 0.2s ease;
      font-weight: 500;
      position: relative;
    }

    .nav-link:hover,
    .nav-link.active {
      background-color: var(--hover-color);
      color: var(--primary-color) !important;
    }

    .nav-link.active::after {
      content: '';
      position: absolute;
      bottom: -8px;
      left: 50%;
      transform: translateX(-50%);
      width: 20px;
      height: 3px;
      background-color: var(--primary-color);
      border-radius: 3px;
    }

    /* Main Content */
    .main-content {
      padding: 2rem;
      margin-top: 70px;
      min-height: calc(100vh - 70px);
    }

    /* Theme Toggle */
    .theme-toggle {
      background-color: transparent;
      border: none;
      font-size: 1.3rem;
      color: var(--primary-color);
      cursor: pointer;
      margin-left: 10px;
      transition: transform 0.3s ease;
    }

    .theme-toggle:hover {
      transform: rotate(30deg);
    }

    /* Dropdown Menu */
    .dropdown-menu {
      background-color: var(--navbar-color);
      border: none;
      box-shadow: var(--shadow);
      margin-top: 0.5rem;
    }

    .dropdown-item {
      color: var(--text-color) !important;
      padding: 0.5rem 1rem;
      transition: all 0.2s ease;
    }

    .dropdown-item:hover {
      background-color: var(--hover-color);
      color: var(--primary-color) !important;
    }

    /* Badge Notification */
    .badge-notif {
      position: absolute;
      top: -5px;
      right: -5px;
      font-size: 0.6rem;
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.2); }
      100% { transform: scale(1); }
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
      .navbar-collapse {
        background-color: var(--navbar-color);
        padding: 1rem;
        border-radius: 0 0 10px 10px;
        box-shadow: var(--shadow);
        margin-top: 0.5rem;
      }

      .nav-link {
        margin: 0.2rem 0;
      }

      .nav-link.active::after {
        display: none;
      }
    }

    @media (max-width: 768px) {
      .main-content {
        padding: 1.5rem;
      }
    }

    @media (max-width: 576px) {
      .main-content {
        padding: 1rem;
      }

      .navbar-brand span {
        display: none;
      }
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="https://admin.methodist.ac.id/cdn/Image/LOGO/komputer.png" alt="Logo">
        <span>pinjamFikom</span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-expanded="false">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a href="{{ route('member.dashboard.index') }}" class="nav-link">
              <i class="bi bi-speedometer2 me-1"></i> Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('member.barang.index') }}" class="nav-link">
              <i class="bi bi-box-seam me-1"></i> Katalog Barang
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('member.peminjaman.index') }}">
              <i class="bi bi-clipboard-check me-1"></i> Peminjaman
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('member.pengembalian.index') }}">
              <i class="bi bi-arrow-counterclockwise me-1"></i> Pengembalian
            </a>
          </li>
        </ul>

        <ul class="navbar-nav">
          <!-- Notifikasi -->
          

          <!-- Profil -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
                <div class="me-2 d-none d-sm-inline">{{ Auth::user()->nama }}</div>
                @if(Auth::user()->foto)
                    <img src="{{ asset('storage/' . Auth::user()->foto) }}" class="rounded-circle" width="32" height="32" style="object-fit:cover;" alt="Foto Profil">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->nama) }}" class="rounded-circle shadow" width="32" height="32" style="object-fit: cover;" alt="Default Avatar">
                @endif
            </a>
            <ul class="dropdown-menu dropdown-menu-end animate__animated animate__fadeIn">
              <li><a class="dropdown-item" href="{{ route('member.dashboard.profile') }}"><i class="bi bi-person me-2"></i> Profil</a></li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form action="{{ route('logout') }}" method="POST">
                  @csrf
                  <button type="submit" class="dropdown-item text-danger">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                  </button>
                </form>
              </li>
            </ul>
          </li>

          <!-- Toggle Tema -->
          <li class="nav-item">
            <button class="theme-toggle" id="themeToggle" title="Ganti Tema">
              <i class="bi bi-moon-fill" id="themeIcon"></i>
            </button>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="main-content" id="mainContent">
    @yield('content')
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Theme Toggle
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');

    // Check for saved theme preference
    if (localStorage.getItem('theme') === 'dark') {
      document.body.classList.add('dark');
      themeIcon.classList.remove('bi-moon-fill');
      themeIcon.classList.add('bi-sun-fill');
    }

    themeToggle.addEventListener('click', () => {
      document.body.classList.toggle('dark');

      // Save user preference
      if (document.body.classList.contains('dark')) {
        localStorage.setItem('theme', 'dark');
        themeIcon.classList.remove('bi-moon-fill');
        themeIcon.classList.add('bi-sun-fill');
      } else {
        localStorage.setItem('theme', 'light');
        themeIcon.classList.remove('bi-sun-fill');
        themeIcon.classList.add('bi-moon-fill');
      }
    });

    // Mobile menu close when clicking outside
    document.addEventListener('click', function(event) {
      const navbarCollapse = document.querySelector('.navbar-collapse');
      const navbarToggler = document.querySelector('.navbar-toggler');

      if (navbarCollapse.classList.contains('show') &&
          !event.target.closest('.navbar-collapse') &&
          !event.target.closest('.navbar-toggler')) {
        navbarToggler.click();
      }
    });
  </script>
</body>
</html>
