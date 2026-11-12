# SINERGI PLD - Pusat Layanan Disabilitas UIS

[![Laravel Version](https://img.shields.io/badge/Laravel-13.x-red.svg?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.4-blue.svg?style=flat-square&logo=php)](https://php.net)
[![Vite](https://img.shields.io/badge/Vite-7.x-purple.svg?style=flat-square&logo=vite)](https://vitejs.dev)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)](LICENSE)

**SINERGI PLD** (Sistem Informasi Layanan Disabilitas) adalah aplikasi berbasis web yang dibangun untuk mendukung operasional Pusat Layanan Disabilitas Universitas (UIS). Sistem ini memfasilitasi pendataan mahasiswa inklusif, pemantauan kebutuhan akomodasi khusus, riwayat akademik, asesmen kompetensi, proses kelulusan, hingga tracer study dan pemantauan karier alumni.

---

## 🚀 Fitur & Modul Utama

### 1. 📋 Pendataan Mahasiswa & Inklusif
- **Mahasiswa Baru**: Pendaftaran awal dan verifikasi calon mahasiswa.
- **Data Mahasiswa**: Manajemen profil lengkap mahasiswa aktif.
- **Data Orang Tua / Wali**: Informasi kontak darurat dan latar belakang wali.
- **Dokumen Mahasiswa**: Manajemen berkas digital (surat keterangan, identitas, rekam medis/asesmen pendukung).
- **Kebutuhan Inklusif**: Identifikasi ragam disabilitas, kebutuhan aksesibilitas khusus, dan fasilitas pendukung perkuliahan.
- **Data Alumni**: Registrasi dan arsip lulusan.

### 2. 🎓 Akademik & Penilaian
- **Mata Kuliah & KRS**: Manajemen kurikulum dan kartu rencana studi per semester.
- **Nilai Mahasiswa & IP/IPK**: Rekapitulasi nilai angka/huruf serta kalkulasi IP Semester dan IP Kumulatif otomatis.
- **Prestasi & Portofolio**: Pencatatan kejuaraan akademik/non-akademik serta karya mahasiswa.
- **Sertifikasi**: Pendataan bukti kelulusan pelatihan atau keahlian profesi mahasiswa.

### 3. 🧠 Asesmen Kompetensi
- **Instrumen & Pertanyaan**: Penyusunan kuesioner dan indikator penilaian kompetensi/kemampuan.
- **Pelaksanaan Asesmen**: Penjadwalan serta pengisian lembar asesmen secara real-time.
- **Hasil & Pemetaan Kompetensi**: Evaluasi performa dan grafik pemetaan potensi mahasiswa inklusif.

### 4. 📜 Kelulusan & Wisuda
- **Data Kelulusan**: Verifikasi berkas yudisium dan status kelulusan.
- **Manajemen Wisuda**: Registrasi periode wisuda dan penetapan toga/undangan.
- **Dokumen Lulusan**: Pengelolaan Ijazah, Transkrip Akademik, dan SKPI (Surat Keterangan Pendamping Ijazah).

### 5. 💼 Pelacakan Karir & Hubungan Alumni
- **Tracer Study**: Kuesioner pelacakan keselarasan pendidikan dengan dunia kerja.
- **Status Pekerjaan & Riwayat Karier**: Pemantauan transisi alumni ke dunia industri/wirausaha.
- **Perusahaan Mitra**: Kolaborasi dengan mitra industri inklusif.
- **Monitoring Alumni**: Pantauan berkelanjutan terhadap keberdayaan lulusan.

### 6. 📊 Laporan & Ekspor Data
- Rekapitulasi laporan komprehensif untuk Mahasiswa, Akademik, Asesmen, Alumni, dan Tracer Study.
- Ekspor data ke format Spreadsheet (Excel) atau cetak dokumen dengan integrasi **Yajra DataTables**.

### 7. ⚙️ Master Data & Akses Pengguna
- **Role-based Access Control (RBAC)**: Hak akses berjenjang (`superadmin`, `admin`, `pimpinan`).
- Master Fakultas, Program Studi, Tahun Akademik, dan Semester.
- Manajemen Pengguna dan Pembaruan Profil Mandiri.

### 8. 🛡️ Backup Database & Storage (Pengaturan Sistem)
- **Ekspor & Impor Database**: Unduh struktur dan seluruh data database ke berkas `.sql`, serta pemulihan (restore) database instan melalui upload berkas backup.
- **Backup & Impor Storage Public**: Pengarsipan otomatis seluruh dokumen lampiran dan berkas publik pada `storage/app/public` ke format `.zip`, serta fitur pemulihan storage.

---

## 🛠️ Kebutuhan Sistem (System Requirements)

- **PHP**: `^8.4` (Ekstensi: `pdo_mysql`, `mbstring`, `openssl`, `curl`, `gd`, `zip`, `intl`, `fileinfo`)
- **Web Server**: Apache / Nginx (Laragon / XAMPP direkomendasikan untuk Windows)
- **Database Server**: MySQL `^8.0` atau MariaDB `^10.4`
- **Composer**: `^2.2`
- **Node.js & NPM**: Node.js `^18.x` / `^20.x` & NPM `^9.x`

---

## 💻 Panduan Instalasi & Menjalankan Proyek

### 1. Klon Repositori
```bash
git clone <url-repository> sinergi
cd sinergi
```

### 2. Atur Versi PHP ke PHP 8.4
Pastikan terminal atau environment server Anda menggunakan **PHP 8.4**.
- **Di Laragon**: Klik kanan pada Laragon tray menu > **PHP** > **Version** > pilih `php-8.4.x`.
- **Periksa versi**:
  ```bash
  php -v
  ```

### 3. Install Dependensi PHP (Composer)
```bash
composer install
```

### 4. Konfigurasi Lingkungan (`.env`)
Salin file `.env.example` ke `.env`:
```bash
copy .env.example .env
```
Buka file `.env` dan sesuaikan koneksi database:
```env
APP_NAME="SINERGI PLD"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sinergi
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Migrasi Database & Seeder
Buat database bernama `sinergi` di MySQL, lalu jalankan:
```bash
php artisan migrate --seed
```

### 7. Install & Build Aset Frontend
```bash
npm install
npm run build
```
*(Untuk mode pengembangan frontend aktif, jalankan `npm run dev`)*

### 8. Jalankan Server Aplikasi
Jalankan development server Laravel:
```bash
php artisan serve
```
Akses aplikasi melalui browser: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🔐 Akun Default (Hasil Seeder)

Setelah menjalankan `php artisan migrate --seed`, akun bawaan berikut siap digunakan:

| Role | Email | Password | Hak Akses |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `superadmin@uis.ac.id` | `password` | Akses penuh ke semua modul, master data, dan manajemen pengguna |
| **Admin Unit** | `admin@uis.ac.id` | `password` | Manajemen pendataan, akademik, asesmen, dan kelulusan |
| **Pimpinan** | `user@uis.ac.id` | `password` | Pemantauan dashboard, monitoring alumni, dan laporan eksekutif |

---

## 🧪 Menjalankan Pengujian (Testing)

Proyek ini telah dikonfigurasi dengan **PHPUnit 11/12** yang kompatibel dengan PHP 8.4. Untuk menjalankan automated tests:

```bash
php artisan test
```

---

## 📁 Struktur Direktori Penting

```text
├── app/
│   ├── Http/
│   │   ├── Controllers/   # Logika bisnis seluruh modul fitur
│   │   └── Middleware/    # Penanganan autentikasi & Checkrole
│   └── Models/            # Model Eloquent ORM
├── database/
│   ├── migrations/        # Skema tabel database
│   └── seeders/           # Data awal pengguna, fakultas, prodi, dll.
├── resources/
│   ├── views/             # Template Blade tampilan sistem
│   └── css/               # Konfigurasi Tailwind & asset styling
├── routes/
│   └── web.php            # Definisi route sistem informasi
└── composer.json          # Dependensi Laravel 13 & PHP 8.4
```

---

## 📄 Lisensi

Proyek ini berada di bawah naungan lisensi [UIS](LICENSE).
