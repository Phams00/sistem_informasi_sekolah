/* ============================================
   DASHBOARD.JS
   Chart tab switching, bar chart animasi
   ============================================ */

document.addEventListener('DOMContentLoaded', function () {

    // ===== Tab Chart =====
    var chartTabs = document.querySelectorAll('.chart-tab');
    chartTabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            chartTabs.forEach(function (t) { t.classList.remove('active'); });
            this.classList.add('active');

            var target = this.getAttribute('data-chart');
            var charts = document.querySelectorAll('.bar-chart');
            charts.forEach(function (chart) {
                chart.style.display = 'none';
            });
            var activeChart = document.getElementById(target);
            if (activeChart) {
                activeChart.style.display = 'flex';
                animateBars(activeChart);
            }
        });
    });

    // ===== Animasi bar chart =====
    function animateBars(chart) {
        var bars = chart.querySelectorAll('.bar-fill');
        bars.forEach(function (bar) {
            var height = bar.getAttribute('data-height');
            bar.style.height = '0%';
            setTimeout(function () {
                bar.style.height = height + '%';
            }, 50);
        });
    }

    // Animasi awal
    var firstChart = document.querySelector('.bar-chart');
    if (firstChart) {
        setTimeout(function () { animateBars(firstChart); }, 300);
    }

    // ===== Jadwal: highlight yang sedang berlangsung =====
    var now = new Date();
    var currentHour = now.getHours();
    var currentMinute = now.getMinutes();

    document.querySelectorAll('.schedule-item').forEach(function (item) {
        var timeText = item.querySelector('.schedule-time').textContent.trim();
        var parts = timeText.split('-');
        if (parts.length === 2) {
            var startParts = parts[0].trim().split(':');
            var endParts = parts[1].trim().split(':');
            var startH = parseInt(startParts[0]);
            var endH = parseInt(endParts[0]);

            var statusEl = item.querySelector('.schedule-status');

            if (currentHour >= endH) {
                item.style.opacity = '0.5';
                if (statusEl) {
                    statusEl.textContent = 'Selesai';
                    statusEl.className = 'schedule-status done';
                }
            } else if (currentHour >= startH) {
                item.style.background = 'rgba(13, 148, 136, 0.04)';
                item.style.borderLeftColor = 'var(--accent)';
                if (statusEl) {
                    statusEl.textContent = 'Berlangsung';
                    statusEl.className = 'schedule-status ongoing';
                }
            } else {
                if (statusEl) {
                    statusEl.textContent = 'Akan Datang';
                    statusEl.className = 'schedule-status upcoming';
                }
            }
        }
    });

});