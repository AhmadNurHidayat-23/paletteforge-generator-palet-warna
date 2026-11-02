/**
 * PaletteForge — Client Interaction Script
 * Minimal Vanilla JavaScript untuk fungsionalitas UI & Clipboard
 */

document.addEventListener('DOMContentLoaded', () => {
    initSwatches();
    initColorInputSync();
    initCopyActions();
    initKeyboardShortcuts();
});

/**
 * Terapkan variabel warna latar dan teks kontras pada swatch tanpa inline style di Blade
 */
function initSwatches() {
    const swatches = document.querySelectorAll('.pf-swatch');
    swatches.forEach((swatch) => {
        const bg = swatch.getAttribute('data-bg');
        const color = swatch.getAttribute('data-color');
        if (bg) {
            swatch.style.setProperty('--swatch-bg', bg);
        }
        if (color) {
            swatch.style.setProperty('--swatch-color', color);
        }
    });
}

/**
 * Sinkronisasi visual antara input color picker dan input teks HEX
 */
function initColorInputSync() {
    const colorPicker = document.querySelector('.js-color-picker');
    const hexInput = document.querySelector('.js-hex-input');

    if (!colorPicker || !hexInput) return;

    colorPicker.addEventListener('input', (e) => {
        const val = e.target.value.replace('#', '').toUpperCase();
        hexInput.value = val;
    });

    hexInput.addEventListener('input', (e) => {
        let val = e.target.value.trim().replace(/^#/, '');
        if (val.length === 3) {
            val = val.split('').map((c) => c + c).join('');
        }
        if (val.length === 6 && /^[0-9A-Fa-f]{6}$/.test(val)) {
            colorPicker.value = '#' + val;
        }
    });
}

/**
 * Logika penyalinan teks ke clipboard dan penampilan notifikasi toast
 */
function initCopyActions() {
    const copyButtons = document.querySelectorAll('.js-copy-btn');
    const toast = document.getElementById('pf-toast');
    const toastMsg = document.getElementById('pf-toast-message');
    let toastTimeout = null;

    copyButtons.forEach((btn) => {
        btn.addEventListener('click', async () => {
            const textToCopy = btn.getAttribute('data-copy');
            const label = btn.getAttribute('data-copy-label') || 'Teks';

            if (!textToCopy) return;

            try {
                await navigator.clipboard.writeText(textToCopy);
                showToast(`${label} berhasil disalin ke papan klip!`);

                const originalHtml = btn.innerHTML;
                btn.classList.add('pf-btn-copied');
                const copyTextEl = btn.querySelector('.pf-copy-text');
                if (copyTextEl) {
                    copyTextEl.textContent = 'Tersalin!';
                }

                setTimeout(() => {
                    btn.classList.remove('pf-btn-copied');
                    btn.innerHTML = originalHtml;
                }, 1800);
            } catch (err) {
                // Fallback untuk browser lama
                fallbackCopy(textToCopy);
                showToast(`${label} disalin.`);
            }
        });
    });

    function showToast(message) {
        if (!toast || !toastMsg) return;
        toastMsg.textContent = message;
        toast.classList.add('pf-toast-visible');

        if (toastTimeout) {
            clearTimeout(toastTimeout);
        }

        toastTimeout = setTimeout(() => {
            toast.classList.remove('pf-toast-visible');
        }, 2800);
    }

    function fallbackCopy(text) {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';
        document.body.appendChild(textarea);
        textarea.select();
        try {
            document.execCommand('copy');
        } finally {
            document.body.removeChild(textarea);
        }
    }
}

/**
 * Pintasan keyboard: Tombol spasi untuk menghasilkan palet acak baru
 */
function initKeyboardShortcuts() {
    window.addEventListener('keydown', (e) => {
        if (e.code === 'Space' || e.key === ' ') {
            const activeTag = document.activeElement ? document.activeElement.tagName.toLowerCase() : '';
            if (activeTag === 'input' || activeTag === 'textarea' || activeTag === 'select' || activeTag === 'button') {
                return;
            }
            e.preventDefault();
            const randomBtn = document.querySelector('a[href*="random"]');
            if (randomBtn) {
                window.location.href = randomBtn.href;
            }
        }
    });
}
