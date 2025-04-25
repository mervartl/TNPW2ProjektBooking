<?php
session_start();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Přihlášení</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include '../partials/header.php'; ?>

<div class="container mt-5">
    <div class="card mx-auto p-4 shadow" style="max-width: 400px;">
        <h2 class="text-center mb-4">Přihlášení</h2>

        <?php if (!empty($_SESSION['login_error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['login_error']) ?></div>
            <?php unset($_SESSION['login_error']); ?>
        <?php endif; ?>

        <form action="../controller/login.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Heslo:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Přihlásit se</button>
        </form>

        <p class="mt-3 text-center">Nemáš účet? <a href="register_form.php">Registruj se</a></p>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
</body>
</html>
