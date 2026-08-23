<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';

    protected $fillable = [
        'nama',
        'nip',
        'jenis_kelamin',
        'ttl',
        'mata_pelajaran',
        'jabatan',
        'email',
        'no_telepon',
        'alamat',
    ];

    public function getMapelAttribute(): ?string
    {
        return $this->mata_pelajaran;
    }

    public function getTeleponAttribute(): ?string
    {
        return $this->no_telepon;
    }
}