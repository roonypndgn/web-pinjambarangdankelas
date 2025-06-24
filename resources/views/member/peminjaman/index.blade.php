@extends('layout.member')

@section('title', 'Peminjaman Barang - Member')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <!-- Daftar Peminjaman -->
        <div class="col-lg-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-exchange-alt me-2"></i>Daftar Peminjaman Saya
                        </h4>
                        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                            <i class="fas fa-plus me-1"></i> Ajukan Peminjaman
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

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Gagal!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Barang</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Waktu Pinjam</th>
                                    <th>Status</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($peminjamans as $no => $peminjaman)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($peminjaman->barang->cover)
                                            <img src="{{ asset('storage/' . $peminjaman->barang->cover) }}"
                                                alt="{{ $peminjaman->barang->merk }}"
                                                class="rounded me-2" width="40" height="40">
                                            @else
                                            <div class="bg-secondary rounded me-2 d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px;">
                                                <i class="fas fa-box text-white"></i>
                                            </div>
                                            @endif
                                            <div>
                                                <strong>{{ $peminjaman->barang->merk }}</strong>
                                                <small class="text-muted d-block">{{ $peminjaman->barang->kategori->nama }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d M Y') }}</td>
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
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalDetail{{ $peminjaman->id }}" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        @if($peminjaman->status == 'pending')
                                        <form action="{{ route('member.peminjaman.cancel', $peminjaman->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                title="Batalkan" onclick="return confirm('Apakah Anda yakin ingin membatalkan peminjaman ini?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
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

                    <!-- Pagination -->
                    @if($peminjamans->hasPages())
                    <div class="mt-3">
                        {{ $peminjamans->links() }}
                    </div>
                    @endif
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
                    <i class="fas fa-plus-circle me-2"></i>Ajukan Peminjaman Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('member.peminjaman.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="barang_id" class="form-label">Pilih Barang</label>
                        <select class="form-select" id="barang_id" name="barang_id" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barangs as $barang)
                            <option value="{{ $barang->id }}" {{ $barang->status != 'tersedia' ? 'disabled' : '' }}>
                                {{ $barang->merk }} ({{ $barang->kategori->nama }})
                                {{ $barang->status != 'tersedia' ? '(Tidak Tersedia)' : '' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tgl_pinjam" class="form-label">Tanggal Pinjam</label>
                            <input type="date" class="form-control" id="tgl_pinjam" name="tgl_pinjam"
                                min="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="time_pinjam" class="form-label">Waktu Pinjam</label>
                            <input type="time" class="form-control" id="time_pinjam" name="time_pinjam" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-1"></i> Ajukan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail Peminjaman -->
@foreach($peminjamans as $peminjaman)
<div class="modal fade" id="modalDetail{{ $peminjaman->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle me-2"></i>Detail Peminjaman
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        @if($peminjaman->barang->cover)
                        <img src="{{ asset('storage/' . $peminjaman->barang->cover) }}"
                            alt="{{ $peminjaman->barang->merk }}"
                            class="img-fluid rounded">
                        @else
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center"
                            style="height: 150px;">
                            <i class="fas fa-box fa-3x text-white"></i>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h5>{{ $peminjaman->barang->merk }}</h5>
                        <p class="text-muted">{{ $peminjaman->barang->deskripsi }}</p>
                        <div class="mb-2">
                            <strong>Kategori:</strong> {{ $peminjaman->barang->kategori->nama }}
                        </div>
                        <div class="mb-2">
                            <strong>Status:</strong>
                            @if($peminjaman->status == 'pending')
                            <span class="badge bg-secondary">Menunggu Persetujuan</span>
                            @elseif($peminjaman->status == 'approved')
                            <span class="badge bg-primary">Disetujui</span>
                            @elseif($peminjaman->status == 'rejected')
                            <span class="badge bg-danger">Ditolak</span>
                            @elseif($peminjaman->status == 'pinjam')
                            <span class="badge bg-warning text-dark">Dipinjam</span>
                            @else
                            <span class="badge bg-success">Selesai</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title text-muted">
                                    <i class="fas fa-calendar-day me-2"></i>Jadwal Peminjaman
                                </h6>
                                <div class="mb-2">
                                    <strong>Tanggal:</strong>
                                    {{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d M Y') }}
                                </div>
                                <div class="mb-2">
                                    <strong>Waktu:</strong> {{ $peminjaman->time_pinjam }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title text-muted">
                                    <i class="fas fa-history me-2"></i>Status Proses
                                </h6>
                                <div class="mb-2">
                                    <strong>Diajukan pada:</strong>
                                    {{ $peminjaman->created_at->format('d M Y H:i') }}
                                </div>
                                @if($peminjaman->status != 'pending')
                                <div class="mb-2">
                                    <strong>Diperbarui pada:</strong>
                                    {{ $peminjaman->updated_at->format('d M Y H:i') }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if($peminjaman->status == 'rejected' && $peminjaman->admin_notes)
                <div class="alert alert-danger">
                    <h6 class="alert-heading">
                        <i class="fas fa-exclamation-triangle me-2"></i>Alasan Penolakan
                    </h6>
                    <p class="mb-0">{{ $peminjaman->admin_notes }}</p>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
                @if($peminjaman->status == 'pending')
                <form action="{{ route('member.peminjaman.cancel', $peminjaman->id) }}" method="POST" onsubmit="return confirm('Batalkan peminjaman ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Batalkan</button>
                </form>
                @endif
            </div>
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
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set tanggal minimal ke hari ini
        document.getElementById('tgl_pinjam').min = new Date().toISOString().split('T')[0];


    });
</script>
@endsection