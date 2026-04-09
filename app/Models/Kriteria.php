<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria';
    protected $primaryKey = 'id_kriteria';

    public function sub_kriteria()
    {
        return $this->hasMany(SubKriteria::class, 'id_kriteria')->orderBy('nilai_likert', 'desc');
    }

    protected $fillable = [
        'nama_kriteria',
        'bobot',
        'tipe_kriteria',
    ];
}
