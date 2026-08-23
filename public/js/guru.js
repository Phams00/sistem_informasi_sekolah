/* ============================================
   GURU.JS
   Pencarian, filter, checkbox bulk,
   modal hapus, toast, paginasi
   ============================================ */

document.addEventListener('DOMContentLoaded', function () {

    var searchInput = document.getElementById('guruSearch');
    var filterSelect = document.getElementById('guruFilterMapel');
    var selectAll = document.getElementById('selectAll');
    var bulkActions = document.getElementById('bulkActions');
    var bulkCount = document.getElementById('bulkCount');
    var toastContainer = document.getElementById('toastContainer');
    var deleteOverlay = document.getElementById('deleteOverlay');
    var deleteModal = document.getElementById('deleteModal');
    var deleteNama = document.getElementById('deleteNama');
    var deleteCancelBtn = document.getElementById('deleteCancelBtn');
    var deleteConfirmBtn = document.getElementById('deleteConfirmBtn');
    var deleteTargetId = null;

    // ===== Pencarian =====
    if (searchInput) {
        searchInput.addEventListener('input', filterTable);
    }
    if (filterSelect) {
        filterSelect.addEventListener('change', filterTable);
    }

    function filterTable() {
        var query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        var mapel = filterSelect ? filterSelect.value : '';
        var rows = document.querySelectorAll('#guruTableBody tr[data-id]');

        var visible = 0;
        rows.forEach(function (row) {
            var nama = (row.getAttribute('data-nama') || '').toLowerCase();
            var rMapel = row.getAttribute('data-mapel') || '';
            var email = (row.getAttribute('data-email') || '').toLowerCase();

            var matchSearch = !query || nama.indexOf(query) !== -1 || email.indexOf(query) !== -1;
            var matchMapel = !mapel || rMapel === mapel;

            if (matchSearch && matchMapel) {
                row.style.display = '';
                visible++;
            } else {
                row.style.display = 'none';
            }
        });
        updateInfo(visible);
    }

    function updateInfo(count) {
        var total = document.querySelectorAll('#guruTableBody tr[data-id]').length;
        var el = document.querySelector('.guru-table-info');
        if (el) el.textContent = 'Menampilkan ' + count + ' dari ' + total + ' data';
    }

    // ===== Select All Checkbox =====
    if (selectAll) {
        selectAll.addEventListener('change', function () {
            var checked = this.checked;
            document.querySelectorAll('.guru-row-checkbox').forEach(function (cb) {
                cb.checked = checked;
                cb.closest('tr').classList.toggle('row-selected', checked);
            });
            updateBulk();
        });
    }

    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('guru-row-checkbox')) {
            e.target.closest('tr').classList.toggle('row-selected', e.target.checked);
            if (selectAll) {
                var all = document.querySelectorAll('.guru-row-checkbox');
                var checked = document.querySelectorAll('.guru-row-checkbox:checked');
                selectAll.checked = all.length > 0 && all.length === checked.length;
                selectAll.indeterminate = checked.length > 0 && checked.length < all.length;
            }
            updateBulk();
        }
    });

    function updateBulk() {
        var checked = document.querySelectorAll('.guru-row-checkbox:checked').length;
        if (bulkActions) {
            if (checked > 0) {
                bulkActions.classList.add('visible');
                if (bulkCount) bulkCount.textContent = checked + ' data dipilih';
            } else {
                bulkActions.classList.remove('visible');
            }
        }
    }

    // ===== Bulk Delete =====
    var bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    if (bulkDeleteBtn) {
        bulkDeleteBtn.addEventListener('click', function () {
            var ids = [];
            document.querySelectorAll('.guru-row-checkbox:checked').forEach(function (cb) {
                ids.push(cb.value);
            });
            if (ids.length === 0) return;

            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.guru.bulk-delete") }}';

            var csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            form.appendChild(csrf);

            var method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'DELETE';
            form.appendChild(method);

            ids.forEach(function (id) {
                var inp = document.createElement('input');
                inp.type = 'hidden';
                inp.name = 'ids[]';
                inp.value = id;
                form.appendChild(inp);
            });

            document.body.appendChild(form);
            form.submit();
        });
    }

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
            form.action = '/admin/guru/' + deleteTargetId;

            var csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            form.appendChild(csrf);

            var method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'DELETE';
            form.appendChild(method);

            document.body.appendChild(form);
            form.submit();
        });
    }

    // ===== Toast dari flash =====
    var flashSuccess = document.getElementById('flashSuccess');
    if (flashSuccess && flashSuccess.value) {
        setTimeout(function () { showToast(flashSuccess.value, 'success'); }, 500);
    }

    function showToast(message, type) {
        var toast = document.createElement('div');
        toast.className = 'toast' + (type === 'danger' ? ' toast--danger' : '');
        var icon = type === 'danger' ? 'trash-2' : 'check';
        toast.innerHTML =
            '<div class="toast-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">' +
            (type === 'danger'
                ? '<polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>'
                : '<polyline points="20 6 9 17 4 12"/>') +
            '</svg></div><span>' + message + '</span>' +
            '<button class="toast-close" aria-label="Tutup"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>';

        toastContainer.appendChild(toast);

        toast.querySelector('.toast-close').addEventListener('click', function () {
            dismissToast(toast);
        });

        setTimeout(function () { dismissToast(toast); }, 4000);
    }

    function dismissToast(toast) {
        if (toast.classList.contains('exiting')) return;
        toast.classList.add('exiting');
        setTimeout(function () {
            if (toast.parentNode) toast.parentNode.removeChild(toast);
        }, 300);
    }

    // ===== Keyboard =====
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && deleteModal && deleteModal.classList.contains('open')) {
            closeDeleteModal();
        }
    });

});