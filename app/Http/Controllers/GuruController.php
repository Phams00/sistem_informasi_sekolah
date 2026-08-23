<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::latest()->paginate(10);
        $mapelList = Guru::query()
            ->whereNotNull('mata_pelajaran')
            ->distinct()
            ->orderBy('mata_pelajaran')
            ->pluck('mata_pelajaran');
        $totalGuru = Guru::count();
        $totalMapel = $mapelList->count();
        $jamMengajar = 0;
        $mapelColors = [];

        return view('guru.index', compact(
            'gurus',
            'mapelList',
            'totalGuru',
            'totalMapel',
            'jamMengajar',
            'mapelColors'
        ));
    }

    public function create()
    {
        $mapelList = Guru::query()
            ->whereNotNull('mata_pelajaran')
            ->distinct()
            ->orderBy('mata_pelajaran')
            ->pluck('mata_pelajaran');

        return view('guru.create', compact('mapelList'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'mata_pelajaran' => $request->input('mapel', $request->input('mata_pelajaran')),
            'no_telepon' => $request->input('telepon', $request->input('no_telepon')),
        ]);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:20',
            'jenis_kelamin' => 'nullable|in:L,P',
            'ttl' => 'nullable|string|max:255',
            'mata_pelajaran' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'email' => 'required|email|unique:guru,email',
            'no_telepon' => 'required|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        Guru::create($validated);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil disimpan!');
    }

    public function show(string $id)
    {
        $guru = Guru::findOrFail($id);
        return view('guru.show', compact('guru'));
    }

    public function edit(string $id)
    {
        $guru = Guru::findOrFail($id);
        $mapelList = Guru::query()
            ->whereNotNull('mata_pelajaran')
            ->distinct()
            ->orderBy('mata_pelajaran')
            ->pluck('mata_pelajaran');

        return view('guru.edit', compact('guru', 'mapelList'));
    }

    public function update(Request $request, string $id)
    {
        $guru = Guru::findOrFail($id);
    
        $request->merge([
            'mata_pelajaran' => $request->input('mapel', $request->input('mata_pelajaran')),
            'no_telepon' => $request->input('telepon', $request->input('no_telepon')),
        ]);
    
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:20',
            'jenis_kelamin' => 'nullable|in:L,P',
            'ttl' => 'nullable|string|max:255',
            'mata_pelajaran' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'email' => 'required|email|unique:guru,email,' . $guru->id,
            'no_telepon' => 'required|string|max:20',
            'alamat' => 'nullable|string',
        ]);
    
        $guru->update($validated);
    
        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil dihapus!');
    }

    public function export()
    {
        $gurus = Guru::orderBy('nama')->get(['nama', 'mata_pelajaran', 'email', 'no_telepon']);

        return response()->streamDownload(function () use ($gurus): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Nama', 'Mata Pelajaran', 'Email', 'No. Telepon']);

            foreach ($gurus as $guru) {
                fputcsv($handle, [$guru->nama, $guru->mata_pelajaran, $guru->email, $guru->no_telepon]);
            }

            fclose($handle);
        }, 'data-guru.csv', ['Content-Type' => 'text/csv']);
    }
}