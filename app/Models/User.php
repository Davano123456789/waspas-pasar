<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'peran',
        'id_pasar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function pasar()
    {
        return $this->belongsTo(Pasar::class, 'id_pasar');
    }

    public function isAdmin()
    {
        return $this->peran === 'Admin';
    }

    public function isKepalaPasar()
    {
        return $this->peran === 'Kepala Pasar';
    }

    public function isDirektur()
    {
        return $this->peran === 'Direktur';
    }
}
