<?php

use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PasarController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\WaspasController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenggunaController;
use Illuminate\Support\Facades\Route;

// Auth Routes (Guest)
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'authenticate'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Admin Only
    Route::middleware(['role:Admin'])->group(function() {
        Route::resource('kriteria', KriteriaController::class);
        Route::resource('pasar', PasarController::class);
        
        // Kelola Akun (Admin)
        Route::get('pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
        Route::get('pengguna/create', [PenggunaController::class, 'create'])->name('pengguna.create');
        Route::post('pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
        Route::get('pengguna/{id}/edit', [PenggunaController::class, 'edit'])->name('pengguna.edit');
        Route::put('pengguna/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
        Route::delete('pengguna/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');
        
        // Process & Save Calculations
        Route::get('perhitungan/proses', [WaspasController::class, 'hitung'])->name('waspas.hitung');
        Route::post('perhitungan/simpan', [WaspasController::class, 'simpan'])->name('waspas.simpan');
        Route::delete('perhitungan/{batch_id}', [WaspasController::class, 'destroy'])->name('waspas.destroy');
    });

    // Admin & Kepala Pasar (Penilaian)
    Route::middleware(['role:Admin,Kepala Pasar'])->group(function() {
        Route::get('penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
        Route::get('penilaian/{id}/input', [PenilaianController::class, 'input'])->name('penilaian.input');
        Route::post('penilaian', [PenilaianController::class, 'store'])->name('penilaian.store');
    });

    // Admin, Direktur, & Kepala Pasar (View & Print Results)
    Route::middleware(['role:Admin,Direktur,Kepala Pasar'])->group(function() {
        Route::get('perhitungan', [WaspasController::class, 'index'])->name('waspas.index');
        Route::get('perhitungan/detail/{batch_id}', [WaspasController::class, 'show'])->name('waspas.show');
        Route::get('perhitungan/cetak/{batch_id}', [WaspasController::class, 'cetak'])->name('waspas.cetak');
    });

    // Admin ONLY (Process & Save Calculations)
    Route::middleware(['role:Admin'])->group(function() {
        Route::get('perhitungan/proses', [WaspasController::class, 'hitung'])->name('waspas.hitung');
        Route::post('perhitungan/simpan', [WaspasController::class, 'simpan'])->name('waspas.simpan');
        Route::delete('perhitungan/{batch_id}', [WaspasController::class, 'destroy'])->name('waspas.destroy');
    });
});
