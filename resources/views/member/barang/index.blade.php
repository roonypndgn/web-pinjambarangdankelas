@extends('layout.member')

@section('title', 'Katalog Barang')

@section('content')
<div class="container-fluid">
  <!-- Header Katalog -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <h2 class="fw-bold mb-0">
          <i class="bi bi-box-seam text-primary me-2"></i> Katalog Barang
        </h2>
        <div class="d-flex">
          <span class="badge bg-primary rounded-pill me-2">
            <i class="bi bi-grid me-1"></i> Tampilan Grid
          </span>
        </div>
      </div>
      <hr class="mt-2 mb-4" style="border-color: var(--hover-color);">
    </div>
  </div>

  <!-- Filter dan Pencarian -->
  <div class="row mb-4">
    <div class="col-md-8 mb-3 mb-md-0">
      <div class="card border-0 shadow-sm" style="background-color: var(--card-bg);">
        <div class="card-body">
          <form action="{{ route('member.barang.index') }}" method="GET">
            <div class="input-group">
              <span class="input-group-text bg-transparent border-0">
                <i class="bi bi-search"></i>
              </span>
              <input 
                type="text" 
                name="search" 
                class="form-control border-0" 
                placeholder="Cari barang berdasarkan nama, merk, atau deskripsi..."
                value="{{ request('search') }}"
              >
              <button class="btn btn-primary px-4" type="submit">Cari</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    
    <div class="col-md-4">
      <div class="card border-0 shadow-sm" style="background-color: var(--card-bg);">
        <div class="card-body">
          <form action="{{ route('member.barang.index') }}" method="GET">
            <select 
              name="kategori" 
              class="form-select border-0" 
              onchange="this.form.submit()"
            >
              <option value="">Semua Kategori</option>
              @foreach($kategoris as $kategori)
                <option 
                  value="{{ $kategori->id }}"
                  {{ request('kategori') == $kategori->id ? 'selected' : '' }}
                >
                  {{ $kategori->nama }}
                </option>
              @endforeach
            </select>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Daftar Barang -->
  <div class="row">
    @forelse($barangs as $barang)
      <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100" style="background-color: var(--card-bg);">
          <!-- Badge Stok -->
          <div class="position-absolute top-0 end-0 m-2">
            <span class="badge
              @if($barang->status == 'tersedia') bg-success
              @elseif($barang->status == 'dipinjam') bg-warning text-dark
              @elseif($barang->status == 'rusak') bg-danger
              @else bg-secondary
              @endif">
              {{ ucfirst($barang->status) }}
          </span>
          </div>
          
          <!-- Gambar Barang -->
          <div class="card-img-top overflow-hidden" style="height: 180px; background-color: #f5f5f5;">
            @if($barang->cover)
              <img 
                src="{{ asset('storage/' . $barang->cover) }}" 
                alt="{{ $barang->merk }}" 
                class="w-100 h-100 object-fit-cover"
              >
            @else
              <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                <i class="bi bi-image text-muted fs-1"></i>
              </div>
            @endif
          </div>
          
          <div class="card-body">
            <!-- Kategori -->
            <span class="badge bg-secondary mb-2">
              {{ $barang->kategori->nama }}
            </span>
            
            <!-- Merk Barang -->
            <h5 class="card-title fw-bold mb-1">{{ $barang->merk }}</h5>
            
            <!-- Deskripsi Singkat -->
            <p class="card-text text-muted small mb-2">
              {{ Str::limit($barang->deskripsi, 100) }}
            </p>
            
            <!-- Stok -->
            <div class="d-flex align-items-center mb-3">
              <i class="bi bi-box-seam me-2 text-primary"></i>
              <small>Stok: {{ $barang->jumlah }} unit</small>
            </div>
            
            <!-- Tombol Aksi -->
            <div class="d-grid gap-2">
              <button 
                class="btn btn-outline-primary btn-sm" 
                data-bs-toggle="modal" 
                data-bs-target="#detailBarangModal{{ $barang->id }}"
              >
                <i class="bi bi-eye me-1"></i> Detail
              </button>
              
              <a 
                href="{{ route('member.peminjaman.create', ['barang_id' => $barang->id]) }}" 
                class="btn btn-primary btn-sm {{ $barang->status != 'tersedia' || $barang->jumlah <= 0 ? 'disabled' : '' }}"
                >
                <i class="bi bi-cart-plus me-1"></i> Pinjam
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Detail Barang -->
      <div class="modal fade" id="detailBarangModal{{ $barang->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content" style="background-color: var(--card-bg);">
            <div class="modal-header">
              <h5 class="modal-title">Detail Barang</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <!-- Gambar Barang -->
                <div class="col-md-6 mb-3 mb-md-0">
                  <div class="rounded overflow-hidden" style="height: 300px; background-color: #f5f5f5;">
                    @if($barang->cover)
                      <img 
                        src="{{ asset('storage/' . $barang->cover) }}" 
                        alt="{{ $barang->merk }}" 
                        class="w-100 h-100 object-fit-cover"
                      >
                    @else
                      <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                        <i class="bi bi-image text-muted fs-1"></i>
                      </div>
                    @endif
                  </div>
                </div>
                
                <!-- Detail Barang -->
                <div class="col-md-6">
                  <h4 class="fw-bold mb-3">{{ $barang->merk }}</h4>
                  
                  <div class="mb-3">
                    <span class="badge bg-secondary">{{ $barang->kategori->nama }}</span>
                    <span class="badge
                        @if($barang->status == 'tersedia') bg-success
                        @elseif($barang->status == 'dipinjam') bg-warning text-dark
                        @elseif($barang->status == 'rusak') bg-danger
                        @else bg-secondary
                        @endif">
                        {{ ucfirst($barang->status) }}
                    </span>
                  </div>
                  
                  <div class="mb-3">
                    <h6 class="fw-bold mb-2">Deskripsi:</h6>
                    <p class="text-muted">{{ $barang->deskripsi }}</p>
                  </div>
                  
                  <div class="row mb-3">
                    <div class="col-6">
                      <h6 class="fw-bold mb-1">Stok:</h6>
                      <p class="text-muted">{{ $barang->jumlah }} unit</p>
                    </div>
                    <div class="col-6">
                      <h6 class="fw-bold mb-1">Terakhir Diupdate:</h6>
                      <p class="text-muted">{{ $barang->updated_at->format('d M Y') }}</p>
                    </div>
                  </div>
                  
                  <div class="d-grid">
                    <a 
                      href="{{ route('member.peminjaman.index', ['barang_id' => $barang->id]) }}" 
                      class="btn btn-primary {{ $barang->status != 'tersedia' || $barang->jumlah <= 0 ? 'disabled' : '' }}"
                    >
                      <i class="bi bi-cart-plus me-1"></i> Ajukan Peminjaman
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="card border-0 shadow-sm" style="background-color: var(--card-bg);">
          <div class="card-body text-center py-5">
            <i class="bi bi-box-seam fs-1 text-muted mb-3"></i>
            <h5 class="fw-bold">Tidak ada barang ditemukan</h5>
            <p class="text-muted">Coba gunakan kata kunci pencarian yang berbeda atau pilih kategori lain</p>
            <a href="{{ route('member.barang.index') }}" class="btn btn-primary mt-3">
              <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Pencarian
            </a>
          </div>
        </div>
      </div>
    @endforelse
  </div>

  <!-- Pagination -->
  @if($barangs->hasPages())
    <div class="row mt-4">
      <div class="col-12">
        <div class="card border-0 shadow-sm" style="background-color: var(--card-bg);">
          <div class="card-body py-2">
            {{ $barangs->links() }}
          </div>
        </div>
      </div>
    </div>
  @endif
</div>

<style>
  .card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  
  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
  }
  
  .object-fit-cover {
    object-fit: cover;
  }
  
  .pagination .page-item.active .page-link {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
  }
  
  .pagination .page-link {
    color: var(--text-color);
    background-color: var(--card-bg);
    border-color: var(--hover-color);
  }
  
  .pagination .page-link:hover {
    background-color: var(--hover-color);
  }
</style>

<script>
  // Animasi saat kartu muncul
  document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
      card.style.opacity = '0';
      card.style.transform = 'translateY(20px)';
      card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
      
      setTimeout(() => {
        card.style.opacity = '1';
        card.style.transform = 'translateY(0)';
      }, index * 100);
    });
  });
</script>
@endsection