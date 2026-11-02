@props(['cssVariables'])

<section class="pf-export-card">
    <div class="pf-export-header">
        <div>
            <span class="pf-eyebrow">Integrasi Kode</span>
            <h2 class="pf-export-title">Ekspor Variabel CSS</h2>
            <p class="pf-export-desc">
                Gunakan variabel CSS ini langsung dalam stylesheet proyek web Anda untuk konsistensi sistem desain.
            </p>
        </div>
        <button type="button" 
                class="pf-btn pf-btn-secondary js-copy-btn" 
                data-copy="{{ $cssVariables }}"
                data-copy-label="Variabel CSS palet">
            <svg class="pf-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect width="14" height="14" x="8" y="8" rx="2" ry="2"/>
                <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>
            </svg>
            Salin Kode CSS
        </button>
    </div>

    <div class="pf-code-container">
        <div class="pf-code-topbar">
            <span class="pf-code-lang">CSS Custom Properties</span>
            <span class="pf-code-dots">
                <span class="pf-dot"></span>
                <span class="pf-dot"></span>
                <span class="pf-dot"></span>
            </span>
        </div>
        <pre class="pf-pre"><code class="pf-code">{{ $cssVariables }}</code></pre>
    </div>
</section>
