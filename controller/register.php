<?php
session_start();
require_once '../database/connect_db.php';

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';

if (!$name || !$email || !$password) {
    $_SESSION['register_error'] = "Vyplň všechna pole.";
    header("Location: ../view/register_form.php");
    exit;
}
if ($password !== $password_confirm) {
    $_SESSION['register_error'] = "Hesla se neshodují.";
    header("Location: ../view/register_form.php");
    exit;
}
if (strlen($password) < 6) {
    $_SESSION['register_error'] = "Heslo musí mít alespoň 6 znaků.";
    header("Location: ../view/register_form.php");
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->execute([
        $name,
        $email,
        password_hash($password, PASSWORD_DEFAULT)
    ]);

    $_SESSION['user_id'] = $pdo->lastInsertId();
    $_SESSION['user'] = $name;

    header("Location: ../controller/home.php");
    exit;
} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        $_SESSION['register_error'] = "E-mail už existuje.";
    } else {
        $_SESSION['register_error'] = "Chyba při registraci: " . $e->getMessage();
    }
    header("Location: ../view/register_form.php");
    exit;
}
