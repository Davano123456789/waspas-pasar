<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaian';
    protected $primaryKey = 'id_penilaian';

    protected $fillable = [
        'id_pengguna',
        'id_pasar',
        'id_kriteria',
        'nilai',
        'nilai_asli',
    ];

    public function pasar()
    {
        return $this->belongsTo(Pasar::class, 'id_pasar');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria');
    }
}
