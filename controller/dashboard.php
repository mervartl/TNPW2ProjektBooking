<?php
session_start();

require_once '../database/connect_db.php';
require_once '../model/listing.php';

// Zkontrolujeme, zda je uživatel přihlášen
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$userName = $_SESSION['user_name'] ?? '';

// Načítání všech inzerátů uživatele
$userListings = searchUserListings($pdo, $userId);

// Pokud byla odeslána žádost o smazání inzerátů
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_listings'])) {
    if (isset($_POST['listing_ids'])) {
        foreach ($_POST['listing_ids'] as $listingrId) {
            deleteListing($pdo, $listingId);
        }
    }
    header('Location: dashboard.php');
    exit;
}

// Předáme data do view
include '../view/dashboard_view.php';
