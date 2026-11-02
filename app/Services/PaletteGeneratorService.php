<?php

namespace App\Services;

class PaletteGeneratorService
{
    public const SCHEMES = [
        'analogous' => 'Analogous',
        'complementary' => 'Complementary',
        'monochromatic' => 'Monochromatic',
    ];

    /**
     * Hasilkan palet 5 warna berdasarkan skema dan warna dasar.
     */
    public function generate(string $harmony = 'analogous', ?string $baseHex = null): array
    {
        $harmony = array_key_exists($harmony, self::SCHEMES) ? $harmony : 'analogous';
        $baseHex = $this->sanitizeHex($baseHex) ?? $this->randomHex();

        [$r, $g, $b] = $this->hexToRgb($baseHex);
        [$h, $s, $l] = $this->rgbToHsl($r, $g, $b);

        $palette = match ($harmony) {
            'complementary' => $this->generateComplementary($h, $s, $l, $baseHex),
            'monochromatic' => $this->generateMonochromatic($h, $s, $l, $baseHex),
            default => $this->generateAnalogous($h, $s, $l, $baseHex),
        };

        return [
            'base_hex' => $baseHex,
            'harmony' => $harmony,
            'harmony_name' => self::SCHEMES[$harmony],
            'colors' => $palette,
            'css_variables' => $this->buildCssVariables($palette),
        ];
    }

    /**
     * Hasilkan warna acak HEX yang seimbang secara estetika.
     */
    public function randomHex(): string
    {
        return $this->hslToHex(mt_rand(0, 359), mt_rand(55, 85), mt_rand(42, 62));
    }

    /**
     * Harmoni Analogous (warna berdekatan pada roda warna).
     */
    protected function generateAnalogous(float $h, float $s, float $l, string $baseHex): array
    {
        $offsets = [-40, -20, 0, 20, 40];
        $labels = ['Analog 1', 'Analog 2', 'Dasar', 'Analog 3', 'Analog 4'];
        $lDiffs = [-8, -4, 0, 4, 8];
        $colors = [];

        for ($i = 0; $i < 5; $i++) {
            if ($offsets[$i] === 0) {
                $hex = $baseHex;
            } else {
                $newH = ($h + $offsets[$i] + 360) % 360;
                $newL = max(18, min(85, $l + $lDiffs[$i]));
                $newS = max(25, min(90, $s));
                $hex = $this->hslToHex($newH, $newS, $newL);
            }
            $colors[] = $this->formatColorData($hex, $labels[$i], $offsets[$i] === 0);
        }

        return $colors;
    }

    /**
     * Harmoni Complementary (warna berlawanan pada roda warna).
     */
    protected function generateComplementary(float $h, float $s, float $l, string $baseHex): array
    {
        $compH = ($h + 180) % 360;
        $specs = [
            ['h' => $h, 's' => max(25, min(90, $s)), 'l' => max(18, min(80, $l - 15)), 'label' => 'Dasar Gelap', 'is_base' => false],
            ['h' => $h, 's' => $s, 'l' => $l, 'label' => 'Dasar', 'is_base' => true, 'exact_hex' => $baseHex],
            ['h' => ($h + 30) % 360, 's' => max(20, min(65, $s - 20)), 'l' => max(25, min(88, $l + 12)), 'label' => 'Aksen Transisi', 'is_base' => false],
            ['h' => $compH, 's' => $s, 'l' => $l, 'label' => 'Komplementer', 'is_base' => false],
            ['h' => $compH, 's' => max(25, min(85, $s - 10)), 'l' => max(25, min(88, $l + 16)), 'label' => 'Komplementer Lembut', 'is_base' => false],
        ];

        return array_map(function ($spec) {
            $hex = $spec['exact_hex'] ?? $this->hslToHex($spec['h'], $spec['s'], $spec['l']);
            return $this->formatColorData($hex, $spec['label'], $spec['is_base']);
        }, $specs);
    }

    /**
     * Harmoni Monochromatic (variasi kecerahan & saturasi dari warna yang sama).
     */
    protected function generateMonochromatic(float $h, float $s, float $l, string $baseHex): array
    {
        $specs = [
            ['l' => 22, 's' => max(25, min(90, $s + 5)), 'label' => 'Paling Gelap'],
            ['l' => 38, 's' => $s, 'label' => 'Gelap Sedang'],
            ['l' => $l, 's' => $s, 'label' => 'Dasar', 'exact_hex' => $baseHex],
            ['l' => 70, 's' => max(20, min(80, $s - 10)), 'label' => 'Terang'],
            ['l' => 88, 's' => max(15, min(75, $s - 20)), 'label' => 'Paling Terang'],
        ];

        return array_map(function ($spec) use ($h) {
            $isBase = isset($spec['exact_hex']);
            $hex = $isBase ? $spec['exact_hex'] : $this->hslToHex($h, $spec['s'], $spec['l']);
            return $this->formatColorData($hex, $spec['label'], $isBase);
        }, $specs);
    }

    /**
     * Format data warna lengkap dengan rgb, hsl, dan teks kontras.
     */
    public function formatColorData(string $hex, string $label, bool $isBase = false): array
    {
        $hex = strtoupper($hex);
        [$r, $g, $b] = $this->hexToRgb($hex);
        [$h, $s, $l] = $this->rgbToHsl($r, $g, $b);

        return [
            'hex' => $hex,
            'rgb' => "rgb({$r}, {$g}, {$b})",
            'hsl' => "hsl({$h}, {$s}%, {$l}%)",
            'text_color' => $this->getTextColor($hex),
            'label' => $label,
            'is_base' => $isBase,
        ];
    }

    /**
     * Susun variabel CSS :root untuk 5 warna palet.
     */
    public function buildCssVariables(array $colors): string
    {
        $lines = [":root {"];
        foreach ($colors as $index => $color) {
            $varNum = $index + 1;
            $lines[] = "  --pf-color-{$varNum}: {$color['hex']};";
        }
        $lines[] = "}";
        return implode("\n", $lines);
    }

    /**
     * Sanitasi dan validasi format HEX.
     */
    public function sanitizeHex(?string $hex): ?string
    {
        if ($hex === null) return null;
        $hex = trim(ltrim($hex, '#'));

        if (strlen($hex) === 3 && ctype_xdigit($hex)) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        return (strlen($hex) === 6 && ctype_xdigit($hex)) ? '#' . strtoupper($hex) : null;
    }

    /**
     * Hitung luminance relatif sesuai standar WCAG.
     */
    public function getLuminance(string $hex): float
    {
        [$r, $g, $b] = $this->hexToRgb($hex);
        $channels = array_map(function ($val) {
            $c = $val / 255.0;
            return ($c <= 0.03928) ? ($c / 12.92) : pow(($c + 0.055) / 1.055, 2.4);
        }, [$r, $g, $b]);

        return (0.2126 * $channels[0]) + (0.7152 * $channels[1]) + (0.0722 * $channels[2]);
    }

    /**
     * Tentukan warna teks kontras yang nyaman dibaca.
     */
    public function getTextColor(string $hex): string
    {
        return $this->getLuminance($hex) > 0.42 ? '#0F172A' : '#FFFFFF';
    }

    /**
     * Konversi HEX ke RGB.
     */
    public function hexToRgb(string $hex): array
    {
        $clean = ltrim($hex, '#');
        if (strlen($clean) === 3) {
            $clean = $clean[0].$clean[0].$clean[1].$clean[1].$clean[2].$clean[2];
        }

        return [
            hexdec(substr($clean, 0, 2)),
            hexdec(substr($clean, 2, 2)),
            hexdec(substr($clean, 4, 2)),
        ];
    }

    /**
     * Konversi RGB ke HEX.
     */
    public function rgbToHex(int $r, int $g, int $b): string
    {
        return sprintf('#%02X%02X%02X', max(0, min(255, $r)), max(0, min(255, $g)), max(0, min(255, $b)));
    }

    /**
     * Konversi RGB (0-255) ke HSL.
     */
    public function rgbToHsl(int $r, int $g, int $b): array
    {
        $r /= 255.0; $g /= 255.0; $b /= 255.0;
        $max = max($r, $g, $b); $min = min($r, $g, $b);
        $delta = $max - $min;
        $l = ($max + $min) / 2.0;

        if ($delta == 0) {
            $h = 0; $s = 0;
        } else {
            $s = ($l > 0.5) ? ($delta / (2.0 - $max - $min)) : ($delta / ($max + $min));
            if ($max == $r) {
                $h = (($g - $b) / $delta) + ($g < $b ? 6 : 0);
            } elseif ($max == $g) {
                $h = (($b - $r) / $delta) + 2;
            } else {
                $h = (($r - $g) / $delta) + 4;
            }
            $h *= 60.0;
        }

        return [(int) round($h), (int) round($s * 100), (int) round($l * 100)];
    }

    /**
     * Konversi HSL ke RGB.
     */
    public function hslToRgb(float $h, float $s, float $l): array
    {
        $h = fmod($h, 360);
        if ($h < 0) $h += 360;
        $s /= 100.0; $l /= 100.0;

        $c = (1.0 - abs(2.0 * $l - 1.0)) * $s;
        $x = $c * (1.0 - abs(fmod($h / 60.0, 2.0) - 1.0));
        $m = $l - ($c / 2.0);

        [$r1, $g1, $b1] = match (true) {
            $h < 60 => [$c, $x, 0],
            $h < 120 => [$x, $c, 0],
            $h < 180 => [0, $c, $x],
            $h < 240 => [0, $x, $c],
            $h < 300 => [$x, 0, $c],
            default => [$c, 0, $x],
        };

        return [
            (int) round(($r1 + $m) * 255),
            (int) round(($g1 + $m) * 255),
            (int) round(($b1 + $m) * 255),
        ];
    }

    /**
     * Konversi HSL langsung ke kode HEX.
     */
    public function hslToHex(float $h, float $s, float $l): string
    {
        [$r, $g, $b] = $this->hslToRgb($h, $s, $l);
        return $this->rgbToHex($r, $g, $b);
    }
}
