<?php

namespace Database\Seeders;

use App\Models\Mapel;
use Illuminate\Database\Seeder;

class MapelSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode_mapel' => 'MTK', 'nama_mapel' => 'Matematika'],
            ['kode_mapel' => 'IPA', 'nama_mapel' => 'Ilmu Pengetahuan Alam'],
            ['kode_mapel' => 'BIN', 'nama_mapel' => 'Bahasa Indonesia'],
        ];

        foreach ($data as $item) {
            Mapel::updateOrCreate(['kode_mapel' => $item['kode_mapel']], $item);
        }
    }
}