<?php
// Panggil config untuk memulai sesi dan mendapatkan $base_url
include 'config.php';

// Hapus semua data sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Arahkan pengguna kembali ke halaman utama
header("Location: " . $base_url . "index.php");
exit(); // Pastikan tidak ada kode lain yang dieksekusi setelah redirect
?>
