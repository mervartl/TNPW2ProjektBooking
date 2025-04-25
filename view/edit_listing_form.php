<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <title>Úprava inzerátu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include '../partials/header.php'; ?>

    <div class="container mt-5">
        <h1 class="mb-4">Úprava inzerátu</h1>
        <form action="../controller/edit_listing.php?id=<?= $listing['id'] ?>" method="post" enctype="multipart/form-data">
            <!-- Úprava nadpisu inzerátu -->
            <div class="mb-3">
                <label for="title" class="form-label">Nadpis:</label>
                <input type="text" class="form-control" name="title" id="title" required value="<?= htmlspecialchars($listing['title']) ?>">
            </div>

            <!-- Úprava popisu inzerátu -->
            <div class="mb-3">
                <label for="description" class="form-label">Popis:</label>
                <textarea class="form-control" name="description" id="description" rows="5" required><?= htmlspecialchars($listing['description']) ?></textarea>
            </div>

            <!-- Úprava místa inzerátu -->
            <div class="mb-3">
                <label for="location" class="form-label">Místo:</label>
                <input type="text" class="form-control" name="location" id="location" required value="<?= htmlspecialchars($listing['location']) ?>">
            </div>

            <!-- Možnost nahrát nový obrázek, pokud uživatel chce změnit aktuální obrázek -->
            <div class="mb-3">
                <label for="image" class="form-label">Obrázek (ponech prázdné pro zachování):</label>              
                <input class="form-control" type="file" name="image" id="image">
            </div>

            <div class="mb-3">
                <label class="form-label">Aktuální obrázek:</label><br>
                <img src="../<?= htmlspecialchars($listing['image_path']) ?>" alt="Aktuální obrázek" class="img-fluid rounded" style="max-width: 200px;">
            </div>

            <button type="submit" class="btn btn-primary">Uložit změny</button>
        </form>
    </div>

    <?php include '../partials/footer.php'; ?>
</body>

</html>
