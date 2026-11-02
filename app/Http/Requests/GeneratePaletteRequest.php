<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeneratePaletteRequest extends FormRequest
{
    /**
     * Izinkan semua pengguna untuk membuat palet.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk pembuatan palet warna.
     */
    public function rules(): array
    {
        return [
            'hex' => [
                'nullable',
                'string',
                'regex:/^#?([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/',
            ],
            'harmony' => [
                'nullable',
                'string',
                'in:analogous,complementary,monochromatic',
            ],
        ];
    }

    /**
     * Pesan validasi dalam bahasa Indonesia yang ramah dan jelas.
     */
    public function messages(): array
    {
        return [
            'hex.regex' => 'Format kode HEX tidak valid. Masukkan 3 atau 6 karakter heksadesimal (contoh: #2563EB atau 2563EB).',
            'harmony.in' => 'Skema warna yang dipilih harus salah satu dari: Analogous, Complementary, atau Monochromatic.',
        ];
    }
}
