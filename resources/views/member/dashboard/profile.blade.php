@extends('layout.member')

@section('title', 'Profil Saya')

@section('content')
<div class="container py-4">
    <!-- Header Profil -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 text-gradient">
            <i class="bi bi-person-circle me-2"></i>
            <span>Profil Saya</span>
        </h2>
        <div class="badge bg-primary bg-opacity-10 text-primary p-2">
            <i class="bi bi-star-fill me-1"></i>Member
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Kolom Kiri - Edit Profil -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom d-flex align-items-center py-3">
                    <i class="bi bi-person-lines-fill fs-4 text-primary me-2"></i>
                    <h5 class="mb-0">Informasi Profil</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('member.dashboard.profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Foto Profil -->
                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                @if($user->foto)
                                    <img src="{{ asset('storage/' . $user->foto) }}"
                                         class="rounded-circle shadow-lg"
                                         width="150" height="150"
                                         style="object-fit: cover; border: 3px solid #e9ecef;"
                                         id="profileImage"
                                         alt="Foto Profil">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->nama) }}&background=random"
                                         class="rounded-circle shadow-lg"
                                         width="150" height="150"
                                         style="object-fit: cover; border: 3px solid #e9ecef;"
                                         id="profileImage"
                                         alt="Default Avatar">
                                @endif
                                <label for="fotoUpload" class="position-absolute bottom-0 end-0 bg-primary rounded-circle p-2 shadow-sm cursor-pointer">
                                    <i class="bi bi-camera-fill text-white"></i>
                                    <input type="file" id="fotoUpload" name="foto" class="d-none" accept="image/*">
                                </label>
                            </div>
                            @error('foto')
                                <div class="text-danger small text-center mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-person-fill text-muted"></i>
                                    </span>
                                    <input type="text" name="nama" class="form-control"
                                           value="{{ old('nama', $user->nama) }}" required>
                                </div>
                                @error('nama') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-envelope-fill text-muted"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control bg-light"
                                           value="{{ old('email', $user->email) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telepon" class="form-label">Nomor Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-telephone-fill text-muted"></i>
                                    </span>
                                    <input type="text" name="telepon" class="form-control"
                                           value="{{ old('telepon', $user->telepon) }}"
                                           placeholder="Contoh: 081234567890">
                                </div>
                                @error('telepon') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-calendar-event text-muted"></i>
                                    </span>
                                    <input type="date" name="tanggal_lahir" class="form-control"
                                           value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-geo-alt-fill text-muted"></i>
                                </span>
                                <textarea name="alamat" class="form-control" rows="3"
                                          placeholder="Masukkan alamat lengkap">{{ old('alamat', $user->alamat) }}</textarea>
                            </div>
                            @error('alamat') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="reset" class="btn btn-outline-secondary me-md-2">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan - Ganti Password & Info -->
        <div class="col-lg-4">
            <!-- Ganti Password -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-bottom d-flex align-items-center py-3">
                    <i class="bi bi-shield-lock fs-4 text-warning me-2"></i>
                    <h5 class="mb-0">Keamanan Akun</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('member.dashboard.changePassword') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-lock-fill text-muted"></i>
                                </span>
                                <input type="password" name="current_password" class="form-control"
                                       placeholder="Masukkan password saat ini" required>
                            </div>
                            @error('current_password') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-key-fill text-muted"></i>
                                </span>
                                <input type="password" name="new_password" class="form-control"
                                       placeholder="Minimal 8 karakter" required>
                            </div>
                            @error('new_password') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Konfirmasi Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-key-fill text-muted"></i>
                                </span>
                                <input type="password" name="new_password_confirmation" class="form-control"
                                       placeholder="Ketik ulang password baru" required>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-arrow-repeat me-1"></i> Ganti Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Akun -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom d-flex align-items-center py-3">
                    <i class="bi bi-info-circle fs-4 text-info me-2"></i>
                    <h5 class="mb-0">Informasi Akun</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                            <span><i class="bi bi-calendar-check me-2 text-muted"></i>Bergabung</span>
                            <span class="badge bg-light text-dark">{{ $user->created_at->diffForHumans() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                            <span><i class="bi bi-arrow-repeat me-2 text-muted"></i>Terakhir Diupdate</span>
                            <span class="badge bg-light text-dark">{{ $user->updated_at->diffForHumans() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                            <span><i class="bi bi-shield-check me-2 text-muted"></i>Status Akun</span>
                            <span class="badge bg-success bg-opacity-10 text-success">Aktif</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-gradient {
        background: linear-gradient(45deg, #3b82f6, #8b5cf6);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .card {
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .input-group-text {
        transition: all 0.3s ease;
    }

    .form-control:focus + .input-group-text {
        background-color: #e9ecef;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 1.25rem;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview image sebelum upload
    const fotoUpload = document.getElementById('fotoUpload');
    const profileImage = document.getElementById('profileImage');

    if (fotoUpload && profileImage) {
        fotoUpload.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    profileImage.src = event.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endsection
