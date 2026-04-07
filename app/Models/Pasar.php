<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasar extends Model
{
    use HasFactory;

    protected $table = 'pasar';
    protected $primaryKey = 'id_pasar';

    protected $fillable = [
        'nama_pasar',
        'alamat',
        'keterangan',
    ];
}
