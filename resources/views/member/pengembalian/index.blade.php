@extends('layout.member')

@section('title', 'Status Pengembalian Saya')

@section('content')
<div class="container-fluid px-4">
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-undo me-2"></i>Status Pengembalian Barang Saya
                </h4>
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
                            <th>Nama Barang</th>
                            <th>Tanggal Pinjam</th>
                            <th>Jam Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Jam Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengembalians as $no => $pengembalian)
                        <tr>
                            <td>{{ $no + 1 }}</td>
                            <td>
                                <strong>{{ $pengembalian->pinjam->barang->merk ?? 'N/A' }}</strong>
                            </td>
                            <td>{{ $pengembalian->pinjam->tgl_pinjam }}</td>
                            <td>{{ $pengembalian->pinjam->time_pinjam ?? 'N/A' }}</td>
                            <td>
                                @if($pengembalian->pinjam->status == 'selesai')
                                    {{ $pengembalian->tgl_kembali }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($pengembalian->pinjam->status == 'selesai')
                                    {{ $pengembalian->time_kembali }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($pengembalian->pinjam->status == 'selesai')
                                    <span class="badge bg-success">Dikembalikan</span>
                                @else
                                    <span class="badge bg-warning">Belum Dikembalikan</span>
                                @endif
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
            </div>
        </div>
    </div>
</div>

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
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
