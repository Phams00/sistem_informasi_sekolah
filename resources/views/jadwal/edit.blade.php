@extends('layouts.app')

@section('title', 'Edit Jadwal - SIS')
@section('breadcrumb', 'Jadwal Pelajaran / Edit')

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
            <h1 class="form-page-title">Edit Jadwal Pelajaran</h1>
            <p class="form-page-subtitle">{{ $jadwal->hari }}, Jam {{ $jadwal->jam_ke }} &mdash; <strong style="color:var(--fg);">{{ $jadwal->mapel->nama }}</strong></p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.jadwal.update', $jadwal->id) }}">
        @csrf @method('PUT')
        <div class="form-card">
            <div class="form-card-header">
                <div class="form-card-header-icon" style="background:rgba(245,158,11,0.1);color:#f59e0b;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </div>
                <span class="form-card-header-text">Ubah Jadwal</span>
            </div>
            <div class="form-card-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Hari <span class="required">*</span></label>
                        <select class="form-select" name="hari" data-validate="required">
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h)
                                <option value="{{ $h }}" {{ old('hari', $jadwal->hari) === $h ? 'selected' : '' }}>{{ $h }}</option>
                            @endforeach
                        </select>
                        <span class="form-error"></span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jam Ke- <span class="required">*</span></label>
                        <select class="form-select" name="jam_ke" data-validate="required">
                            @foreach($jamList as $j)
                                <option value="{{ $j['ke'] }}" {{ old('jam_ke', $jadwal->jam_ke) == $j['ke'] ? 'selected' : '' }}>{{ $j['label'] }} ({{ $j['waktu'] }})</option>
                            @endforeach
                        </select>
                        <span class="form-error"></span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Mata Pelajaran <span class="required">*</span></label>
                        <select class="form-select" name="mapel_id" data-validate="required">
                            @foreach($mapelList as $m)
                                <option value="{{ $m->id }}" {{ old('mapel_id', $jadwal->mapel_id) == $m->id ? 'selected' : '' }}>{{ $m->nama }}</option>
                            @endforeach
                        </select>
                        <span class="form-error"></span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Guru Pengampu <span class="required">*</span></label>
                        <select class="form-select" name="guru_id" data-validate="required">
                            @foreach($guruList as $g)
                                <option value="{{ $g->id }}" {{ old('guru_id', $jadwal->guru_id) == $g->id ? 'selected' : '' }}>{{ $g->nama }}</option>
                            @endforeach
                        </select>
                        <span class="form-error"></span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kelas <span class="required">*</span></label>
                        <select class="form-select" name="kelas" data-validate="required">
                            @foreach($kelasList as $k)
                                <option value="{{ $k }}" {{ old('kelas', $jadwal->kelas) === $k ? 'selected' : '' }}>{{ $k }}</option>
                            @endforeach
                        </select>
                        <span class="form-error"></span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Semester</label>
                        <select class="form-select" name="semester">
                            <option value="1" {{ old('semester', $jadwal->semester) == 1 ? 'selected' : '' }}>Ganjil</option>
                            <option value="2" {{ old('semester', $jadwal->semester) == 2 ? 'selected' : '' }}>Genap</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-card-footer">
                <a href="{{ route('admin.jadwal.index') }}" class="btn-cancel-form">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Batal
                </a>
                <button type="submit" class="btn-submit-form" style="background:linear-gradient(135deg,#f59e0b,#f97316);box-shadow:0 4px 16px rgba(245,158,11,0.25);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Perbarui Jadwal
                </button>
            </div>
        </div>
    </form>
</div>

@endsection

@section('js')
    <script src="{{ asset('js/form.js') }}"></script>
@endsection