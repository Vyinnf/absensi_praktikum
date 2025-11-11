<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = ['nim', 'nama'];

    public function nilai_moduls()
    {
        return $this->hasMany(NilaiModul::class);
    }

    /**
     * Hitung rata-rata dari semua modul (kehadiran, laporan, demo)
     */
    public function getRataRataModul()
    {
        $nilai_moduls = $this->nilai_moduls;
        if ($nilai_moduls->isEmpty()) {
            return 0;
        }

        $total = 0;
        $count = 0;

        foreach ($nilai_moduls as $nilai) {
            if ($nilai->kehadiran !== null) {
                $total += $nilai->kehadiran;
                $count++;
            }
            if ($nilai->laporan !== null) {
                $total += $nilai->laporan;
                $count++;
            }
            if ($nilai->demo !== null) {
                $total += $nilai->demo;
                $count++;
            }
        }

        return $count > 0 ? round($total / $count, 2) : 0;
    }

    /**
     * Hitung nilai akhir: (rata-rata modul * 0.7) + (final project * 0.3)
     */
    public function getNilaiAkhir()
    {
        $rataRata = $this->getRataRataModul();
        $finalProject = $this->nilai_moduls->first()?->final_project ?? 0;

        return round(($rataRata * 0.7) + ($finalProject * 0.3), 2);
    }

    /**
     * Hitung grade berdasarkan nilai akhir
     */
    public function getGrade()
    {
        $nilaiAkhir = $this->getNilaiAkhir();

        if ($nilaiAkhir >= 85) return 'A';
        if ($nilaiAkhir >= 70) return 'B';
        if ($nilaiAkhir >= 60) return 'C';
        if ($nilaiAkhir >= 50) return 'D';
        return 'E';
    }
}
