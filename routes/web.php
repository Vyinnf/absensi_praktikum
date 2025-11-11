<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\NilaiController;

// Route untuk menampilkan dashboard (dengan data mahasiswa)
Route::get('/', [MahasiswaController::class, 'index'])->name('dashboard');

// Route untuk menyimpan data mahasiswa baru
Route::post('/mahasiswa/store', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
Route::put('/mahasiswa/update/{id}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
Route::delete('/mahasiswa/delete/{id}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');

// Nilai
Route::post('/nilai/update', [MahasiswaController::class, 'updateNilai'])->name('nilai.update');
