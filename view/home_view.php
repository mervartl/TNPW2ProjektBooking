<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <title>Inzeráty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <script src="../public/js/favourites.js" defer></script>
    <?php include '../partials/header.php'; ?>

    <div class="container mt-4">

        <?php if (!empty($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['message']) ?>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <h1 class="mb-4">Vítej, <?= isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']) : 'návštěvníku' ?> 👋</h1>

        <form method="GET" action="home.php" class="mb-4 row g-3 align-items-center">
            <div class="col-sm-6 col-md-4">
                <input type="text" class="form-control" name="q" placeholder="Hledat inzeráty..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
            </div>
            <div class="col-auto">
                <?php if (isset($_SESSION['user'])): ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="showOwn" value="1" id="showOwn" <?= isset($showOwn) && $showOwn ? 'checked' : '' ?>>
                    <label class="form-check-label" for="showOwn">
                        Zobrazit pouze mé inzeráty
                    </label>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filtrovat</button>
            </div>
        </form>

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" id="show-favourites-only">
            <label class="form-check-label" for="show-favourites-only">
                Zobrazit pouze oblíbené
            </label>
        </div>

        <h2><?= $showOwn ? 'Moje inzeráty' : 'Všechny inzeráty' ?></h2>

        <?php if (empty($offers)): ?>
            <p class="text-muted">Žádné inzeráty k zobrazení.</p>
        <?php else: ?>
            <?php foreach ($offers as $offer): ?>
                <?php include '../view/components/listing_card.php'; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <nav class="mt-4">
            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">« Předchozí</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">Další »</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <?php include '../partials/footer.php'; ?>
</body>

</html>
