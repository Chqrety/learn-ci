# 📝 UTS Pemrograman Web Lanjut

![CodeIgniter](https://img.shields.io/badge/Framework-CodeIgniter_4.5-EF4423?style=for-the-badge&logo=codeigniter&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Bootstrap](https://img.shields.io/badge/UI_Theme-NiceAdmin-5f3fef?style=for-the-badge&logo=bootstrap&logoColor=white)
![Status](https://img.shields.io/badge/Status-UTS_Ready-green?style=for-the-badge)

Proyek ini adalah implementasi tugas UTS untuk mata kuliah Pemrograman Web Lanjut menggunakan CodeIgniter 4, template NiceAdmin, dan sistem autentikasi berbasis session.

> [!NOTE]
> README ini mengikuti kondisi aplikasi yang ada di repository saat ini, termasuk login hardcoded, role admin, dan halaman profile berbasis session.

> [!TIP]
> Jika ingin tampilan lebih hidup saat presentasi, buka halaman setelah login karena sidebar, header, dan title akan berubah sesuai route aktif.

## Ringkasan Fitur

- Login dan logout dengan validasi username/password.
- Session menyimpan `username`, `email`, `role`, `login_time`, dan status `isLoggedIn`.
- Route protection menggunakan filter `auth`.
- Sidebar dinamis berbasis role, menu Produk hanya muncul untuk user dengan role `admin`.
- Halaman profile menampilkan data session pengguna yang sedang login.
- Layout terpisah untuk halaman utama dan halaman login.
- Dynamic page title berdasarkan URI aktif.
- Halaman `Home`, `Produk`, dan `Keranjang` masih menggunakan konten sederhana sebagai demonstrasi struktur MVC.

## Akun Demo

Login demo yang dipakai pada aplikasi saat ini:

> [!IMPORTANT]
> Akun demo ini dipakai langsung oleh `AuthController`, jadi pastikan username dan password sesuai agar bisa masuk ke halaman utama.

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
> Proyek ini dijalankan lewat CodeIgniter 4, jadi pastikan environment PHP dan Composer sudah tersedia sebelum menjalankan server.

1. Jalankan `composer install`.
2. Pastikan konfigurasi base URL sudah sesuai di `app/Config/App.php`.
3. Jalankan server lokal dengan `php spark serve` atau lewat XAMPP sesuai environment yang dipakai.
4. Buka aplikasi di `http://localhost:8080`.
5. Login dengan akun demo di atas.

## Catatan Implementasi

> [!TIP]
> Route dengan filter `auth` akan langsung menolak akses jika session `isLoggedIn` belum ada, jadi login harus dilakukan terlebih dahulu.

> [!WARNING]
> Sistem autentikasi masih memakai kredensial hardcoded untuk kebutuhan tugas, sehingga belum aman untuk produksi.

- Proteksi route ada di `app/Filters/Auth.php`, yang akan me-redirect user ke halaman login jika session `isLoggedIn` belum ada.
- Sidebar memeriksa `session()->get('role')` untuk menampilkan menu Produk hanya kepada admin.
- Halaman profile membaca data dari session untuk menampilkan informasi pengguna yang sedang aktif.

© 2026 - Husnul Fikri Averus
