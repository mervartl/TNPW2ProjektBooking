<?php include '../partials/header.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h2 class="mb-4">Nastavení účtu</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Změna emailu -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Změnit e-mail</h5>
        </div>
        <div class="card-body">
            <form method="POST">
                <p>Současný email: <strong><?= htmlspecialchars($user['email'])?></strong></p>
                <div class="mb-3">
                    <label for="email" class="form-label">Nový e-mail</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <button type="submit" name="update_email" class="btn btn-primary">Aktualizovat e-mail</button>
            </form>
        </div>
    </div>

    <!-- Změna hesla -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Změnit heslo</h5>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label for="password" class="form-label">Nové heslo</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirm" class="form-label">Potvrď heslo</label>
                    <input type="password" id="password_confirm" name="password_confirm" class="form-control" required>
                </div>
                <button type="submit" name="update_password" class="btn btn-warning">Změnit heslo</button>
            </form>
        </div>
    </div>

    <!-- Smazání účtu -->
    <div class="card border-danger">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0">Smazat účet</h5>
        </div>
        <div class="card-body">
            <form method="POST" onsubmit="return confirm('Opravdu chcete smazat účet? Tuto akci nelze vrátit.')">
                <button type="submit" name="delete_account" class="btn btn-danger">Smazat účet</button>
            </form>
        </div>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
