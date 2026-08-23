<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Mapel;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index()
    {
        $nilais = Nilai::with(['siswa', 'mapel'])
            ->where('jenis', 'Tugas')
            ->latest()
            ->paginate(10);
        $kelasList = Siswa::query()->whereNotNull('kelas')->distinct()->orderBy('kelas')->pluck('kelas');
        $mapelList = Mapel::orderBy('nama_mapel')->get();
        $selectedKelas = request('kelas', $kelasList->first());
        $semester = (int) request('semester', 1);
        $tahunAjaran = date('Y') . '/' . (date('Y') + 1);
        $totalNilai = $nilais->total();
        $rataRata = $nilais->avg('nilai') ?? 0;
        $predikatSummary = [];

        return view('nilai.index', compact(
            'nilais',
            'kelasList',
            'mapelList',
            'selectedKelas',
            'semester',
            'tahunAjaran',
            'totalNilai',
            'rataRata',
            'predikatSummary'
        ));
    }

    public function create()
    {
        $mapelList = Mapel::orderBy('nama_mapel')->get();
        $selectedMapel = $mapelList->firstWhere('id', request('mapel_id'));
    
        if (! $selectedMapel) {
            return redirect()->route('admin.nilai.index')
                ->with('error', 'Pilih mata pelajaran terlebih dahulu sebelum input nilai.');
        }
    
        $siswas = Siswa::orderBy('nama')->get();
        $selectedKelas = request('kelas', $siswas->first()?->kelas);
        $semester = (int) request('semester', 1);
        $existingNilai = collect();
    
        return view('nilai.create', compact('siswas', 'mapelList', 'selectedKelas', 'selectedMapel', 'semester', 'existingNilai'));
    }

    public function store(Request $request)
    {
        if ($request->has('tugas') || $request->has('uts') || $request->has('uas')) {
            $request->validate([
                'mapel_id' => 'required|exists:mapel,id',
            ]);
    
            foreach (['tugas' => 'Tugas', 'uts' => 'UTS', 'uas' => 'UAS'] as $field => $type) {
                foreach ($request->input($field, []) as $siswaId => $score) {
                    if ($score === null || $score === '') {
                        continue;
                    }
    
                    Nilai::updateOrCreate(
                        ['siswa_id' => $siswaId, 'mapel_id' => $request->input('mapel_id'), 'jenis' => $type],
                        ['nilai' => $score]
                    );
                }
            }
    
            return redirect()->route('admin.nilai.index')->with('success', 'Nilai berhasil disimpan!');
        }
    
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'mapel_id' => 'required|exists:mapel,id',
            'jenis' => 'required|in:Tugas,UTS,UAS',
            'nilai' => 'required|integer|min:0|max:100',
        ]);
    
        Nilai::create($validated);
    
        return redirect()->route('admin.nilai.index')->with('success', 'Nilai berhasil disimpan!');
    }

    public function edit(string $id)
    {
        $nilai = Nilai::findOrFail($id);
        $siswa = Siswa::all();
        $mapel = Mapel::all();
        return view('nilai.edit', compact('nilai', 'siswa', 'mapel'));
    }

    public function update(Request $request, string $id)
    {
        $nilai = Nilai::findOrFail($id);

        if ($request->hasAny(['tugas', 'uts', 'uas'])) {
            foreach (['tugas' => 'Tugas', 'uts' => 'UTS', 'uas' => 'UAS'] as $field => $type) {
                if ($request->filled($field)) {
                    Nilai::updateOrCreate(
                        ['siswa_id' => $nilai->siswa_id, 'mapel_id' => $nilai->mapel_id, 'jenis' => $type],
                        ['nilai' => $request->input($field)]
                    );
                }
            }

            return redirect()->route('admin.nilai.index')->with('success', 'Nilai berhasil diperbarui!');
        }

        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'mapel_id' => 'required|exists:mapel,id',
            'jenis' => 'required|in:Tugas,UTS,UAS',
            'nilai' => 'required|integer|min:0|max:100',
        ]);

        $nilai->update($validated);

        return redirect()->route('admin.nilai.index')->with('success', 'Nilai berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $nilai = Nilai::findOrFail($id);
        $nilai->delete();

        return redirect()->route('admin.nilai.index')->with('success', 'Nilai berhasil dihapus!');
    }

    public function show(string $id)
    {
        $nilai = Nilai::with(['siswa', 'mapel'])->findOrFail($id);

        return view('nilai.show', compact('nilai'));
    }
}