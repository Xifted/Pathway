<?php
include 'config.php';

// Cegah akses langsung jika belum login
if ($user_profile === null) {
    $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Anda harus login terlebih dahulu.'];
    header("Location: " . $base_url . "login.php");
    exit();
}

// Proses hanya jika metode POST dan file dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] === 0) {

    $upload_dir = __DIR__ . '/uploads/';
    $file = $_FILES['cv_file'];

    // Validasi: hanya file PDF
    $file_type = mime_content_type($file['tmp_name']);
    if ($file_type !== 'application/pdf') {
        $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Gagal: Hanya file PDF yang diperbolehkan.'];
        header("Location: " . $base_url . "profile.php");
        exit();
    }

    // Validasi ukuran (maks 5MB)
    if ($file['size'] > 5 * 1024 * 1024) {
        $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Gagal: Ukuran file tidak boleh lebih dari 5MB.'];
        header("Location: " . $base_url . "profile.php");
        exit();
    }

    // Pastikan folder uploads ada
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Buat nama file unik
    $nama_asli = basename($file['name']);
    $nama_unik = uniqid('cv_', true) . '.pdf';
    $lokasi_simpan = $upload_dir . $nama_unik;
    $url_simpan = $base_url . 'uploads/' . $nama_unik;

    // Pindahkan file ke folder uploads
    if (move_uploaded_file($file['tmp_name'], $lokasi_simpan)) {
        // Simpan data ke session
        $_SESSION['user_profile']['cv_file_name'] = $nama_asli;
        $_SESSION['user_profile']['cv_file_path'] = $url_simpan;

        $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'CV berhasil di-upload.'];
    } else {
        $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Gagal menyimpan file. Coba lagi.'];
    }

} else {
    $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Tidak ada file yang dipilih atau terjadi kesalahan.'];
}

// Redirect kembali ke halaman profil
header("Location: " . $base_url . "profile.php");
exit();
