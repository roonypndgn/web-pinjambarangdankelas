
@extends('layout.admin')

@section('title', 'Manajemen Peminjaman Barang')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <!-- Daftar Peminjaman -->
        <div class="col-lg-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-exchange-alt me-2"></i>Daftar Peminjaman Barang
                        </h4>
                        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                            <i class="fas fa-plus me-1"></i> Tambah Peminjaman
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Sukses!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Peminjam</th>
                                <th>Barang</th>
                                <th>Tanggal Pinjam</th>
                                <th>Waktu Pinjam</th>
                                <th>Status</th>
                                <th width="20%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjamans as $no => $peminjaman)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td>
                                    <strong>{{ $peminjaman->user->nama }}</strong>
                                    <small class="text-muted d-block">{{ $peminjaman->user->email }}</small>
                                </td>
                                <td>
                                    {{ $peminjaman->barang->merk }}
                                    <small class="text-muted d-block">Kode: {{ $peminjaman->barang->kode_barang }}</small>
                                </td>
                                <td>
                                    {{ $peminjaman->tgl_pinjam }}
                                    <small class="text-muted d-block">{{ $peminjaman->tgl_pinjam }}</small>
                                </td>
                                <td>
                                    {{ $peminjaman->time_pinjam }}
                                    <small class="text-muted d-block">{{ $peminjaman->time_pinjam }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $peminjaman->status == 'pinjam' ? 'warning' : 'success' }}">
                                        {{ $peminjaman->status == 'pinjam' ? 'Dipinjam' : 'Dikembalikan' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $peminjaman->id }}" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.peminjaman.destroy', $peminjaman->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data peminjaman ini?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p>Belum ada data peminjaman</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Peminjaman -->
        <div class="col-lg-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-info text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-history me-2"></i>Riwayat Terbaru
                        </h4>
                        <span class="badge bg-white text-info">{{ $recentPeminjamans->count() }} item</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @forelse($recentPeminjamans as $peminjaman)
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $peminjaman->barang->merk }}</h6>
                                <small>{{ $peminjaman->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">Dipinjam oleh: {{ $peminjaman->user->nama }}</p>
                            <small class="text-muted">
                                Kode: {{ $peminjaman->barang->kode_barang }} |
                                Status:
                                <span class="badge bg-{{ $peminjaman->status == 'pinjam' ? 'warning' : 'success' }}">
                                    {{ $peminjaman->status == 'pinjam' ? 'Dipinjam' : 'Dikembalikan' }}
                                </span>
                            </small>
                        </div>
                        @empty
                        <div class="text-center py-3 text-muted">
                            <i class="fas fa-clock fa-2x mb-2"></i>
                            <p>Belum ada riwayat</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Tambah Peminjaman -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Peminjaman Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.peminjaman.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Pilih Member</label>
                        <select class="form-select select2" id="user_id" name="user_id" required>
                            <option value="">-- Pilih Member --</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}">
                                    {{ $member->nama }} <!-- Hanya tampilkan nama -->
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="barang_id" class="form-label">Pilih Barang</label>
                        <select class="form-select select2" id="barang_id" name="barang_id" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barangs as $barang)
                                <option value="{{ $barang->id }}">
                                    {{ $barang->merk }} <!-- Hanya tampilkan nama barang -->
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tgl_pinjam" class="form-label">Tanggal Pinjam</label>
                            <input type="date" class="form-control" id="tgl_pinjam" name="tgl_pinjam" min="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="time_pinjam" class="form-label">Waktu Pinjam</label>
                            <input type="time" class="form-control" id="time_pinjam" name="time_pinjam" required>
                        </div>
                    </div>
                    <input type="hidden" name="status" value="pinjam">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Peminjaman -->
@foreach($peminjamans as $peminjaman)
<div class="modal fade" id="modalEdit{{ $peminjaman->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Edit Peminjaman
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.peminjaman.update', $peminjaman->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="user_id_edit{{ $peminjaman->id }}" class="form-label">Pilih Member</label>
                        <select class="form-select select2" id="user_id_edit{{ $peminjaman->id }}" name="user_id" required>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}" {{ $peminjaman->user_id == $member->id ? 'selected' : '' }}>
                                    {{ $member->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="barang_id_edit{{ $peminjaman->id }}" class="form-label">Pilih Barang</label>
                        <select class="form-select select2" id="barang_id_edit{{ $peminjaman->id }}" name="barang_id" required>
                            @foreach($barangs as $barang)
                                <option value="{{ $barang->id }}" {{ $peminjaman->barang_id == $barang->id ? 'selected' : '' }}>
                                    {{ $barang->merk }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tgl_pinjam_edit{{ $peminjaman->id }}" class="form-label">Tanggal Pinjam</label>
                            <input type="date" class="form-control" id="tgl_pinjam_edit{{ $peminjaman->id }}" name="tgl_pinjam" value="{{ $peminjaman->tgl_pinjam }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="time_pinjam_edit{{ $peminjaman->id }}" class="form-label">Waktu Pinjam</label>
                            <input type="time" class="form-control" id="time_pinjam_edit{{ $peminjaman->id }}" name="time_pinjam" value="{{ $peminjaman->time_pinjam }}" required>
                        </div>
                    </div>
                    <input type="hidden" name="status" value="{{ $peminjaman->status }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- CSS Khusus -->
<style>
    .card {
        border-radius: 0.5rem;
    }
    .card-header {
        border-radius: 0.5rem 0.5rem 0 0 !important;
        padding: 1rem 1.35rem;
    }
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    .modal-content {
        border-radius: 0.5rem;
    }
    .modal-header {
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }
    .list-group-item {
        border-left: none;
        border-right: none;
        padding: 1rem 1.25rem;
    }
    .list-group-item:first-child {
        border-top: none;
    }
    .badge.bg-warning {
        color: #000;
    }
    .select2-container--default .select2-selection--single {
        height: 38px;
        padding: 5px 10px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
</style>

<!-- Tambahkan sebelum penutup body -->
@section('scripts')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Inisialisasi Select2 untuk semua select
    $('.select2').select2({
        placeholder: "Pilih...",
        allowClear: true,
        width: '100%'
    });
});
</script>
@endsection

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
