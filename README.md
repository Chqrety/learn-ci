# 🚀 Capstone Project: Pemrograman Web Lanjut

![CodeIgniter](https://img.shields.io/badge/Framework-CodeIgniter_4.5-EF4423?style=for-the-badge&logo=codeigniter&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Bootstrap](https://img.shields.io/badge/UI_Theme-NiceAdmin-5f3fef?style=for-the-badge&logo=bootstrap&logoColor=white)
![Status](https://img.shields.io/badge/Status-Capstone_10_Completed-green?style=for-the-badge)

Proyek ini adalah implementasi tugas UTS untuk mata kuliah Pemrograman Web Lanjut menggunakan CodeIgniter 4, template NiceAdmin, autentikasi berbasis database, manajemen keranjang, checkout, dan integrasi ongkir RajaOngkir.

> [!NOTE]
> README ini mengikuti kondisi aplikasi terbaru di repository yang sudah memakai Migrations, Seeders, route protection, serta endpoint AJAX untuk destinasi dan ongkir.

> [!TIP]
> Setelah login, sidebar, header, profile, dan title halaman akan berubah secara dinamis sesuai route aktif dan role pengguna.

## Ringkasan Fitur

- Login dan logout dengan validasi data pengguna langsung dari database.
- Otomatisasi setup database menggunakan **Migrations** dan **Seeders**.
- Session menyimpan `username`, `email`, `role`, `login_time`, dan status `isLoggedIn`.
- Route protection menggunakan filter `auth`.
- Sidebar dinamis berbasis role, menu Produk hanya muncul untuk user dengan role `admin`.
- Halaman profile menampilkan data session pengguna yang sedang login.
- CRUD produk, hapus produk, dan download data produk.
- Manajemen keranjang: tambah, edit, hapus item, dan kosongkan keranjang.
- Checkout dengan perhitungan ongkir dari RajaOngkir.
- Endpoint AJAX untuk pencarian destinasi dan biaya pengiriman.
- Layout terpisah untuk halaman utama dan halaman login.
- Dynamic page title berdasarkan URI aktif.

## Akun Demo

Login demo digenerate otomatis melalui `UserSeeder`.

> [!IMPORTANT]
> Pastikan proses migrasi dan seeder sudah dijalankan agar data akun demo masuk ke database sebelum pengujian login.

- Username: `husnul`
- Password: `123`
- Role: `admin`

## Route yang Tersedia

| Method | Endpoint                    | Controller                          | Filter | Keterangan                            |
| :----- | :-------------------------- | :---------------------------------- | :----: | :------------------------------------ |
| GET    | `/`                         | `Home::index`                       |  auth  | Halaman utama setelah login           |
| GET    | `/login`                    | `AuthController::login`             |   -    | Menampilkan form login                |
| POST   | `/login`                    | `AuthController::login`             |   -    | Proses validasi login                 |
| GET    | `/logout`                   | `AuthController::logout`            |   -    | Menghapus session dan keluar          |
| GET    | `/profile`                  | `UserController::index`             |  auth  | Halaman profil user                   |
| GET    | `/produk`                   | `ProdukController::index`           |  auth  | Daftar produk                         |
| POST   | `/produk`                   | `ProdukController::create`          |  auth  | Tambah produk                         |
| POST   | `/produk/edit/{id}`         | `ProdukController::edit`            |  auth  | Ubah data produk                      |
| GET    | `/produk/delete/{id}`       | `ProdukController::delete`          |  auth  | Hapus produk                          |
| GET    | `/produk/download`          | `ProdukController::download`        |  auth  | Download data produk                  |
| GET    | `/keranjang`                | `TransaksiController::index`        |  auth  | Halaman keranjang                     |
| POST   | `/keranjang`                | `TransaksiController::cart_add`     |  auth  | Tambah produk ke keranjang            |
| POST   | `/keranjang/edit`           | `TransaksiController::cart_edit`    |  auth  | Ubah jumlah item keranjang            |
| GET    | `/keranjang/delete/{rowid}` | `TransaksiController::cart_delete`  |  auth  | Hapus item keranjang                  |
| GET    | `/keranjang/clear`          | `TransaksiController::cart_clear`   |  auth  | Kosongkan keranjang                   |
| GET    | `/checkout`                 | `TransaksiController::checkout`     |  auth  | Halaman checkout                      |
| POST   | `/buy`                      | `TransaksiController::buy`          |  auth  | Simpan transaksi pembelian            |
| GET    | `/ajax/destinations`        | `TransaksiController::destinations` |  auth  | Cari destinasi RajaOngkir             |
| GET    | `/ajax/costs`               | `TransaksiController::costs`        |  auth  | Ambil biaya pengiriman RajaOngkir     |
| GET    | `/layout`                   | `Home::layout`                      |   -    | View layout untuk pengecekan tampilan |

## Struktur Penting

```text
app/
├── Config/
│   ├── App.php
│   ├── Filters.php
│   └── Routes.php
├── Controllers/
│   ├── AuthController.php
│   ├── Home.php
│   ├── ProdukController.php
│   ├── TransaksiController.php
│   └── UserController.php
├── Database/
│   ├── Migrations/
│   │   ├── 2026-05-12-095313_User.php
│   │   ├── 2026-05-12-095320_Product.php
│   │   ├── 2026-05-12-095329_Transaction.php
│   │   ├── 2026-05-12-095336_TransactionDetail.php
│   │   └── 2026-05-19-094710_AddDeletedAtToTables.php
│   └── Seeds/
│       └── UserSeeder.php
├── Filters/
│   └── Auth.php
├── Models/
│   ├── ProductModel.php
│   ├── TransactionModel.php
│   ├── TransactionDetailModel.php
│   └── UserModel.php
├── Services/
│   └── RajaOngkirService.php
└── Views/
    ├── layout.php
    ├── layout_clear.php
    ├── v_home.php
    ├── v_login.php
    ├── v_produk.php
    ├── v_keranjang.php
    ├── v_checkout.php
    ├── v_profile.php
    ├── welcome_message.php
    ├── components/
    │   ├── header.php
    │   ├── sidebar.php
    │   └── footer.php
    ├── errors/
    └── styles/
        └── style.css
```

## Cara Menjalankan

> [!NOTE]
> Proyek ini dijalankan lewat CodeIgniter 4, jadi pastikan environment PHP, MySQL, dan Composer sudah tersedia sebelum menjalankan server.

1. Jalankan `composer install` untuk memasang dependensi vendor.
2. Salin file `env` menjadi `.env`, lalu sesuaikan kredensial database dan konfigurasi RajaOngkir.
3. Isi konfigurasi berikut di `.env` jika belum ada:

   ```ini
   RAJAONGKIR_API_KEY=your_api_key
   RAJAONGKIR_BASE_URL=https://your-rajaongkir-base-url/
   ```

4. Jalankan migrasi dan seed data:

   ```bash
   php spark migrate
   php spark db:seed UserSeeder
   ```

5. Pastikan konfigurasi base URL sudah sesuai di `app/Config/App.php` atau `.env`.
6. Jalankan server lokal:

   ```bash
   php spark serve
   ```

7. Buka aplikasi di `http://localhost:8080` dan login menggunakan akun demo di atas.

## Catatan Implementasi

> [!TIP]
> Route dengan filter `auth` akan langsung menolak akses jika session `isLoggedIn` belum ada, jadi login harus dilakukan terlebih dahulu.

> [!WARNING]
> Sistem autentikasi dan checkout pada rilis akademik ini ditujukan untuk demonstrasi pemenuhan tugas UTS, sehingga pengamanan password tingkat lanjut dan validasi transaksi produksi belum diterapkan.

- Proteksi route ada di `app/Filters/Auth.php`, yang akan me-redirect user ke halaman login jika session `isLoggedIn` belum ada.
- Autentikasi masuk divalidasi secara dinamis mencocokkan data dari tabel user di database.
- Sidebar memeriksa `session()->get('role')` untuk menampilkan menu Produk hanya kepada admin.
- Checkout menggunakan `app/Services/RajaOngkirService.php` untuk mengambil destinasi dan biaya kirim.
- Transaksi disimpan ke tabel transaksi dan detail transaksi melalui `TransactionModel` dan `TransactionDetailModel`.

© 2026 - Husnul Fikri Averus
