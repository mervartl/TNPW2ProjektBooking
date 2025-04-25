<?php
session_start();
if (!isset($_SESSION['user_id'])) { // Kontrola, zda je uživatel přihlášen
    header("Location: login_form.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Přidat inzerát</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include '../partials/header.php'; ?>

<div class="container mt-4">
    <h1 class="mb-4">Přidat nový inzerát</h1>

    <?php if (!empty($_SESSION['add_error'])): ?> <!-- Zobrazení chybové hlášky, pokud je k dispozici -->
        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['add_error']) ?>
        </div>
        <?php unset($_SESSION['add_error']); ?>
    <?php endif; ?>

    <form action="../controller/add_listing.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="title" class="form-label">Nadpis</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Popis</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Lokalita</label>
            <input type="text" class="form-control" id="location" name="location" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Obrázek</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-primary">Přidat</button>
    </form>
</div>

<?php include '../partials/footer.php'; ?>
</body>
</html>
