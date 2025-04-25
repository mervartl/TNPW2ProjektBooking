<?php
session_start();

require_once '../database/connect_db.php';
require_once '../model/listing.php';

// Získání parametrů z URL
$showOwn = isset($_GET['showOwn']) ? (bool)$_GET['showOwn'] : false;
$query = $_GET['q'] ?? '';

$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
$itemsPerPage = 4; // Počet inzerátů na stránku
$offset = ($page - 1) * $itemsPerPage;

// Načtení inzerátů podle filtru + stránkování
if ($showOwn && isset($_SESSION['user_id'])) {
    $offers = searchUserOffersPaged($pdo, $_SESSION['user_id'], $query, $itemsPerPage, $offset);
    $totalOffers = countUserOffers($pdo, $_SESSION['user_id'], $query);
} else {
    $offers = searchAllOffersPaged($pdo, $query, $itemsPerPage, $offset);
    $totalOffers = countAllOffers($pdo, $query);
}

$totalPages = ceil($totalOffers / $itemsPerPage);

// Načtení view
include '../view/home_view.php';

?>
