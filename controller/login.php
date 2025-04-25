<?php
session_start();
require_once '../database/connect_db.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Pokud není vyplněn e-mail nebo heslo, skript se ukončí
if (!$email || !$password) {
    $_SESSION['login_error'] = "Vyplň všechna pole.";
    exit;
}

// Příprava a spuštění SQL dotazu na získání uživatele podle e-mailu
$stmt = $pdo->prepare("SELECT id, name, password FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

// Ověření, zda heslo odpovídá (pomocí funkce password_verify pro porovnání hashe)
if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user'] = $user['name'];
    header("Location: ../controller/home.php");
    exit;
} else {
    $_SESSION['login_error'] = "Neplatný e-mail nebo heslo.";
    header("Location: ../view/login_form.php");
    exit;
}
?>
