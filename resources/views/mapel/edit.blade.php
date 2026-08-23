@extends('layouts.app')

@section('title', 'Edit Mapel - SIS')
@section('breadcrumb', 'Mata Pelajaran / Edit')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('content')

<div class="form-page fade-up">
    <div class="form-page-header">
        <a href="{{ route('admin.mapel.index') }}" class="btn-back">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        </a>
        <div>
            <h1 class="form-page-title">Edit Mata Pelajaran</h1>
            <p class="form-page-subtitle">Perbarui informasi <strong style="color:var(--fg);">{{ $mapel->nama }}</strong></p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.mapel.update', $mapel->id) }}">
        @csrf @method('PUT')
        <div class="form-card">
            <div class="form-card-header">
                <div class="form-card-header-icon" style="background:rgba(245,158,11,0.1);color:#f59e0b;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </div>
                <span class="form-card-header-text">Edit Detail Mapel</span>
            </div>
            <div class="form-card-body">
                <div class="form-section">
                    <div class="form-section-title">Informasi Umum</div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nama Mapel <span class="required">*</span></label>
                            <input type="text" class="form-input" name="nama" value="{{ old('nama', $mapel->nama) }}" data-validate="required|min:2">
                            <span class="form-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kode Mapel</label>
                            <input type="text" class="form-input" name="kode" value="{{ old('kode', $mapel->kode ?? '') }}" maxlength="10" style="text-transform:uppercase;">
                            <span class="form-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kelompok</label>
                            <select class="form-select" name="kelompok">
                                <option value="umum" {{ old('kelompok', $mapel->kelompok) === 'umum' ? 'selected' : '' }}>Muatan Nasional</option>
                                <option value="lokal" {{ old('kelompok', $mapel->kelompok) === 'lokal' ? 'selected' : '' }}>Muatan Lokal</option>
                                <option value="peminatan" {{ old('kelompok', $mapel->kelompok) === 'peminatan' ? 'selected' : '' }}>Peminatan Kejuruan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">KKM</label>
                            <input type="number" class="form-input" name="kkm" value="{{ old('kkm', $mapel->kkm ?? 75) }}" min="0" max="100">
                        </div>
                    </div>
                </div>
                <div class="form-section">
                    <div class="form-section-title">Pengaturan</div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Guru Pengampu</label>
                            <select class="form-select" name="guru_id">
                                <option value="">-- Pilih Guru --</option>
                                @foreach($guruList as $g)
                                    <option value="{{ $g->id }}" {{ old('guru_id', $mapel->guru_id) == $g->id ? 'selected' : '' }}>{{ $g->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jam Per Minggu</label>
                            <input type="number" class="form-input" name="jam_minggu" value="{{ old('jam_minggu', $mapel->jam_minggu ?? 2) }}" min="1" max="10">
                        </div>
                        <div class="form-group--full form-group">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-input" name="deskripsi" rows="3" data-max-chars="300">{{ old('deskripsi', $mapel->deskripsi ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-card-footer">
                <a href="{{ route('admin.mapel.index') }}" class="btn-cancel-form">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Batal
                </a>
                <button type="submit" class="btn-submit-form" style="background:linear-gradient(135deg,#f59e0b,#f97316);box-shadow:0 4px 16px rgba(245,158,11,0.25);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Perbarui Data
                </button>
            </div>
        </div>
    </form>
</div>

@endsection

@section('js')
    <script src="{{ asset('js/form.js') }}"></script>
@endsection