# 🚀 Capstone Project: Pemrograman Web Lanjut

![CodeIgniter](https://img.shields.io/badge/Framework-CodeIgniter_4.7-EF4423?style=for-the-badge&logo=codeigniter&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Status](https://img.shields.io/badge/Status-Development-green?style=for-the-badge)

Proyek ini dikembangkan sebagai tugas **Capstone** untuk mata kuliah **Pemrograman Web Lanjut**. Aplikasi ini mengimplementasikan pola desain **MVC (Model-View-Controller)** menggunakan framework CodeIgniter 4 untuk menciptakan struktur kode yang bersih dan terorganisir.

---

## 🎓 Profil Mahasiswa

- **Nama:** Husnul Fikri Averus
- **Institusi:** Universitas Dian Nuswantoro (UDINUS)
- **Program Studi:** Teknik Informatika
- **Tujuan:** Implementasi Konsep MVC dan PHP Framework.

---

## 🛠️ Stack Teknologi

| Komponen      | Teknologi   | Versi  |
| :------------ | :---------- | :----- |
| **Bahasa**    | PHP         | ^8.2   |
| **Framework** | CodeIgniter | 4.7    |
| **Tooling**   | Composer    | Latest |

---

## 🛤️ Daftar Routes & Navigasi

Aplikasi telah dikonfigurasi dengan beberapa rute utama untuk menangani request user:

| Method  | Endpoint     | Controller                   | View              | Deskripsi                                    |
| :------ | :----------- | :--------------------------- | :---------------- | :------------------------------------------- |
| **GET** | `/`          | `Home::index`                | `v_home.php`      | Halaman beranda dengan menu navigasi.        |
| **GET** | `/produk`    | `ProdukController::index`    | `v_produk.php`    | Menampilkan daftar produk aplikasi.          |
| **GET** | `/keranjang` | `TransaksiController::index` | `v_keranjang.php` | Halaman untuk mengelola transaksi/keranjang. |

---

## 📂 Struktur Penting Proyek

Berikut adalah file-file kunci yang telah diimplementasikan dalam tahap awal ini:

- `app/Config/Routes.php`: Pengaturan alur URL aplikasi.
- `app/Controllers/`: Logika pemrosesan data (Produk & Transaksi).
- `app/Views/`: Template tampilan antarmuka (Home, Produk, Keranjang).
- `composer.json`: Manajemen dependensi framework.

---

## 🚀 Panduan Instalasi

Pastikan perangkat Anda sudah terpasang PHP ^8.2 dan Composer.

1.  **Clone Repositori**

    ```bash
    git clone https://github.com/Chqrety/learn-ci.git
    cd learn-ci
    ```

2.  **Instalasi Dependensi**

    ```bash
    composer install
    ```

3.  **Konfigurasi Environment**

    ```bash
    cp env .env
    ```

4.  **Menjalankan Server Lokal**
    ```bash
    php spark serve
    ```
    Buka browser dan akses: `http://localhost:8080`

---

> [!NOTE]
> Pastikan konfigurasi pada **Materi 3 slide 12 - 14** sudah diterapkan sepenuhnya sebelum melanjutkan ke tahap pengembangan database.

---

© 2026 - Husnul Fikri Averus
