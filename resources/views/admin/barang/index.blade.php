@extends('layout.admin')

@section('title', 'Manajemen Barang')
@section('content')
<div class="container-fluid px-4">
    <div class="card mb-4 mt-4">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-boxes me-2"></i>Data Barang
                </h4>
                <a href="#" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahBarang">
                    <i class="fas fa-plus me-1"></i> Tambah Barang
                </a>
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
                            <th scope="col" width="5%">ID</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Merk</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col" class="text-center">Stok</th>
                            <th scope="col" width="10%">Gambar</th>
                            <th scope="col" width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangs as $barang)
                        <tr>
                            <td>{{ $barang->id }}</td>
                            <td>{{ $barang->kategori->nama }}</td>
                            <td>
                                <strong>{{ $barang->merk }}</strong>
                            </td>
                            <td>{{ Str::limit($barang->deskripsi, 50) }}</td>
                            <td class="text-center">
                                <span class="badge @if($barang->status == 'tersedia') bg-success @elseif($barang->status == 'dipinjam') bg-warning text-dark @elseif($barang->status == 'rusak') bg-danger @else bg-secondary @endif">
                                    {{ ucfirst($barang->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge @if($barang->jumlah > 20) bg-success @elseif($barang->jumlah > 0) bg-warning text-dark @else bg-danger @endif">
                                    {{ $barang->jumlah }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($barang->cover)
                                <img src="{{ asset('storage/' . $barang->cover) }}" class="img-thumbnail" width="60" alt="Cover">
                                @else
                                <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalUpdateBarang{{ $barang->id }}" title="Edit">
                                <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.barang.destroy', $barang->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                <a href="#" class="btn btn-sm btn-outline-info" title="Detail" data-bs-toggle="modal" data-bs-target="#detailModal{{ $barang->id }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data produk</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <a href="{{ route('admin.laporan.laporanbarang') }}" class="btn btn-success">
                <i class="fas fa-file-pdf me-1"></i> Export Pdf
                </a>
            </div>
            <!-- Modal Tambah Barang -->
            <div class="modal fade" id="modalTambahBarang" tabindex="-1" aria-labelledby="modalTambahBarangLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ route('admin.barang.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTambahBarangLabel">Tambah Barang</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="kategori_id" class="form-label">Kategori</label>
                                    <select name="kategori_id" class="form-control" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="merk" class="form-label">Merk</label>
                                    <input type="text" name="merk" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="tersedia" selected>Tersedia</option>
                                        <option value="dipinjam">Dipinjam</option>
                                        <option value="rusak">Rusak</option>
                                        <option value="hilang">Hilang</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                    <input type="number" name="jumlah" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="cover" class="form-label">Cover</label>
                                    <input type="file" name="cover" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Detail Barang -->
            @foreach($barangs as $barang)
            <div class="modal fade" id="detailModal{{ $barang->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $barang->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailModalLabel{{ $barang->id }}">Detail Barang - {{ $barang->merk }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th width="25%"><i class="fas fa-tag me-2"></i>Merk Produk</th>
                                        <td>{{ $barang->merk }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-list me-2"></i>Kategori</th>
                                        <td>
                                            <span class="badge bg-info text-dark">
                                                {{ $barang->kategori->nama ?? 'Tidak ada kategori' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-boxes me-2"></i>Stok Tersedia</th>
                                        <td>
                                            <span class="badge @if($barang->jumlah > 20) bg-success @elseif($barang->jumlah > 0) bg-warning text-dark @else bg-danger @endif">
                                                {{ $barang->jumlah }} unit
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-calendar-plus me-2"></i>Ditambahkan</th>
                                        <td>{{ $barang->created_at->translatedFormat('l, d F Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-calendar-check me-2"></i>Terakhir Diupdate</th>
                                        <td>{{ $barang->updated_at->translatedFormat('l, d F Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-align-left me-2"></i>Deskripsi</th>
                                        <td>{!! nl2br(e($barang->deskripsi)) !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('admin.barang.edit', $barang->id) }}" class="btn btn-warning me-2">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.barang.destroy', $barang->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                        <i class="fas fa-trash-alt me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- Modal Update Barang -->
            @foreach($barangs as $barang)
            <div class="modal fade" id="modalUpdateBarang{{ $barang->id }}" tabindex="-1" aria-labelledby="modalUpdateBarangLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ route('admin.barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalUpdateBarangLabel">Update Barang</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="kategori_id" class="form-label">Kategori</label>
                                    <select name="kategori_id" class="form-control" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}" {{ $barang->kategori_id == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="merk" class="form-label">Merk</label>
                                    <input type="text" name="merk" class="form-control" value="{{ $barang->merk }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" required>{{ $barang->deskripsi }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="tersedia" {{ $barang->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                        <option value="dipinjam" {{ $barang->status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                        <option value="rusak" {{ $barang->status == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                        <option value="hilang" {{ $barang->status == 'hilang' ? 'selected' : '' }}>Hilang</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                    <input type="number" name="jumlah" class="form-control" value="{{ $barang->jumlah }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="cover" class="form-label">Cover</label>
                                    <input type="file" name="cover" class="form-control">
                                    @if($barang->cover)
                                    <small class="text-muted">Gambar saat ini: <a href="{{ asset('storage/' . $barang->cover) }}" target="_blank">Lihat Gambar</a></small>
                                    @else
                                    <small class="text-muted">Tidak ada gambar saat ini</small>
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between">
                        <div class="dataTables_info">
                            Menampilkan {{ $barangs->firstItem() }} sampai {{ $barangs->lastItem() }} dari {{ $barangs->total() }} entri
                        </div>
                        {{ $barangs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan Font Awesome untuk ikon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Link ke file CSS terpisah -->
<link href="{{ asset('css/barang.css') }}" rel="stylesheet">
@endsection