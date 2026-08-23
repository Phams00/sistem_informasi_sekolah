@extends('layouts.app')

@section('title', 'Tambah Siswa - SIS')
@section('breadcrumb', 'Data Siswa / Tambah')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('content')

<div class="form-page fade-up">
    <div class="form-page-header">
        <a href="{{ route('admin.siswa.index') }}" class="btn-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        </a>
        <div>
            <h1 class="form-page-title">Tambah Siswa Baru</h1>
            <p class="form-page-subtitle">Isi data lengkap siswa yang akan didaftarkan</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.siswa.store') }}">
        @csrf

        <div class="form-card">
            <div class="form-card-header">
                <div class="form-card-header-icon" style="background:rgba(6,182,212,0.1);color:#06b6d4;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                </div>
                <span class="form-card-header-text">Data Siswa</span>
            </div>
            <div class="form-card-body">
                <div class="form-section">
                    <div class="form-section-title">Data Pribadi</div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">NIS <span class="required">*</span></label>
                            <input type="text" class="form-input" name="nis" value="{{ old('nis') }}" placeholder="Nomor Induk Siswa" data-validate="required|numeric" maxlength="12">
                            <span class="form-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">NISN</label>
                            <input type="text" class="form-input" name="nisn" value="{{ old('nisn') }}" placeholder="NISN (opsional)" data-validate="numeric" maxlength="10">
                            <span class="form-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                            <input type="text" class="form-input" name="nama" value="{{ old('nama') }}" placeholder="Nama lengkap siswa" data-validate="required|min:3" autofocus>
                            <span class="form-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jenis Kelamin <span class="required">*</span></label>
                            <div class="form-radio-group">
                                <label class="form-radio-label">
                                    <input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin', 'L') === 'L' ? 'checked' : '' }}>
                                    Laki-laki
                                </label>
                                <label class="form-radio-label">
                                    <input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin') === 'P' ? 'checked' : '' }}>
                                    Perempuan
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-input" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Kota kelahiran">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-input" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-title">Akademik</div>
                    <div class="form-grid">
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
                            <label class="form-label">Jurusan <span class="required">*</span></label>
                            <select class="form-select" name="jurusan" data-validate="required" id="jurusanSelect">
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach($jurusanList as $j)
                                    <option value="{{ $j }}" {{ old('jurusan') === $j ? 'selected' : '' }}>{{ $j }}</option>
                                @endforeach
                            </select>
                            <span class="form-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tahun Masuk</label>
                            <input type="number" class="form-input" name="tahun_masuk" value="{{ old('tahun_masuk', date('Y')) }}" min="2020" max="{{ date('Y') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="aktif" {{ old('status', 'aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="pindah" {{ old('status') === 'pindah' ? 'selected' : '' }}>Pindah</option>
                                <option value="keluar" {{ old('status') === 'keluar' ? 'selected' : '' }}>Keluar</option>
                                <option value="lulus" {{ old('status') === 'lulus' ? 'selected' : '' }}>Lulus</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-title">Kontak & Alamat</div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-input" name="email" value="{{ old('email') }}" placeholder="email@siswa.sch.id" data-validate="email">
                            <span class="form-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">No. Telepon</label>
                            <input type="tel" class="form-input" name="telepon" value="{{ old('telepon') }}" placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nama Orang Tua / Wali</label>
                            <input type="text" class="form-input" name="nama_ortu" value="{{ old('nama_ortu') }}" placeholder="Nama orang tua/wali">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Telepon Orang Tua</label>
                            <input type="tel" class="form-input" name="telp_ortu" value="{{ old('telp_ortu') }}" placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="form-group--full form-group">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-input" name="alamat" rows="3" placeholder="Alamat lengkap siswa" data-max-chars="500">{{ old('alamat') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-card-footer">
                <a href="{{ route('admin.siswa.index') }}" class="btn-cancel-form">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Batal
                </a>
                <button type="submit" class="btn-submit-form">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Data
                </button>
            </div>
        </div>
    </form>
</div>

@endsection

@section('js')
    <script src="{{ asset('js/form.js') }}"></script>
@endsection