<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Přehled vlastních inzerátů</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<?php include '../partials/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Vaše inzeráty</h2>

    <div class="alert alert-info">
        <strong>Počet vašich inzerátů:</strong> <?= count($userOffers) ?>
    </div>

    <form method="POST">
        <ul class="list-group mb-3">
            <?php foreach ($userOffers as $offer): ?>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="offer_ids[]" value="<?= $offer['id'] ?>" id="offer<?= $offer['id'] ?>">
                        <label class="form-check-label" for="offer<?= $offer['id'] ?>">
                            <strong><?= htmlspecialchars($offer['title']) ?></strong><br>
                            <small><?= htmlspecialchars($offer['location']) ?> – <?= htmlspecialchars($offer['created_at']) ?></small>
                        </label>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <button type="submit" name="delete_offers" class="btn btn-danger" onclick="return confirm('Opravdu chcete smazat označené inzeráty?')">
            🗑️ Smazat označené inzeráty
        </button>
    </form>
</div>

<?php include '../partials/footer.php'; ?>
