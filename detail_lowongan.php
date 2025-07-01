<?php
// SELALU panggil config.php di baris pertama
include 'config.php';

// Cek sesi login
if (!$user_profile) {
    $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Anda harus login untuk melihat detail lowongan.'];
    header("Location: " . $base_url . "login.php");
    exit();
}

// Simulasi database lowongan kerja
$all_jobs_database = [
    [
        'id' => 'frontend-dev-kreatif',
        'title' => 'Frontend Developer',
        'company' => 'PT. Kreatif Indonesia',
        'location' => 'Jakarta',
        'salary' => 'Rp5.000.000 - Rp7.000.000',
        'logo' => 'https://via.placeholder.com/80x80?text=KI',
        'type' => 'Penuh Waktu',
        'posted_date' => '2025-06-28',
        'description' => 'Membangun antarmuka pengguna yang responsif dan menarik...',
        'qualifications' => ['Minimal 2 tahun pengalaman...', 'Menguasai HTML, CSS, JS', 'Memahami UI/UX', 'Bisa Git'],
        'skills' => ['React', 'Vue.js', 'SCSS', 'Webpack', 'Figma'],
        'company_industry' => 'Teknologi Informasi',
        'company_size' => '51-200 karyawan',
        'company_website' => 'kreatifindonesia.com'
    ],
    [
        'id' => 'backend-eng-xyz',
        'title' => 'Backend Engineer',
        'company' => 'Startup XYZ',
        'location' => 'Bandung',
        'salary' => 'Rp6.000.000 - Rp8.000.000',
        'logo' => 'https://via.placeholder.com/80x80?text=XYZ',
        'type' => 'Penuh Waktu',
        'posted_date' => '2025-06-27',
        'description' => 'Merancang dan mengelola arsitektur server-side...',
        'qualifications' => ['Mahir PHP/Laravel...', 'Menguasai SQL', 'RESTful API', 'Keamanan Web'],
        'skills' => ['PHP', 'Laravel', 'Node.js', 'MySQL', 'REST API'],
        'company_industry' => 'Teknologi',
        'company_size' => '11-50 karyawan',
        'company_website' => 'startupxyz.id'
    ]
    // Tambahkan job lain jika perlu
];

// Ambil dan sanitasi job_id dari URL
$job_id = $_GET['job_id'] ?? '';
$job_id = htmlspecialchars(trim($job_id));

// Cari lowongan
$selected_job = null;
foreach ($all_jobs_database as $job) {
    if ($job['id'] === $job_id) {
        $selected_job = $job;
        break;
    }
}

// Redirect jika tidak ditemukan
if (!$selected_job) {
    $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Lowongan tidak ditemukan.'];
    header("Location: " . $base_url . "beranda.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lowongan: <?= htmlspecialchars($selected_job['title']) ?></title>
    <link rel="stylesheet" href="<?= $base_url ?>beranda.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="has-sticky-bar">
    
<div class="container">
    <header>
        <button class="menu-btn" id="menuBtn">&#9776;</button>
        
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

    <main class="job-detail-main">
        <div class="job-detail-content">
            <div class="job-detail-header-card">
                <img src="<?= htmlspecialchars($selected_job['logo']) ?>" alt="Logo Perusahaan">
                <h1><?= htmlspecialchars($selected_job['title']) ?></h1>
                <p><?= htmlspecialchars($selected_job['company']) ?> - <?= htmlspecialchars($selected_job['location']) ?></p>
                <p><small>Diposting pada: <?= date('d M Y', strtotime($selected_job['posted_date'])) ?></small></p>
            </div>

            <div class="detail-card">
                <h2>Deskripsi Pekerjaan</h2>
                <p><?= nl2br(htmlspecialchars($selected_job['description'])) ?></p>
            </div>

            <div class="detail-card">
                <h2>Kualifikasi</h2>
                <ul>
                    <?php if (!empty($selected_job['qualifications'])): ?>
                        <?php foreach ($selected_job['qualifications'] as $q): ?>
                            <li><?= htmlspecialchars($q) ?></li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>Tidak ada kualifikasi khusus.</li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="detail-card">
                <h2>Skill yang Dibutuhkan</h2>
                <div class="tag-container">
                    <?php if (!empty($selected_job['skills'])): ?>
                        <?php foreach ($selected_job['skills'] as $skill): ?>
                            <span class="tag"><?= htmlspecialchars($skill) ?></span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Tidak ada skill spesifik dicantumkan.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <aside class="job-detail-sidebar">
            <div class="job-summary-card">
                <h3>Tentang Perusahaan</h3>
                <div class="company-info">
                    <img src="<?= htmlspecialchars($selected_job['logo']) ?>" alt="Logo Perusahaan">
                    <h4><?= htmlspecialchars($selected_job['company']) ?></h4>
                </div>
                <ul>
                    <li><i class="fas fa-industry"></i> Industri: <?= htmlspecialchars($selected_job['company_industry'] ?? 'N/A') ?></li>
                    <li><i class="fas fa-users"></i> Ukuran: <?= htmlspecialchars($selected_job['company_size'] ?? 'N/A') ?></li>
                    <li><i class="fas fa-globe"></i> Situs:
                        <?php if (!empty($selected_job['company_website'])): ?>
                            <a href="https://<?= htmlspecialchars($selected_job['company_website']) ?>" target="_blank"><?= htmlspecialchars($selected_job['company_website']) ?></a>
                        <?php else: ?>
                            <span>N/A</span>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </aside>
    </main>

    <div class="sticky-apply-bar">
        <div class="sticky-bar-content">
            <div class="sticky-bar-job-info">
                <h4><?= htmlspecialchars($selected_job['title']) ?></h4>
                <p><?= htmlspecialchars($selected_job['company']) ?></p>
            </div>
                <div class="sticky-bar-actions">
                    <a href="<?= $base_url ?>beranda.php?open_chat=<?= urlencode($selected_job['id']) ?>" class="button-chat-sticky"><i class="fas fa-comments"></i></a>
                    <button class="button-primary" id="applyBtn">Lamar Sekarang</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const applyBtn = document.getElementById('applyBtn');
        if (applyBtn) {
            applyBtn.addEventListener('click', () => {
                applyBtn.textContent = '✔️ Sudah Dilamar';
                applyBtn.disabled = true;
                applyBtn.classList.add('applied');

                alert('Lamaran Anda berhasil dikirim!');
            });
        }

        // Popout menu
        const menuBtn = document.getElementById('menuBtn');
        const profileBtn = document.getElementById('profileBtn');
        const profileMenu = document.getElementById('profileMenu');

        if (menuBtn) {
            menuBtn.addEventListener('click', () => {
                alert('Menu belum aktif');
            });
        }

        if (profileBtn && profileMenu) {
            profileBtn.addEventListener('click', () => {
                profileMenu.classList.toggle('show');
            });
        }
    });
    document.addEventListener('DOMContentLoaded', () => {
        const applyBtn = document.getElementById('applyBtn');
        const flashContainer = document.getElementById('flashMessageContainer');

        if (applyBtn && flashContainer) {
            applyBtn.addEventListener('click', () => {
                // Disable tombol
                applyBtn.textContent = '✔️ Sudah Dilamar';
                applyBtn.disabled = true;
                applyBtn.classList.add('applied');

                // Tampilkan flash message
                flashContainer.innerHTML = `
                    <div class="flash-message success" style="
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        background-color: #4CAF50;
                        color: white;
                        padding: 12px 20px;
                        border-radius: 8px;
                        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                        z-index: 9999;
                    ">
                        Lamaran Anda berhasil dikirim!
                        <span style="margin-left: 10px; cursor: pointer;" onclick="this.parentElement.remove()">✖</span>
                    </div>
                `;

                // Hapus otomatis setelah 5 detik
                setTimeout(() => {
                    const flash = flashContainer.querySelector('.flash-message');
                    if (flash) flash.remove();
                }, 5000);
            });
        }
    });
    </script>
    
    <div id="flashMessageContainer"></div>
</body>
</html>
