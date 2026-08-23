@extends('layouts.app')

@section('title', 'Detail Guru')

@section('content')
    <h1>Detail Guru</h1>

    <p><strong>Nama:</strong> {{ $guru->nama }}</p>
    <p><strong>Mata Pelajaran:</strong> {{ $guru->mata_pelajaran }}</p>
    <p><strong>Email:</strong> {{ $guru->email }}</p>
    <p><strong>No. Telepon:</strong> {{ $guru->no_telepon }}</p>

    <a href="{{ route('admin.guru.edit', $guru->id) }}">Edit</a>
    <a href="{{ route('admin.guru.index') }}">&laquo; Kembali ke daftar</a>
@endsection