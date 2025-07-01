<?php
// FILE: config.php (VERSI PALING AMAN)

// PERBAIKAN: Cek dulu apakah sesi sudah aktif atau belum.
// Ini akan mencegah error jika file ini dipanggil dua kali.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Definisikan Base URL Otomatis
$base_url = sprintf(
    "%s://%s%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME'],
    rtrim(dirname($_SERVER['REQUEST_URI']), '/\\') . '/'
);

// Inisialisasi data pengguna di Sesi HANYA JIKA belum ada
if (!isset($_SESSION['user_profile'])) {
    $_SESSION['logged_in'] = true;
    $_SESSION['user_profile'] = [
        'nama' => 'Dava Pangestu',
        'email' => 'dava.mahasiswa@example.com',
        'jurusan' => 'Informatika',
        'nim' => '123456789',
        'tanggal_lahir' => '2002-08-17',
        'kategori_pekerjaan' => ['Web Development', 'UI/UX Design'],
        'skills' => ['PHP', 'JavaScript', 'React', 'Figma'],
        'profile_picture' => 'https://via.placeholder.com/150?text=Dava',
        'last_photo_update' => '2022-01-01 10:00:00',
        'cv_file_name' => null,
        'cv_file_path' => null
    ];
}

// DEFINISIKAN VARIABEL $user_profile UNTUK SEMUA HALAMAN
$user_profile = $_SESSION['user_profile'] ?? null;
?>
