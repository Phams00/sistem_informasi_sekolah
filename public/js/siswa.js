/* ============================================
   SISWA.JS
   Filter chip, pencarian, modal hapus
   ============================================ */

document.addEventListener('DOMContentLoaded', function () {

    var searchInput = document.getElementById('siswaSearch');
    var chips = document.querySelectorAll('.siswa-filter-chip');
    var currentKelas = '';
    var toastContainer = document.getElementById('toastContainer');

    // ===== Filter chip kelas =====
    chips.forEach(function (chip) {
        chip.addEventListener('click', function () {
            chips.forEach(function (c) { c.classList.remove('active'); });
            this.classList.add('active');
            currentKelas = this.getAttribute('data-kelas') || '';
            filterTable();
        });
    });

    // ===== Pencarian =====
    if (searchInput) {
        searchInput.addEventListener('input', filterTable);
    }

    function filterTable() {
        var query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        var rows = document.querySelectorAll('#siswaTableBody tr[data-id]');

        var visible = 0;
        rows.forEach(function (row) {
            var nama = (row.getAttribute('data-nama') || '').toLowerCase();
            var nis = (row.getAttribute('data-nis') || '').toLowerCase();
            var kelas = row.getAttribute('data-kelas') || '';

            var matchSearch = !query || nama.indexOf(query) !== -1 || nis.indexOf(query) !== -1;
            var matchKelas = !currentKelas || kelas === currentKelas;

            row.style.display = (matchSearch && matchKelas) ? '' : 'none';
            if (matchSearch && matchKelas) visible++;
        });

        var info = document.querySelector('.guru-table-info');
        if (info) {
            var total = document.querySelectorAll('#siswaTableBody tr[data-id]').length;
            info.textContent = 'Menampilkan ' + visible + ' dari ' + total + ' data';
        }
    }

    // ===== Modal Hapus =====
    var deleteOverlay = document.getElementById('deleteOverlay');
    var deleteModal = document.getElementById('deleteModal');
    var deleteNama = document.getElementById('deleteNama');
    var deleteCancelBtn = document.getElementById('deleteCancelBtn');
    var deleteConfirmBtn = document.getElementById('deleteConfirmBtn');
    var deleteTargetId = null;

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
            form.action = '/admin/siswa/' + deleteTargetId;
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

    // ===== Toast =====
    var flashSuccess = document.getElementById('flashSuccess');
    if (flashSuccess && flashSuccess.value) {
        setTimeout(function () {
            showToast(flashSuccess.value);
        }, 500);
    }

    function showToast(message, type) {
        type = type || 'success';
        var toast = document.createElement('div');
        toast.className = 'toast' + (type === 'danger' ? ' toast--danger' : '');
        toast.innerHTML =
            '<div class="toast-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div>' +
            '<span>' + message + '</span>' +
            '<button class="toast-close"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>';
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
        if (e.key === 'Escape' && deleteModal && deleteModal.classList.contains('open')) {
            closeDeleteModal();
        }
    });

});