{{-- ============================================
     PARTIAL: SIDEBAR
     Navigasi utama sisi kiri
     ============================================ --}}

<aside class="sidebar" id="sidebar" role="navigation" aria-label="Menu utama">

    {{-- Logo --}}
    <div class="sidebar-logo">
        <div class="sidebar-logo-inner">
            <div class="sidebar-logo-icon">
                <i data-lucide="graduation-cap"></i>
            </div>
            <div>
                <div class="sidebar-logo-text">SIS</div>
                <div class="sidebar-logo-sub">Sistem Informasi Sekolah</div>
            </div>
        </div>
    </div>

    {{-- Navigasi --}}
    <nav class="sidebar-nav">
        <div class="nav-section-label">Menu Utama</div>

        <a href="{{ route('admin.dashboard') }}"
           class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i data-lucide="layout-dashboard" class="nav-icon"></i>
            <span>Dasbor</span>
        </a>

        <a href="{{ route('admin.guru.index') }}"
           class="nav-item {{ request()->routeIs('admin.guru.*') ? 'active' : '' }}">
            <i data-lucide="users" class="nav-icon"></i>
            <span>Data Guru</span>
            <span class="nav-badge">{{ App\Models\Guru::count() }}</span>
        </a>

        <a href="{{ route('admin.siswa.index') }}"
           class="nav-item {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
            <i data-lucide="book-open" class="nav-icon"></i>
            <span>Data Siswa</span>
            <span class="nav-badge nav-badge--warning">{{ App\Models\Siswa::count() }}</span>
        </a>

        <a href="{{ route('admin.mapel.index') }}"
           class="nav-item {{ request()->routeIs('admin.mapel.*') ? 'active' : '' }}">
            <i data-lucide="book-marked" class="nav-icon"></i>
            <span>Mata Pelajaran</span>
        </a>

        <a href="{{ route('admin.jadwal.index') }}"
           class="nav-item {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}">
            <i data-lucide="calendar-days" class="nav-icon"></i>
            <span>Jadwal Pelajaran</span>
        </a>

        <div class="nav-section-label">Laporan</div>

        <a href="{{ route('admin.nilai.index') }}"
           class="nav-item {{ request()->routeIs('admin.nilai.*') ? 'active' : '' }}">
            <i data-lucide="bar-chart-3" class="nav-icon"></i>
            <span>Nilai Siswa</span>
        </a>

        <a href="{{ route('admin.absensi.index') }}"
           class="nav-item {{ request()->routeIs('admin.absensi.*') ? 'active' : '' }}">
            <i data-lucide="clipboard-check" class="nav-icon"></i>
            <span>Absensi</span>
        </a>

        <div class="nav-section-label">Pengaturan</div>

        <a href="#"
           class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <i data-lucide="settings" class="nav-icon"></i>
            <span>Pengaturan</span>
        </a>
    </nav>

    {{-- Info user di bawah sidebar --}}
    <div class="sidebar-footer">
        <div class="sidebar-footer-inner">
            <div class="sidebar-footer-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div class="sidebar-footer-info">
                <div class="sidebar-footer-name">{{ auth()->user()->name }}</div>
                <div class="sidebar-footer-email">{{ auth()->user()->email }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="sidebar-footer-logout" title="Keluar" aria-label="Keluar">
                    <i data-lucide="log-out"></i>
                </button>
            </form>
        </div>
    </div>

</aside>