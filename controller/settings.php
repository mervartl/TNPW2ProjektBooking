<?php
session_start();

require_once '../database/connect_db.php';
require_once '../model/user.php';

// Pokud není uživatel přihlášen, přesměruj ho na přihlašovací stránku
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aktualizace e-mailu
    if (isset($_POST['update_email'])) {
        if (updateEmail($pdo, $_SESSION['user_id'], $_POST['email'])) {
            $success = 'E-mail byl aktualizován.';
        } else {
            $error = 'Nepodařilo se aktualizovat e-mail.';
        }
    // Aktualizace hesla
    } elseif (isset($_POST['update_password'])) {
        if ($_POST['password'] === $_POST['password_confirm']) {
            if (updatePassword($pdo, $_SESSION['user_id'], $_POST['password'])) {
                $success = 'Heslo bylo změněno.';
            } else {
                $error = 'Nepodařilo se změnit heslo.';
            }
        } else {
            $error = 'Hesla se neshodují.';
        }
    // Smazání účtu
    } elseif (isset($_POST['delete_account'])) {
        deleteUser($pdo, $_SESSION['user_id']);
        session_destroy();
        header('Location: ../index.php');
        exit;
    }
}

$user = getUserById($pdo, $_SESSION['user_id']);
include '../view/settings_view.php';
