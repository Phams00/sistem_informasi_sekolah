<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::latest()->paginate(10);
        $kelasList = Siswa::query()
            ->whereNotNull('kelas')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas');
        $totalSiswa = Siswa::count();

        return view('siswa.index', compact('siswas', 'kelasList', 'totalSiswa'));
    }

    public function create()
    {
        $kelasList = Siswa::query()
            ->whereNotNull('kelas')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas');
        $jurusanList = collect();

        return view('siswa.create', compact('kelasList', 'jurusanList'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'no_telepon' => $request->input('telepon', $request->input('no_telepon')),
        ]);

        $validated = $request->validate([
            'nis' => 'required|string|max:30|unique:siswa,nis',
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        Siswa::create($validated);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil disimpan!');
    }

    public function show(string $id)
    {
        $siswa = Siswa::with(['nilai.mapel', 'absensi'])->findOrFail($id);
        return view('siswa.show', compact('siswa'));
    }

    public function edit(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelasList = Siswa::query()
            ->whereNotNull('kelas')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas');
        $jurusanList = collect();

        return view('siswa.edit', compact('siswa', 'kelasList', 'jurusanList'));
    }

    public function update(Request $request, string $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->merge([
            'no_telepon' => $request->input('telepon', $request->input('no_telepon')),
        ]);

        $validated = $request->validate([
            'nis' => 'required|string|max:30|unique:siswa,nis,' . $siswa->id,
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        $siswa->update($validated);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus!');
    }

    public function export()
    {
        $siswas = Siswa::orderBy('nama')->get(['nis', 'nama', 'kelas', 'jenis_kelamin', 'alamat', 'no_telepon']);

        return response()->streamDownload(function () use ($siswas): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['NIS', 'Nama', 'Kelas', 'Jenis Kelamin', 'Alamat', 'No. Telepon']);

            foreach ($siswas as $siswa) {
                fputcsv($handle, [
                    $siswa->nis,
                    $siswa->nama,
                    $siswa->kelas,
                    $siswa->jenis_kelamin,
                    $siswa->alamat,
                    $siswa->no_telepon,
                ]);
            }

            fclose($handle);
        }, 'data-siswa.csv', ['Content-Type' => 'text/csv']);
    }
}