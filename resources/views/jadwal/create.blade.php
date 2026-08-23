@extends('layouts.app')

@section('title', 'Tambah Jadwal - SIS')
@section('breadcrumb', 'Jadwal Pelajaran / Tambah')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('content')

<div class="form-page fade-up">
    <div class="form-page-header">
        <a href="{{ route('admin.jadwal.index') }}" class="btn-back">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        </a>
        <div>
            <h1 class="form-page-title">Tambah Jadwal Pelajaran</h1>
            <p class="form-page-subtitle">Atur jadwal baru di tabel mingguan</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.jadwal.store') }}">
        @csrf
        <div class="form-card">
            <div class="form-card-header">
                <div class="form-card-header-icon" style="background:rgba(6,182,212,0.1);color:#06b6d4;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <span class="form-card-header-text">Detail Jadwal</span>
            </div>
            <div class="form-card-body">
                <div class="form-section">
                    <div class="form-section-title">Waktu & Hari</div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Hari <span class="required">*</span></label>
                            <select class="form-select" name="hari" data-validate="required">
                                <option value="">-- Pilih Hari --</option>
                                @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h)
                                    <option value="{{ $h }}" {{ old('hari', request('hari')) === $h ? 'selected' : '' }}>{{ $h }}</option>
                                @endforeach
                            </select>
                            <span class="form-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jam Ke- <span class="required">*</span></label>
                            <select class="form-select" name="jam_ke" data-validate="required">
                                <option value="">-- Pilih Jam --</option>
                                @foreach($jamList as $j)
                                    <option value="{{ $j['ke'] }}" {{ old('jam_ke', request('jam')) == $j['ke'] ? 'selected' : '' }}>{{ $j['label'] }} ({{ $j['waktu'] }})</option>
                                @endforeach
                            </select>
                            <span class="form-error"></span>
                        </div>
                    </div>
                </div>
                <div class="form-section">
                    <div class="form-section-title">Pelajaran & Pengampu</div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Mata Pelajaran <span class="required">*</span></label>
                            <select class="form-select" name="mapel_id" data-validate="required" id="mapelSelect">
                                <option value="">-- Pilih Mapel --</option>
                                @foreach($mapelList as $m)
                                    <option value="{{ $m->id }}" {{ old('mapel_id') == $m->id ? 'selected' : '' }}>{{ $m->nama }}</option>
                                @endforeach
                            </select>
                            <span class="form-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Guru Pengampu <span class="required">*</span></label>
                            <select class="form-select" name="guru_id" data-validate="required">
                                <option value="">-- Pilih Guru --</option>
                                @foreach($guruList as $g)
                                    <option value="{{ $g->id }}" {{ old('guru_id') == $g->id ? 'selected' : '' }}>{{ $g->nama }}</option>
                                @endforeach
                            </select>
                            <span class="form-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kelas <span class="required">*</span></label>
                            <select class="form-select" name="kelas" data-validate="required">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelasList as $k)
                                    <option value="{{ $k }}" {{ old('kelas') === $k ? 'selected' : '' }}>{{ $k }}</option>
                                @endforeach
                            </select>
                            <span class="form-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Semester</label>
                            <select class="form-select" name="semester">
                                <option value="1" {{ old('semester', 1) == 1 ? 'selected' : '' }}>Ganjil</option>
                                <option value="2" {{ old('semester') == 2 ? 'selected' : '' }}>Genap</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-card-footer">
                <a href="{{ route('admin.jadwal.index') }}" class="btn-cancel-form">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Batal
                </a>
                <button type="submit" class="btn-submit-form">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Jadwal
                </button>
            </div>
        </div>
    </form>
</div>

@endsection

@section('js')
    <script src="{{ asset('js/form.js') }}"></script>
@endsection