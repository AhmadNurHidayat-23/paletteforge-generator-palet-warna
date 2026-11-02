<?php

namespace App\Http\Controllers;

use App\Http\Requests\GeneratePaletteRequest;
use App\Services\PaletteGeneratorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaletteController extends Controller
{
    public function __construct(
        protected PaletteGeneratorService $paletteService
    ) {}

    /**
     * Tampilkan halaman generator warna utama.
     */
    public function index(Request $request): View
    {
        $rawHex = $request->query('hex');
        $rawHarmony = $request->query('harmony', 'analogous');

        $baseHex = $this->paletteService->sanitizeHex($rawHex);
        $harmony = in_array($rawHarmony, array_keys(PaletteGeneratorService::SCHEMES), true)
            ? $rawHarmony
            : 'analogous';

        $palette = $this->paletteService->generate($harmony, $baseHex);

        return view('palette.index', [
            'palette' => $palette,
            'schemes' => PaletteGeneratorService::SCHEMES,
            'currentHarmony' => $harmony,
            'currentHex' => $palette['base_hex'],
        ]);
    }

    /**
     * Proses form submit untuk menghasilkan palet dengan proteksi CSRF.
     */
    public function generate(GeneratePaletteRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $harmony = $validated['harmony'] ?? 'analogous';
        $sanitizedHex = $this->paletteService->sanitizeHex($validated['hex'] ?? null);

        $params = ['harmony' => $harmony];
        if ($sanitizedHex) {
            $params['hex'] = ltrim($sanitizedHex, '#');
        }

        return redirect()->route('palette.index', $params)
            ->with('status', 'Palet warna berhasil dibuat.');
    }

    /**
     * Hasilkan palet baru secara acak.
     */
    public function random(): RedirectResponse
    {
        $randomHex = $this->paletteService->randomHex();
        $keys = array_keys(PaletteGeneratorService::SCHEMES);
        $randomHarmony = $keys[array_rand($keys)];

        return redirect()->route('palette.index', [
            'hex' => ltrim($randomHex, '#'),
            'harmony' => $randomHarmony,
        ]);
    }
}
