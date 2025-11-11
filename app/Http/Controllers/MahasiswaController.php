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
        $mahasiswa = Mahasiswa::with('nilai_moduls')->get();

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
            'nim' => 'required|numeric|unique:mahasiswas,nim,' . $id,
            'nama' => 'required|string|max:255',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->update([
            'nim' => $request->nim,
            'nama' => $request->nama,
        ]);

        // Return JSON untuk AJAX
        return response()->json(['success' => true, 'message' => 'Data mahasiswa berhasil diperbarui']);
    }

    public function destroy($id)
    {
        try {
            $mahasiswa = Mahasiswa::findOrFail($id);
            $mahasiswa->delete();

            return response()->json(['success' => true, 'message' => 'Mahasiswa berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function updateNilai(Request $request)
    {
        $validated = $request->validate([
            'mahasiswa_id' => 'required|integer',
            'modul' => 'nullable|integer|min:1|max:10',
            'kolom' => 'required|string|in:kehadiran,laporan,demo,final_project',
            'nilai' => 'nullable|integer|min:0|max:100',
        ]);

        // Untuk final_project, modul bisa null (karena final_project adalah 1 nilai per mahasiswa)
        if ($validated['kolom'] === 'final_project') {
            $nilai = \App\Models\NilaiModul::firstOrCreate(
                [
                    'mahasiswa_id' => $validated['mahasiswa_id'],
                    'modul' => 1, // Gunakan modul 1 sebagai storage final_project
                ]
            );
        } else {
            $nilai = \App\Models\NilaiModul::firstOrCreate(
                [
                    'mahasiswa_id' => $validated['mahasiswa_id'],
                    'modul' => $validated['modul'],
                ]
            );
        }

        $nilai->{$validated['kolom']} = $validated['nilai'];
        $nilai->save();

        return response()->json(['success' => true]);
    }
}

