@extends('layout.admin')

@section('title', 'Data Pengembalian')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Data Pengembalian</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-2">
  <h2 class="mb-4">Daftar Pengembalian Barang</h2>

  <!-- Tombol Tambah -->
  <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Pengembalian</button>

  <!-- Notifikasi -->
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <!-- Tabel -->
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>No</th>
        <th>Pinjam ID</th>
        <th>Tanggal Kembali</th>
        <th>Waktu Kembali</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($pengembalians as $no => $k)
      <tr>
        <td>{{ $no + 1 }}</td>
        <td>{{ $k->pinjam_id }}</td>
        <td>{{ $k->tgl_kembali }}</td>
        <td>{{ $k->time_kembali }}</td>
        <td>
          <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $k->id }}">Edit</button>
          <form action="{{ route('admin.pengembalian.destroy', $k->id) }}" method="POST" style="display:inline-block">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="5" class="text-center">Belum ada data pengembalian.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('admin.pengembalian.store') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Tambah Pengembalian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label>Pinjam ID</label>
          <input type="number" name="pinjam_id" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Tanggal Kembali</label>
          <input type="date" name="tgl_kembali" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Waktu Kembali</label>
          <input type="time" name="time_kembali" class="form-control" required>
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
@foreach($pengembalians as $k)
<div class="modal fade" id="modalEdit{{ $k->id }}" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('admin.pengembalian.update', $k->id) }}" method="POST" class="modal-content">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title">Edit Pengembalian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label>Pinjam ID</label>
          <input type="number" name="pinjam_id" class="form-control" value="{{ $k->pinjam_id }}" required>
        </div>
        <div class="mb-3">
          <label>Tanggal Kembali</label>
          <input type="date" name="tgl_kembali" class="form-control" value="{{ $k->tgl_kembali }}" required>
        </div>
        <div class="mb-3">
          <label>Waktu Kembali</label>
          <input type="time" name="time_kembali" class="form-control" value="{{ $k->time_kembali }}" required>
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
