<?php
// Přidání inzerátu
function createListing($pdo, $user_id, $title, $description, $location, $image_path) {
    $stmt = $pdo->prepare("INSERT INTO listings (user_id, title, description, location, image_path, created_at) 
                           VALUES (?, ?, ?, ?, ?, datetime('now'))");
    return $stmt->execute([$user_id, $title, $description, $location, $image_path]);
}

function deleteListing($pdo, $listingId) {
    $stmt = $pdo->prepare("DELETE FROM listings WHERE id = ?");
    return $stmt->execute([$listingId]);
}

// Získání jednoho inzerátu
function getListingById($pdo, $listingId) {
    $stmt = $pdo->prepare("SELECT o.*, u.name AS user_name FROM listings o JOIN users u ON o.user_id = u.id WHERE o.id = ?");
    $stmt->execute([$listingId]);
    return $stmt->fetch();
}


// Úprava inzerátu
function updateListing($pdo, $listingId, $title, $description, $location, $imagePath = null) {
    if ($imagePath) {
        $stmt = $pdo->prepare("UPDATE listings
 SET title = ?, description = ?, location = ?, image_path = ? WHERE id = ?");
        return $stmt->execute([$title, $description, $location, $imagePath, $listingId]);
    } else {
        $stmt = $pdo->prepare("UPDATE listings
 SET title = ?, description = ?, location = ? WHERE id = ?");
        return $stmt->execute([$title, $description, $location, $listingId]);
    }
}

// Vyhledávání všech inzerátů (bez stránkování)
function searchAllListing($pdo, $query = '') {
    if ($query) {
        $stmt = $pdo->prepare("SELECT o.*, u.name AS user_name FROM listings
 o JOIN users u ON o.user_id = u.id 
                               WHERE title LIKE ? OR description LIKE ? ORDER BY created_at DESC");
        $q = '%' . $query . '%';
        $stmt->execute([$q, $q]);
    } else {
        $stmt = $pdo->query("SELECT o.*, u.name AS user_name FROM listings
 o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC");
    }
    return $stmt->fetchAll();
}

// Vyhledávání vlastních inzerátů (bez stránkování)
function searchUserListings($pdo, $user_id, $query = '') {
    if ($query) {
        $stmt = $pdo->prepare("SELECT o.*, u.name AS user_name FROM listings
 o JOIN users u ON o.user_id = u.id 
                               WHERE o.user_id = ? AND (title LIKE ? OR description LIKE ?) ORDER BY o.created_at DESC");
        $q = '%' . $query . '%';
        $stmt->execute([$user_id, $q, $q]);
    } else {
        $stmt = $pdo->prepare("SELECT o.*, u.name AS user_name FROM listings
 o JOIN users u ON o.user_id = u.id 
                               WHERE o.user_id = ? ORDER BY o.created_at DESC");
        $stmt->execute([$user_id]);
    }
    return $stmt->fetchAll();
}

// Stránkované načítání všech inzerátů
function searchAllListingsPaged($pdo, $query, $limit, $offset) {
    $q = '%' . $query . '%';
    $stmt = $pdo->prepare("SELECT o.*, u.name AS user_name FROM listings o JOIN users u ON o.user_id = u.id 
                           WHERE title LIKE ? OR description LIKE ? 
                           ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->execute([$q, $q, $limit, $offset]);
    return $stmt->fetchAll();
}

function countAllListings($pdo, $query) {
    $q = '%' . $query . '%';
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM listings WHERE title LIKE ? OR description LIKE ?");
    $stmt->execute([$q, $q]);
    return $stmt->fetchColumn();
}

// Stránkované načítání vlastních inzerátů
function searchUserListingsPaged($pdo, $user_id, $query, $limit, $offset) {
    $q = '%' . $query . '%';
    $stmt = $pdo->prepare("SELECT o.*, u.name AS user_name FROM listings o JOIN users u ON o.user_id = u.id 
                           WHERE o.user_id = ? AND (title LIKE ? OR description LIKE ?) 
                           ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->execute([$user_id, $q, $q, $limit, $offset]);
    return $stmt->fetchAll();
}

function countUserlistings($pdo, $user_id, $query) {
    $q = '%' . $query . '%';
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM listings WHERE user_id = ? AND (title LIKE ? OR description LIKE ?)");
    $stmt->execute([$user_id, $q, $q]);
    return $stmt->fetchColumn();
}
