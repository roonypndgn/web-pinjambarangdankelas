@extends('layout.member') {{-- Asumsi Anda menggunakan template di atas sebagai layout --}}

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
  <!-- Header Dashboard -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <h2 class="fw-bold mb-0">Dashboard Peminjaman</h2>
        <div class="d-flex">
          <span class="badge bg-primary rounded-pill me-2 d-flex align-items-center">
            <i class="bi bi-person-fill me-1"></i> Member
          </span>
          <span class="badge bg-secondary rounded-pill d-flex align-items-center">
            <i class="bi bi-calendar3 me-1"></i> {{ now()->format('d M Y') }}
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
              <h3 class="mb-0 fw-bold">5</h3>
            </div>
            <div class="bg-primary bg-opacity-10 p-3 rounded">
              <i class="bi bi-box-seam fs-4 text-primary"></i>
            </div>
          </div>
          <div class="mt-3">
            <span class="badge bg-success bg-opacity-10 text-success">+2 dari kemarin</span>
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
              <h3 class="mb-0 fw-bold">42</h3>
            </div>
            <div class="bg-success bg-opacity-10 p-3 rounded">
              <i class="bi bi-check-circle fs-4 text-success"></i>
            </div>
          </div>
          <div class="mt-3">
            <a href="#" class="small text-decoration-none">Lihat katalog</a>
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
              <h3 class="mb-0 fw-bold">2</h3>
            </div>
            <div class="bg-warning bg-opacity-10 p-3 rounded">
              <i class="bi bi-exclamation-triangle fs-4 text-warning"></i>
            </div>
          </div>
          <div class="mt-3">
            <span class="badge bg-warning bg-opacity-10 text-warning">Batas waktu dekat</span>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-md-3">
      <div class="card border-0 shadow-sm h-100" style="background-color: var(--card-bg);">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="text-muted mb-2">Riwayat Peminjaman</h6>
              <h3 class="mb-0 fw-bold">17</h3>
            </div>
            <div class="bg-info bg-opacity-10 p-3 rounded">
              <i class="bi bi-clock-history fs-4 text-info"></i>
            </div>
          </div>
          <div class="mt-3">
            <a href="#" class="small text-decoration-none">Lihat riwayat</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Shortcut Peminjaman -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card border-0 shadow-sm" style="background-color: var(--card-bg);">
        <div class="card-body">
          <h5 class="card-title fw-bold mb-4">
            <i class="bi bi-lightning-charge-fill text-warning me-2"></i> Shortcut Peminjaman Cepat
          </h5>
          
          <div class="row">
            <div class="col-md-3 mb-3">
              <a href="#" class="btn btn-primary w-100 h-100 py-3 d-flex flex-column align-items-center justify-content-center">
                <i class="bi bi-laptop fs-2 mb-2"></i>
                <span>Laptop</span>
              </a>
            </div>
            
            <div class="col-md-3 mb-3">
              <a href="#" class="btn btn-success w-100 h-100 py-3 d-flex flex-column align-items-center justify-content-center">
                <i class="bi bi-projector fs-2 mb-2"></i>
                <span>Proyektor</span>
              </a>
            </div>
            
            <div class="col-md-3 mb-3">
              <a href="#" class="btn btn-info w-100 h-100 py-3 d-flex flex-column align-items-center justify-content-center">
                <i class="bi bi-camera-video fs-2 mb-2"></i>
                <span>Kamera</span>
              </a>
            </div>
            
            <div class="col-md-3">
              <a href="#" class="btn btn-warning w-100 h-100 py-3 d-flex flex-column align-items-center justify-content-center">
                <i class="bi bi-mic fs-2 mb-2"></i>
                <span>Perangkat Audio</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Peminjaman Aktif & Jadwal -->
  <div class="row">
    <!-- Peminjaman Aktif -->
    <div class="col-lg-8 mb-4 mb-lg-0">
      <div class="card border-0 shadow-sm h-100" style="background-color: var(--card-bg);">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title fw-bold mb-0">
              <i class="bi bi-box-seam text-primary me-2"></i> Peminjaman Aktif
            </h5>
            <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
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
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="https://via.placeholder.com/40" alt="Laptop" class="rounded me-2" width="40" height="40">
                      <div>
                        <div class="fw-bold">Laptop Asus ROG</div>
                        <small class="text-muted">#ID-20240001</small>
                      </div>
                    </div>
                  </td>
                  <td>15 Jun 2024</td>
                  <td>20 Jun 2024</td>
                  <td><span class="badge bg-success">Aktif</span></td>
                  <td>
                    <button class="btn btn-sm btn-outline-secondary">Detail</button>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="https://via.placeholder.com/40" alt="Proyektor" class="rounded me-2" width="40" height="40">
                      <div>
                        <div class="fw-bold">Proyektor Epson</div>
                        <small class="text-muted">#ID-20240002</small>
                      </div>
                    </div>
                  </td>
                  <td>18 Jun 2024</td>
                  <td>22 Jun 2024</td>
                  <td><span class="badge bg-warning text-dark">Batas waktu dekat</span></td>
                  <td>
                    <button class="btn btn-sm btn-outline-secondary">Detail</button>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="https://via.placeholder.com/40" alt="Kamera" class="rounded me-2" width="40" height="40">
                      <div>
                        <div class="fw-bold">Kamera Canon EOS</div>
                        <small class="text-muted">#ID-20240003</small>
                      </div>
                    </div>
                  </td>
                  <td>20 Jun 2024</td>
                  <td>25 Jun 2024</td>
                  <td><span class="badge bg-success">Aktif</span></td>
                  <td>
                    <button class="btn btn-sm btn-outline-secondary">Detail</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Jadwal & Pengumuman -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm h-100" style="background-color: var(--card-bg);">
        <div class="card-body">
          <ul class="nav nav-tabs" id="infoTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="jadwal-tab" data-bs-toggle="tab" data-bs-target="#jadwal" type="button" role="tab">
                <i class="bi bi-calendar-event me-1"></i> Jadwal
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pengumuman-tab" data-bs-toggle="tab" data-bs-target="#pengumuman" type="button" role="tab">
                <i class="bi bi-megaphone me-1"></i> Pengumuman
              </button>
            </li>
          </ul>
          
          <div class="tab-content mt-3" id="infoTabsContent">
            <!-- Tab Jadwal -->
            <div class="tab-pane fade show active" id="jadwal" role="tabpanel">
              <div class="list-group list-group-flush">
                <div class="list-group-item d-flex justify-content-between align-items-center">
                  <div>
                    <div class="fw-bold">Pengembalian Proyektor</div>
                    <small class="text-muted">22 Jun 2024 - 10:00 WIB</small>
                  </div>
                  <span class="badge bg-warning text-dark">Hari Ini</span>
                </div>
                <div class="list-group-item">
                  <div class="fw-bold">Peminjaman Kamera</div>
                  <small class="text-muted">25 Jun 2024 - 08:00 WIB</small>
                </div>
                <div class="list-group-item">
                  <div class="fw-bold">Workshop Fotografi</div>
                  <small class="text-muted">28 Jun 2024 - 13:00 WIB</small>
                </div>
              </div>
              <a href="#" class="btn btn-sm btn-outline-primary w-100 mt-3">Lihat Kalender</a>
            </div>
            
            <!-- Tab Pengumuman -->
            <div class="tab-pane fade" id="pengumuman" role="tabpanel">
              <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Maintenance Sistem</strong> pada 25 Juni 2024 pukul 00:00-03:00 WIB
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
        <form>
          <div class="mb-3">
            <label class="form-label">Pilih Barang</label>
            <select class="form-select">
              <option selected>-- Pilih Barang --</option>
              <option>Laptop Asus ROG</option>
              <option>Proyektor Epson</option>
              <option>Kamera Canon EOS</option>
              <option>Microphone Rode</option>
            </select>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Tanggal Pinjam</label>
              <input type="date" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Tanggal Kembali</label>
              <input type="date" class="form-control">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Keperluan</label>
            <textarea class="form-control" rows="3"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary">Ajukan Peminjaman</button>
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