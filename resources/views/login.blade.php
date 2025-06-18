<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Sistem Peminjaman Barang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #0d6efd, #6c63ff);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }

    .login-container {
      width: 100%;
      max-width: 400px;
      background: #fff;
      padding: 40px 30px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .login-header {
      text-align: center;
      margin-bottom: 30px;
    }

    .login-header img {
      width: 80px;
      height: 80px;
      margin-bottom: 10px;
    }

    .login-header h3 {
      margin-bottom: 0;
      font-weight: bold;
      color: #343a40;
    }

    .form-control {
      border-radius: 50px;
      padding-left: 40px;
    }

    .form-group {
      position: relative;
      margin-bottom: 1.5rem;
    }

    .form-group i {
      position: absolute;
      top: 12px;
      left: 15px;
      color: #aaa;
    }

    .btn-login {
      width: 100%;
      padding: 10px;
      border-radius: 50px;
      background-color: #0d6efd;
      border: none;
      transition: background 0.3s ease;
    }

    .btn-login:hover {
      background-color: #084298;
    }

    .text-center a {
      color: #0d6efd;
      text-decoration: none;
      font-size: 0.9rem;
    }

    .text-center a:hover {
      text-decoration: underline;
    }

    @media (max-width: 576px) {
      .login-container {
        padding: 30px 20px;
      }
    }
  </style>
</head>

<body>

  <div class="login-container">
    <div class="login-header">
      <img src="library-logo.png" alt="Logo" />
      <h3>Login Sistem</h3>
    </div>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
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
        <input type="email" value ="{{ old('email') }}" name="email" class="form-control" placeholder="Alamat Email" required />
      </div>
      <div class="form-group">
        <i class="bi bi-lock-fill"></i>
        <input type="password" name="password" class="form-control" placeholder="Kata Sandi" required />
      </div>
      <button type="submit" class="btn btn-login text-white">Masuk</button>
    </form>

    <div class="text-center mt-3">
      <a href="#">Lupa kata sandi?</a>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
