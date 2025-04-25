<?php
$isOwn = isset($_SESSION['user_id']) && $_SESSION['user_id'] === $offer['user_id'];
?>

<script src="../public/js/favourites.js" defer></script>

<div class="card mb-4 shadow-sm listing" data-id="<?= $offer['id'] ?>">
    <div class="row g-0">
        <div class="col-md-4">
            <a href="listing_detail.php?id=<?= $offer['id'] ?>">
                <img src="../<?= htmlspecialchars($offer['image_path']) ?>" class="img-fluid rounded-start" alt="Obrázek inzerátu" style="object-fit: cover; height: 100%;">
            </a>
        </div>
        <div class="col-md-8">
            <div class="card-body d-flex flex-column h-100">
                <a href="listing_detail.php?id=<?= $offer['id'] ?>" class="text-decoration-none text-dark flex-grow-1">
                    <h5 class="card-title"><?= htmlspecialchars($offer['title']) ?></h5>
                    <p class="card-text"><strong>Místo:</strong> <?= htmlspecialchars($offer['location']) ?></p>
                    <p class="card-text"><?= nl2br(htmlspecialchars($offer['description'])) ?></p>
                    <p class="card-text">
                        <small class="text-muted">Vložil: <?= htmlspecialchars($offer['user_name']) ?> dne <?= date('d.m.Y H:i', strtotime($offer['created_at'])) ?></small>
                    </p>
                </a>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <button
                        class="btn btn-outline-danger btn-sm fav-btn"
                        data-id="<?= $offer['id'] ?>">❤ Přidat do oblíbených</button>

                    <?php if ($isOwn): ?>
                        <div class="d-flex gap-2">
                            <form method="POST" action="../controller/delete_listing.php" class="m-0">
                                <input type="hidden" name="id" value="<?= $offer['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Opravdu smazat?')">🗑️ Smazat</button>
                            </form>
                            <a href="edit_listing.php?id=<?= $offer['id'] ?>" class="btn btn-secondary btn-sm">✏️ Upravit</a>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>