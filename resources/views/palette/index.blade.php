@extends('layouts.app')

@section('title', 'PaletteForge — Generator Palet Warna Harmonis')

@section('content')
<div class="pf-container">
    {{-- Notifikasi Sukses --}}
    @if (session('status'))
        <div class="pf-alert pf-alert-success" role="alert">
            <svg class="pf-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    {{-- Hero Section --}}
    <section class="pf-hero">
        <div class="pf-hero-content">
            <div class="pf-hero-tag">
                <span class="pf-tag-indicator"></span>
                <span>Harmoni Warna Otomatis</span>
            </div>
            <h1 class="pf-hero-headline">
                Temukan kombinasi warna yang sempurna.
            </h1>
            <p class="pf-hero-subtitle">
                Hasilkan lima palet warna harmonis yang presisi untuk desainer dan web developer menggunakan kalkulasi matematis ruang warna HSL.
            </p>
            <div class="pf-hero-actions">
                <a href="{{ route('palette.random') }}" class="pf-btn pf-btn-primary pf-btn-lg">
                    <svg class="pf-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                        <path d="M3 3v5h5"/>
                        <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/>
                        <path d="M16 16h5v5"/>
                    </svg>
                    Buat Palet Baru
                </a>
                <a href="#kontrol" class="pf-btn pf-btn-outline pf-btn-lg">
                    Sesuaikan Warna
                </a>
            </div>
        </div>
    </section>

    {{-- Swatch Panel (Lima Warna Utama) --}}
    <section class="pf-palette-section" aria-label="Palet Lima Warna">
        <div class="pf-palette-header">
            <div class="pf-palette-info">
                <span class="pf-eyebrow">Skema Terpilih</span>
                <span class="pf-palette-scheme-badge">{{ $palette['harmony_name'] }}</span>
            </div>
            <div class="pf-palette-hint">
                <span class="pf-kbd">Spasi</span> Tekan spasi untuk palet acak baru
            </div>
        </div>

        <div class="pf-swatches-grid">
            @foreach ($palette['colors'] as $index => $color)
                <x-swatch-card :color="$color" :index="$index" />
            @endforeach
        </div>
    </section>

    {{-- Kontrol Generator --}}
    <div id="kontrol" class="pf-section-divider">
        <x-generator-controls 
            :current-harmony="$currentHarmony" 
            :current-hex="$currentHex" 
            :schemes="$schemes" 
        />
    </div>

    {{-- CSS Export Section --}}
    <div class="pf-section-divider">
        <x-css-export :css-variables="$palette['css_variables']" />
    </div>

    {{-- Tentang Section --}}
    <div class="pf-section-divider">
        <x-about-section />
    </div>
</div>
@endsection
