<footer class="pf-footer">
    <div class="pf-container pf-footer-inner">
        <div class="pf-footer-brand">
            <a href="{{ route('palette.index') }}" class="pf-brand">
                <span class="pf-brand-mark"></span>
                paletteforge<span class="pf-brand-dot">.</span>
            </a>
            <p class="pf-footer-desc">
                Aplikasi generator palet warna presisi untuk desainer dan web developer. Menghasilkan kombinasi warna harmonis dengan perhitungan matematis HSL yang konsisten.
            </p>
        </div>

        <div class="pf-footer-meta">
            <p class="pf-footer-copyright">
                &copy; {{ date('Y') }} PaletteForge. Dibuat dengan presisi arsitektur Laravel 13 &amp; Blade.
            </p>
            <p class="pf-footer-sub">
                Swiss Editorial Minimalist Tooling.
            </p>
        </div>
    </div>
</footer>
