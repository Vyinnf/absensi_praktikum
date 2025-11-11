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


}
