<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class MahasiswaController extends Controller
{
    // Menampilkan dashboard absensi
    public function index()
    {
        // Ambil semua data mahasiswa dari database
        $mahasiswa = Mahasiswa::all();

        // Kirim ke view dashboard
        return view('dashboard', compact('mahasiswa'));
    }

    // Menyimpan data mahasiswa baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nim' => 'required|numeric|unique:mahasiswas,nim',
            'nama' => 'required|string|max:255',
        ]);

        // Simpan ke database
        Mahasiswa::create([
            'nim' => $request->nim,
            'nama' => $request->nama,
        ]);

        // Kembali ke dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Mahasiswa berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'nim' => 'required',
        'nama' => 'required',
    ]);

    $mahasiswa = Mahasiswa::findOrFail($id);
    $mahasiswa->update([
        'nim' => $request->nim,
        'nama' => $request->nama,
    ]);

    return redirect()->route('dashboard')->with('success', 'Data mahasiswa berhasil diperbarui.');
}

}
