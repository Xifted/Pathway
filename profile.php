<?php
include 'config.php';

if ($user_profile === null) {
    $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Sesi Anda telah berakhir. Silakan login kembali.'];
    header("Location: " . $base_url . "beranda.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profil <?= htmlspecialchars($user_profile['nama'] ?? 'Pengguna') ?> - Pathway</title>
    <link rel="stylesheet" href="<?= $base_url ?>beranda.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<div class="container">
    <header>
        <button class="menu-btn" id="menuBtn">&#9776;</button>
        <div class="right-header-group">
            <a href="<?= $base_url ?>beranda.php"><h1 style="margin: 0;">Pathway</h1></a>
            <div class="profile-wrapper">
                <?php $foto = $user_profile['profile_picture'] ?? 'https://via.placeholder.com/40?text=P'; ?>
                <img src="<?= htmlspecialchars($foto) ?>" class="profile-pic-header" id="profileBtn" alt="Profil">
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
        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="flash-message <?= $_SESSION['flash_message']['type'] ?>">
                <p><?= htmlspecialchars($_SESSION['flash_message']['text']) ?></p>
                <span class="close-flash" onclick="this.parentElement.remove();">&times;</span>
            </div>
            <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>

        <section class="user-profile-section">
            <div class="profile-header">
                <?php
                    $nama_singkat = substr($user_profile['nama'] ?? 'U', 0, 1);
                    $foto_utama = $user_profile['profile_picture'] ?? 'https://via.placeholder.com/120?text=' . $nama_singkat;
                ?>
                <img src="<?= htmlspecialchars($foto_utama) ?>" class="profile-main-pic" alt="Foto Profil">
                <div class="profile-header-info">
                    <h2><?= htmlspecialchars($user_profile['nama']) ?></h2>
                    <p class="profile-tagline"><?= htmlspecialchars($user_profile['jurusan'] ?? '-') ?> - NIM: <?= htmlspecialchars($user_profile['nim'] ?? '-') ?></p>
                    <a href="<?= $base_url ?>pengaturan.php" class="edit-profile-btn"><i class="fas fa-pencil-alt"></i> Pengaturan Akun</a>
                </div>
            </div>

            <!-- ✅ Tambahan: Upload CV -->
            <div class="profile-details-card">
                <h3>Curriculum Vitae (CV)</h3>
                <form action="<?= $base_url ?>uploud_cv.php" method="POST" enctype="multipart/form-data">
                    <div class="cv-area">
                        <i class="fas fa-file-pdf cv-icon"></i>
                        <div class="cv-info">
                            <p><?= $user_profile['cv_file_name'] ?? 'Belum ada CV diunggah.' ?></p>
                            <small>Format PDF, maksimal 5MB</small>
                        </div>
                        <?php if (!empty($user_profile['cv_file_path'])): ?>
                            <a href="<?= htmlspecialchars($user_profile['cv_file_path']) ?>" class="cv-download-btn" download>Download</a>
                        <?php endif; ?>
                        <input type="file" name="cv_file" accept="application/pdf" required>
                        <button type="submit" class="cv-upload-btn">Upload</button>
                    </div>
                </form>
            </div>

            <!-- Kategori Pekerjaan -->
            <div class="profile-details-card">
                <h3>Kategori Pekerjaan yang Diminati</h3>
                <div class="tag-container">
                    <?php if (!empty($user_profile['kategori_pekerjaan'])): ?>
                        <?php foreach ($user_profile['kategori_pekerjaan'] as $kategori): ?>
                            <span class="tag"><?= htmlspecialchars($kategori) ?></span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="empty-state">Belum ada kategori. <a href="<?= $base_url ?>pengaturan.php">Tambah sekarang</a>.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Skills -->
            <div class="profile-details-card">
                <h3>Keahlian (Skills)</h3>
                <div class="tag-container">
                    <?php if (!empty($user_profile['skills'])): ?>
                        <?php foreach ($user_profile['skills'] as $skill): ?>
                            <span class="tag skill-tag"><?= htmlspecialchars($skill) ?></span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="empty-state">Belum ada skill. <a href="<?= $base_url ?>pengaturan.php">Tambah sekarang</a>.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const profileBtn = document.getElementById('profileBtn');
    const profileMenu = document.getElementById('profileMenu');
    const backdrop = document.getElementById('popoutBackdrop');

    function closeMenus() {
        document.querySelectorAll('.popout').forEach(p => p.classList.remove('show'));
        if (backdrop) backdrop.classList.remove('show');
    }

    if (profileBtn && profileMenu) {
        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            profileMenu.classList.toggle('show');
            if (backdrop) backdrop.classList.toggle('show');
        });
    }

    if (backdrop) {
        backdrop.addEventListener('click', closeMenus);
    }
});
</script>
</body>
</html>
