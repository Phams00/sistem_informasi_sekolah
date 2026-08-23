<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $tanggal = Carbon::parse(request('tanggal', now()->toDateString()));
        $kelasList = Siswa::query()->whereNotNull('kelas')->distinct()->orderBy('kelas')->pluck('kelas');
        $selectedKelas = request('kelas', $kelasList->first());
        $absensis = Absensi::with('siswa')
            ->whereDate('tanggal', $tanggal)
            ->when($selectedKelas, fn ($query) => $query->whereHas('siswa', fn ($siswa) => $siswa->where('kelas', $selectedKelas)))
            ->latest('tanggal')
            ->paginate(10);
        $counts = Absensi::whereDate('tanggal', $tanggal)->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');
        $stats = [
            'hadir' => $counts['Hadir'] ?? 0,
            'sakit' => $counts['Sakit'] ?? 0,
            'izin' => $counts['Izin'] ?? 0,
            'alpha' => $counts['Alpa'] ?? 0,
        ];

        return view('absensi.index', compact('absensis', 'tanggal', 'kelasList', 'selectedKelas', 'stats'));
    }

    public function create()
    {
        $siswas = Siswa::orderBy('nama')->get();
        $tanggal = Carbon::parse(request('tanggal', now()->toDateString()));
        $selectedKelas = request('kelas', $siswas->first()?->kelas);
        $existingAbsensi = Absensi::whereDate('tanggal', $tanggal)->get()->keyBy('siswa_id');

        return view('absensi.create', compact('siswas', 'tanggal', 'selectedKelas', 'existingAbsensi'));
    }

    public function store(Request $request)
    {
        if ($request->has('status') && is_array($request->input('status'))) {
            foreach ($request->input('status') as $siswaId => $status) {
                if ($status === null || $status === '') {
                    continue;
                }

                Absensi::updateOrCreate(
                    ['siswa_id' => $siswaId, 'tanggal' => $request->input('tanggal')],
                    ['status' => $status === 'Alpha' ? 'Alpa' : $status]
                );
            }

            return redirect()->route('admin.absensi.index')->with('success', 'Absensi berhasil disimpan!');
        }

        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:Hadir,Izin,Sakit,Alpa',
        ]);

        Absensi::create($validated);

        return redirect()->route('admin.absensi.index')->with('success', 'Absensi berhasil disimpan!');
    }

    public function edit(string $id)
    {
        $absensi = Absensi::findOrFail($id);
        $siswa = Siswa::all();
        return view('absensi.edit', compact('absensi', 'siswa'));
    }

    public function update(Request $request, string $id)
    {
        $absensi = Absensi::findOrFail($id);

        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:Hadir,Izin,Sakit,Alpa',
        ]);

        $absensi->update($validated);

        return redirect()->route('admin.absensi.index')->with('success', 'Absensi berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();

        return redirect()->route('admin.absensi.index')->with('success', 'Absensi berhasil dihapus!');
    }

    public function show(string $id)
    {
        $absensi = Absensi::with('siswa')->findOrFail($id);
        $riwayat = Absensi::where('siswa_id', $absensi->siswa_id)
            ->where('id', '!=', $absensi->id)
            ->latest('tanggal')
            ->limit(30)
            ->get();
        $total = Absensi::where('siswa_id', $absensi->siswa_id)->count();
        $counts = Absensi::where('siswa_id', $absensi->siswa_id)->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');
        $kehadiranStats = collect([
            ['key' => 'Hadir', 'label' => 'Hadir', 'color' => '#16a34a'],
            ['key' => 'Sakit', 'label' => 'Sakit', 'color' => '#f59e0b'],
            ['key' => 'Izin', 'label' => 'Izin', 'color' => '#3b82f6'],
            ['key' => 'Alpa', 'label' => 'Alpa', 'color' => '#dc2626'],
        ])->map(function ($stat) use ($counts, $total) {
            $count = $counts[$stat['key']] ?? 0;
            $stat['count'] = $count;
            $stat['persen'] = $total > 0 ? round($count / $total * 100, 1) : 0;
            return $stat;
        });

        return view('absensi.show', compact('absensi', 'riwayat', 'kehadiranStats'));
    }
}