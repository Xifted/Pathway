<?php
// SELALU panggil config.php di baris pertama
include 'config.php';

// Data khusus untuk halaman ini
$applications = [['title' => 'Frontend Developer','company' => 'PT. Kreatif Indonesia','location' => 'Jakarta','logo' => 'https://via.placeholder.com/60x60?text=Kreatif','date' => '15 Juni 2025','status' => 'Sedang ditinjau','status_class' => 'status-sedang-ditinjau']];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lamaran Aktif - Pathway</title>
    <link rel="stylesheet" href="<?= $base_url ?>beranda.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<div class="popout-backdrop" id="popoutBackdrop"></div>
<div class="container">
    <header>
        <button class="menu-btn" id="menuBtn" aria-label="Menu">&#9776;</button>
        <div class="right-header-group">
            <a href="<?= $base_url ?>beranda.php" style="text-decoration: none;"><h1>Pathway</h1></a>
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
            </ul>
        </div>
    </header>
    </header>
    </header>

    <main>
        <section class="my-applications-section">
            <div class="section-header">
                <h2>Lamaran Aktif Saya</h2>
            </div>
            <div class="job-list">
                <?php foreach ($applications as $app): ?>
                    <div class="job-item">
                        <img src="<?= htmlspecialchars($app['logo']) ?>" alt="Logo <?= htmlspecialchars($app['company']) ?>" class="job-icon">
                        <div class="job-info">
                            <h4><?= htmlspecialchars($app['title']) ?></h4>
                            <p><?= htmlspecialchars($app['company']) ?> - <?= htmlspecialchars($app['location']) ?></p>
                            <p style="font-size: 0.9em; color: var(--text-medium);">Dilamar pada: <?= htmlspecialchars($app['date']) ?></p>
                        </div>
                        <div class="application-status <?= htmlspecialchars($app['status_class']) ?>">
                            <?= htmlspecialchars($app['status']) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
    
    <div class="popout popout-menu-detail" id="popoutLowongan">
        <ul>
            <li><a href="<?= $base_url ?>lamaran_aktif.php">Lamaran Aktif</a></li>
            <li><a href="<?= $base_url ?>lowongan_diposting.php">Lowongan Diposting</a></li>
            <li><a href="<?= $base_url ?>tambah_lowongan.php">Tambah Lowongan</a></li>
        </ul>
    </div>
</div>

<script>
// JavaScript yang sama juga harus ada di setiap halaman
document.addEventListener('DOMContentLoaded', () => {
    // ... (salin tempel seluruh blok javascript dari beranda.php ke sini) ...
    const allPopouts = document.querySelectorAll('.popout');
    const menuBtn = document.getElementById('menuBtn');
    const menuPopout = document.getElementById('menuPopout');
    const profileBtn = document.getElementById('profileBtn');
    const profileMenu = document.getElementById('profileMenu');
    const popoutBackdrop = document.getElementById('popoutBackdrop');
    function closeAllPopouts() {
        allPopouts.forEach(popout => popout.classList.remove('show'));
        popoutBackdrop.classList.remove('show');
    }
    function openPopout(popoutElement) {
        closeAllPopouts();
        if (popoutElement) {
            popoutElement.classList.add('show');
            popoutBackdrop.classList.add('show');
        }
    }
    popoutBackdrop.addEventListener('click', closeAllPopouts);
    allPopouts.forEach(popout => popout.addEventListener('click', e => e.stopPropagation()));
    menuBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        menuPopout.classList.contains('show') ? closeAllPopouts() : openPopout(menuPopout);
    });
    profileBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        profileMenu.classList.contains('show') ? closeAllPopouts() : openPopout(profileMenu);
    });
    document.querySelectorAll('.open-popout').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const targetPopout = document.getElementById(e.currentTarget.dataset.popout);
            openPopout(targetPopout);
        });
    });
    document.querySelectorAll('.popout a:not(.open-popout)').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const href = this.getAttribute('href');
            if (href && href !== '#') {
                window.location.href = href;
            }
        });
    });
});
</script>
</body>
</html>
