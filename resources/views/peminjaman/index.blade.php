@extends('layout.app')

@section('title', 'Data Peminjaman')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Data Peminjaman</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-2">
  <h2 class="mb-4">Daftar Peminjaman Barang</h2>

  <!-- Tombol Tambah -->
  <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Peminjaman</button>

  <!-- Notifikasi -->
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <!-- Tabel -->
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>No</th>
        <th>Barang ID</th>
        <th>User ID</th>
        <th>Tgl Pinjam</th>
        <th>Tgl Kembali</th>
        <th>Jam Pinjam</th>
        <th>Jam Kembali</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($peminjamans as $no => $p)
      <tr>
        <td>{{ $no + 1 }}</td>
        <td>{{ $p->barang_id }}</td>
        <td>{{ $p->user_id }}</td>
        <td>{{ $p->tgl_pinjam }}</td>
        <td>{{ $p->tgl_kembali }}</td>
        <td>{{ $p->time_pinjam }}</td>
        <td>{{ $p->time_kembali }}</td>
        <td>
          <span class="badge bg-{{ $p->status === 'dipinjam' ? 'warning' : 'success' }}">
            {{ ucfirst($p->status) }}
          </span>
        </td>
        <td>
          <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $p->id }}">Edit</button>
          <form action="{{ route('peminjaman.destroy', $p->id) }}" method="POST" style="display:inline-block">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="9" class="text-center">Belum ada data peminjaman.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('peminjaman.store') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Tambah Peminjaman</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label>Barang ID</label>
          <input type="number" name="barang_id" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>User ID</label>
          <input type="number" name="user_id" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Tanggal Pinjam</label>
          <input type="date" name="tgl_pinjam" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Tanggal Kembali</label>
          <input type="date" name="tgl_kembali" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Jam Pinjam</label>
          <input type="time" name="time_pinjam" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Jam Kembali</label>
          <input type="time" name="time_kembali" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Status</label>
          <select name="status" class="form-control" required>
            <option value="dipinjam">Dipinjam</option>
            <option value="dikembalikan">Dikembalikan</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-primary" type="submit">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit -->
@foreach($peminjamans as $p)
<div class="modal fade" id="modalEdit{{ $p->id }}" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('peminjaman.update', $p->id) }}" method="POST" class="modal-content">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title">Edit Peminjaman</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label>Barang ID</label>
          <input type="number" name="barang_id" class="form-control" value="{{ $p->barang_id }}" required>
        </div>
        <div class="mb-3">
          <label>User ID</label>
          <input type="number" name="user_id" class="form-control" value="{{ $p->user_id }}" required>
        </div>
        <div class="mb-3">
          <label>Tanggal Pinjam</label>
          <input type="date" name="tgl_pinjam" class="form-control" value="{{ $p->tgl_pinjam }}" required>
        </div>
        <div class="mb-3">
          <label>Tanggal Kembali</label>
          <input type="date" name="tgl_kembali" class="form-control" value="{{ $p->tgl_kembali }}" required>
        </div>
        <div class="mb-3">
          <label>Jam Pinjam</label>
          <input type="time" name="time_pinjam" class="form-control" value="{{ $p->time_pinjam }}" required>
        </div>
        <div class="mb-3">
          <label>Jam Kembali</label>
          <input type="time" name="time_kembali" class="form-control" value="{{ $p->time_kembali }}" required>
        </div>
        <div class="mb-3">
          <label>Status</label>
          <select name="status" class="form-control" required>
            <option value="dipinjam" {{ $p->status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
            <option value="dikembalikan" {{ $p->status == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-primary" type="submit">Update</button>
      </div>
    </form>
  </div>
</div>
@endforeach

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection
