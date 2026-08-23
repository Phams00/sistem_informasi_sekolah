<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';

    protected $fillable = [
        'siswa_id',
        'tanggal',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function getPersenKehadiranAttribute(): float
    {
        $total = static::query()->where('siswa_id', $this->siswa_id)->count();
        $hadir = static::query()->where('siswa_id', $this->siswa_id)->where('status', 'Hadir')->count();

        return $total > 0 ? ($hadir / $total) * 100 : 0;
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}