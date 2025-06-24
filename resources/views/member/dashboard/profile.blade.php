@extends('layout.member')

@section('title', 'Profil Saya')

@section('content')
<div class="container py-4">
        <h4 class="mb-4 text-primary d-flex align-items-center">
            <i class="bi bi-person-circle me-2"></i>
            <span>Profil Saya</span>
        </h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form Edit Profil --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="bi bi-person-lines-fill me-2"></i>
            <span>Edit Profil Member</span>
        </div>
        <div class="card-body">
            <form action="{{ route('member.dashboard.profile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Foto Profil --}}
                <div class="mb-3 text-center">
                    @if($user->foto)
                        <img src="{{ asset('storage/' . $user->foto) }}" class="rounded-circle shadow" width="120" height="120" style="object-fit: cover;" alt="Foto Profil">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->nama) }}" class="rounded-circle shadow" width="120" height="120" style="object-fit: cover;" alt="Default Avatar">
                    @endif
                </div>

                <div class="mb-3">
                    <label for="foto" class="form-label">Foto Profil</label>
                    <input type="file" name="foto" class="form-control">
                    @error('foto') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $user->nama) }}" required>
                    @error('nama') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required readonly>
                    @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="telepon" class="form-label">Telepon</label>
                    <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $user->telepon) }}">
                    @error('telepon') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control">{{ old('alamat', $user->alamat) }}</textarea>
                    @error('alamat') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
            </form>
        </div>
    </div>

    {{-- Form Ganti Password --}}
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="bi bi-key-fill me-2"></i>
            <span>Ganti Password</span>
        </div>
        <div class="card-body">
            <form action="{{ route('member.dashboard.changePassword') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="current_password" class="form-label">Password Saat Ini</label>
                    <input type="password" name="current_password" class="form-control" required>
                    @error('current_password') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">Password Baru</label>
                    <input type="password" name="new_password" class="form-control" required>
                    @error('new_password') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="new_password_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-warning"><i class="bi bi-key me-1"></i> Ganti Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
