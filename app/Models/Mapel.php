<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $table = 'mapel';

    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
    ];

    public function getKodeAttribute(): ?string
    {
        return $this->kode_mapel;
    }

    public function getNamaAttribute(): ?string
    {
        return $this->nama_mapel;
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }
}