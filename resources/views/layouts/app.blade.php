<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Informasi Sekolah')</title>

    <!-- CSRF Token untuk AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    @yield('css')
</head>
<body>

    <!-- Background dekorasi -->
    <div class="bg-decoration"></div>
    <div class="bg-decoration-2"></div>

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Wrapper (membungkus navbar + content + footer) -->
    <div class="main-wrapper">

        <!-- Navbar / Topbar -->
        @include('partials.navbar')

        <!-- Konten Halaman -->
        <main class="content" role="main">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('partials.footer')

    </div>

    <!-- Flash session (untuk toast otomatis) -->
    @if(session('success'))
        <input type="hidden" id="flashSuccess" value="{{ session('success') }}">
    @endif
    @if(session('error'))
        <input type="hidden" id="flashError" value="{{ session('error') }}">
    @endif

    <!-- JS -->
    <script src="{{ asset('js/global.js') }}"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('js/footer.js') }}"></script>
    @yield('js')

</body>
</html>