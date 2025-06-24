@extends('layout.admin')

@section('title', 'Manajemen Peminjaman Barang')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <!-- Daftar Peminjaman -->
        <div class="col-lg-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-success text-white">
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
                                    <td>{{ $peminjaman->tgl_pinjam }}</td>
                                    <td>{{ $peminjaman->time_pinjam }}</td>
                                    <td>
                                        @if($peminjaman->status == 'pending')
                                            <span class="badge bg-secondary">Menunggu Persetujuan</span>
                                        @elseif($peminjaman->status == 'approved')
                                            <span class="badge bg-primary">Disetujui</span>
                                        @elseif($peminjaman->status == 'rejected')
                                            <span class="badge bg-danger">Ditolak</span>
                                            @if($peminjaman->admin_notes)
                                                <small class="d-block text-muted">Alasan: {{ $peminjaman->admin_notes }}</small>
                                            @endif
                                        @elseif($peminjaman->status == 'pinjam')
                                            <span class="badge bg-warning text-dark">Dipinjam</span>
                                        @else
                                            <span class="badge bg-success">Selesai</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($peminjaman->status == 'pending')
                                            <form action="{{ route('admin.peminjaman.approve', $peminjaman->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" title="Setujui">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalTolak{{ $peminjaman->id }}" title="Tolak">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @elseif($peminjaman->status == 'approved')
                                            <form action="{{ route('admin.peminjaman.confirm', $peminjaman->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary" title="Konfirmasi">
                                                    <i class="fas fa-check-double"></i>
                                                </button>
                                            </form>
                                        @elseif($peminjaman->status == 'pinjam')
                                            <form action="{{ route('admin.peminjaman.complete', $peminjaman->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-info" title="Selesaikan">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
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
                                @if($peminjaman->status == 'pending')
                                    <span class="badge bg-secondary">Menunggu</span>
                                @elseif($peminjaman->status == 'approved')
                                    <span class="badge bg-primary">Disetujui</span>
                                @elseif($peminjaman->status == 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @elseif($peminjaman->status == 'pinjam')
                                    <span class="badge bg-warning text-dark">Dipinjam</span>
                                @else
                                    <span class="badge bg-success">Selesai</span>
                                @endif
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
            <div class="modal-header bg-success text-white">
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
                                    {{ $member->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="barang_id" class="form-label">Pilih Barang</label>
                        <select class="form-select select2" id="barang_id" name="barang_id" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barangs as $barang)
                                <option value="{{ $barang->id }}" {{ $barang->status != 'tersedia' ? 'disabled' : '' }}>
                                    {{ $barang->merk }} ({{ $barang->kode_barang }})
                                    {{ $barang->status != 'tersedia' ? '(Tidak Tersedia)' : '' }}
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
                    <button type="submit" class="btn btn-success">
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
            <div class="modal-header bg-success text-white">
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
                                <option value="{{ $barang->id }}" {{ $peminjaman->barang_id == $barang->id ? 'selected' : '' }} {{ $barang->status != 'tersedia' && $peminjaman->barang_id != $barang->id ? 'disabled' : '' }}>
                                    {{ $barang->merk }} ({{ $barang->kode_barang }})
                                    {{ $barang->status != 'tersedia' && $peminjaman->barang_id != $barang->id ? '(Tidak Tersedia)' : '' }}
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
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="pending" {{ $peminjaman->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $peminjaman->status == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ $peminjaman->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            <option value="pinjam" {{ $peminjaman->status == 'pinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="selesai" {{ $peminjaman->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    @if($peminjaman->status == 'rejected' || $peminjaman->admin_notes)
                    <div class="mb-3">
                        <label class="form-label">Catatan Admin</label>
                        <textarea class="form-control" name="admin_notes" rows="3">{{ $peminjaman->admin_notes }}</textarea>
                    </div>
                    @endif
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

<!-- Modal Tolak Peminjaman -->
@foreach($peminjamans as $peminjaman)
@if($peminjaman->status == 'pending')
<div class="modal fade" id="modalTolak{{ $peminjaman->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-times-circle me-2"></i>Tolak Peminjaman
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.peminjaman.reject', $peminjaman->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Alasan Penolakan</label>
                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-ban me-1"></i> Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
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
    .badge.bg-secondary {
        background-color: #6c757d !important;
        color: white !important;
    }
    .badge.bg-primary {
        background-color: #0d6efd !important;
        color: white !important;
    }
    .badge.bg-danger {
        background-color: #dc3545 !important;
        color: white !important;
    }
    .badge.bg-warning {
        background-color: #ffc107 !important;
        color: black !important;
    }
    .badge.bg-success {
        background-color: #198754 !important;
        color: white !important;
    }
    .select2-container--default .select2-selection--single {
        height: 38px;
        padding: 5px 10px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px;
    }
</style>

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

    // Konfirmasi sebelum menolak
    $('form[action*="reject"]').on('submit', function(e) {
        if(!confirm('Apakah Anda yakin ingin menolak peminjaman ini?')) {
            e.preventDefault();
        }
    });

    // Konfirmasi sebelum menyetujui
    $('form[action*="approve"]').on('submit', function(e) {
        if(!confirm('Apakah Anda yakin ingin menyetujui peminjaman ini?')) {
            e.preventDefault();
        }
    });

    // Konfirmasi sebelum mengkonfirmasi
    $('form[action*="confirm"]').on('submit', function(e) {
        if(!confirm('Apakah Anda yakin ingin mengkonfirmasi peminjaman ini?')) {
            e.preventDefault();
        }
    });

    // Konfirmasi sebelum menyelesaikan
    $('form[action*="complete"]').on('submit', function(e) {
        if(!confirm('Apakah Anda yakin ingin menyelesaikan peminjaman ini?')) {
            e.preventDefault();
        }
    });
});
</script>
@endsection

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection