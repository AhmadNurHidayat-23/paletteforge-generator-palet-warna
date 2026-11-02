<?php

namespace Tests\Unit;

use App\Services\PaletteGeneratorService;
use PHPUnit\Framework\TestCase;

class PaletteGeneratorServiceTest extends TestCase
{
    protected PaletteGeneratorService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new PaletteGeneratorService();
    }

    /**
     * Layanan menghasilkan tepat 5 warna dalam palet.
     */
    public function test_generates_exactly_five_colors(): void
    {
        $result = $this->service->generate('analogous', '#3B82F6');

        $this->assertCount(5, $result['colors']);
        $this->assertEquals('#3B82F6', $result['base_hex']);
        $this->assertEquals('analogous', $result['harmony']);
    }

    /**
     * Setiap skema harmoni (analogous, complementary, monochromatic) menghasilkan 5 kode HEX valid.
     */
    public function test_all_schemes_generate_valid_hex_codes(): void
    {
        $schemes = ['analogous', 'complementary', 'monochromatic'];

        foreach ($schemes as $scheme) {
            $result = $this->service->generate($scheme, '#10B981');
            $this->assertCount(5, $result['colors']);

            foreach ($result['colors'] as $color) {
                $this->assertMatchesRegularExpression('/^#[0-9A-F]{6}$/', $color['hex']);
                $this->assertArrayHasKey('rgb', $color);
                $this->assertArrayHasKey('hsl', $color);
                $this->assertArrayHasKey('text_color', $color);
            }
        }
    }

    /**
     * Sanitasi kode HEX bekerja dengan format 3 digit, 6 digit, dan simbol #.
     */
    public function test_sanitize_hex_formats(): void
    {
        $this->assertEquals('#FFFFFF', $this->service->sanitizeHex('fff'));
        $this->assertEquals('#FFFFFF', $this->service->sanitizeHex('#FFF'));
        $this->assertEquals('#2563EB', $this->service->sanitizeHex('2563eb'));
        $this->assertEquals('#2563EB', $this->service->sanitizeHex('#2563EB'));
        $this->assertNull($this->service->sanitizeHex('xyz123'));
        $this->assertNull($this->service->sanitizeHex('12345'));
    }

    /**
     * Warna teks kontras otomatis putih untuk warna gelap dan hitam untuk warna terang.
     */
    public function test_contrast_text_color(): void
    {
        $this->assertEquals('#FFFFFF', $this->service->getTextColor('#000000'));
        $this->assertEquals('#FFFFFF', $this->service->getTextColor('#1E293B'));
        $this->assertEquals('#0F172A', $this->service->getTextColor('#FFFFFF'));
        $this->assertEquals('#0F172A', $this->service->getTextColor('#FDE047'));
    }

    /**
     * Pembangun variabel CSS menghasilkan blok :root yang benar.
     */
    public function test_build_css_variables_format(): void
    {
        $result = $this->service->generate('analogous', '#3B82F6');
        $css = $result['css_variables'];

        $this->assertStringContainsString(':root {', $css);
        $this->assertStringContainsString('--pf-color-1:', $css);
        $this->assertStringContainsString('--pf-color-5:', $css);
        $this->assertStringEndsWith('}', $css);
    }
}
