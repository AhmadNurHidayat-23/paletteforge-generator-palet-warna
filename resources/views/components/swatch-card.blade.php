@props(['color', 'index'])

<article class="pf-swatch" data-bg="{{ $color['hex'] }}" data-color="{{ $color['text_color'] }}" data-hex="{{ $color['hex'] }}">
    <div class="pf-swatch-top">
        <span class="pf-swatch-index">0{{ $index + 1 }}</span>
        @if ($color['is_base'])
            <span class="pf-badge pf-badge-base">Warna Dasar</span>
        @else
            <span class="pf-swatch-label">{{ $color['label'] }}</span>
        @endif
    </div>

    <div class="pf-swatch-middle">
        <h3 class="pf-swatch-hex">{{ $color['hex'] }}</h3>
        <p class="pf-swatch-meta">{{ $color['rgb'] }}</p>
        <p class="pf-swatch-meta">{{ $color['hsl'] }}</p>
    </div>

    <div class="pf-swatch-bottom">
        <button type="button" 
                class="pf-btn-copy pf-btn-copy-swatch js-copy-btn" 
                data-copy="{{ $color['hex'] }}"
                data-copy-label="Kode warna {{ $color['hex'] }}"
                title="Salin kode HEX {{ $color['hex'] }}">
            <svg class="pf-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect width="14" height="14" x="8" y="8" rx="2" ry="2"/>
                <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>
            </svg>
            <span class="pf-copy-text">Salin HEX</span>
        </button>
    </div>
</article>
