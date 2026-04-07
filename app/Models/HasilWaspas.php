<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilWaspas extends Model
{
    use HasFactory;

    protected $table = 'hasil_waspas';
    protected $primaryKey = 'id_hasil_waspas';

    protected $fillable = [
        'batch_id',
        'id_pasar',
        'id_pengguna',
        'skor_wsm',
        'skor_wpm',
        'skor_total_qi',
        'rangking',
    ];

    public function pasar()
    {
        return $this->belongsTo(Pasar::class, 'id_pasar');
    }
}
