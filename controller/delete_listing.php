<?php
session_start();
require_once '../database/connect_db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Zkontroluj, že inzerát patří přihlášenému uživateli
    $stmt = $pdo->prepare("SELECT * FROM offers WHERE id = ?");
    $stmt->execute([$id]);
    $offer = $stmt->fetch();

    if ($offer && $offer['user_id'] == $_SESSION['user_id']) {
        $stmt = $pdo->prepare("DELETE FROM offers WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['message'] = "Inzerát byl úspěšně smazán.";
    } else {
        $_SESSION['message'] = "Nelze smazat tento inzerát.";
    }
}

header('Location: home.php');
exit;
