<?php
// Memanggil file konfigurasi untuk mendapatkan $base_url dan data sesi $user_profile
include 'config.php';

// --- DATABASE SIMULASI LENGKAP UNTUK SEMUA LOWONGAN POPULER ---
// Di dunia nyata, ini akan menjadi query ke database untuk mengambil semua lowongan
$all_popular_jobs = [
    ['id' => 'frontend-dev-kreatif', 'title' => 'Frontend Developer', 'company' => 'PT. Kreatif Indonesia', 'location' => 'Jakarta', 'salary' => 'Rp5jt - Rp7jt', 'logo' => 'https://via.placeholder.com/60x60?text=KI', 'category' => 'Teknologi', 'type' => 'Penuh Waktu'],
    ['id' => 'backend-eng-xyz', 'title' => 'Backend Engineer', 'company' => 'Startup XYZ', 'location' => 'Bandung', 'salary' => 'Rp6jt - Rp8jt', 'logo' => 'https://via.placeholder.com/60x60?text=XYZ', 'category' => 'Teknologi', 'type' => 'Penuh Waktu'],
    ['id' => 'uiux-designer-creative', 'title' => 'UI/UX Designer', 'company' => 'Creative Agency', 'location' => 'Surabaya', 'salary' => 'Rp8jt - Rp12jt', 'logo' => 'https://via.placeholder.com/60x60?text=CA', 'category' => 'Desain', 'type' => 'Kontrak'],
    ['id' => 'digital-marketer-growth', 'title' => 'Digital Marketer', 'company' => 'Growth Inc.', 'location' => 'Jakarta', 'salary' => 'Rp9jt - Rp15jt', 'logo' => 'https://via.placeholder.com/60x60?text=GI', 'category' => 'Pemasaran', 'type' => 'Penuh Waktu'],
    ['id' => 'data-scientist-analytic', 'title' => 'Data Scientist', 'company' => 'Analytic Corp', 'location' => 'Jakarta', 'salary' => 'Rp10jt - Rp18jt', 'logo' => 'https://via.placeholder.com/60x60?text=AC', 'category' => 'Teknologi', 'type' => 'Penuh Waktu'],
    ['id' => 'project-manager-buildit', 'title' => 'Project Manager', 'company' => 'BuildIt Group', 'location' => 'Work From Home', 'salary' => 'Rp12jt - Rp20jt', 'logo' => 'https://via.placeholder.com/60x60?text=BG', 'category' => 'Manajemen', 'type' => 'Remote']
];

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lowongan Populer - Pathway</title>
    <link rel="stylesheet" href="<?= $base_url ?>beranda.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<div class="popout-backdrop" id="popoutBackdrop"></div>
<div class="container">
    <header>
        <!-- Header Konsisten Anda -->
        <button class="menu-btn" id="menuBtn" aria-label="Menu">&#9776;</button>
        <div class="header-brand">
            <a href="<?= $base_url ?>beranda.php" style="text-decoration: none;"><h1>Pathway</h1></a>
        </div>
        <div class="right-header-group">
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
        <div class="popout popout-menu" id="menuPopout">
             <ul>
                <li><a href="<?= $base_url ?>beranda.php">Beranda</a></li>
                <li><a href="#" class="open-popout" data-popout="popoutLowongan">Lowongan Saya</a></li>
                <li><a href="<?= $base_url ?>bookmark_tersimpan.php">Bookmark</a></li>
            </ul>
        </div>
    </header>

    <main>
        <section class="all-jobs-section">
            <div class="section-header">
                <div>
                    <h2>Semua Lowongan Populer</h2>
                    <p class="search-subtitle">Jelajahi semua lowongan yang sedang tren saat ini.</p>
                </div>
            </div>

            <div class="job-list">
                <?php if (empty($all_popular_jobs)): ?>
                    <div class="empty-state-card">
                        <i class="fas fa-wind"></i>
                        <h3>Belum Ada Lowongan</h3>
                        <p>Saat ini belum ada lowongan populer yang tersedia. Silakan cek kembali nanti.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($all_popular_jobs as $job): ?>
                        <a class="job-item" href="<?= $base_url ?>detail_lowongan.php?job_id=<?= urlencode($job['id']) ?>">
                            <img src="<?= htmlspecialchars($job['logo']) ?>" alt="Logo" class="job-icon">
                            <div class="job-info">
                                <h4><?= htmlspecialchars($job['title']) ?></h4>
                                <p><?= htmlspecialchars($job['company']) ?> - <?= htmlspecialchars($job['location']) ?></p>
                            </div>
                            <div class="salary"><?= htmlspecialchars($job['salary']) ?></div>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </main>
</div>

<script>
    // JavaScript untuk menu popout
    document.addEventListener('DOMContentLoaded', () => {
        const allPopouts = document.querySelectorAll('.popout');
        const menuBtn = document.getElementById('menuBtn');
        const menuPopout = document.getElementById('menuPopout');
        const profileBtn = document.getElementById('profileBtn');
        const profileMenu = document.getElementById('profileMenu');
        const popoutBackdrop = document.getElementById('popoutBackdrop');
        
        function closeAllPopouts() {
            allPopouts.forEach(popout => popout.classList.remove('show'));
            if(popoutBackdrop) popoutBackdrop.classList.remove('show');
        }

        function openPopout(popoutElement) {
            closeAllPopouts();
            if (popoutElement) {
                popoutElement.classList.add('show');
                if(popoutBackdrop) popoutBackdrop.classList.add('show');
            }
        }

        if(popoutBackdrop) popoutBackdrop.addEventListener('click', closeAllPopouts);
        allPopouts.forEach(popout => popout.addEventListener('click', e => e.stopPropagation()));
        if(menuBtn) menuBtn.addEventListener('click', (e) => { e.stopPropagation(); if(menuPopout) menuPopout.classList.contains('show') ? closeAllPopouts() : openPopout(menuPopout); });
        if(profileBtn) profileBtn.addEventListener('click', (e) => { e.stopPropagation(); if(profileMenu) profileMenu.classList.contains('show') ? closeAllPopouts() : openPopout(profileMenu); });
        document.querySelectorAll('.open-popout').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault(); e.stopPropagation();
                const targetPopout = document.getElementById(e.currentTarget.dataset.popout);
                if(targetPopout) openPopout(targetPopout);
            });
        });
    });
</script>
</body>
</html>
