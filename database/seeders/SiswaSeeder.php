<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nis' => '2026001', 'nama' => 'Ahmad Fauzi', 'kelas' => 'X-A', 'jenis_kelamin' => 'L'],
            ['nis' => '2026002', 'nama' => 'Siti Aminah', 'kelas' => 'X-A', 'jenis_kelamin' => 'P'],
            ['nis' => '2026003', 'nama' => 'Budi Santoso', 'kelas' => 'X-B', 'jenis_kelamin' => 'L'],
        ];

        foreach ($data as $item) {
            Siswa::updateOrCreate(['nis' => $item['nis']], $item);
        }
    }
}