<?php
// Memanggil file konfigurasi untuk mendapatkan $base_url dan data sesi $user_profile
include 'config.php';

// Data dummy dengan penambahan 'category' untuk fitur filter
$popular_jobs = [
    ['id' => 'frontend-dev-kreatif', 'company' => 'PT. Kreatif Indonesia', 'title' => 'Frontend Developer', 'location' => 'Jakarta', 'salary' => 'Rp5.000.000 - Rp7.000.000', 'logo' => 'https://via.placeholder.com/60x60?text=KI', 'category' => 'Teknologi'],
    ['id' => 'backend-eng-xyz', 'company' => 'Startup XYZ', 'title' => 'Backend Engineer', 'location' => 'Bandung', 'salary' => 'Rp6.000.000 - Rp8.000.000', 'logo' => 'https://via.placeholder.com/60x60?text=XYZ', 'category' => 'Teknologi'],
    ['id' => 'uiux-designer-creative', 'title' => 'UI/UX Designer', 'company' => 'Creative Agency', 'location' => 'Surabaya', 'salary' => 'Rp8.000.000 - Rp12.000.000', 'logo' => 'https://via.placeholder.com/60x60?text=CA', 'category' => 'Desain'],
    ['id' => 'digital-marketer-growth', 'title' => 'Digital Marketer', 'company' => 'Growth Inc.', 'location' => 'Jakarta', 'salary' => 'Rp9.000.000 - Rp15.000.000', 'logo' => 'https://via.placeholder.com/60x60?text=GI', 'category' => 'Pemasaran']
];
$job_categories = ['Semua', 'Teknologi', 'Desain', 'Pemasaran'];

// Data dummy untuk percakapan chat
$company_chats = [
    'frontend-dev-kreatif' => ['name' => 'PT. Kreatif Indonesia', 'logo' => 'https://via.placeholder.com/60x60?text=KI', 'messages' => [['type' => 'received', 'text' => 'Halo! Ada yang bisa kami bantu terkait lowongan Frontend Developer?']]],
    'backend-eng-xyz' => ['name' => 'Startup XYZ', 'logo' => 'https://via.placeholder.com/60x60?text=XYZ', 'messages' => [['type' => 'received', 'text' => 'Terima kasih telah tertarik dengan posisi Backend Engineer kami.']]],
    'uiux-designer-creative' => ['name' => 'Creative Agency', 'logo' => 'https://via.placeholder.com/60x60?text=CA', 'messages' => [['type' => 'received', 'text' => 'Selamat datang! Silakan ajukan pertanyaan Anda mengenai posisi UI/UX Designer.']]],
    'digital-marketer-growth' => ['name' => 'Growth Inc.', 'logo' => 'https://via.placeholder.com/60x60?text=GI', 'messages' => [['type' => 'received', 'text' => 'Hai! Kami dari Growth Inc. siap menjawab pertanyaanmu.']]]
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pathway - Temukan Pekerjaan Impianmu</title>
    
    <!-- Memanggil file CSS yang benar -->
    <link rel="stylesheet" href="<?= $base_url ?>beranda.css" />
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
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
                <li><a href="<?= $base_url ?>lamaran_aktif.php">Lowongan Saya</a></li>
               
            </ul>
        </div>
    </header>

    <main>
        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="flash-message <?= htmlspecialchars($_SESSION['flash_message']['type']) ?>">
                <p><?= htmlspecialchars($_SESSION['flash_message']['text']) ?></p>
                <span class="close-flash" onclick="this.parentElement.style.display='none';">&times;</span>
            </div>
            <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>

        <section class="hero-section">
            <div class="hero-content">
                <h2>Temukan Pekerjaan Impian Anda Berikutnya</h2>
                <p>Jelajahi ribuan lowongan dari perusahaan terkemuka di Indonesia.</p>
                <form action="<?= $base_url ?>cari_lowongan.php" method="GET" class="hero-search-bar">
                    <input type="text" placeholder="Contoh: Product Manager, Jakarta" name="keyword" />
                    <button type="submit">Cari</button>
                </form>
            </div>
        </section>

        <section class="jobs-section">
            <div class="section-header">
                <h2>Lowongan Populer</h2>
                <a href="<?= $base_url ?>lowongan_populer.php">Lihat Semua</a>
            </div>
            <div class="category-filters">
                <?php foreach($job_categories as $index => $category): ?>
                    <button class="filter-btn <?= $index === 0 ? 'active' : '' ?>" data-category="<?= $category ?>"><?= $category ?></button>
                <?php endforeach; ?>
            </div>
            <div class="job-cards">
                <?php foreach ($popular_jobs as $job): ?>
                    <div class="job-card" data-category="<?= $job['category'] ?>">
                        <div class="job-card-header">
                            <img src="<?= htmlspecialchars($job['logo']) ?>" alt="Logo" class="job-logo">
                        </div>
                        <a href="<?= $base_url ?>detail_lowongan.php?job_id=<?= urlencode($job['id']) ?>" class="job-card-link">
                            <h3><?= htmlspecialchars($job['title']) ?></h3>
                            <p><?= htmlspecialchars($job['company']) ?></p>
                            <p><?= htmlspecialchars($job['location']) ?></p>
                            <p class="salary"><?= htmlspecialchars($job['salary']) ?></p>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <div class="popout popout-menu-detail" id="popoutLowongan">
        <ul>
            <li><a href="<?= $base_url ?>lamaran_aktif.php">Lamaran Aktif</a></li>
           
        </ul>
    </div>
</div>

<div class="messenger-container" id="messengerContainer">
    <div class="messenger-header">
        <div class="messenger-profile">
            <img src="https://via.placeholder.com/30" alt="logo" id="messengerLogo">
            <h4 id="messengerName">Pilih Percakapan</h4>
        </div>
        <button class="messenger-close-btn" id="closeMessengerBtn">&times;</button>
    </div>
    <div class="messenger-body" id="messengerBody">
        <p class="messenger-placeholder">Pilih lowongan dan mulai chat dari halaman detail.</p>
    </div>
    <div class="messenger-footer">
        <input type="text" id="messengerInput" placeholder="Ketik pesan...">
        <button id="messengerSendBtn"><i class="fas fa-paper-plane"></i></button>
    </div>
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

