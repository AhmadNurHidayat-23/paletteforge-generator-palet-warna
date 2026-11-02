<?php

namespace Tests\Feature;

use Tests\TestCase;

class PaletteGeneratorTest extends TestCase
{
    /**
     * Halaman beranda dapat diakses dan menampilkan komponen utama.
     */
    public function test_home_page_renders_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('paletteforge');
        $response->assertSee('Temukan kombinasi warna yang sempurna.');
        $response->assertSee('Ekspor Variabel CSS');
        $response->assertSee('Konfigurasi Palet');
    }

    /**
     * Generator dapat memproses warna dasar dan skema valid.
     */
    public function test_can_generate_palette_with_valid_base_and_scheme(): void
    {
        $response = $this->post('/generate', [
            'hex' => '2563EB',
            'harmony' => 'complementary',
        ]);

        $response->assertRedirect('/?harmony=complementary&hex=2563EB');
        $response->assertSessionHas('status', 'Palet warna berhasil dibuat.');
    }

    /**
     * Input kode HEX yang tidak valid ditolak oleh validasi server-side.
     */
    public function test_invalid_hex_is_rejected_by_server_validation(): void
    {
        $response = $this->from('/')->post('/generate', [
            'hex' => 'ZZZZZZ',
            'harmony' => 'analogous',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHasErrors(['hex']);
    }

    /**
     * Endpoint acak mengarahkan kembali ke index dengan parameter palet baru.
     */
    public function test_random_palette_redirects_with_new_parameters(): void
    {
        $response = $this->get('/random');

        $response->assertStatus(302);
        $response->assertRedirectContains('hex=');
    }
}
