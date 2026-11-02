@props(['currentHarmony', 'currentHex', 'schemes'])

<section class="pf-controls-card">
    <div class="pf-controls-header">
        <div>
            <span class="pf-eyebrow">Parameter Harmoni</span>
            <h2 class="pf-controls-title">Konfigurasi Palet</h2>
        </div>
        <a href="{{ route('palette.random') }}" class="pf-btn pf-btn-secondary">
            <svg class="pf-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m21.5 2-5 5M21.5 7l-5-5M15.5 12a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0ZM2.5 22l5-5M2.5 17l5 5"/>
            </svg>
            Acak Warna & Harmoni
        </a>
    </div>

    <form action="{{ route('palette.generate') }}" method="POST" class="pf-form">
        @csrf

        <div class="pf-form-grid">
            {{-- Input Warna Dasar --}}
            <div class="pf-field">
                <label for="hex-input" class="pf-label">
                    Warna Dasar (HEX)
                </label>
                <div class="pf-input-group">
                    <div class="pf-color-picker-wrapper">
                        <input type="color" 
                               id="color-picker" 
                               class="pf-color-picker js-color-picker" 
                               value="{{ $currentHex }}" 
                               aria-label="Pilih warna secara visual">
                    </div>
                    <span class="pf-input-prefix">#</span>
                    <input type="text" 
                           id="hex-input" 
                           name="hex" 
                           class="pf-input pf-input-hex js-hex-input @error('hex') pf-input-error @enderror" 
                           value="{{ old('hex', ltrim($currentHex, '#')) }}" 
                           placeholder="Contoh: 2563EB" 
                           maxlength="7"
                           autocomplete="off"
                           spellcheck="false">
                </div>
                @error('hex')
                    <p class="pf-error-message">{{ $message }}</p>
                @else
                    <p class="pf-help-text">Mendukung format 6 atau 3 karakter heksadesimal.</p>
                @enderror
            </div>

            {{-- Pemilihan Skema Harmoni --}}
            <div class="pf-field">
                <label class="pf-label">
                    Skema Harmoni
                </label>
                <div class="pf-scheme-selector">
                    @foreach ($schemes as $schemeKey => $schemeLabel)
                        <label class="pf-scheme-option">
                            <input type="radio" 
                                   name="harmony" 
                                   value="{{ $schemeKey }}" 
                                   class="pf-radio-input"
                                   {{ old('harmony', $currentHarmony) === $schemeKey ? 'checked' : '' }}>
                            <span class="pf-scheme-box">
                                <span class="pf-scheme-title">{{ $schemeLabel }}</span>
                                <span class="pf-scheme-desc">
                                    @if ($schemeKey === 'analogous')
                                        Sudut nada berdekatan
                                    @elseif ($schemeKey === 'complementary')
                                        Kontras sudut berlawanan
                                    @else
                                        Variasi kecerahan satu nada
                                    @endif
                                </span>
                            </span>
                        </label>
                    @endforeach
                </div>
                @error('harmony')
                    <p class="pf-error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="pf-form-actions">
            <button type="submit" class="pf-btn pf-btn-primary">
                <svg class="pf-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="m10 8 4 4-4 4"/>
                </svg>
                Hasilkan Palet Harmonis
            </button>
            <a href="{{ route('palette.index') }}" class="pf-btn pf-btn-ghost">
                Reset ke Default
            </a>
        </div>
    </form>
</section>

