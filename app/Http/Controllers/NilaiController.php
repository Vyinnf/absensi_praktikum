<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nilai;

class NilaiController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'mahasiswa_id' => 'required|integer',
            'modul' => 'required|integer',
            'kolom' => 'required|string',
            'nilai' => 'nullable|string',
        ]);

        // Simpan atau update nilai
        $nilai = Nilai::updateOrCreate(
            [
                'mahasiswa_id' => $validated['mahasiswa_id'],
                'modul' => $validated['modul'],
            ],
            [
                $validated['kolom'] => $validated['nilai'],
            ]
        );

        return response()->json(['success' => true, 'data' => $nilai]);
    }
}
