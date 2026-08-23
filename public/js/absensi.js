/* ============================================
   ABSENSI.JS
   Filter tanggal, toast
   ============================================ */

document.addEventListener('DOMContentLoaded', function () {

    var toastContainer = document.getElementById('toastContainer');

    document.querySelectorAll('.absensi-auto-submit').forEach(function (el) {
        el.addEventListener('change', function () {
            this.closest('form').submit();
        });
    });

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

});