<?php include '../partials/header.php'; ?>

<div class="container my-5">
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title"><?= htmlspecialchars($listing['title']) ?></h2>
            <p class="card-text"><?= nl2br(htmlspecialchars($listing['description'])) ?></p>
            <p><strong>Lokalita:</strong> <?= htmlspecialchars($listing['location']) ?></p>

            <?php if ($listing['image_path']): ?>
                <!-- Zobrazení obrázku, pokud je k dispozici -->
                <img src="../<?= htmlspecialchars($listing['image_path']) ?>" class="img-fluid rounded my-3" alt="Obrázek inzerátu" style="max-width: 400px;">
            <?php endif; ?>

            <p><em>Autor: <?= htmlspecialchars($listing['user_name'] ?? '') ?></em></p>
        </div>
    </div>

    <hr>

    <h3>Komentáře</h3>

    <?php if (isset($_SESSION['user_id'])): ?>
        <!-- Formulář pro přidání komentáře, pokud je uživatel přihlášen -->
        <form method="POST" class="mb-4">
            <div class="mb-3">
                <textarea class="form-control" name="comment" placeholder="Váš komentář..." rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Přidat komentář</button>
        </form>
    <?php else: ?>
        <!-- Zpráva pro nepřihlášeného uživatele -->
        <p>Pro přidání komentáře se musíte <a href="../view/login_form.php">přihlásit</a>.</p>
    <?php endif; ?>

    <ul class="list-group mb-4">
        <?php foreach ($comments as $comment): ?>
            <li class="list-group-item">
                <strong><?= htmlspecialchars($comment['user_name']) ?>:</strong>
                <p class="mb-1"><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                <small class="text-muted"><?= htmlspecialchars($comment['created_at']) ?></small>

                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $comment['user_id']): ?>
                    <!-- Možnost smazání komentáře, pokud je uživatel jeho autorem -->
                    <form method="POST" class="d-inline float-end" onsubmit="return confirm('Opravdu smazat komentář?');">
                        <input type="hidden" name="delete_comment_id" value="<?= $comment['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger">🗑️ Smazat</button>
                    </form>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="home.php" class="btn btn-secondary">← Zpět na seznam</a>
</div>

<?php include '../partials/footer.php'; ?>
