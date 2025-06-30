@extends('layout.admin')

@section('title', 'Manajemen Pengembalian Barang')

@section('content')
<div class="container-fluid px-4">
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-undo me-2"></i>Daftar Pengembalian Barang
                </h4>
                <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPengembalian">
                    <i class="fas fa-plus me-1"></i> Tambah Pengembalian
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
                            <th>Peminjaman</th>
                            <th>Tanggal Kembali</th>
                            <th>Waktu Kembali</th>
                            <th>Status</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengembalians as $no => $pengembalian)
                        <tr>
                            <td>{{ $no + 1 }}</td>
                            <td>
                                <strong>ID: {{ $pengembalian->pinjam_id }}</strong>
                                <small class="text-muted d-block">
                                    Barang: {{ $pengembalian->pinjam->barang->merk ?? 'N/A' }}
                                </small>
                                <small class="text-muted d-block">
                                    Peminjam: {{ $pengembalian->pinjam->user->nama ?? 'N/A' }}
                                </small>
                            </td>
                            <td>{{ $pengembalian->tgl_kembali }}</td>
                            <td>{{ $pengembalian->time_kembali }}</td>
                            <td>
                                @if($pengembalian->pinjam && $pengembalian->pinjam->status == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-warning text-dark">Proses</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditPengembalian{{ $pengembalian->id }}" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.pengembalian.destroy', $pengembalian->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data pengembalian ini?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2"></i>
                                    <p>Belum ada data pengembalian</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    {{ $pengembalians->links() }}
                </div>
            </div>
            <div class="mt-3">
                <a href="{{ route('admin.laporanPengembalian.export') }}" class="btn btn-success">
                    <i class="fas fa-file-pdf me-1"></i> Export PDF
                </a>
        </div>
    </div>
</div>

<!-- Modal Tambah Pengembalian -->
<div class="modal fade" id="modalTambahPengembalian" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Pengembalian Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.pengembalian.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="pinjam_id" class="form-label">Pilih Peminjaman</label>
                        <select class="form-select select2" id="pinjam_id" name="pinjam_id" required>
                            <option value="">-- Pilih Peminjaman --</option>
                            @foreach($peminjamans as $pinjam)
                                @if($pinjam->status == 'pinjam')
                                    <option value="{{ $pinjam->id }}">
                                        ID: {{ $pinjam->id }} -
                                        {{ $pinjam->barang->merk }} ({{ $pinjam->barang->kode_barang }}) -
                                        {{ $pinjam->user->nama }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tgl_kembali" class="form-label">Tanggal Kembali</label>
                            <input type="date" class="form-control" id="tgl_kembali" name="tgl_kembali" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="time_kembali" class="form-label">Waktu Kembali</label>
                            <input type="time" class="form-control" id="time_kembali" name="time_kembali" value="{{ date('H:i') }}" required>
                        </div>
                    </div>
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

<!-- Modal Edit Pengembalian -->
@foreach($pengembalians as $pengembalian)
<div class="modal fade" id="modalEditPengembalian{{ $pengembalian->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Edit Pengembalian
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.pengembalian.update', $pengembalian->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Peminjaman</label>
                        <input type="text" class="form-control" value="ID: {{ $pengembalian->pinjam_id }} - {{ $pengembalian->pinjam->barang->merk ?? 'N/A' }}" readonly>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tgl_kembali_edit{{ $pengembalian->id }}" class="form-label">Tanggal Kembali</label>
                            <input type="date" class="form-control" id="tgl_kembali_edit{{ $pengembalian->id }}" name="tgl_kembali" value="{{ $pengembalian->tgl_kembali }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="time_kembali_edit{{ $pengembalian->id }}" class="form-label">Waktu Kembali</label>
                            <input type="time" class="form-control" id="time_kembali_edit{{ $pengembalian->id }}" name="time_kembali" value="{{ $pengembalian->time_kembali }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
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
    .badge.bg-success {
        background-color: #198754 !important;
        color: white !important;
    }
    .badge.bg-warning {
        background-color: #ffc107 !important;
        color: black !important;
    }
    .select2-container--default .select2-selection--single {
        height: 38px;
        padding: 5px 10px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
</style>

@section('scripts')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Inisialisasi Select2
    $('.select2').select2({
        placeholder: "Pilih...",
        allowClear: true,
        width: '100%'
    });

    // Konfirmasi sebelum menghapus
    $('form[action*="destroy"]').on('submit', function(e) {
        if(!confirm('Apakah Anda yakin ingin menghapus data pengembalian ini?')) {
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
