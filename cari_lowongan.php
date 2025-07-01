<?php
// Memanggil file konfigurasi untuk mendapatkan $base_url dan data sesi $user_profile
include 'config.php';

// --- DATABASE SIMULASI LENGKAP UNTUK PENCARIAN ---
$all_jobs_database = [
    ['id' => 'frontend-dev-kreatif', 'title' => 'Frontend Developer', 'company' => 'PT. Kreatif Indonesia', 'location' => 'Jakarta', 'salary' => 'Rp5jt - Rp7jt', 'logo' => 'https://via.placeholder.com/60x60?text=KI', 'category' => 'Teknologi', 'type' => 'Penuh Waktu'],
    ['id' => 'backend-eng-xyz', 'title' => 'Backend Engineer', 'company' => 'Startup XYZ', 'location' => 'Bandung', 'salary' => 'Rp6jt - Rp8jt', 'logo' => 'https://via.placeholder.com/60x60?text=XYZ', 'category' => 'Teknologi', 'type' => 'Penuh Waktu'],
    ['id' => 'uiux-designer-creative', 'title' => 'UI/UX Designer', 'company' => 'Creative Agency', 'location' => 'Surabaya', 'salary' => 'Rp8jt - Rp12jt', 'logo' => 'https://via.placeholder.com/60x60?text=CA', 'category' => 'Desain', 'type' => 'Kontrak'],
    ['id' => 'digital-marketer-growth', 'title' => 'Digital Marketer', 'company' => 'Growth Inc.', 'location' => 'Jakarta', 'salary' => 'Rp9jt - Rp15jt', 'logo' => 'https://via.placeholder.com/60x60?text=GI', 'category' => 'Pemasaran', 'type' => 'Penuh Waktu'],
    ['id' => 'data-scientist-analytic', 'title' => 'Data Scientist', 'company' => 'Analytic Corp', 'location' => 'Jakarta', 'salary' => 'Rp10jt - Rp18jt', 'logo' => 'https://via.placeholder.com/60x60?text=AC', 'category' => 'Teknologi', 'type' => 'Penuh Waktu'],
    ['id' => 'project-manager-buildit', 'title' => 'Project Manager', 'company' => 'BuildIt Group', 'location' => 'Work From Home', 'salary' => 'Rp12jt - Rp20jt', 'logo' => 'https://via.placeholder.com/60x60?text=BG', 'category' => 'Manajemen', 'type' => 'Remote']
];

// --- LOGIKA PENCARIAN ---
$keyword = $_GET['keyword'] ?? '';
$found_jobs = [];

if (!empty($keyword)) {
    $found_jobs = array_filter($all_jobs_database, function($job) use ($keyword) {
        // Mencari keyword di judul, perusahaan, atau lokasi (case-insensitive)
        return stripos($job['title'], $keyword) !== false || 
               stripos($job['company'], $keyword) !== false || 
               stripos($job['location'], $keyword) !== false;
    });
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Hasil Pencarian untuk "<?= htmlspecialchars($keyword) ?>" - Pathway</title>
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
            
        </div>
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

    <main>
        <section class="search-results-section">
            <div class="section-header">
                <div>
                    <h2>Hasil Pencarian</h2>
                    <p class="search-subtitle">Menampilkan hasil untuk: <strong>"<?= htmlspecialchars($keyword) ?>"</strong></p>
                </div>
            </div>

            <div class="job-list">
                <?php if (empty($found_jobs)): ?>
                    <div class="empty-state-card">
                        <i class="fas fa-search"></i>
                        <h3>Lowongan Tidak Ditemukan</h3>
                        <p>Maaf, kami tidak dapat menemukan lowongan yang cocok dengan kata kunci Anda. Coba kata kunci lain.</p>
                        <a href="<?= $base_url ?>beranda.php" class="button-primary">Kembali ke Beranda</a>
                    </div>
                <?php else: ?>
                    <?php foreach ($found_jobs as $job): ?>
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
const companyChatsData = <?= json_encode($company_chats ?? []) ?>;

document.addEventListener('DOMContentLoaded', () => {
    // --- Bagian 1: Logika untuk Popout Menu di Header ---
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
    document.querySelectorAll('.popout a:not(.open-popout)').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault(); e.stopPropagation();
            const href = this.getAttribute('href');
            if (href && href !== '#') window.location.href = href;
        });
    });

    // --- Bagian 2: Logika untuk Fitur UI Lainnya ---
    const animatedElements = document.querySelectorAll('.job-card, .section-header, .filter-btn');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('visible');
        });
    }, { threshold: 0.1 });
    animatedElements.forEach(el => observer.observe(el));

    const filterButtons = document.querySelectorAll('.filter-btn');
    const jobCards = document.querySelectorAll('.job-card');
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            const selectedCategory = button.dataset.category;
            jobCards.forEach(card => {
                card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                if (selectedCategory === 'Semua' || card.dataset.category === selectedCategory) {
                    card.style.display = 'block';
                    setTimeout(() => { card.style.opacity = '1'; card.style.transform = 'scale(1)'; }, 10);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.95)';
                    setTimeout(() => { card.style.display = 'none'; }, 300);
                }
            });
        });
    });

    const cardBookmarkButtons = document.querySelectorAll('.card-bookmark-btn');
    cardBookmarkButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault(); e.stopPropagation();
            button.classList.toggle('bookmarked');
            const icon = button.querySelector('i');
            if (button.classList.contains('bookmarked')) {
                icon.classList.remove('far'); icon.classList.add('fas');
            } else {
                icon.classList.remove('fas'); icon.classList.add('far');
            }
        });
    });

    // --- Bagian 3: Logika untuk Fitur Chat ---
    const messengerContainer = document.getElementById('messengerContainer');
    const closeMessengerBtn = document.getElementById('closeMessengerBtn');
    const messengerLogo = document.getElementById('messengerLogo');
    const messengerName = document.getElementById('messengerName');
    const messengerBody = document.getElementById('messengerBody');
    const messengerInput = document.getElementById('messengerInput');
    const messengerSendBtn = document.getElementById('messengerSendBtn');
    
    function openChat(chatId) {
        const chatData = companyChatsData[chatId];
        if (!chatData || !messengerContainer) return;
        messengerLogo.src = chatData.logo;
        messengerName.textContent = chatData.name;
        messengerBody.innerHTML = '';
        chatData.messages.forEach(msg => addMessageToChat(msg.text, msg.type));
        messengerContainer.classList.add('open');
    }

    function closeChat() { if(messengerContainer) messengerContainer.classList.remove('open'); }

    function addMessageToChat(text, type) {
        const messageEl = document.createElement('div');
        messageEl.classList.add('message', `message-${type}`);
        messageEl.textContent = text;
        messengerBody.appendChild(messageEl);
        messengerBody.scrollTop = messengerBody.scrollHeight;
    }
    
    function sendMessage() {
        const text = messengerInput.value.trim();
        if (text !== '') {
            addMessageToChat(text, 'sent');
            messengerInput.value = '';
            setTimeout(() => {
                addMessageToChat('Terima kasih atas pesan Anda. Kami akan segera merespons.', 'received');
            }, 1500);
        }
    }

    if(closeMessengerBtn) closeMessengerBtn.addEventListener('click', closeChat);
    if(messengerSendBtn) messengerSendBtn.addEventListener('click', sendMessage);
    if(messengerInput) messengerInput.addEventListener('keypress', (e) => { if (e.key === 'Enter') sendMessage(); });

    const urlParams = new URLSearchParams(window.location.search);
    const chatToOpen = urlParams.get('open_chat');
    if (chatToOpen) {
        openChat(chatToOpen);
    }
});
</script>

</body>
</html>
