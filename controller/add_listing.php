<?php
session_start();
require_once '../database/connect_db.php';
require_once '../model/listing.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../view/login_form.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $location = trim($_POST['location']);
    $user_id = $_SESSION['user_id'];

    // Zpracování obrázku
    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $imageName = basename($_FILES['image']['name']);
    $imagePath = $uploadDir . time() . "_" . $imageName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
        $relativeImagePath = str_replace('../', '', $imagePath); // ukládáme relativní cestu
        if (createListing($pdo, $user_id, $title, $description, $location, $relativeImagePath)) {
            header("Location: ../controller/home.php");
            exit;
        } else {
            $_SESSION['add_error'] = "Nepodařilo se uložit inzerát.";
        }
    } else {
        $_SESSION['add_error'] = "Nepodařilo se nahrát obrázek.";
    }

    header("Location: ../view/add_listing_form.php");
    exit;
}
