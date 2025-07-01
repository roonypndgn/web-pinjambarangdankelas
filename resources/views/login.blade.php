<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - pinjamFikom</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-umi.jpg') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary-color: #0d6efd;
      --secondary-color: #00b4d8;
      --dark-color: #1e1e2f;
      --light-color: #f8f9fa;
      --text-color: #333333;
      --text-light: #6c757d;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
      overflow: hidden;
    }

    .login-container {
      width: 100%;
      max-width: 420px;
      background: white;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      position: relative;
      z-index: 1;
    }

    .login-header {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
      color: white;
      padding: 30px;
      text-align: center;
      position: relative;
    }

    .login-header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('https://www.transparenttextures.com/patterns/45-degree-fabric-light.png');
      opacity: 0.1;
    }

    .login-header img {
      width: 80px;
      margin-bottom: 15px;
      filter: drop-shadow(0 2px 5px rgba(0,0,0,0.2));
    }

    .login-header h3 {
      font-weight: 600;
      margin-bottom: 5px;
      position: relative;
    }

    .login-header p {
      font-size: 0.9rem;
      opacity: 0.9;
    }

    .login-body {
      padding: 30px;
    }

    .form-group {
      position: relative;
      margin-bottom: 20px;
    }

    .form-group i {
      position: absolute;
      top: 15px;
      left: 15px;
      color: var(--text-light);
      font-size: 1.1rem;
    }

    .form-control {
      padding-left: 45px;
      height: 50px;
      border-radius: 8px;
      border: 1px solid #e0e0e0;
      transition: all 0.3s;
    }

    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .btn-login {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
      border: none;
      font-weight: 600;
      color: white;
      transition: all 0.3s;
      margin-top: 10px;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
    }

    .login-footer {
      text-align: center;
      padding: 0 30px 30px;
      color: var(--text-light);
      font-size: 0.9rem;
    }

    .login-footer a {
      color: var(--primary-color);
      text-decoration: none;
      font-weight: 500;
    }

    .login-footer a:hover {
      text-decoration: underline;
    }

    .alert-danger {
      border-radius: 8px;
      margin-bottom: 20px;
    }

    .floating {
      position: absolute;
      animation: float 6s ease-in-out infinite;
      opacity: 0.1;
      z-index: 0;
    }

    .floating-1 {
      width: 300px;
      height: 300px;
      background: var(--primary-color);
      border-radius: 50%;
      top: -100px;
      right: -100px;
      filter: blur(40px);
    }

    .floating-2 {
      width: 200px;
      height: 200px;
      background: var(--secondary-color);
      border-radius: 50%;
      bottom: -50px;
      left: -50px;
      filter: blur(30px);
      animation-delay: 2s;
    }

    @keyframes float {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-15px); }
      100% { transform: translateY(0px); }
    }

    @media (max-width: 576px) {
      .login-container {
        margin: 0 15px;
      }

      .login-header {
        padding: 25px 20px;
      }

      .login-body {
        padding: 25px 20px;
      }
    }
  </style>
</head>

<body>
  <div class="floating floating-1"></div>
  <div class="floating floating-2"></div>

  <div class="login-container">
    <div class="login-header">
      <img src="https://admin.methodist.ac.id/cdn/Image/LOGO/komputer.png" alt="Logo pinjamFikom">
      <h3>Selamat Datang</h3>
      <p>Sistem Peminjaman Barang Fakultas Ilmu Komputer Universitas Methodist Indonesia</p>
    </div>

    <div class="login-body">
      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $item)
              <li>{{ $item }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="" method="POST">
        @csrf
        <div class="form-group">
          <i class="bi bi-envelope-fill"></i>
          <input type="text" value="{{ old('nim_nip') }}" name="nim_nip" class="form-control" placeholder="Username" required>
        </div>

        <div class="form-group">
          <i class="bi bi-lock-fill"></i>
          <input type="password" name="password" class="form-control" placeholder="Kata Sandi" required>
        </div>

        <button type="submit" class="btn btn-login">Masuk</button>
      </form>
    </div>

    <div class="login-footer">
      <a href="#">Lupa kata sandi?</a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
