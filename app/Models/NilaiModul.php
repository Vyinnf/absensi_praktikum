<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiModul extends Model
{
    use HasFactory;

    protected $fillable = ['mahasiswa_id', 'modul', 'kehadiran', 'laporan', 'demo'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
