@extends('layout.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
  <h2 class="mb-4">Dashboard</h2>
  <div class="row g-4">
    <div class="col-md-6 col-lg-4">
      <div class="card card-custom p-4 text-center">
        <div class="card-icon mb-2"><i class="bi bi-book"></i></div>
        <h5>Total Buku</h5>
        <p class="text-muted">150 Buku</p>
      </div>
    </div>
    <div class="col-md-6 col-lg-4">
      <div class="card card-custom p-4 text-center">
        <div class="card-icon mb-2"><i class="bi bi-hourglass-split"></i></div>
        <h5>Dipinjam</h5>
        <p class="text-muted">35 Buku</p>
      </div>
    </div>
    <div class="col-md-6 col-lg-4">
      <div class="card card-custom p-4 text-center">
        <div class="card-icon mb-2"><i class="bi bi-arrow-return-left"></i></div>
        <h5>Belum Dikembalikan</h5>
        <p class="text-muted">12 Buku</p>
      </div>
    </div>
  </div>
</div>
@endsection