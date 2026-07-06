<?php

/**
 * Helper Transaksi untuk UAS Pemrograman Web Lanjut
 * Kelompok: A11.4416
 */

if (!function_exists('hitung_ppn')) {
  /**
   * 1. Menghitung PPN (Pajak Pertambahan Nilai)
   * Dihitung 11% dari total harga pembelian (tidak termasuk ongkir).
   */
  function hitung_ppn($total_harga)
  {
    return $total_harga * 0.11;
  }
}

if (!function_exists('hitung_biaya_admin')) {
  /**
   * 2. Menghitung Biaya Admin
   * Dihitung berdasarkan total harga pembelian dengan tarif berjenjang.
   */
  function hitung_biaya_admin($total_harga)
  {
    if ($total_harga <= 20000000) {
      // Jika total harga sampai dengan 20 juta rupiah
      return $total_harga * 0.006;
    } elseif ($total_harga <= 40000000) {
      // Jika total harga di atas 20 juta sampai dengan 40 juta rupiah
      return $total_harga * 0.008;
    } else {
      // Jika total harga di atas 40 juta rupiah
      return $total_harga * 0.01;
    }
  }
}

if (!function_exists('hitung_diskon_voucher')) {
  /**
   * 3. Menghitung Perhitungan Voucher Diskon
   * Pelanggan dapat memasukkan kode voucher untuk mendapatkan diskon tambahan.
   */
  function hitung_diskon_voucher($total_harga, $voucher_code)
  {
    $code = strtoupper(trim($voucher_code));

    switch ($code) {
      case 'FLASH10':
        return $total_harga * 0.10;
      case 'FLASH15':
        return $total_harga * 0.15;
      case 'MEMBER20':
        return $total_harga * 0.20;
      default:
        // Jika kode tidak valid atau kosong, diskon bernilai 0
        return 0;
    }
    return 0;
  }
}