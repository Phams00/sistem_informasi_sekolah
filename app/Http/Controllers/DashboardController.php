<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Mapel;
use App\Models\Absensi;
use App\Models\Jadwal;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalGuru = Guru::count();
        $totalSiswa = Siswa::count();
        $totalMapel = Mapel::count();
        $absensiHariIni = Absensi::whereDate('tanggal', today())->count();
        $kehadiranHariIni = $totalSiswa > 0
            ? (int) round(Absensi::whereDate('tanggal', today())->where('status', 'Hadir')->count() / $totalSiswa * 100)
            : 0;
        $kehadiranMinggu = collect(range(0, 6))->map(function (int $daysAgo): array {
            $date = Carbon::today()->subDays($daysAgo);
            $total = Absensi::whereDate('tanggal', $date)->count();
            $hadir = Absensi::whereDate('tanggal', $date)->where('status', 'Hadir')->count();

            return [
                'label' => $date->translatedFormat('D'),
                'persen' => $total > 0 ? (int) round($hadir / $total * 100) : 0,
                'color' => '#0d9488',
                'colorLight' => '#5eead4',
            ];
        })->reverse()->values();
        $kehadiranBulan = $kehadiranMinggu;
        $aktivitas = collect();
        $jadwalHariIni = Jadwal::with(['guru', 'mapel'])
            ->where('hari', Carbon::today()->translatedFormat('l'))
            ->orderBy('jam_mulai')
            ->get()
            ->map(fn (Jadwal $jadwal): array => [
                'jam' => $jadwal->jam_mulai . ' - ' . $jadwal->jam_selesai,
                'mapel' => $jadwal->mapel->nama,
                'guru' => $jadwal->guru->nama,
                'kelas' => $jadwal->kelas,
            ]);

        return view('dashboard', compact(
            'totalGuru',
            'totalSiswa',
            'totalMapel',
            'absensiHariIni',
            'kehadiranHariIni',
            'kehadiranMinggu',
            'kehadiranBulan',
            'aktivitas',
            'jadwalHariIni'
        ));
    }
}