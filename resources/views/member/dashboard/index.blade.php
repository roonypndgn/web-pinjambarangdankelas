@extends('layout.member')

@section('title', 'Dashboard Member')

@section('content')
<div class="container-fluid">
  <!-- Header Dashboard -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <h2 class="fw-bold mb-0">Hallo Selamat Datang, {{ Auth::user()->nama }}</h2>
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
          <h6 class="text-muted mb-2">Riwayat Pengembalian</h6>
        </div>
        <div class="bg-info bg-opacity-10 p-3 rounded">
          <i class="bi bi-arrow-repeat fs-4 text-info"></i>
        </div>
        </div>
        <div class="mt-3">
        <a href="{{ route('member.pengembalian.index') }}" class="small text-decoration-none">Lihat riwayat</a>
        </div>
      </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 shadow-sm h-100" style="background-color: var(--card-bg);">
        <div class="card-body d-flex flex-column justify-content-between">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="text-muted mb-2">Jam Saat Ini</h6>
              <h3 class="mb-0 fw-bold" id="current-time"></h3>
            </div>
            <div class="bg-dark bg-opacity-10 p-3 rounded">
              <i class="bi bi-clock-history fs-4 text-dark"></i>
            </div>
          </div>
          <div class="mt-3">
            <span class="small text-muted">Waktu lokal</span>
          </div>
        </div>
      </div>
    </div>
    <script>
      function updateTime() {
        const now = new Date();
        const jam = now.getHours().toString().padStart(2, '0');
        const menit = now.getMinutes().toString().padStart(2, '0');
        const detik = now.getSeconds().toString().padStart(2, '0');
        document.getElementById('current-time').textContent = `${jam}:${menit}:${detik}`;
      }
      setInterval(updateTime, 1000);
      updateTime();
    </script>
  </div>

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
                      <img src="{{ asset($peminjaman->barang->cover ?? 'https://via.placeholder.com/40') }}" alt="{{ $peminjaman->barang->merk }}" class="rounded me-2" width="40" height="40">
                      <div>
                        <div class="fw-bold">{{ $peminjaman->barang->merk }}</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    {{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->translatedFormat('d M Y') }}
                  </td>
                  <td>
                    {{ \Carbon\Carbon::parse($peminjaman->tgl_kembali)->translatedFormat('d M Y') }}
                  </td>
                  <td>
                    @if($peminjaman->status == 'pinjam')
                    @php
                    $tglKembali = \Carbon\Carbon::parse($peminjaman->tgl_kembali);
                    @endphp
                    @if($tglKembali->isToday())
                    <span class="badge bg-warning text-dark">Hari ini kembali</span>
                    @elseif($tglKembali->isPast())
                    <span class="badge bg-danger">Terlambat</span>
                    @else
                    <span class="badge bg-success">Aktif</span>
                    @endif
                    @else
                    <span class="badge bg-secondary">{{ ucfirst($peminjaman->status) }}</span>
                    @endif
                  </td>
                  <td>
                    <a href="{{ route('member.peminjaman.index', $peminjaman->id) }}" class="btn btn-sm btn-outline-secondary">Detail</a>
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

    <div class="col-lg-4">
      <div class="card border-0 shadow-sm h-100" style="background-color: var(--card-bg);">
        <div class="card-body">
          <h5 class="card-title mb-3">
            <i class="bi bi-megaphone me-1"></i> Pengumuman
          </h5>
          <div class="alert alert-secondary">
            <i class="bi bi-envelope-at me-2"></i>
            <strong>Website Dikekola</strong> Biro Fakultas Ilmu Komputer Universitas Methodist Indonesia.
          </div>
          <div class="alert alert-warning">
            <i class="bi bi-calendar-x me-2"></i>
            <strong>Pemberitahuan!</strong> Layanan peminjaman tidak tersedia pada hari Minggu dan tanggal merah.
          </div>
          <div class="alert alert-success">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong>Barang Baru!</strong>
            {{ $barangBaru->count() }} barang terbaru telah tersedia:
            <ul class="mb-0 mt-1 ps-3">
              @foreach($barangBaru as $barang)
              <li>{{ $barang->merk }} ({{ $barang->kode_barang ?? $barang->id }})</li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="alert alert-info mt-4">
  <i class="bi bi-lightbulb me-2"></i>
  Tips: Selalu cek status peminjaman Anda secara berkala untuk menghindari keterlambatan pengembalian.
</div>

<script>
  // Inisialisasi tooltip
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  tooltipTriggerList.map(function(tooltipTriggerEl) {
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