# 🚀 Capstone Project: Pemrograman Web Lanjut

![CodeIgniter](https://img.shields.io/badge/Framework-CodeIgniter_4.5-EF4423?style=for-the-badge&logo=codeigniter&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Bootstrap](https://img.shields.io/badge/UI_Theme-NiceAdmin-5f3fef?style=for-the-badge&logo=bootstrap&logoColor=white)
![Status](https://img.shields.io/badge/Status-Capstone_4_Completed-green?style=for-the-badge)

Proyek ini adalah tahap **Capstone 4** untuk mata kuliah Pemrograman Web Lanjut. Fokus utama pada tahap ini adalah implementasi **Advanced Layouting** menggunakan template NiceAdmin dan pembuatan sistem **Authentication UI**.

---

## 🎓 Profil Mahasiswa

- **Nama:** Husnul Fikri Averus
- **Institusi:** Universitas Dian Nuswantoro (UDINUS)
- **Program Studi:** Teknik Informatika
- **Tujuan:** Implementasi Konsep MVC dan PHP Framework.

---

## 🛠️ Fitur Utama (Capstone 4 Update)

- **Master Layouting:** Menggunakan `renderSection` dan `include` untuk memisahkan komponen _Header_, _Sidebar_, dan _Footer_.
- **Multi-Layout System:**
  - `layout.php`: Untuk halaman dashboard/utama (dengan navigasi).
  - `layout_clear.php`: Khusus halaman autentikasi (Login/Register).
- **Authentication System:**
  - Implementasi login dengan validasi username & password.
  - Session management untuk menyimpan data user (username, role).
  - Logout functionality untuk menghancurkan session.
  - Dynamic profile display di header menampilkan username & role yang sedang login.
- **Dynamic Title:** Penamaan title halaman otomatis berdasarkan segmen URL menggunakan `uri_string()`.
- **Datatables Integration:** Implementasi tabel dinamis dengan fitur _search_ dan _paging_ yang sudah ter-styling.

---

## 🛤️ Daftar Routes & Navigasi

Aplikasi telah dikonfigurasi dengan rute-rute berikut:

| Method   | Endpoint     | Controller                   | View              | Deskripsi                           |
| :------- | :----------- | :--------------------------- | :---------------- | :---------------------------------- |
| **GET**  | `/`          | `Home::index`                | `v_home.php`      | Dashboard utama aplikasi.           |
| **GET**  | `/login`     | `AuthController::login`      | `v_login.php`     | Halaman login (Layout Clear).       |
| **POST** | `/login`     | `AuthController::login`      | -                 | Proses validasi login.              |
| **GET**  | `/logout`    | `AuthController::logout`     | -                 | Keluar dari session & redirect.     |
| **GET**  | `/produk`    | `ProdukController::index`    | `v_produk.php`    | Manajemen daftar produk.            |
| **GET**  | `/keranjang` | `TransaksiController::index` | `v_keranjang.php` | Halaman kelola transaksi/keranjang. |

---

## 📂 Struktur Penting Proyek

- `app/Views/layout.php`: Master template utama aplikasi.
- `app/Views/layout_clear.php`: Template minimalis tanpa sidebar (untuk Auth).
- `app/Views/components/`: Folder berisi potongan UI (Header, Sidebar, Footer).
- `public/NiceAdmin/`: Asset template static (CSS, JS, Vendor).

---

## 🚀 Panduan Instalasi

1.  **Clone Repositori**

    ```bash
    git clone [https://github.com/Chqrety/learn-ci.git](https://github.com/Chqrety/learn-ci.git)
    cd learn-ci
    ```

2.  **Instalasi Dependensi**

    ```bash
    composer install
    ```

3.  **Konfigurasi Environment**

    ```bash
    cp env .env
    # Ubah CI_ENVIRONMENT ke development di file .env
    ```

4.  **Menjalankan Server Lokal**

    ```bash
    php spark serve
    ```

    Akses aplikasi di: `http://localhost:8080`

5.  **Login ke Aplikasi**
    - Username: `april`
    - Password: `123`

---

## 🔐 Sistem Autentikasi

Fitur login & logout sudah terimplementasi. Pengguna harus login terlebih dahulu sebelum mengakses halaman utama. Informasi yang tersimpan dalam session:

```php
session()->set([
    'username' => 'april',      // Username user yang login
    'role' => 'admin',          // Role/level akses pengguna
    'isLoggedIn' => TRUE        // Status login
]);
```

> [!NOTE]
> Saat ini menggunakan hardcoded credentials untuk demo. Untuk production, integrasi dengan database dan password hashing yang lebih aman (bcrypt/argon2) sangat direkomendasikan.

---

> [!TIP]
> Jika tampilan elemen datatables (search bar atau dropdown) terlihat polos, pastikan file CSS di `public/NiceAdmin/assets/vendor/simple-datatables/style.css` sudah ter-load dengan benar (Status 200 OK di Network Tab).

© 2026 - Husnul Fikri Averus
