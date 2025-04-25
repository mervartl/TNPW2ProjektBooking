<?php if (!isset($_SESSION)) session_start(); ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<header class="bg-light border-bottom py-3 mb-3">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <?php if (isset($_SESSION['user'])): ?>
                <span class="fw-semibold">👤 <?= htmlspecialchars($_SESSION['user']) ?></span>
                <a class="text-decoration-none" href="/Projekt/controller/home.php">🏠 Domů</a>
                <a class="text-decoration-none" href="/Projekt/view/add_listing_form.php">➕ Přidat inzerát</a>
                <a class="text-decoration-none" href="/Projekt/controller/dashboard.php">📊 Vaše Inzeráty</a>
                <a class="text-decoration-none" href="/Projekt/controller/settings.php">⚙️ Nastavení</a>
            <?php else: ?>
                <a class="text-decoration-none" href="/Projekt/view/login_form.php">Přihlášení</a>
                <a class="text-decoration-none" href="/Projekt/view/register_form.php">Registrace</a>
            <?php endif; ?>
        </div>
        <?php if (isset($_SESSION['user'])): ?>
            <a class="btn btn-outline-secondary btn-sm" href="/Projekt/controller/logout.php" id="logout">🚪 Odhlásit se</a>
        <?php endif; ?>
    </div>
</header>
