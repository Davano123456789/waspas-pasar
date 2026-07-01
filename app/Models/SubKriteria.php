<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    use HasFactory;

    protected $table = 'sub_kriteria';
    protected $primaryKey = 'id_sub_kriteria';

    protected $fillable = [
        'id_kriteria',
        'nama_sub_kriteria',
        'nilai_likert',
        'minimal_nilai',
        'maksimal_nilai',
    ];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria');
    }
}
