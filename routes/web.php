<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;

// Route untuk menampilkan dashboard (dengan data mahasiswa)
Route::get('/', [MahasiswaController::class, 'index'])->name('dashboard');

// Route untuk menyimpan data mahasiswa baru
Route::post('/mahasiswa/store', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
Route::put('/mahasiswa/update/{id}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
