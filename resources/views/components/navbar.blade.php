<header class="pf-header">
    <div class="pf-container pf-navbar">
        <a href="{{ route('palette.index') }}" class="pf-brand">
            <span class="pf-brand-mark"></span>
            paletteforge<span class="pf-brand-dot">.</span>
        </a>

        <nav class="pf-nav-links">
            <a href="{{ route('palette.index') }}" class="pf-nav-link pf-nav-link-active">
                Generator Warna
            </a>
            <a href="#tentang" class="pf-nav-link">
                Tentang
            </a>
            <a href="{{ route('palette.random') }}" class="pf-btn pf-btn-sm pf-btn-outline">
                Acak Warna
            </a>
        </nav>
    </div>
</header>
