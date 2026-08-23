@extends('layouts.app')

@section('title', 'Edit Siswa - SIS')
@section('breadcrumb', 'Data Siswa / Edit')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('content')

<div class="form-page fade-up">

    {{-- ===== Header ===== --}}
    <div class="form-page-header">
        <a href="{{ route('admin.siswa.index') }}" class="btn-back" title="Kembali ke daftar siswa">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"/>
                <polyline points="12 19 5 12 12 5"/>
            </svg>
        </a>
        <div>
            <h1 class="form-page-title">Edit Data Siswa</h1>
            <p class="form-page-subtitle">
                Memperbarui informasi
                <strong style="color:var(--fg);">{{ $siswa->nama }}</strong>
                <span style="color:var(--muted);">&mdash; NIS: {{ $siswa->nis }}</span>
            </p>
        </div>
    </div>

    {{-- ===== Info Bar ===== --}}
    <div style="display:flex;gap:12px;margin-bottom:24px;flex-wrap:wrap;" class="fade-up">
        <div style="display:inline-flex;align-items:center;gap:8px;padding:8px 16px;border-radius:10px;background:rgba(13,148,136,0.08);border:1px solid rgba(13,148,136,0.15);font-size:13px;font-weight:600;color:var(--accent);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            {{ $siswa->kelas }} &middot; {{ $siswa->jurusan }}
        </div>
        <div style="display:inline-flex;align-items:center;gap:8px;padding:8px 16px;border-radius:10px;background:{{ $siswa->status === 'aktif' ? 'rgba(22,163,74,0.08)' : 'rgba(245,158,11,0.08)' }};border:1px solid {{ $siswa->status === 'aktif' ? 'rgba(22,163,74,0.15)' : 'rgba(245,158,11,0.15)' }};font-size:13px;font-weight:600;color:{{ $siswa->status === 'aktif' ? 'var(--success)' : '#f59e0b' }};">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Status: {{ ucfirst($siswa->status) }}
        </div>
        <div style="display:inline-flex;align-items:center;gap:8px;padding:8px 16px;border-radius:10px;background:var(--bg);border:1px solid var(--border);font-size:13px;font-weight:600;color:var(--muted);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Terdaftar: {{ $siswa->created_at->format('d M Y') }}
        </div>
    </div>

    {{-- ===== Form ===== --}}
    <form method="POST" action="{{ route('admin.siswa.update', $siswa->id) }}" id="formEditSiswa">
        @csrf
        @method('PUT')

        {{-- ===== Card 1: Data Pribadi ===== --}}
        <div class="form-card fade-up-delay" style="margin-bottom:24px;">
            <div class="form-card-header">
                <div class="form-card-header-icon" style="background:rgba(6,182,212,0.1);color:#06b6d4;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <span class="form-card-header-text">Data Pribadi</span>
            </div>
            <div class="form-card-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="editNis">NIS <span class="required">*</span></label>
                        <input type="text" class="form-input" id="editNis" name="nis"
                               value="{{ old('nis', $siswa->nis) }}"
                               placeholder="Nomor Induk Siswa"
                               data-validate="required|numeric" maxlength="12">
                        <span class="form-error"></span>
                        <p class="form-hint">Nomor Induk Siswa, maksimal 12 digit angka.</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="editNisn">NISN</label>
                        <input type="text" class="form-input" id="editNisn" name="nisn"
                               value="{{ old('nisn', $siswa->nisn ?? '') }}"
                               placeholder="NISN nasional (opsional)"
                               data-validate="numeric" maxlength="10">
                        <span class="form-error"></span>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="editNama">Nama Lengkap <span class="required">*</span></label>
                        <input type="text" class="form-input" id="editNama" name="nama"
                               value="{{ old('nama', $siswa->nama) }}"
                               placeholder="Nama lengkap sesuai akta"
                               data-validate="required|min:3" autofocus>
                        <span class="form-error"></span>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jenis Kelamin</label>
                        <div class="form-radio-group">
                            <label class="form-radio-label">
                                <input type="radio" name="jenis_kelamin" value="L"
                                       {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'L' ? 'checked' : '' }}>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:#3b82f6;"><circle cx="12" cy="8" r="5"/><line x1="12" y1="13" x2="12" y2="22"/></svg>
                                Laki-laki
                            </label>
                            <label class="form-radio-label">
                                <input type="radio" name="jenis_kelamin" value="P"
                                       {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'P' ? 'checked' : '' }}>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:#ec4899;"><circle cx="12" cy="8" r="5"/><line x1="12" y1="13" x2="12" y2="22"/><line x1="9" y1="18" x2="15" y2="18"/></svg>
                                Perempuan
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="editTempatLahir">Tempat Lahir</label>
                        <input type="text" class="form-input" id="editTempatLahir" name="tempat_lahir"
                               value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}"
                               placeholder="Kota/kabupaten kelahiran">
                        <span class="form-error"></span>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="editTglLahir">Tanggal Lahir</label>
                        <input type="date" class="form-input" id="editTglLahir" name="tanggal_lahir"
                               value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ?? '') }}">
                        <span class="form-error"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== Card 2: Akademik ===== --}}
        <div class="form-card fade-up-delay" style="margin-bottom:24px;animation-delay:0.1s;">
            <div class="form-card-header">
                <div class="form-card-header-icon" style="background:rgba(245,158,11,0.1);color:#f59e0b;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 3 3 6 3s6-1 6-3v-5"/>
                    </svg>
                </div>
                <span class="form-card-header-text">Informasi Akademik</span>
            </div>
            <div class="form-card-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="editKelas">Kelas <span class="required">*</span></label>
                        <select class="form-select" id="editKelas" name="kelas" data-validate="required">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k }}" {{ old('kelas', $siswa->kelas) === $k ? 'selected' : '' }}>
                                    {{ $k }}
                                </option>
                            @endforeach
                        </select>
                        <span class="form-error"></span>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="editJurusan">Jurusan <span class="required">*</span></label>
                        <select class="form-select" id="editJurusan" name="jurusan" data-validate="required">
                            <option value="">-- Pilih Jurusan --</option>
                            @foreach($jurusanList as $j)
                                <option value="{{ $j }}" {{ old('jurusan', $siswa->jurusan) === $j ? 'selected' : '' }}>
                                    {{ $j }}
                                </option>
                            @endforeach
                        </select>
                        <span class="form-error"></span>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="editTahunMasuk">Tahun Masuk</label>
                        <input type="number" class="form-input" id="editTahunMasuk" name="tahun_masuk"
                               value="{{ old('tahun_masuk', $siswa->tahun_masuk ?? '') }}"
                               min="2018" max="{{ date('Y') + 1 }}">
                        <span class="form-error"></span>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="editStatus">Status Siswa</label>
                        <select class="form-select" id="editStatus" name="status">
                            <option value="aktif"   {{ old('status', $siswa->status) === 'aktif'  ? 'selected' : '' }}>Aktif</option>
                            <option value="pindah"  {{ old('status', $siswa->status) === 'pindah' ? 'selected' : '' }}>Pindah</option>
                            <option value="keluar"  {{ old('status', $siswa->status) === 'keluar' ? 'selected' : '' }}>Keluar</option>
                            <option value="lulus"   {{ old('status', $siswa->status) === 'lulus'  ? 'selected' : '' }}>Lulus</option>
                        </select>
                        <p class="form-hint">Ubah status jika siswa sudah tidak aktif.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== Card 3: Kontak & Alamat ===== --}}
        <div class="form-card fade-up-delay" style="margin-bottom:24px;animation-delay:0.15s;">
            <div class="form-card-header">
                <div class="form-card-header-icon" style="background:rgba(139,92,246,0.1);color:#8b5cf6;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                </div>
                <span class="form-card-header-text">Kontak &amp; Alamat</span>
            </div>
            <div class="form-card-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="editEmail">Email Siswa</label>
                        <input type="email" class="form-input" id="editEmail" name="email"
                               value="{{ old('email', $siswa->email ?? '') }}"
                               placeholder="email@siswa.sch.id"
                               data-validate="email">
                        <span class="form-error"></span>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="editTelp">No. Telepon Siswa</label>
                        <input type="tel" class="form-input" id="editTelp" name="telepon"
                               value="{{ old('telepon', $siswa->telepon ?? '') }}"
                               placeholder="08xxxxxxxxxx">
                        <span class="form-error"></span>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="editNamaOrtu">Nama Orang Tua / Wali</label>
                        <input type="text" class="form-input" id="editNamaOrtu" name="nama_ortu"
                               value="{{ old('nama_ortu', $siswa->nama_ortu ?? '') }}"
                               placeholder="Nama lengkap orang tua/wali">
                        <span class="form-error"></span>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="editTelpOrtu">Telepon Orang Tua</label>
                        <input type="tel" class="form-input" id="editTelpOrtu" name="telp_ortu"
                               value="{{ old('telp_ortu', $siswa->telp_ortu ?? '') }}"
                               placeholder="08xxxxxxxxxx">
                        <span class="form-error"></span>
                    </div>

                    <div class="form-group--full form-group">
                        <label class="form-label" for="editAlamat">Alamat Lengkap</label>
                        <textarea class="form-input" id="editAlamat" name="alamat" rows="3"
                                  placeholder="Jalan, RT/RW, Desa/Kelurahan, Kecamatan, Kabupaten/Kota, Provinsi"
                                  data-max-chars="500">{{ old('alamat', $siswa->alamat ?? '') }}</textarea>
                        <span class="form-error"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== Footer Aksi ===== --}}
        <div class="form-card fade-up-delay" style="animation-delay:0.2s;">
            <div class="form-card-footer" style="background:white;">
                <a href="{{ route('admin.siswa.index') }}" class="btn-cancel-form">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                    Batal
                </a>
                <button type="submit" class="btn-submit-form" id="btnSubmitEdit"
                        style="background:linear-gradient(135deg,#f59e0b,#f97316);box-shadow:0 4px 16px rgba(245,158,11,0.25);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
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