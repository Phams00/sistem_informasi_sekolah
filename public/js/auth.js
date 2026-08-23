/* ============================================
   AUTH.JS
   Password toggle, validasi login/register
   ============================================ */

document.addEventListener('DOMContentLoaded', function () {

    // ===== Toggle password visibility =====
    document.querySelectorAll('.auth-password-toggle').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var wrapper = this.closest('.auth-password-wrapper');
            var input = wrapper.querySelector('input');
            var isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            // Ganti ikon
            if (isPassword) {
                this.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>';
            } else {
                this.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>';
            }
        });
    });

    // ===== Validasi form sebelum submit =====
    var authForms = document.querySelectorAll('.auth-form');
    authForms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            var inputs = form.querySelectorAll('[required]');
            var hasError = false;

            inputs.forEach(function (input) {
                var errorEl = input.parentElement.querySelector('.form-error');
                if (!input.value.trim()) {
                    input.classList.add('is-error');
                    if (errorEl) {
                        errorEl.textContent = 'Field ini wajib diisi';
                        errorEl.classList.add('visible');
                    }
                    hasError = true;
                } else {
                    input.classList.remove('is-error');
                    if (errorEl) {
                        errorEl.textContent = '';
                        errorEl.classList.remove('visible');
                    }
                }
            });

            if (hasError) {
                e.preventDefault();
                // Scroll ke error pertama
                var firstError = form.querySelector('.is-error');
                if (firstError) firstError.focus();
            }
        });
    });

    // ===== Hapus error saat mengetik =====
    document.querySelectorAll('.auth-form input, .auth-form select').forEach(function (el) {
        el.addEventListener('input', function () {
            this.classList.remove('is-error');
            var errorEl = this.parentElement.querySelector('.form-error');
            if (errorEl) {
                errorEl.textContent = '';
                errorEl.classList.remove('visible');
            }
        });
        el.addEventListener('change', function () {
            this.classList.remove('is-error');
            var errorEl = this.parentElement.querySelector('.form-error');
            if (errorEl) {
                errorEl.textContent = '';
                errorEl.classList.remove('visible');
            }
        });
    });

});