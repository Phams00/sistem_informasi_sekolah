/* ============================================
   SIDEBAR.JS
   Navigasi aktif, toggle mobile sidebar
   ============================================ */

document.addEventListener('DOMContentLoaded', function () {

    const sidebar = document.getElementById('sidebar');
    const menuToggle = document.getElementById('menuToggle');

    // ===== Klik navigasi sidebar =====
    // Catatan: TIDAK pakai preventDefault() lagi.
    // Highlight menu aktif sekarang ditentukan server-side lewat
    // request()->routeIs(...) di sidebar.blade.php, jadi otomatis
    // benar setiap kali halaman baru dimuat (tidak perlu JS untuk itu).
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(function (item) {
        item.addEventListener('click', function () {
            // Di mobile, tutup sidebar setelah klik (sebelum browser pindah halaman)
            if (window.innerWidth <= 768 && sidebar) {
                sidebar.classList.remove('mobile-open');
            }
            // href dibiarkan jalan normal -> browser pindah halaman
        });
    });

    // ===== Toggle sidebar di mobile =====
    if (menuToggle) {
        menuToggle.addEventListener('click', function () {
            sidebar.classList.toggle('mobile-open');
        });
    }

    // ===== Responsif: tampilkan/sembunyikan hamburger =====
    function checkMobile() {
        if (!menuToggle) return;
        if (window.innerWidth <= 768) {
            menuToggle.style.display = 'flex';
        } else {
            menuToggle.style.display = 'none';
            sidebar.classList.remove('mobile-open');
        }
    }

    window.addEventListener('resize', checkMobile);
    checkMobile();
});