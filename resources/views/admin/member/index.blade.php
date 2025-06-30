
@extends('layout.admin')

@section('title', 'Manajemen Member')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <!-- Daftar Member -->
        <div class="col-lg-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-users me-2"></i>Daftar Member
                        </h4>
                        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                            <i class="fas fa-plus me-1"></i> Tambah Member
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Sukses!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Telepon</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($members as $no => $member)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $member->nama }}</td>
                                    <td>{{ $member->email }}</td>
                                    <td>{{ $member->telepon }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $member->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.member.destroy', $member->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus member ini?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p>Belum ada data member</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3">
                            <a href="{{ route('admin.laporan.laporanmember') }}" class="btn btn-success">
                                <i class="fas fa-file-pdf me-1"></i> Export Pdf
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Member -->
<div class="col-lg-4">
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-info text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-history me-2"></i>Riwayat Member
                </h4>
                <span class="badge bg-white text-info">{{ $recentMembers->count() }} baru</span>
            </div>
        </div>
        <div class="card-body">
            <div class="list-group">
                @forelse($recentMembers as $member)
                <div class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">{{ $member->nama }}</h6>
                        <small>{{ $member->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="mb-1 text-muted">Email: {{ $member->email }}</p>
                    <small>Ditambahkan oleh: {{ $member->created_by ?? 'Admin' }}</small>
                </div>
                @empty
                <div class="text-center py-3 text-muted">
                    <i class="fas fa-clock fa-2x mb-2"></i>
                    <p>Belum ada member baru</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>


<!-- Modal Tambah -->
 @foreach($members as $no => $member)
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="{{ route('admin.member.store') }}" method="POST">
            @csrf
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Tambah Member</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat') }}">
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="telepon" class="form-label">Telepon</label>
                    <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" value="{{ old('telepon') }}">
                    @error('telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Batal
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach
<!-- Modal Edit -->
@foreach($members as $member)
<div class="modal fade" id="modalEdit{{ $member->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" method="POST" action="{{ route('admin.member.update', $member->id) }}">
            @csrf
            @method('PUT')
            <div class="modal-header bg-primary text-light">
                <h5 class="modal-title"><i class="fas fa-user-edit me-2"></i>Edit Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="nama{{ $member->id }}" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama{{ $member->id }}" name="nama" value="{{ $member->nama }}" required>
                </div>
                <div class="mb-3">
                    <label for="alamat{{ $member->id }}" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat{{ $member->id }}" name="alamat" value="{{ $member->alamat }}">
                </div>
                <div class="mb-3">
                    <label for="telepon{{ $member->id }}" class="form-label">Telepon</label>
                    <input type="text" class="form-control" id="telepon{{ $member->id }}" name="telepon" value="{{ $member->telepon }}">
                </div>
                <div class="mb-3">
                    <label for="email{{ $member->id }}" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email{{ $member->id }}" name="email" value="{{ $member->email }}" required>
                </div>
                <div class="mb-3">
                    <label for="password{{ $member->id }}" class="form-label">Password Baru (opsional)</label>
                    <input type="password" class="form-control" id="password{{ $member->id }}" name="password">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Batal
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Update
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach

<!-- Font Awesome & CSS Khusus -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .card { border-radius: 0.5rem; }
    .card-header { border-radius: 0.5rem 0.5rem 0 0 !important; }
    .table th { text-transform: uppercase; font-size: 0.75rem; font-weight: 600; }
    .modal-content { border-radius: 0.5rem; }
    .modal-header { border-radius: 0.5rem 0.5rem 0 0 !important; }
</style>
@endsection
