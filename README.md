# Sekolah App

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=flat-square&logo=php)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql)](https://www.mysql.com/)
[![Tailwind CSS](https://img.shields.io/badge/TailwindCSS-06B6D4?style=flat-square&logo=tailwindcss)](https://tailwindcss.com/)
[![Vite](https://img.shields.io/badge/Vite-646CFF?style=flat-square&logo=vite)](https://vitejs.dev/)
[![Pest](https://img.shields.io/badge/Pest-000000?style=flat-square)](https://pestphp.com/)
[![Midtrans](https://img.shields.io/badge/Midtrans-0080FF?style=flat-square)](https://midtrans.com/)
[![License: MIT](https://img.shields.io/badge/License-MIT-success.svg)](LICENSE)

> Sistem Informasi Manajemen Sekolah berbasis Laravel 12 yang mendukung pengelolaan akademik, absensi, keuangan, serta pembayaran SPP secara terintegrasi menggunakan Midtrans.

Sekolah App merupakan hasil pengembangan dari proyek **Pesantren App** yang telah direbranding dan dikembangkan lebih lanjut untuk memenuhi kebutuhan administrasi sekolah modern.

---

# Highlights

- Multi Role (Admin, Guru, Siswa)
- Dashboard Statistik
- Manajemen Data Sekolah
- Import Data Excel
- Rekapitulasi Absensi
- Pembayaran SPP Online
- Integrasi Midtrans Snap
- Laravel 12 + Vite + Tailwind CSS

---

# Status Project

| Komponen | Status |
|----------|--------|
| Development | 🟢 Active |
| Testing | 🟢 Ongoing |
| Documentation | 🟢 Complete |
| Midtrans | 🟢 Integrated |

---

# Screenshot

| Dashboard | Data Siswa | SPP |
|-----------|------------|-----|
| TODO | TODO | TODO |

---

# Daftar Isi

- [Fitur](#fitur)
- [Tech Stack](#tech-stack)
- [Built With](#built-with)
- [Arsitektur](#arsitektur)
- [Struktur Folder](#struktur-folder)
- [Role & Permission](#role--permission)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi](#instalasi)
- [Konfigurasi Environment](#konfigurasi-environment)
- [Database](#database)
- [Menjalankan Development](#menjalankan-development)
- [Menjalankan Production](#menjalankan-production)
- [Testing](#testing)
- [Payment Flow](#payment-flow)
- [Development Workflow](#development-workflow)
- [Roadmap](#roadmap)
- [Kontributor](#kontributor)
- [License](#license)

---

# Fitur

## Admin

- Dashboard
- CRUD Data Siswa
- CRUD Data Guru
- CRUD Mata Pelajaran
- CRUD Jadwal Pelajaran
- CRUD Absensi
- Rekapitulasi Absensi
- Import Data Siswa (Excel)
- Generate Tagihan SPP
- Pembayaran SPP
- Manajemen Keuangan

## Guru

- Dashboard Guru
- Melihat Jadwal Mengajar
- Melihat Data Akademik

## Siswa

- Dashboard Siswa
- Melihat Jadwal
- Melihat Histori Absensi
- Melihat Tagihan SPP
- Pembayaran SPP

---

# Tech Stack

| Bagian | Teknologi |
|---------|-----------|
| Backend | Laravel 12 |
| Bahasa | PHP 8.3+ |
| Database | MySQL |
| Frontend | Blade |
| CSS | Tailwind CSS |
| Javascript | Alpine.js |
| Build Tools | Vite |
| Payment Gateway | Midtrans Snap |
| Testing | Pest PHP |

---

# Built With

- Laravel Framework
- Laravel Breeze
- Laravel Eloquent ORM
- Tailwind CSS
- Alpine.js
- Vite
- Pest PHP
- Maatwebsite Laravel Excel
- Midtrans PHP SDK

---

# Arsitektur

```text
Browser
    │
    ▼
Laravel Routes
    │
    ▼
Controllers
    │
    ▼
Services
    │
    ▼
Models
    │
    ▼
MySQL Database
```

Aplikasi menerapkan pola **MVC (Model-View-Controller)** dengan **Service Layer** sehingga logika bisnis tetap terpisah dari Controller.

---

# Struktur Folder

```
app/
 ├── Http/
 │    ├── Controllers
 │    └── Middleware
 │
 ├── Models
 │
 ├── Services
 │
 └── Providers

database/
 ├── migrations
 ├── factories
 └── seeders

resources/
 ├── views
 ├── css
 └── js

routes/
 └── web.php

tests/
 ├── Feature
 └── Unit

public/
config/
```

---

# Role & Permission

| Modul | Admin | Guru | Siswa |
|--------|:----:|:----:|:----:|
| Dashboard | ✅ | ✅ | ✅ |
| Data Siswa | ✅ | ❌ | ❌ |
| Data Guru | ✅ | ❌ | ❌ |
| Mata Pelajaran | ✅ | ❌ | ❌ |
| Jadwal | ✅ | ✅ | ✅ |
| Absensi | ✅ | ✅ | ✅ |
| Rekap Absensi | ✅ | ❌ | ❌ |
| Keuangan | ✅ | ❌ | ❌ |
| Pembayaran SPP | ✅ | ❌ | ✅ |

---

# Persyaratan Sistem

- PHP >= 8.3
- Composer >= 2
- Node.js >= 22
- npm >= 10
- MySQL >= 8.0

---

# Instalasi

```bash
git clone https://github.com/AnandaAnugrahHandyanto/sekolah-app.git

cd sekolah-app

composer install

npm install

cp .env.example .env

php artisan key:generate

php artisan migrate

npm run build
```

Jika menggunakan seeder:

```bash
php artisan db:seed
```

---

# Konfigurasi Environment

Pastikan konfigurasi berikut telah disesuaikan.

```env
APP_NAME=Sekolah App

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sekolah_app
DB_USERNAME=root
DB_PASSWORD=

MIDTRANS_SERVER_KEY=
MIDTRANS_CLIENT_KEY=
MIDTRANS_IS_PRODUCTION=false
```

---

# Database

Database menggunakan **MySQL**.

Tabel utama meliputi:

- users
- siswas
- gurus
- mata_pelajarans
- jadwals
- absensis
- spp_bills
- payment_transactions
- keuangans

---

# Menjalankan Development

```bash
php artisan serve

npm run dev
```

---

# Menjalankan Production

```bash
composer install --no-dev

php artisan config:cache

php artisan route:cache

php artisan view:cache

npm run build
```

---

# Testing

Project menggunakan **Pest PHP**.

Menjalankan seluruh test:

```bash
php artisan test
```

Format coding:

```bash
vendor/bin/pint
```

Melihat daftar route:

```bash
php artisan route:list
```

---

# Payment Flow

```text
Admin
   │
Generate Tagihan
   │
   ▼
Siswa Login
   │
Pilih Tagihan
   │
Checkout Midtrans
   │
Pembayaran
   │
Webhook Midtrans
   │
Status Pembayaran Terupdate
```

---

# Development Workflow

```text
Feature Branch
      │
      ▼
Development
      │
      ▼
Testing
      │
      ▼
Code Review
      │
      ▼
Merge ke Main
```

---

# Roadmap

- [ ] Dashboard Analytics
- [ ] Export PDF
- [ ] Export Excel
- [ ] REST API
- [ ] QR Code Absensi
- [ ] Multi Tahun Ajaran
- [ ] Notifikasi WhatsApp
- [ ] Mobile Friendly Improvement

---

# Kontributor

### Lead Developer

- **Ananda Anugrah Handyanto**

---

# License

Project ini menggunakan lisensi **MIT License**.

---

<p align="center">
Dikembangkan menggunakan ❤️ dengan Laravel 12
</p>
