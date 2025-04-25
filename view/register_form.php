<?php
session_start();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Registrace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include '../partials/header.php'; ?>

<div class="container mt-5">
    <div class="card mx-auto p-4 shadow" style="max-width: 500px;">
        <h2 class="text-center mb-4">Registrace</h2>

        <?php if (!empty($_SESSION['register_error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['register_error']) ?></div>
            <?php unset($_SESSION['register_error']); ?>
        <?php endif; ?>

        <form action="../controller/register.php" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Jméno:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Heslo:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password_confirm" class="form-label">Potvrzení hesla:</label>
                <input type="password" name="password_confirm" id="password_confirm" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-secondary w-100">Registrovat</button>
        </form>

        <p class="mt-3 text-center">Už máš účet? <a href="login_form.php">Přihlas se</a></p>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
</body>
</html>
