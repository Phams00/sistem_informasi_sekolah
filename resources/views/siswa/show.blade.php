@extends('layouts.app')
@section('title', 'Detail Siswa')

{{-- TODO STYLING --}}
@section('content')
    <h1>Detail Siswa</h1>
    <p><strong>NIS:</strong> {{ $siswa->nis }}</p>
    <p><strong>Nama:</strong> {{ $siswa->nama }}</p>
    <p><strong>Kelas:</strong> {{ $siswa->kelas }}</p>
    <p><strong>Jenis Kelamin:</strong> {{ $siswa->jenis_kelamin }}</p>
    <p><strong>Alamat:</strong> {{ $siswa->alamat }}</p>
    <p><strong>No. Telepon:</strong> {{ $siswa->no_telepon }}</p>

    <h2>Nilai</h2>
    <ul>
        @forelse ($siswa->nilai as $n)
            <li>{{ $n->mapel->nama_mapel }} - {{ $n->jenis }}: {{ $n->nilai }}</li>
        @empty
            <li>Belum ada nilai.</li>
        @endforelse
    </ul>

    <h2>Riwayat Absensi</h2>
    <ul>
        @forelse ($siswa->absensi as $a)
            <li>{{ $a->tanggal }} - {{ $a->status }}</li>
        @empty
            <li>Belum ada data absensi.</li>
        @endforelse
    </ul>

    <a href="{{ route('admin.siswa.edit', $siswa->id) }}">Edit</a>
    <a href="{{ route('admin.siswa.index') }}">&laquo; Kembali</a>
@endsection