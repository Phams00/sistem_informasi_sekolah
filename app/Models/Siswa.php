<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'nis',
        'nama',
        'kelas',
        'jenis_kelamin',
        'alamat',
        'no_telepon',
    ];

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}