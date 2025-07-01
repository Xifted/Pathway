<?php
// SELALU panggil config.php di baris pertama
include 'config.php';

// Blok perlindungan halaman yang sudah aman
if ($user_profile === null) {
    $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Sesi Anda telah berakhir. Silakan login kembali.'];
    header("Location: " . $base_url . "login.php");
    exit();
}

// Logika untuk memproses form saat disimpan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Logika untuk menyimpan data (nama, jurusan, dll.)
    $_SESSION['user_profile']['nama'] = $_POST['nama'] ?? $user_profile['nama'];
    $_SESSION['user_profile']['jurusan'] = $_POST['jurusan'] ?? $user_profile['jurusan'];
    $_SESSION['user_profile']['nim'] = $_POST['nim'] ?? $user_profile['nim'];
    $_SESSION['user_profile']['kategori_pekerjaan'] = $_POST['kategori'] ?? [];
    $_SESSION['user_profile']['skills'] = $_POST['skills'] ?? [];

    $flash_message_text = 'Profil berhasil diperbarui!';
    
    // Logika untuk upload foto
    if (isset($_FILES['photo_upload']) && $_FILES['photo_upload']['error'] == 0) {
        $upload_dir = 'uploads/';
        $file = $_FILES['photo_upload'];
        $file_name = uniqid() . '-' . basename($file['name']);
        $target_path = $upload_dir . $file_name;

        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            $_SESSION['user_profile']['profile_picture'] = $base_url . $target_path;
            $_SESSION['user_profile']['last_photo_update'] = date('Y-m-d H:i:s');
            $flash_message_text = 'Profil dan foto berhasil diperbarui!';
        } else {
            $flash_message_text = 'Profil diperbarui, tapi gagal mengupload foto.';
        }
    }

    

    $_SESSION['flash_message'] = ['type' => 'success', 'text' => $flash_message_text];
    header("Location: " . $base_url . "profile.php");
    exit();
}

// LOGIKA UNTUK MENGUNCI UPLOAD FOTO
$can_change_photo = true;
$next_change_date_formatted = '';

if (isset($user_profile['last_photo_update'])) {
    $last_update = new DateTime($user_profile['last_photo_update']);
    $next_change_date = $last_update->add(new DateInterval('P0D')); // Tambah 30 hari
    $now = new DateTime();

    if ($now < $next_change_date) {
        $can_change_photo = false; // Kunci fitur jika belum 30 hari
        $next_change_date_formatted = $next_change_date->format('d F Y');
    }
}

// DATA MASTER UNTUK PILIHAN
$daftar_jurusan = ['Manajemen', 'Akuntansi', 'Informatika', 'Sistem Informasi', 'Psikologi', 'DKV', 'Ilkom', 'Teksip', 'Arsitektur', 'Desain Produk'];
$all_job_categories = ['Web Development', 'UI/UX Design', 'Data Science', 'Mobile Development', 'Digital Marketing', 'Project Management', 'Finance', 'Human Resources', 'Architecture'];
$all_skills = ['PHP', 'Laravel', 'JavaScript', 'React', 'Figma', 'MySQL', 'Python', 'Node.js', 'Vue.js', 'AutoCAD', 'SketchUp', 'SAP', 'SPSS', 'Adobe Creative Suite'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pengaturan Akun - Pathway</title>
    <link rel="stylesheet" href="<?= $base_url ?>beranda.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<div class="container">
    <header>
        <a href="<?= $base_url ?>profile.php" class="menu-btn" style="text-decoration: none; font-size: 16px; display:flex; align-items:center; gap: 8px;">
            <i class="fas fa-arrow-left"></i> Kembali ke Profil
        </a>
        <div class="right-header-group">
            <a href="<?= $base_url ?>beranda.php" style="text-decoration:none;"><h1 style="margin: 0;">Pathway</h1></a>
            <div class="profile-wrapper">
                <?php $foto_header = $user_profile['profile_picture'] ?? 'https://via.placeholder.com/40?text=P'; ?>
                <img src="<?= htmlspecialchars($foto_header) ?>" alt="Foto Profil" class="profile-pic-header" id="profileBtn">
                <div class="popout popout-profile" id="profileMenu">
                    <ul>
                        <li><a href="<?= $base_url ?>profile.php">Profil Saya</a></li>
                        <li><a href="<?= $base_url ?>pengaturan.php">Pengaturan</a></li>
                        <li><a href="<?= $base_url ?>logout.php">Keluar</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="section-header">
            <h2>Pengaturan Akun</h2>
        </div>

        <form action="<?= $base_url ?>pengaturan.php" method="POST" class="settings-form" enctype="multipart/form-data">
            
            <div class="settings-card">
                <h3>Foto Profil</h3>
                <div class="profile-upload-area">
                    
                    <?php
                        $foto_sekarang = $user_profile['profile_picture'] ?? 'https://via.placeholder.com/100?text=None';
                    ?>
                    <img src="<?= htmlspecialchars($foto_sekarang) ?>" alt="Foto Profil Saat Ini" class="current-profile-pic">
                    
                    <div class="upload-controls">
                        <?php if ($can_change_photo): ?>
                            <label for="photo_upload" class="upload-button">
                                <i class="fas fa-upload"></i> Pilih Gambar Baru
                            </label>
                            <input type="file" id="photo_upload" name="photo_upload" accept="image/jpeg, image/png" hidden>
                            <small>Gunakan gambar format JPG atau PNG, maks 2MB.</small>
                        <?php else: ?>
                            <div class="upload-locked">
                                <i class="fas fa-lock"></i>
                                <span>Anda baru bisa mengganti foto lagi pada tanggal <strong><?= $next_change_date_formatted ?></strong>.</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="settings-card">
                <h3>Data Diri Mahasiswa</h3>
                 <div class="form-group">
                    <label for="jurusan">Jurusan</label>
                    <select id="jurusan" name="jurusan" onchange="syncCheckboxes()">
                        <option value="">-- Pilih Jurusan --</option>
                        <?php foreach ($daftar_jurusan as $jurusan): ?>
                            <option value="<?= $jurusan ?>" <?= ($user_profile['jurusan'] == $jurusan) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($jurusan) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($user_profile['nama']) ?>">
                </div>
                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="text" id="nim" name="nim" value="<?= htmlspecialchars($user_profile['nim']) ?>">
                </div>
            </div>

            <div class="settings-card">
                <h3>Kategori Pekerjaan & Keahlian</h3>
                <small>Pilih jurusan di atas untuk mendapatkan rekomendasi otomatis.</small>
                <div class="checkbox-group" style="margin-top: 15px;">
                    <?php foreach ($all_job_categories as $kategori): ?>
                        <label class="checkbox-label">
                            <input type="checkbox" name="kategori[]" value="<?= $kategori ?>" class="kategori-checkbox"
                                <?= in_array($kategori, $user_profile['kategori_pekerjaan']) ? 'checked' : '' ?>>
                            <span><?= htmlspecialchars($kategori) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
                <hr style="margin: 20px 0; border: 0; border-top: 1px solid var(--border-color);">
                <div class="checkbox-group">
                    <?php foreach ($all_skills as $skill): ?>
                        <label class="checkbox-label">
                            <input type="checkbox" name="skills[]" value="<?= $skill ?>" class="skill-checkbox"
                                <?= in_array($skill, $user_profile['skills']) ? 'checked' : '' ?>>
                            <span><?= htmlspecialchars($skill) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="form-submit-area">
                <button type="submit" class="save-button">Simpan Perubahan</button>
            </div>
        </form>
    </main>
</div>

<script>
    // Kode JavaScript untuk sinkronisasi, tidak perlu diubah
    const jurusanMapping = { 'Manajemen': { kategori: ['Project Management', 'Digital Marketing', 'Human Resources'], skills: ['SAP'] }, 'Akuntansi': { kategori: ['Finance'], skills: ['SAP', 'SPSS'] }, 'Informatika': { kategori: ['Web Development', 'Mobile Development', 'Data Science', 'UI/UX Design'], skills: ['PHP', 'Laravel', 'JavaScript', 'React', 'MySQL', 'Python', 'Node.js', 'Vue.js', 'Golang', 'Flutter', 'Swift'] }, 'Sistem Informasi': { kategori: ['Web Development', 'Project Management', 'Data Science'], skills: ['PHP', 'MySQL', 'Python', 'SAP'] }, 'Psikologi': { kategori: ['Human Resources'], skills: ['SPSS'] }, 'DKV': { kategori: ['UI/UX Design', 'Digital Marketing'], skills: ['Figma', 'Adobe Creative Suite'] }, 'Ilkom': { kategori: ['Digital Marketing', 'Human Resources'], skills: ['Adobe Creative Suite'] }, 'Teksip': { kategori: ['Architecture', 'Project Management'], skills: ['AutoCAD', 'SketchUp'] }, 'Arsitektur': { kategori: ['Architecture', 'UI/UX Design'], skills: ['AutoCAD', 'SketchUp', 'Figma'] }, 'Desain Produk': { kategori: ['UI/UX Design'], skills: ['Figma', 'SketchUp', 'Adobe Creative Suite'] } };
    const jurusanDropdown = document.getElementById('jurusan');
    const kategoriCheckboxes = document.querySelectorAll('.kategori-checkbox');
    const skillCheckboxes = document.querySelectorAll('.skill-checkbox');
    function syncCheckboxes() { const selectedJurusan = jurusanDropdown.value; const recommendations = jurusanMapping[selectedJurusan]; const checkedKategori = Array.from(kategoriCheckboxes).filter(cb => cb.checked).map(cb => cb.value); const checkedSkills = Array.from(skillCheckboxes).filter(cb => cb.checked).map(cb => cb.value); kategoriCheckboxes.forEach(cb => cb.checked = false); skillCheckboxes.forEach(cb => cb.checked = false); if (!recommendations) { kategoriCheckboxes.forEach(cb => { if (checkedKategori.includes(cb.value)) cb.checked = true; }); skillCheckboxes.forEach(cb => { if (checkedSkills.includes(cb.value)) cb.checked = true; }); return; } const finalKategori = [...new Set([...checkedKategori, ...recommendations.kategori])]; const finalSkills = [...new Set([...checkedSkills, ...recommendations.skills])]; kategoriCheckboxes.forEach(cb => { if (finalKategori.includes(cb.value)) cb.checked = true; }); skillCheckboxes.forEach(cb => { if (finalSkills.includes(cb.value)) cb.checked = true; }); }
    jurusanDropdown.addEventListener('change', syncCheckboxes);
</script>
</body>
</html>
