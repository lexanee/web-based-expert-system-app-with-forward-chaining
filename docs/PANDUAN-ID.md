# Panduan Teknis & Manual Pengguna

Aplikasi: Sistem Pakar Diagnosis Permasalahan Teknis pada E-Procurement Iotace Solusi Indonesia dengan Metode Forward Chaining (Laravel 12)


---

## 1. Ringkasan

Aplikasi ini adalah sistem pakar berbasis web untuk membantu diagnosis masalah berdasarkan gejala menggunakan metode inferensi Forward Chaining. Aplikasi menyediakan alur diagnosa publik (tanpa login), formulir pelaporan masalah, serta dashboard admin untuk mengelola data Gejala, Masalah, Aturan, dan melihat Riwayat.

---

## 2. Prasyarat & Perangkat Pendukung

- OS: Windows (disarankan)
- Laragon 8 (Apache/Nginx, PHP 8.3, MariaDB/MySQL opsional; aplikasi ini memakai SQLite by default)
- Visual Studio Code
- Node.js LTS (untuk Vite/Tailwind)
- Composer 2 (sudah termasuk pada Laragon 8)

Catatan: Repo ini menggunakan database SQLite (file `database/database.sqlite`). Tidak perlu membuat database MySQL kecuali Anda ingin memindahkan mesin basis data.

---

## 3. Instalasi Cepat (Developer)

Langkah berikut diasumsikan dijalankan di PowerShell (pwsh) pada Windows.

1) Clone & buka folder proyek
- Buka VS Code, lalu buka folder repo ini.

2) Instal dependensi PHP
- Jalankan Composer install agar vendor terpasang dan file `.env` tersalin dari `.env.example` otomatis via script Composer.

3) Instal dependensi frontend
- Jalankan `npm install` untuk memasang paket Vite/Tailwind/Alpine.

4) Siapkan database
- Pastikan file `database/database.sqlite` ada (script Composer post-create akan membuatnya pada proyek baru; bila belum ada, buat file kosong).
- Jalankan migrasi & seeder:
  - `php artisan migrate --seed`

5) Jalankan aplikasi (mode dev)
- Opsi A (semua proses paralel): `composer run dev`
  - Ini menjalankan: PHP server, queue listener, log tail, dan Vite dev server secara bersamaan.
- Opsi B (manual terpisah):
  - Terminal 1: `php artisan serve`
  - Terminal 2: `npm run dev`

6) Akses aplikasi
- Halaman publik: http://127.0.0.1:8000/
- Dashboard admin: http://127.0.0.1:8000/dashboard (perlu login)

---

## 4. Kredensial Admin (Default)

Seeder membuat 2 akun admin berikut dengan email sudah terverifikasi:

- Super Admin
  - Email: superadmin@iotace.co.id
  - Password: bismillah

- Admin IOTACE
  - Email: admin@iotace.co.id
  - Password: bismillah

Silakan login di /login lalu akses /dashboard.

Penting: Ubah password segera di menu Profil setelah login pada lingkungan produksi.

---

## 5. Struktur Fitur Utama

- Landing page: route `/` menampilkan halaman depan.
- Diagnosa publik (tanpa login):
  - `/diagnosis` (alias `/diagnosis/pilih-pengguna`) — langkah 1 pilih tipe pengguna: Vendor/Internal
  - `/diagnosis/pilih-proses` — langkah 2 pilih tahapan proses (daftar tergantung tipe)
  - `/diagnosis/pilih-gejala` — langkah 3 pilih gejala terfilter
  - Submit ke `/diagnosis/hasil-diagnosa` — hasil inferensi forward chaining ditampilkan dan tersimpan ke riwayat
- Lapor masalah (publik):
  - GET `/lapor` — form pelaporan (Issue Teknis/Bug/Saran) + optional lampiran
  - POST `/lapor` — simpan laporan dan tampilkan halaman sukses/detail
- Dashboard admin (perlu login & verifikasi email):
  - `/dashboard` — ringkas statistik/tautan
  - `/admin/gejala` — CRUD Gejala
  - `/admin/masalah` — CRUD Masalah + export PDF
  - `/admin/aturan` — CRUD Aturan + export PDF
  - `/admin/riwayat-diagnosis` — list, detail, export Excel/PDF
  - `/admin/riwayat-lapor-masalah` — list, detail, ubah status, export Excel/PDF, export satuan PDF

---

## 6. Data & Seeders

- Sumber data awal berada di folder `database/data/`:
  - `gejala.json`, `masalah.json`, `aturan.json`
- Seeder:
  - `UserSeeder` — membuat 2 akun admin default (lihat kredensial di atas)
  - `GejalaSeeder` — memuat data gejala dari JSON
  - `MasalahSeeder` — memuat data masalah dari JSON
  - `AturanSeeder` — memuat data aturan dari JSON (format: "IF G1 AND G2 THEN M1")
- Jalankan seeder dengan `php artisan db:seed` (otomatis dipanggil jika Anda memakai `php artisan migrate --seed`).

---

## 7. Cara Kerja Forward Chaining (Teknis Singkat)

- Engine: `App\Services\ForwardChainingEngine`
- Input: array ID gejala terpilih, tipe pengguna (Vendor/Internal)
- Proses:
  - Validasi gejala sesuai tipe pengguna (Vendor/Internal/atau Both)
  - Cari aturan dengan gejala yang terpenuhi 100%; jika ada, pilih skor tertinggi
  - Jika tidak ada yang 100%, hitung skor partial match berbobot (70% cakupan aturan, 30% cakupan gejala pengguna). Ambang minimal 70%
- Output: objek hasil dengan `found`, `masalah`, `solution`, `score`, `confidence_level`

---

## 8. Manual Pengguna (Publik)

A. Melakukan Diagnosa
1) Buka halaman `/diagnosis`
2) Pilih Tipe Pengguna: Vendor atau Internal
3) Pilih Tahapan Proses (daftar menyesuaikan tipe)
4) Pilih satu atau lebih Gejala yang relevan
5) Klik Lanjut/Diagnosa untuk melihat hasil
6) Hasil akan menampilkan masalah teridentifikasi (jika ada), solusi, serta tingkat kepercayaan

B. Melapor Masalah
1) Buka halaman `/lapor`
2) Isi jenis laporan, deskripsi, tipe pengguna, dan kontak (opsional)
3) Unggah lampiran (opsional; jpg/png/pdf/doc/docx hingga 10MB)
4) Submit, lalu catat ID laporan pada halaman sukses jika diperlukan

---

## 9. Manual Admin

A. Login & Profil
- Masuk ke `/login` menggunakan kredensial admin.
- Akses `/dashboard` setelah login.
- Ubah informasi profil atau password di `/profile`.

B. Kelola Gejala (`/admin/gejala`)
- Tambah gejala baru (kode, nama, tipe pengguna, proses)
- Edit/Hapus gejala
- Catatan: Pastikan konsistensi kode gejala karena digunakan pada Aturan

C. Kelola Masalah (`/admin/masalah`)
- Tambah/Edit/Hapus masalah (kode, nama, solusi)
- Export PDF daftar masalah

D. Kelola Aturan (`/admin/aturan`)
- Tambah/Edit/Hapus aturan
- Format data aturan (di seeder JSON) mengikuti pola: `IF G3 AND G4 THEN M4`
- Pada UI internal, relasikan masalah dengan daftar gejala (tersimpan sebagai array `gejala_ids`)
- Export PDF daftar aturan

E. Riwayat Diagnosis (`/admin/riwayat-diagnosis`)
- Lihat daftar & detail riwayat
- Export ke Excel atau PDF

F. Riwayat Lapor Masalah (`/admin/riwayat-lapor-masalah`)
- Lihat daftar & detail laporan
- Ubah status (contoh: Baru -> Diproses -> Selesai)
- Export Excel/PDF, termasuk export satu laporan ke PDF

---

## 10. Konfigurasi Penting

- Environment
  - Salin `.env.example` ke `.env` (Composer script biasanya sudah melakukan ini). Atur `APP_NAME`, `APP_URL`, dsb.
  - Default DB: SQLite via `DB_CONNECTION=sqlite`. Pastikan `database/database.sqlite` ada.
- Storage
  - Jalankan `php artisan storage:link` agar upload (lampiran laporan) dapat diakses via `public/storage`.
- Queue (opsional)
  - Beberapa fitur memakai queue listener dalam skrip dev. Untuk produksi, sesuaikan supervisor/daemon queue.

---

## 11. Build Produksi (opsional)

- Build aset front-end: `npm run build`
- Jalankan aplikasi di server web (Laragon/Apache/Nginx) yang mengarah ke folder `public/`
- Pastikan izin tulis pada `storage/` dan `bootstrap/cache/`

---

## 12. Troubleshooting Singkat

- 404 saat akses `/storage/...` untuk lampiran: jalankan `php artisan storage:link`
- Data aturan tidak nyambung: pastikan kode gejala (G1, G2, ...) dan kode masalah (M1, ...) di file JSON cocok dengan data yang sudah ada
- Tidak bisa login: pastikan seeder user sudah jalan (`php artisan db:seed`) dan gunakan email/password default
- Error migrasi: pastikan file `database.sqlite` ada dan tidak sedang dikunci oleh proses lain; coba ulang `php artisan migrate:fresh --seed`

---

## 13. Dukungan Perangkat: Laragon 8 & VS Code

- Laragon 8
  - Dapat dipakai sebagai web server lokal. Arahkan document root ke folder `public/` jika memakai Virtual Host.
  - Pastikan versi PHP di Laragon adalah 8.3 atau lebih baru.
- VS Code
  - Disarankan memasang ekstensi PHP Intelephense, Laravel Blade Snippets, Tailwind CSS IntelliSense, dan ESLint (opsional) untuk produktivitas.

---

## 14. Keamanan & Rekomendasi

- Ubah password admin default segera di produksi.
- Batasi akses register publik bila tidak diperlukan (nonaktifkan route register atau lindungi via policy).
- Lakukan backup berkala untuk file `database/database.sqlite` dan folder `storage/app/public`.

---

Selesai. Jika butuh panduan lebih lanjut (contoh: migrasi ke MySQL), tambahkan permintaan pada dokumentasi ini.
