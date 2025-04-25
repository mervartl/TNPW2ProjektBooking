<?php
session_start();
require_once '../database/connect_db.php';
require_once '../model/listing.php';

// Ujistíme se, že je uživatel přihlášen
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$listingId = $_GET['id'] ?? null;
if (!$listingId) {
    $_SESSION['message'] = 'Neplatné ID inzerátu.';
    header('Location: ../controller/home.php');
    exit;
}

$listing = getListingById($pdo, $listingId);

// Ověříme, že inzerát patří přihlášenému uživateli
if (!$listing || $listing['user_id'] !== $_SESSION['user_id']) {
    $_SESSION['message'] = 'Nemáte oprávnění upravit tento inzerát.';
    header('Location: ../controller/home.php');
    exit;
}

// Zpracování POST požadavku
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $location = $_POST['location'] ?? '';
    $imagePath = $listing['image_path'];

    // Zpracování nového obrázku
    if (!empty($_FILES['image']['tmp_name'])) {
        $uploadDir = 'uploads/';
        $filename = basename($_FILES['image']['name']);
        $targetPath = $uploadDir . uniqid() . '_' . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], "../" . $targetPath)) {
            $imagePath = $targetPath;
        } else {
            $_SESSION['message'] = 'Nepodařilo se nahrát obrázek.';
        }
    }

    updateListing($pdo, $listingId, $title, $description, $location, $imagePath);

    $_SESSION['message'] = 'Inzerát byl úspěšně upraven.';
    header("Location: home.php");
    exit;
}

include '../view/edit_listing_form.php';
