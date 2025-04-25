<?php
session_start();
require_once '../database/connect_db.php';
require_once '../model/listing.php';
require_once '../model/comment.php';

$listingId = $_GET['id'] ?? null;
if (!$listingId) {
    header("Location: home.php");
    exit;
}

$listing = getListingById($pdo, $listingId);
$comments = getCommentsForListing($pdo, $listingId);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    if (isset($_POST['comment'])) {
        // Přidání nového komentáře
        $content = trim($_POST['comment']);
        if ($content) {
            addComment($pdo, $listingId, $_SESSION['user_id'], $content);
        }
    } elseif (isset($_POST['delete_comment_id'])) {
        // Mazání komentáře
        $commentId = (int)$_POST['delete_comment_id'];
        deleteComment($pdo, $commentId, $_SESSION['user_id']);
    }

    // Obnovení stránky (bez opakovaného odeslání formuláře)
    header("Location: listing_detail.php?id=$listingId");
    exit;
}


include '../view/listing_detail_view.php';
