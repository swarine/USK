<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PelangganHomeController;
use App\Http\Controllers\CheckoutController;

// ── AUTH ──────────────────────────────────────────
Route::get('/',          [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',    [AuthController::class, 'login'])->name('login.post');
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');
Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// ── ADMIN ─────────────────────────────────────────
Route::middleware('auth.admin')->group(function () {
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('produk',    ProdukController::class);
    Route::resource('penjualan', PenjualanController::class);
    Route::patch('/penjualan/{id}/status', [PenjualanController::class, 'updateStatus'])->name('penjualan.status');
});

// ── PELANGGAN ─────────────────────────────────────
Route::middleware('auth.pelanggan')->group(function () {
    Route::get('/home',      [PelangganHomeController::class, 'home'])->name('pelanggan.home');
    Route::get('/riwayat',   [PelangganHomeController::class, 'riwayat'])->name('pelanggan.riwayat');
    Route::get('/checkout',  [CheckoutController::class, 'show'])->name('pelanggan.checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('pelanggan.checkout');
});
