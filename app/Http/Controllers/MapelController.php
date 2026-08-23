<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Guru;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index()
    {
        $mapels = Mapel::latest()->paginate(10);
        $totalMapel = Mapel::count();

        return view('mapel.index', compact('mapels', 'totalMapel'));
    }

    public function create()
    {
        $guruList = Guru::orderBy('nama')->get();

        return view('mapel.create', compact('guruList'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'kode_mapel' => $request->input('kode', $request->input('kode_mapel')),
            'nama_mapel' => $request->input('nama', $request->input('nama_mapel')),
        ]);

        $validated = $request->validate([
            'kode_mapel' => 'required|string|max:20|unique:mapel,kode_mapel',
            'nama_mapel' => 'required|string|max:255',
        ]);

        Mapel::create($validated);

        return redirect()->route('admin.mapel.index')->with('success', 'Mata pelajaran berhasil disimpan!');
    }

    public function edit(string $id)
    {
        $mapel = Mapel::findOrFail($id);
        $guruList = Guru::orderBy('nama')->get();

        return view('mapel.edit', compact('mapel', 'guruList'));
    }

    public function show(string $id)
    {
        $mapel = Mapel::findOrFail($id);

        return view('mapel.show', compact('mapel'));
    }

    public function update(Request $request, string $id)
    {
        $mapel = Mapel::findOrFail($id);

        $request->merge([
            'kode_mapel' => $request->input('kode', $request->input('kode_mapel')),
            'nama_mapel' => $request->input('nama', $request->input('nama_mapel')),
        ]);

        $validated = $request->validate([
            'kode_mapel' => 'required|string|max:20|unique:mapel,kode_mapel,' . $mapel->id,
            'nama_mapel' => 'required|string|max:255',
        ]);

        $mapel->update($validated);

        return redirect()->route('admin.mapel.index')->with('success', 'Mata pelajaran berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $mapel = Mapel::findOrFail($id);
        $mapel->delete();

        return redirect()->route('admin.mapel.index')->with('success', 'Mata pelajaran berhasil dihapus!');
    }
}