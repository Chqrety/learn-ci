# 🚀 Capstone Project: Pemrograman Web Lanjut

![CodeIgniter](https://img.shields.io/badge/Framework-CodeIgniter_4.5-EF4423?style=for-the-badge&logo=codeigniter&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Bootstrap](https://img.shields.io/badge/UI_Theme-NiceAdmin-5f3fef?style=for-the-badge&logo=bootstrap&logoColor=white)
![Status](https://img.shields.io/badge/Status-Capstone_6_Completed-green?style=for-the-badge)

Proyek ini adalah implementasi tugas UTS untuk mata kuliah Pemrograman Web Lanjut menggunakan CodeIgniter 4, template NiceAdmin, dan sistem autentikasi berbasis session yang terintegrasi dengan database.

> [!NOTE]
> README ini mengikuti kondisi aplikasi terbaru di repository yang kini telah mendukung otomatisasi skema database melalui fitur Migrations dan Seeders.

> [!TIP]
> Jika ingin tampilan lebih hidup saat presentasi, buka halaman setelah login karena sidebar, header, dan title akan berubah secara dinamis sesuai route aktif dan role pengguna.

## Ringkasan Fitur

- Login dan logout dengan validasi data pengguna langsung dari database.
- Otomatisasi setup database menggunakan fitur **Database Migrations** dan **Seeders**.
- Session menyimpan `username`, `email`, `role`, `login_time`, dan status `isLoggedIn`.
- Route protection menggunakan filter `auth`.
- Sidebar dinamis berbasis role, menu Produk hanya muncul untuk user dengan role `admin`.
- Halaman profile menampilkan data session pengguna yang sedang login.
- Layout terpisah untuk halaman utama dan halaman login.
- Dynamic page title berdasarkan URI aktif.
- Halaman `Home`, `Produk`, dan `Keranjang` masih menggunakan konten sederhana sebagai demonstrasi struktur MVC.

## Akun Demo

Login demo yang digenerate otomatis melalui `UserSeeder`:

> [!IMPORTANT]
> Pastikan proses migrasi dan seeder sudah dijalankan agar data akun demo ini masuk ke dalam database sebelum melakukan pengujian login.

- Username: `husnul`
- Password: `123`
- Role: `admin`

## Route yang Tersedia

| Method | Endpoint     | Controller                   | Filter | Keterangan                            |
| :----- | :----------- | :--------------------------- | :----: | :------------------------------------ |
| GET    | `/`          | `Home::index`                |  auth  | Halaman utama setelah login           |
| GET    | `/login`     | `AuthController::login`      |   -    | Menampilkan form login                |
| POST   | `/login`     | `AuthController::login`      |   -    | Proses validasi login                 |
| GET    | `/logout`    | `AuthController::logout`     |   -    | Menghapus session dan keluar          |
| GET    | `/produk`    | `ProdukController::index`    |  auth  | Halaman produk                        |
| GET    | `/keranjang` | `TransaksiController::index` |  auth  | Halaman keranjang/transaksi           |
| GET    | `/profile`   | `UserController::profile`    |  auth  | Halaman profil user                   |
| GET    | `/layout`    | `Home::layout`               |   -    | View layout untuk pengecekan tampilan |

## Struktur Penting

```
app/
├── Controllers/
│   ├── AuthController.php
│   ├── Home.php
│   ├── ProdukController.php
│   ├── TransaksiController.php
│   └── UserController.php
├── Database/
│   ├── Migrations/
│   └── Seeds/
│       └── UserSeeder.php
├── Filters/
│   └── Auth.php
├── Views/
│   ├── layout.php
│   ├── layout_clear.php
│   ├── v_home.php
│   ├── v_login.php
│   ├── v_produk.php
│   ├── v_keranjang.php
│   ├── v_profile.php
│   └── components/
│       └── sidebar.php
└── Config/
    └── Routes.php
```

## Cara Menjalankan

> [!NOTE]
> Proyek ini dijalankan lewat CodeIgniter 4, jadi pastikan environment PHP, MySQL, dan Composer sudah tersedia sebelum menjalankan server.

1. Jalankan `composer install` untuk memasang dependensi vendor.
2. Salin file `env` menjadi `.env` lalu sesuaikan kredensial koneksi database MySQL Anda.
3. Jalankan perintah database migration dan seeder melalui terminal:
   ```bash
   php spark migrate
   php spark db:seed
   ```
4. Pastikan konfigurasi base URL sudah sesuai di `app/Config/App.php` atau `.env`.
5. Jalankan server lokal dengan perintah:
   ```bash
   php spark serve
   ```
6. Buka aplikasi di `http://localhost:8080` dan masukkan Akun Demo di atas.

## Catatan Implementasi

> [!TIP]
> Route dengan filter `auth` akan langsung menolak akses jika session `isLoggedIn` belum ada, jadi login harus dilakukan terlebih dahulu.

> [!WARNING]
> Sistem autentikasi pada rilis akademik ini ditujukan untuk demonstrasi pemenuhan tugas UTS, sehingga skema pengamanan enkripsi password tingkat lanjut belum diterapkan.

- Proteksi route ada di `app/Filters/Auth.php`, yang akan me-redirect user ke halaman login jika session `isLoggedIn` belum ada.
- Autentikasi masuk divalidasi secara dinamis mencocokkan data baris tabel dari database.
- Sidebar memeriksa `session()->get('role')` untuk menampilkan menu Produk hanya kepada admin.
- Halaman profile membaca data dari session untuk menampilkan informasi pengguna yang sedang aktif.

© 2026 - Husnul Fikri Averus
