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
        $kelasList = Siswa::whereNotNull('kelas')->distinct()->orderBy('kelas')->pluck('kelas');
        $mapelList = Mapel::orderBy('nama_mapel')->get();

        $selectedKelas = request('kelas', $kelasList->first());
        $mapelId = request('mapel_id');
        $semester = (int) request('semester', 1);
        $tahunAjaran = date('Y') . '/' . (date('Y') + 1);
        $mapelIdForCreate = $mapelId ?: optional($mapelList->first())->id;

        $anchorIds = Nilai::selectRaw('MIN(id) as id')
            ->groupBy('siswa_id', 'mapel_id', 'semester')
            ->pluck('id');

        $query = Nilai::with(['siswa', 'mapel'])
            ->whereIn('id', $anchorIds)
            ->where('semester', $semester)
            ->when($mapelId, fn ($q) => $q->where('mapel_id', $mapelId))
            ->when($selectedKelas, fn ($q) => $q->whereHas('siswa', fn ($sq) => $sq->where('kelas', $selectedKelas)));

        $semuaNilai = (clone $query)->get();
        $totalNilai = $semuaNilai->count();
        $rataRata = $semuaNilai->avg('nilai_akhir') ?? 0;

        $predikatCount = ['A' => 0, 'B' => 0, 'C' => 0, 'D' => 0, 'E' => 0];
        foreach ($semuaNilai as $n) {
            $na = $n->nilai_akhir;
            $grade = $na >= 88 ? 'A' : ($na >= 75 ? 'B' : ($na >= 60 ? 'C' : ($na >= 50 ? 'D' : 'E')));
            $predikatCount[$grade]++;
        }
        $colors = ['A' => '#16a34a', 'B' => '#0d9488', 'C' => '#f59e0b', 'D' => '#f97316', 'E' => '#dc2626'];
        $predikatSummary = collect($predikatCount)->map(fn ($count, $label) => [
            'label' => $label,
            'count' => $count,
            'color' => $colors[$label],
        ])->values();

        $nilais = $query->latest()->paginate(10);

        return view('nilai.index', compact(
            'nilais', 'kelasList', 'mapelList', 'selectedKelas', 'semester', 'tahunAjaran',
            'totalNilai', 'rataRata', 'predikatSummary', 'mapelIdForCreate'
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

            $semester = (int) $request->input('semester', 1);

            foreach (['tugas' => 'Tugas', 'uts' => 'UTS', 'uas' => 'UAS'] as $field => $type) {
                foreach ($request->input($field, []) as $siswaId => $score) {
                    if ($score === null || $score === '') {
                        continue;
                    }

                    Nilai::updateOrCreate(
                        [
                            'siswa_id' => $siswaId,
                            'mapel_id' => $request->input('mapel_id'),
                            'semester' => $semester,
                            'jenis' => $type,
                        ],
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
                        [
                            'siswa_id' => $nilai->siswa_id,
                            'mapel_id' => $nilai->mapel_id,
                            'semester' => $nilai->semester,
                            'jenis' => $type,
                        ],
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