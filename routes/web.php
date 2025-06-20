<?php

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
| Guest Routes (Belum Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [SesiController::class, 'index'])->name('login');
    Route::post('/login', [SesiController::class, 'login'])->name('login.post');
    Route::redirect('/', '/dashboard')->name('home');
});

/* 
|--------------------------------------------------------------------------
| Authenticated Routes (Sudah Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Logout (better as POST for security)
    Route::post('/logout', [SesiController::class, 'logout'])->name('logout');
    
    /* Admin Routes */
    Route::prefix('admin')->name('admin.')->middleware(['userakses:admin'])->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/members', [AdminController::class, 'member'])->name('members');
        Route::get('/layouts', [AdminController::class, 'layouts'])->name('layouts');
        
        // Resource Routes with explicit naming
        Route::resource('kategori', KategoriController::class)
            ->except(['show'])
            ->names([
                'index' => 'kategori.index',
                'create' => 'kategori.create',
                'store' => 'kategori.store',
                'edit' => 'kategori.edit',
                'update' => 'kategori.update',
                'destroy' => 'kategori.destroy'
            ]);
            
        Route::resource('barang', BarangController::class)
            ->except(['show'])
            ->names([
                'index' => 'barang.index',
                // ... same pattern as above
            ]);
    });
    
    /* Member Routes */
    Route::prefix('member')->name('member.')->middleware(['userakses:member'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'member'])->name('dashboard');
        
        // More explicit route definitions
        Route::prefix('peminjaman')->name('peminjaman.')->group(function () {
            Route::get('/', [PeminjamanController::class, 'index'])->name('index');
            Route::get('/create', [PeminjamanController::class, 'create'])->name('create');
            Route::post('/', [PeminjamanController::class, 'store'])->name('store');
        });
        
        // Similar for pengembalian
        Route::prefix('pengembalian')->name('pengembalian.')->group(function () {
            Route::get('/', [PengembalianController::class, 'index'])->name('index');
            // ... other routes
        });
    });
    
    /* Shared Routes */
    Route::get('/peminjaman/{peminjaman}', [PeminjamanController::class, 'show'])
        ->name('peminjaman.show');
        
    Route::get('/pengembalian/{pengembalian}', [PengembalianController::class, 'show'])
        ->name('pengembalian.show');
});

/* Fallback Route */
Route::fallback(function () {
    return auth()->check() 
        ? redirect()->route('dashboard') 
        : redirect()->route('login');
})->name('fallback');