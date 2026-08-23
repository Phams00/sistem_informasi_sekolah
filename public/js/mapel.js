/* ============================================
   MAPEL.JS
   Dropdown menu per card, modal hapus, toast
   ============================================ */

document.addEventListener('DOMContentLoaded', function () {

    var toastContainer = document.getElementById('toastContainer');
    var deleteOverlay = document.getElementById('deleteOverlay');
    var deleteModal = document.getElementById('deleteModal');
    var deleteNama = document.getElementById('deleteNama');
    var deleteCancelBtn = document.getElementById('deleteCancelBtn');
    var deleteConfirmBtn = document.getElementById('deleteConfirmBtn');
    var deleteTargetId = null;

    // ===== Dropdown per card =====
    document.querySelectorAll('.mapel-card-menu-btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            // Tutup dropdown lain
            document.querySelectorAll('.mapel-card-dropdown.open').forEach(function (d) {
                if (d !== this.nextElementSibling) d.classList.remove('open');
            }.bind(this));
            var dropdown = this.nextElementSibling;
            if (dropdown) dropdown.classList.toggle('open');
        });
    });

    // Tutup dropdown saat klik di luar
    document.addEventListener('click', function () {
        document.querySelectorAll('.mapel-card-dropdown.open').forEach(function (d) {
            d.classList.remove('open');
        });
    });

    // ===== Modal Hapus =====
    window.openDeleteModal = function (id, nama) {
        deleteTargetId = id;
        deleteNama.textContent = nama;
        deleteModal.classList.add('open');
        deleteOverlay.classList.add('open');
    };

    function closeDeleteModal() {
        deleteModal.classList.remove('open');
        deleteOverlay.classList.remove('open');
        deleteTargetId = null;
    }

    if (deleteCancelBtn) deleteCancelBtn.addEventListener('click', closeDeleteModal);
    if (deleteOverlay) deleteOverlay.addEventListener('click', closeDeleteModal);

    if (deleteConfirmBtn) {
        deleteConfirmBtn.addEventListener('click', function () {
            if (deleteTargetId === null) return;
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/mapel/' + deleteTargetId;
            var csrf = document.createElement('input');
            csrf.type = 'hidden'; csrf.name = '_token';
            csrf.value = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            form.appendChild(csrf);
            var method = document.createElement('input');
            method.type = 'hidden'; method.name = '_method'; method.value = 'DELETE';
            form.appendChild(method);
            document.body.appendChild(form);
            form.submit();
        });
    }

    // ===== Toast dari flash =====
    var flashSuccess = document.getElementById('flashSuccess');
    if (flashSuccess && flashSuccess.value) {
        setTimeout(function () { showToast(flashSuccess.value); }, 500);
    }

    function showToast(message) {
        var toast = document.createElement('div');
        toast.className = 'toast';
        toast.innerHTML =
            '<div class="toast-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div>' +
            '<span>' + message + '</span>' +
            '<button class="toast-close"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>';
        toastContainer.appendChild(toast);
        toast.querySelector('.toast-close').addEventListener('click', function () {
            toast.classList.add('exiting');
            setTimeout(function () { if (toast.parentNode) toast.remove(); }, 300);
        });
        setTimeout(function () {
            toast.classList.add('exiting');
            setTimeout(function () { if (toast.parentNode) toast.remove(); }, 300);
        }, 4000);
    }

    // ===== Keyboard =====
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.mapel-card-dropdown.open').forEach(function (d) { d.classList.remove('open'); });
            if (deleteModal && deleteModal.classList.contains('open')) closeDeleteModal();
        }
    });

});