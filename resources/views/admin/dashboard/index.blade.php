@extends('layout.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
  <h1 class="mt-4 mb-4 text-primary"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h1>
<h2 class="fw-bold mb-0">Hallo Selamat Datang, {{ Auth::user()->nama }}</h2>
<br>
  <div class="row">
    @php
      $cards = [
        ['title' => 'Total Barang', 'count' => $totalBarang, 'icon' => 'fa-boxes', 'color' => 'primary'],
        ['title' => 'Total Member', 'count' => $totalMember, 'icon' => 'fa-users', 'color' => 'success'],
        ['title' => 'Peminjaman Aktif', 'count' => $totalPeminjamanBerlangsung, 'icon' => 'fa-clipboard-list', 'color' => 'info'],
        ['title' => 'Total Pengembalian', 'count' => $totalPengembalian, 'icon' => 'fa-exchange-alt', 'color' => 'warning'],
      ];
    @endphp

    @foreach($cards as $card)
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-start-{{ $card['color'] }} shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col me-2">
              <div class="text-xs font-weight-bold text-{{ $card['color'] }} text-uppercase mb-1">{{ $card['title'] }}</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $card['count'] }}</div>
            </div>
            <div class="col-auto">
              <i class="fas {{ $card['icon'] }} fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <div class="row">
    <!-- Grafik Peminjaman -->
    <div class="col-xl-8 col-lg-7 mb-4">
      <div class="card shadow h-100">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
          <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-chart-line me-2"></i>Peminjaman per Bulan</h6>
        </div>
        <div class="card-body">
          <canvas id="peminjamanChart" height="100"></canvas>
        </div>
      </div>
    </div>

    <!-- Barang Populer -->
    <div class="col-xl-4 col-lg-5 mb-4">
      <div class="card shadow h-100">
        <div class="card-header bg-white">
          <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-star me-2"></i>Barang Paling Populer</h6>
        </div>
        <div class="card-body text-center">
          @if($barangPopuler)
            @if($barangPopuler->cover)
              <img src="{{ asset('storage/' . $barangPopuler->cover) }}" class="img-fluid rounded mb-3" style="max-height: 150px;">
            @else
              <div class="bg-light py-4 mb-3"><i class="fas fa-box-open fa-3x text-muted"></i></div>
            @endif
            <h5>{{ $barangPopuler->merk }}</h5>
            <p class="text-muted">{{ $barangPopuler->kategori->nama }}</p>
            <span class="badge bg-primary">Dipinjam {{ $barangPopuler->pinjams_count }} kali</span>
            <p class="mt-3">{{ Str::limit($barangPopuler->deskripsi, 100) }}</p>
            <a href="{{ route('admin.barang.show', $barangPopuler->id) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
          @else
            <p class="text-muted">Tidak ada data barang populer.</p>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Aktivitas Terkini -->
  <div class="card shadow mb-4">
    <div class="card-header bg-white">
      <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-history me-2"></i>Aktivitas Terkini</h6>
    </div>
    <div class="card-body">
      @forelse($aktivitasTerkini as $aktivitas)
        <div class="mb-3">
          <strong class="text-{{ $aktivitas['tipe'] == 'Peminjaman' ? 'info' : 'success' }}">{{ $aktivitas['tipe'] }}</strong> -
          <span>{{ $aktivitas['barang'] }}</span>
          <br>
          <small class="text-muted">{{ $aktivitas['waktu']->diffForHumans() }} - {{ $aktivitas['deskripsi'] }}</small>
        </div>
        <hr>
      @empty
        <p class="text-muted text-center mb-0">Belum ada aktivitas terbaru.</p>
      @endforelse
    </div>
  </div>
</div>
@endsection

@section('scripts')

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('peminjamanChart').getContext('2d');
    const data = @json(array_values($grafikPeminjaman));

    const chart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
        datasets: [{
          label: 'Jumlah Peminjaman',
          data: data.length === 12 ? data : [...Array(12)].map((_, i) => data[i] || 0),
          borderColor: 'rgba(78, 115, 223, 1)',
          backgroundColor: 'rgba(116, 136, 195, 0.1)',
          pointBackgroundColor: 'rgba(78, 115, 223, 1)',
          borderWidth: 2,
          fill: true,
          tension: 0.3
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              precision: 0
            }
          }
        },
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: context => `${context.parsed.y} peminjaman`
            }
          }
        }
      }
    });
  });
</script>
@endsection
