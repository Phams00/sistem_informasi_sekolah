/* ============================================
   GLOBAL.JS
   Inisialisasi Lucide, load font, utilitas umum
   ============================================ */

document.addEventListener('DOMContentLoaded', function () {
    // Inisialisasi semua ikon Lucide
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});

/**
 * Helper: buat elemen HTML dengan class & attributes
 */
function createElement(tag, attributes, children) {
    const el = document.createElement(tag);
    if (attributes) {
        Object.entries(attributes).forEach(([key, value]) => {
            if (key === 'className') {
                el.className = value;
            } else if (key.startsWith('on')) {
                el.addEventListener(key.slice(2).toLowerCase(), value);
            } else {
                el.setAttribute(key, value);
            }
        });
    }
    if (children) {
        if (typeof children === 'string') {
            el.innerHTML = children;
        } else if (Array.isArray(children)) {
            children.forEach(child => {
                if (typeof child === 'string') {
                    el.appendChild(document.createTextNode(child));
                } else if (child) {
                    el.appendChild(child);
                }
            });
        } else if (children instanceof HTMLElement) {
            el.appendChild(children);
        }
    }
    return el;
}