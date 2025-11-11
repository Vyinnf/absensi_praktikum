<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;

Route::get('/', function () {
    return view('dashboard');
});

Route::post('/mahasiswa/store', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
