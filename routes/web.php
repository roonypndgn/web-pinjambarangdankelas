<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\MemberBarangController;
use App\Http\Controllers\MemberProfilController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\AdminLaporanMBController;
use App\Http\Controllers\AdminLaporanPPController;
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\MemberPeminjamanController;
use App\Http\Controllers\MemberPengembalianController;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return view('landing_page.index');
    })->name('landing');
    Route::get('/login', [SesiController::class, 'index'])->name('login');
    Route::post('/login', [SesiController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::middleware(['auth'])->group(function () {

    // Logout
    Route::post('/logout', [SesiController::class, 'logout'])->name('logout');

    // Default route setelah login (opsional, bisa diarahkan ke dashboard sesuai role)
    Route::get('/admin', [AdminController::class, 'index']);

     /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['userakses:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::resource('/member', MemberController::class);
            Route::resource('/kategori', KategoriController::class);
            Route::resource('/barang', BarangController::class);
            Route::resource('/peminjaman', PeminjamanController::class);
            Route::post('/peminjaman/{peminjaman}/complete', [PeminjamanController::class, 'complete'])->name('peminjaman.complete');
            Route::post('/peminjaman/{peminjaman}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
            Route::post('/peminjaman/{peminjaman}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');
            Route::post('/peminjaman/{peminjaman}/confirm', [PeminjamanController::class, 'confirm'])->name('peminjaman.confirm');
            Route::resource('pengembalian', PengembalianController::class)->except(['show']);
            Route::get('laporanpeminjaman/export', [AdminLaporanPPController::class, 'exportPdf'])->name('laporanPeminjaman.export');
            Route::get('laporanpengembalian/export', [AdminLaporanPPController::class, 'exportPdfPengembalian'])->name('laporanPengembalian.export');
            Route::get('laporan/laporanbarang', [AdminLaporanMBController::class, 'exportPdf'])->name('laporan.laporanbarang');
            Route::get('laporan/laporanmember', [AdminLaporanMBController::class, 'exportPdfMember'])->name('laporan.laporanmember');


        });

    /*
    |--------------------------------------------------------------------------
    | Member Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['userakses:member'])
        ->prefix('member')
        ->name('member.')
        ->group(function () {
            Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('dashboard.index');
            Route::get('/barang', [MemberBarangController::class, 'index'])->name('barang.index');
            Route::resource('/peminjaman', MemberPeminjamanController::class);
            Route::get('/member/profile', [MemberDashboardController::class, 'profile'])->name('dashboard.profil');
            Route::delete('/peminjaman/{peminjaman}/cancel', [MemberPeminjamanController::class, 'cancel'])->name('peminjaman.cancel');
            Route::get('/dashboard/profile', [MemberProfilController::class, 'index'])->name('dashboard.profile');
            Route::put('/dashboard/profile', [MemberProfilController::class, 'update'])->name('dashboard.profile');
            Route::put('/dashboard/profile/password', [MemberProfilController::class, 'changePassword'])->name('dashboard.changePassword');
            Route::get('/pengembalian', [MemberPengembalianController::class, 'index'])->name('pengembalian.index');
        });
});

/*
|--------------------------------------------------------------------------
| Redirect Default
|--------------------------------------------------------------------------
*/
