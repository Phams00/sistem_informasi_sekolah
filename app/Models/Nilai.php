<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';

    protected $fillable = [
        'siswa_id',
        'mapel_id',
        'semester',
        'jenis',
        'nilai',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function getTugasAttribute(): ?int
    {
        return $this->scoreForType('Tugas');
    }

    public function getUtsAttribute(): ?int
    {
        return $this->scoreForType('UTS');
    }

    public function getUasAttribute(): ?int
    {
        return $this->scoreForType('UAS');
    }

    public function getNilaiAkhirAttribute(): int
    {
        return (int) round(($this->tugas ?? 0) * 0.3 + ($this->uts ?? 0) * 0.3 + ($this->uas ?? 0) * 0.4);
    }

    private function scoreForType(string $type): ?int
    {
        if ($this->jenis === $type) {
            return $this->nilai;
        }

        return static::query()
            ->where('siswa_id', $this->siswa_id)
            ->where('mapel_id', $this->mapel_id)
            ->where('semester', $this->semester)
            ->where('jenis', $type)
            ->value('nilai');
    }
}