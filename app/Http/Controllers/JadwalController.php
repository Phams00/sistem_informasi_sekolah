<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Siswa;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::with(['guru', 'mapel'])->latest()->get();
        $kelasList = Siswa::query()->whereNotNull('kelas')->distinct()->orderBy('kelas')->pluck('kelas');
        $selectedKelas = request('kelas', $kelasList->first());
        $jadwalData = $jadwals->groupBy('hari')->map(function ($items) {
            return $items->keyBy('jam_ke');
        });
        $legendColors = $jadwals->map(function ($item) {
            return ['nama' => $item->mapel->nama, 'color' => $item->color_text];
        })->unique('nama')->values();
        $jamList = $this->jamList();

        return view('jadwal.index', compact(
            'kelasList',
            'selectedKelas',
            'jadwalData',
            'legendColors',
            'jamList'
        ));
    }

    public function create()
    {
        $guruList = Guru::orderBy('nama')->get();
        $mapelList = Mapel::orderBy('nama_mapel')->get();
        $kelasList = Siswa::query()->whereNotNull('kelas')->distinct()->orderBy('kelas')->pluck('kelas');
        $jamList = $this->jamList();

        return view('jadwal.create', compact('guruList', 'mapelList', 'kelasList', 'jamList'));
    }

    public function store(Request $request)
    {
        $times = $this->slotTimes((int) $request->input('jam_ke'));
        $request->merge([
            'jam_mulai' => $times['mulai'] ?? null,
            'jam_selesai' => $times['selesai'] ?? null,
        ]);

        $validated = $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'mapel_id' => 'required|exists:mapel,id',
            'kelas' => 'required|string|max:50',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        Jadwal::create($validated);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil disimpan!');
    }

    public function edit(string $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $guruList = Guru::orderBy('nama')->get();
        $mapelList = Mapel::orderBy('nama_mapel')->get();
        $kelasList = Siswa::query()->whereNotNull('kelas')->distinct()->orderBy('kelas')->pluck('kelas');
        $jamList = $this->jamList();

        return view('jadwal.edit', compact('jadwal', 'guruList', 'mapelList', 'kelasList', 'jamList'));
    }

    public function update(Request $request, string $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $times = $this->slotTimes((int) $request->input('jam_ke'));
        $request->merge([
            'jam_mulai' => $times['mulai'] ?? null,
            'jam_selesai' => $times['selesai'] ?? null,
        ]);

        $validated = $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'mapel_id' => 'required|exists:mapel,id',
            'kelas' => 'required|string|max:50',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        $jadwal->update($validated);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dihapus!');
    }

    private function jamList(): array
    {
        return [
            ['ke' => 1, 'label' => 'Jam Ke-1', 'waktu' => '07:00 - 07:45'],
            ['ke' => 2, 'label' => 'Jam Ke-2', 'waktu' => '07:45 - 08:30'],
            ['ke' => 3, 'label' => 'Jam Ke-3', 'waktu' => '08:30 - 09:15'],
            ['ke' => 4, 'label' => 'Jam Ke-4', 'waktu' => '09:15 - 10:00'],
            ['ke' => 5, 'label' => 'Jam Ke-5', 'waktu' => '10:15 - 11:00'],
            ['ke' => 6, 'label' => 'Jam Ke-6', 'waktu' => '11:00 - 11:45'],
            ['ke' => 7, 'label' => 'Jam Ke-7', 'waktu' => '12:45 - 13:30'],
            ['ke' => 8, 'label' => 'Jam Ke-8', 'waktu' => '13:30 - 14:15'],
        ];
    }

    private function slotTimes(int $slot): ?array
    {
        $times = [
            1 => ['mulai' => '07:00', 'selesai' => '07:45'],
            2 => ['mulai' => '07:45', 'selesai' => '08:30'],
            3 => ['mulai' => '08:30', 'selesai' => '09:15'],
            4 => ['mulai' => '09:15', 'selesai' => '10:00'],
            5 => ['mulai' => '10:15', 'selesai' => '11:00'],
            6 => ['mulai' => '11:00', 'selesai' => '11:45'],
            7 => ['mulai' => '12:45', 'selesai' => '13:30'],
            8 => ['mulai' => '13:30', 'selesai' => '14:15'],
        ];

        return $times[$slot] ?? null;
    }
}