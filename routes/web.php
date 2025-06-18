<?php

use App\Http\Controllers\SesiController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    // bisa mengakses halaman login jika belum login
    // jika sudah login, diarahkan ke halaman admin
    Route::get('/', [SesiController::class, 'index'])->name('login');
    Route::post('/', [SesiController::class, 'login']);
});
Route::get('/home', function(){
    return redirect('/admin');
});
Route::middleware(['auth'])->group(function () {
    // hanya bisa diakses jika sudah login
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/admin/admin', [AdminController::class, 'admin'])->middleware('userakses:admin');
    Route::get('/admin/member', [AdminController::class, 'member'])->middleware('userakses:member');
    Route::get('/logout',[SesiController::class,'logout']);
});
