<?php
$isOwn = isset($_SESSION['user_id']) && $_SESSION['user_id'] === $listing['user_id'];
?>

<div class="card mb-4 shadow-sm listing" data-id="<?= $listing['id'] ?>">
    <div class="row g-0">
        <!-- Sloupec pro obrázek nabídky -->
        <div class="col-md-4">
            <a href="listing_detail.php?id=<?= $listing['id'] ?>">
                <img src="../<?= htmlspecialchars($listing['image_path']) ?>" class="img-fluid rounded-start" alt="Obrázek inzerátu" style="object-fit: cover; height: 100%;">
            </a>
        </div>
        <!-- Sloupec pro textovou část nabídky -->
        <div class="col-md-8">
            <div class="card-body d-flex flex-column h-100">
                <a href="listing_detail.php?id=<?= $listing['id'] ?>" class="text-decoration-none text-dark flex-grow-1">
                    <h5 class="card-title"><?= htmlspecialchars($listing['title']) ?></h5>
                    <p class="card-text"><strong>Místo:</strong> <?= htmlspecialchars($listing['location']) ?></p>
                    <p class="card-text"><?= nl2br(htmlspecialchars($listing['description'])) ?></p>
                    <p class="card-text">
                        <small class="text-muted">Vložil: <?= htmlspecialchars($listing['user_name']) ?> dne <?= date('d.m.Y H:i', strtotime($listing['created_at'])) ?></small>
                    </p>
                </a>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <!-- Tlačítko pro přidání do oblíbených -->
                    <button class="btn btn-outline-danger btn-sm fav-btn" data-id="<?= $listing['id'] ?>">❤ Přidat do oblíbených</button>

                    <?php if ($isOwn): ?>
                        <!-- Zobrazí se pouze pro vlastníka nabídky -->
                        <div class="d-flex gap-2">
                            <form method="POST" action="../controller/delete_listing.php" class="m-0">
                                <input type="hidden" name="id" value="<?= $listing['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Opravdu smazat?')">🗑️ Smazat</button>
                            </form>
                            <!-- Odkaz na úpravu nabídky -->
                            <a href="edit_listing.php?id=<?= $listing['id'] ?>" class="btn btn-secondary btn-sm">✏️ Upravit</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
