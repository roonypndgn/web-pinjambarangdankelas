<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['guest'])->group(function () {
    Route::get('/', [SesiController::class, 'index'])->name('login');
    Route::post('/', [SesiController::class, 'login']);
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
    Route::middleware(['userakses:admin'])->group(function () {
        Route::get('/admin/admin', [AdminController::class, 'admin'])->name('admin.dashboard');

        // Resource routes khusus admin
        Route::resource('/kategori', KategoriController::class);
        Route::resource('/barang', BarangController::class);
        Route::resource('/peminjaman', PeminjamanController::class);
        Route::resource('/pengembalian', PengembalianController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | Member Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['userakses:member'])->group(function () {
        Route::get('/admin/member', [AdminController::class, 'member'])->name('member.dashboard');

        // Jika member diizinkan akses ini, tidak perlu diduplikasi
        // Hapus jika hanya admin yang boleh akses
        Route::resource('/peminjaman', PeminjamanController::class);
        Route::resource('/pengembalian', PengembalianController::class);
    });
});

/*
|--------------------------------------------------------------------------
| Redirect Default
|--------------------------------------------------------------------------
*/