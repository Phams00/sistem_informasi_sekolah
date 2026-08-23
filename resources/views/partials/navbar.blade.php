{{-- ============================================
     PARTIAL: NAVBAR / TOPBAR
     Bar navigasi atas dengan breadcrumb
     ============================================ --}}

<header class="topbar" role="banner">
    <div class="topbar-left">

        {{-- Hamburger menu (muncul di mobile) --}}
        <button class="topbar-btn topbar-hamburger" id="menuToggle" aria-label="Toggle menu">
            <i data-lucide="menu"></i>
        </button>

        {{-- Breadcrumb --}}
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dasbor</a>
            <span class="breadcrumb-sep">/</span>
            <span class="current">@yield('breadcrumb', 'Halaman')</span>
        </nav>

    </div>

    <div class="topbar-right">
        <button class="topbar-btn" aria-label="Pencarian global">
            <i data-lucide="search"></i>
        </button>
        <button class="topbar-btn" aria-label="Notifikasi">
            <i data-lucide="bell"></i>
            <span class="notif-dot"></span>
        </button>
        <button class="topbar-btn" aria-label="Pengaturan tampilan">
            <i data-lucide="sun"></i>
        </button>
        <div class="avatar-user" title="{{ auth()->user()->name }}">
            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
        </div>
    </div>
</header>