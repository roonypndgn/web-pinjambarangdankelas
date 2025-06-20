<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Sistem Peminjaman Barang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: url('https://images.unsplash.com/photo-1600195077070-7c815f540b7b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
      background-size: cover;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    .overlay {
      position: absolute;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      z-index: 0;
    }

    .login-container {
      position: relative;
      z-index: 1;
      max-width: 400px;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(15px);
      padding: 40px 30px;
      border-radius: 20px;
      box-shadow: 0 0 30px rgba(0, 255, 255, 0.3);
      color: #fff;
    }

    .login-header {
      text-align: center;
      margin-bottom: 30px;
    }

    .login-header img {
      width: 70px;
      margin-bottom: 10px;
    }

    .login-header h3 {
      font-weight: 600;
      letter-spacing: 1px;
    }

    .form-group {
      position: relative;
      margin-bottom: 20px;
    }

    .form-group i {
      position: absolute;
      top: 12px;
      left: 15px;
      color: #ccc;
      font-size: 1.2rem;
    }

    .form-control {
      background: rgba(255,255,255,0.2);
      border: none;
      border-radius: 50px;
      padding: 10px 20px 10px 40px;
      color: #fff;
    }

    .form-control::placeholder {
      color: #eee;
    }

    .btn-login {
      width: 100%;
      padding: 12px;
      border-radius: 50px;
      background: linear-gradient(135deg, #00ffe7, #0d6efd);
      border: none;
      font-weight: 600;
      color: #000;
      transition: 0.3s;
    }

    .btn-login:hover {
      background: linear-gradient(135deg, #0d6efd, #00ffe7);
      color: #fff;
    }

    .text-center a {
      color: #00ffe7;
      text-decoration: none;
      font-size: 0.9rem;
    }

    .text-center a:hover {
      text-decoration: underline;
    }

    @media(max-width: 576px){
      .login-container {
        padding: 30px 20px;
      }
    }
  </style>
</head>

<body>
  <div class="overlay"></div>

  <div class="login-container">
    <div class="login-header">
      <img src="https://cdn-icons-png.flaticon.com/512/3064/3064197.png" alt="Logo" />
      <h3>Selamat Datang</h3>
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
        <input type="email" value="{{ old('email') }}" name="email" class="form-control" placeholder="Alamat Email" required />
      </div>
      <div class="form-group">
        <i class="bi bi-lock-fill"></i>
        <input type="password" name="password" class="form-control" placeholder="Kata Sandi" required />
      </div>
      <button type="submit" class="btn btn-login">Masuk</button>
    </form>

    <div class="text-center mt-3">
      <a href="#">Lupa kata sandi?</a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
