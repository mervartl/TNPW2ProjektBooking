<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Přehled vlastních inzerátů</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include '../partials/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Vaše inzeráty</h2>

    <div class="alert alert-info">
        <strong>Počet vašich inzerátů:</strong> <?= count($userListings) ?> <!-- Zobrazení počtu inzerátů uživatele -->
    </div>

    <form method="POST"> <!-- Formulář pro smazání označených inzerátů -->
        <ul class="list-group mb-3">
            <?php foreach ($userListings as $listing): ?> <!-- Pro každý inzerát v poli $userListings -->
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="listing_ids[]" value="<?= $listing['id'] ?>" id="listing<?= $listing['id'] ?>"> <!-- Checkbox pro výběr inzerátu k odstranění -->
                        <label class="form-check-label" for="listing<?= $listing['id'] ?>">
                            <strong><?= htmlspecialchars($listing['title']) ?></strong><br>
                            <small><?= htmlspecialchars($listing['location']) ?> – <?= htmlspecialchars($listing['created_at']) ?></small> <!-- Místo a datum vytvoření inzerátu -->
                        </label>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <button type="submit" name="delete_listings" class="btn btn-danger" onclick="return confirm('Opravdu chcete smazat označené inzeráty?')">
            🗑️ Smazat označené inzeráty
        </button>
    </form>
</div>

<?php include '../partials/footer.php'; ?>
</body>
</html>
