/* ============================================
   FORMS.JS
   Validasi, character counter, konfirmasi
   keluar untuk semua halaman create/edit
   ============================================ */

document.addEventListener('DOMContentLoaded', function () {

    // ===== Hapus error saat mengetik =====
    document.querySelectorAll('.form-input, .form-select').forEach(function (el) {
        el.addEventListener('input', function () { clearFieldError(this); });
        el.addEventListener('change', function () { clearFieldError(this); });
    });

    // ===== Character counter untuk textarea =====
    document.querySelectorAll('[data-max-chars]').forEach(function (textarea) {
        var max = parseInt(textarea.getAttribute('data-max-chars'));
        var counter = textarea.parentElement.querySelector('.char-counter');

        if (!counter) {
            counter = document.createElement('div');
            counter.className = 'char-counter';
            textarea.parentElement.appendChild(counter);
        }

        function updateCount() {
            var len = textarea.value.length;
            counter.textContent = len + ' / ' + max;
            if (len > max) {
                counter.classList.add('is-over');
            } else {
                counter.classList.remove('is-over');
            }
        }

        textarea.addEventListener('input', updateCount);
        updateCount();
    });

    // ===== Submit dengan loading state =====
    var submitBtn = document.querySelector('.btn-submit-form');
    if (submitBtn) {
        var form = submitBtn.closest('form');
        if (form) {
            form.addEventListener('submit', function () {
                submitBtn.classList.add('is-loading');
                var originalHTML = submitBtn.innerHTML;
                submitBtn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan...';
            });
        }
    }

    // ===== Konfirmasi keluar jika ada perubahan =====
    var formEl = document.querySelector('.form-card form');
    if (formEl) {
        var hasChanged = false;

        formEl.querySelectorAll('input, select, textarea').forEach(function (el) {
            el.addEventListener('input', function () { hasChanged = true; });
            el.addEventListener('change', function () { hasChanged = true; });
        });

        window.addEventListener('beforeunload', function (e) {
            if (hasChanged) {
                e.preventDefault();
                e.returnValue = '';
            }
        });
    }

    // ===== Validasi real-time (opsional, aktifkan dengan data-validate) =====
    document.querySelectorAll('[data-validate]').forEach(function (input) {
        var rules = input.getAttribute('data-validate').split('|');

        input.addEventListener('blur', function () {
            var value = this.value.trim();
            var errorEl = this.parentElement.querySelector('.form-error');

            for (var i = 0; i < rules.length; i++) {
                var rule = rules[i];
                var msg = null;

                if (rule === 'required' && !value) {
                    msg = 'Field ini wajib diisi';
                } else if (rule === 'email' && value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                    msg = 'Format email tidak valid';
                } else if (rule.startsWith('min:')) {
                    var min = parseInt(rule.split(':')[1]);
                    if (value && value.length < min) {
                        msg = 'Minimal ' + min + ' karakter';
                    }
                } else if (rule.startsWith('max:')) {
                    var maxVal = parseInt(rule.split(':')[1]);
                    if (value && value.length > maxVal) {
                        msg = 'Maksimal ' + maxVal + ' karakter';
                    }
                } else if (rule === 'numeric' && value && !/^\d+$/.test(value)) {
                    msg = 'Hanya angka yang diperbolehkan';
                }

                if (msg) {
                    showFieldError(input, msg);
                    return;
                }
            }

            // Jika lolos semua validasi
            clearFieldError(input);
            if (value) {
                input.classList.add('is-valid');
            } else {
                input.classList.remove('is-valid');
            }
        });
    });

});

// ===== Fungsi global =====

function showFieldError(input, message) {
    input.classList.remove('is-valid');
    input.classList.add('is-error');
    var errorEl = input.parentElement.querySelector('.form-error');
    if (errorEl) {
        errorEl.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>' + message;
        errorEl.classList.add('visible');
    }
}

function clearFieldError(input) {
    input.classList.remove('is-error');
    var errorEl = input.parentElement.querySelector('.form-error');
    if (errorEl) {
        errorEl.innerHTML = '';
        errorEl.classList.remove('visible');
    }
}