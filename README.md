# PaletteForge — Color Palette Generator

PaletteForge adalah aplikasi web generator palet warna harmonis untuk desainer antarmuka dan web developer. Mengadopsi prinsip desain *Swiss Editorial Minimalist*, aplikasi ini menonjolkan tipografi bersih, ruang bernapas lapang, dan palet warna sebagai fokus visual utama tanpa dekorasi berlebihan.

Melalui PaletteForge, eksplorasi warna digital menjadi lebih terarah dan terukur. Aplikasi meniadakan tebakan visual acak dengan menerapkan kalkulasi matematis harmoni warna HSL yang konsisten, mudah dipahami, dan langsung siap diintegrasikan ke stylesheet proyek modern.

### Tujuan dan Manfaat
PaletteForge bertujuan mempermudah penentuan kombinasi lima warna yang proporsional dan nyaman di mata. Manfaat utamanya mencakup percepatan penyusunan sistem desain (*design system*), pemilihan hierarki visual antarmuka, serta kemudahan transfer nilai variabel warna langsung ke dalam proyek web.

### Fitur Utama
1. **Generasi Otomatis Lima Warna**: Hasilkan 5 warna harmonis dalam satu klik atau pintasan spasi.
2. **Kustomisasi Warna Dasar**: Buat palet seimbang yang berpusat pada satu kode warna HEX pilihan.
3. **Pilihan Skema Harmoni**: Mendukung 3 model harmoni visual: *Analogous*, *Complementary*, dan *Monochromatic*.
4. **Inspeksi Format Warna**: Menampilkan nilai HEX, RGB, serta HSL untuk tiap panel warna.
5. **Kontras Teks Otomatis**: Menyesuaikan warna teks label secara dinamis berbasis luminansi WCAG agar selalu terbaca jelas.
6. **Ekspor Variabel CSS**: Menyusun dan menyalin variabel CSS `:root` siap pakai ke papan klip.
7. **Validasi Server-Side**: Memvalidasi format heksadesimal dengan pesan panduan ramah dalam bahasa Indonesia.

### Teknologi
- **Laravel 13** (PHP 8.5)
- **Blade Template Engine** (Server-Side Rendering)
- **HTML5 & CSS3**
- **Vanilla JavaScript** (Interaksi ringan & clipboard)
- **Vite**

### Cara Kerja Generator Warna
PaletteForge menggunakan model ruang warna HSL (*Hue, Saturation, Lightness*):
- **Analogous**: Memilih warna dengan pergeseran sudut hue berdekatan (±20° hingga ±40°).
- **Complementary**: Mengambil warna dengan sudut berlawanan (180°) disertai modulasi saturasi dan kecerahan.
- **Monochromatic**: Menjaga nilai hue tetap dan memvariasikan kecerahan (22%–88%) serta saturasi.

### Menjalankan Project Secara Lokal
1. Pastikan PHP (>= 8.2), Composer, dan Node.js terpasang.
2. Clone repositori:
   ```bash
   git clone https://github.com/AhmadNurHidayat-23/paletteforge-generator-palet-warna.git
   cd paletteforge-generator-palet-warna
   ```
3. Salin berkas lingkungan dan pasang dependensi:
   ```bash
   cp .env.example .env && composer install && php artisan key:generate
   ```
4. Pasang modul frontend dan kompilasi aset:
   ```bash
   npm install && npm run build
   ```
5. Jalankan server lokal:
   ```bash
   php artisan serve
   ```
6. Buka peramban di `http://127.0.0.1:8000`.
