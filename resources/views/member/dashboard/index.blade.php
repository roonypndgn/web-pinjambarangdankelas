@extends('layout.member')

@section('title', 'Dashboard Member')

@section('content')
<div class="container-fluid">
  <!-- Header Dashboard -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        @php
        $hour = (int)now()->format('HH');
            if ($hour >= 5 && $hour < 12) {
                $greeting = 'Selamat Pagi';
            } elseif ($hour >= 12 && $hour < 15) {
                $greeting = 'Selamat Siang';
            } elseif ($hour >= 15 && $hour < 18) {
                $greeting = 'Selamat Sore';
            } else {
                $greeting = 'Selamat Malam';
            }
        @endphp
        <h2 class="fw-bold mb-0">Hallo {{ $greeting }}, {{ Auth::user()->nama }}</h2>
        <div class="d-flex">
          <span class="badge bg-primary rounded-pill me-2 d-flex align-items-center">
            <i class="bi bi-person-fill me-1"></i> {{ Auth::user()->nama }}
          </span>
          <span class="badge bg-secondary rounded-pill d-flex align-items-center">
            <i class="bi bi-calendar3 me-1"></i> {{ now()->translatedFormat('d F Y') }}
          </span>
        </div>
      </div>
      <hr class="mt-2 mb-4" style="border-color: var(--hover-color);">
    </div>
  </div>

  <!-- Statistik Cepat -->
  <div class="row mb-4">
    <div class="col-md-3 mb-3 mb-md-0">
      <div class="card border-0 shadow-sm h-100" style="background-color: var(--card-bg);">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="text-muted mb-2">Peminjaman Aktif</h6>
              <h3 class="mb-0 fw-bold">{{ $peminjamanAktif }}</h3>
            </div>
            <div class="bg-primary bg-opacity-10 p-3 rounded">
              <i class="bi bi-box-seam fs-4 text-primary"></i>
            </div>
          </div>
          <div class="mt-3">
            <a href="{{ route('member.peminjaman.index') }}" class="small text-decoration-none">Lihat detail</a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3 mb-3 mb-md-0">
      <div class="card border-0 shadow-sm h-100" style="background-color: var(--card-bg);">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="text-muted mb-2">Barang Tersedia</h6>
              <h3 class="mb-0 fw-bold">{{ $barangTersedia }}</h3>
            </div>
            <div class="bg-success bg-opacity-10 p-3 rounded">
              <i class="bi bi-check-circle fs-4 text-success"></i>
            </div>
          </div>
          <div class="mt-3">
            <a href="{{ route('member.barang.index') }}" class="small text-decoration-none">Lihat katalog</a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3 mb-3 mb-md-0">
      <div class="card border-0 shadow-sm h-100" style="background-color: var(--card-bg);">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="text-muted mb-2">Harus Dikembalikan</h6>
              <h3 class="mb-0 fw-bold">{{ $harusDikembalikan }}</h3>
            </div>
            <div class="bg-warning bg-opacity-10 p-3 rounded">
              <i class="bi bi-exclamation-triangle fs-4 text-warning"></i>
            </div>
          </div>
          <div class="mt-3">
            @if($harusDikembalikan > 0)
              <span class="badge bg-warning bg-opacity-10 text-warning">Batas waktu dekat</span>
            @else
              <span class="badge bg-success bg-opacity-10 text-success">Tidak ada</span>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Peminjaman Aktif & Barang Populer -->
  <div class="row">
    <!-- Peminjaman Aktif -->
    <div class="col-lg-8 mb-4 mb-lg-0">
      <div class="card border-0 shadow-sm h-100" style="background-color: var(--card-bg);">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title fw-bold mb-0">
              <i class="bi bi-box-seam text-primary me-2"></i> Peminjaman Aktif
            </h5>
            <a href="{{ route('member.peminjaman.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
          </div>

          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Barang</th>
                  <th>Tanggal Pinjam</th>
                  <th>Tanggal Kembali</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($peminjamanAktifList as $peminjaman)
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="{{ asset($peminjaman->barang->foto ?? 'https://via.placeholder.com/40') }}" alt="{{ $peminjaman->barang->merk }}" class="rounded me-2" width="40" height="40">
                      <div>
                        <div class="fw-bold">{{ $peminjaman->barang->merk }}</div>
                        <small class="text-muted">#{{ $peminjaman->kode_peminjaman }}</small>
                      </div>
                    </div>
                  </td>
                  <td>{{ $peminjaman->tgl_pinjam->translatedFormat('d M Y') }}</td>
                  <td>{{ $peminjaman->tgl_kembali->translatedFormat('d M Y') }}</td>
                  <td>
                    @if($peminjaman->status == 'dipinjam')
                      @if($peminjaman->tgl_kembali->isToday())
                        <span class="badge bg-warning text-dark">Hari ini kembali</span>
                      @elseif($peminjaman->tgl_kembali->isPast())
                        <span class="badge bg-danger">Terlambat</span>
                      @else
                        <span class="badge bg-success">Aktif</span>
                      @endif
                    @else
                      <span class="badge bg-secondary">{{ ucfirst($peminjaman->status) }}</span>
                    @endif
                  </td>
                  <td>
                    <a href="{{ route('member.peminjaman.show', $peminjaman->id) }}" class="btn btn-sm btn-outline-secondary">Detail</a>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" class="text-center py-4">
                    <div class="text-muted">
                      <i class="bi bi-inbox fs-2 mb-2"></i>
                      <p>Tidak ada peminjaman aktif</p>
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

    <!-- Barang Populer & Pengumuman -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm h-100" style="background-color: var(--card-bg);">
        <div class="card-body">
          <ul class="nav nav-tabs" id="infoTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="populer-tab" data-bs-toggle="tab" data-bs-target="#populer" type="button" role="tab">
                <i class="bi bi-star-fill me-1"></i> Populer
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pengumuman-tab" data-bs-toggle="tab" data-bs-target="#pengumuman" type="button" role="tab">
                <i class="bi bi-megaphone me-1"></i> Pengumuman
              </button>
            </li>
          </ul>

          <div class="tab-content mt-3" id="infoTabsContent">
            <!-- Tab Barang Populer -->

            <!-- Tab Pengumuman -->
            <div class="tab-pane fade" id="pengumuman" role="tabpanel">
              <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Maintenance Sistem</strong> pada {{ now()->addDays(2)->translatedFormat('d F Y') }} pukul 00:00-03:00 WIB
              </div>
              <div class="alert alert-info">
                <i class="bi bi-info-circle-fill me-2"></i>
                <strong>Perubahan Kebijakan</strong> Durasi peminjaman maksimal 7 hari
              </div>
              <div class="alert alert-success">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>Barang Baru!</strong> 5 Laptop terbaru telah tersedia
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Quick Peminjaman -->
<div class="modal fade" id="quickPinjamModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color: var(--card-bg);">
      <div class="modal-header">
        <h5 class="modal-title">Peminjaman Cepat</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('member.peminjaman.store') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label class="form-label">Pilih Barang</label>
            <select class="form-select" name="barang_id" required>
              <option value="">-- Pilih Barang --</option>
              @foreach($barangPopuler as $barang)
                <option value="{{ $barang->id }}">{{ $barang->merk }} ({{ $barang->kode_barang }})</option>
              @endforeach
            </select>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Tanggal Pinjam</label>
              <input type="date" class="form-control" name="tgl_pinjam" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Tanggal Kembali</label>
              <input type="date" class="form-control" name="tgl_kembali" value="{{ date('Y-m-d', strtotime('+3 days')) }}" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Keperluan</label>
            <textarea class="form-control" name="keperluan" rows="3" required></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Ajukan Peminjaman</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  // Inisialisasi tooltip
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  });

  // Animasi saat masuk dashboard
  document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
      card.classList.add('animate__animated', 'animate__fadeInUp');
      card.style.animationDelay = `${index * 0.1}s`;
    });
  });
</script>
@endsection
