<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';

    protected $fillable = [
        'guru_id',
        'mapel_id',
        'kelas',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    public function getJamKeAttribute(): ?int
    {
        $slots = [
            '07:00:00' => 1,
            '07:45:00' => 2,
            '08:30:00' => 3,
            '09:15:00' => 4,
            '10:15:00' => 5,
            '11:00:00' => 6,
            '12:45:00' => 7,
            '13:30:00' => 8,
        ];

        return $slots[$this->jam_mulai] ?? null;
    }

    public function getSemesterAttribute(): int
    {
        return 1;
    }

    public function getColorBgAttribute(): string
    {
        return 'rgba(13,148,136,0.1)';
    }

    public function getColorTextAttribute(): string
    {
        return '#0d9488';
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }
}