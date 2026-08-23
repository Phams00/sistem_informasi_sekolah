<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama' => 'Ahmad Fuadi', 'mata_pelajaran' => 'Inggris', 'email' => 'ahmad.fuadi@example.com', 'no_telepon' => '081234567890'],
            ['nama' => 'Siti Nurhaliza', 'mata_pelajaran' => 'Matematika', 'email' => 'siti.nurhaliza@example.com', 'no_telepon' => '081234567891'],
            ['nama' => 'Budi Santoso', 'mata_pelajaran' => 'Fisika', 'email' => 'budi.santoso@example.com', 'no_telepon' => '081234567892']
        ];

        foreach ($data as $item) {
            \App\Models\Guru::updateOrCreate(
                ['email' => $item['email']],
                $item
            );
        }
    }
}
