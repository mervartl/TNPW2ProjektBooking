<?php
// Přidání inzerátu
function createListing($pdo, $user_id, $title, $description, $location, $image_path) {
    $stmt = $pdo->prepare("INSERT INTO offers (user_id, title, description, location, image_path, created_at) 
                           VALUES (?, ?, ?, ?, ?, datetime('now'))");
    return $stmt->execute([$user_id, $title, $description, $location, $image_path]);
}

function deleteOffer($pdo, $offerId) {
    $stmt = $pdo->prepare("DELETE FROM offers WHERE id = ?");
    return $stmt->execute([$offerId]);
}

// Získání jednoho inzerátu
function getOfferById($pdo, $offerId) {
    $stmt = $pdo->prepare("SELECT o.*, u.name AS user_name FROM offers o JOIN users u ON o.user_id = u.id WHERE o.id = ?");
    $stmt->execute([$offerId]);
    return $stmt->fetch();
}


// Úprava inzerátu
function updateOffer($pdo, $offerId, $title, $description, $location, $imagePath = null) {
    if ($imagePath) {
        $stmt = $pdo->prepare("UPDATE offers SET title = ?, description = ?, location = ?, image_path = ? WHERE id = ?");
        return $stmt->execute([$title, $description, $location, $imagePath, $offerId]);
    } else {
        $stmt = $pdo->prepare("UPDATE offers SET title = ?, description = ?, location = ? WHERE id = ?");
        return $stmt->execute([$title, $description, $location, $offerId]);
    }
}

// Vyhledávání všech inzerátů (bez stránkování)
function searchAllOffers($pdo, $query = '') {
    if ($query) {
        $stmt = $pdo->prepare("SELECT o.*, u.name AS user_name FROM offers o JOIN users u ON o.user_id = u.id 
                               WHERE title LIKE ? OR description LIKE ? ORDER BY created_at DESC");
        $q = '%' . $query . '%';
        $stmt->execute([$q, $q]);
    } else {
        $stmt = $pdo->query("SELECT o.*, u.name AS user_name FROM offers o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC");
    }
    return $stmt->fetchAll();
}

// Vyhledávání vlastních inzerátů (bez stránkování)
function searchUserOffers($pdo, $user_id, $query = '') {
    if ($query) {
        $stmt = $pdo->prepare("SELECT o.*, u.name AS user_name FROM offers o JOIN users u ON o.user_id = u.id 
                               WHERE o.user_id = ? AND (title LIKE ? OR description LIKE ?) ORDER BY o.created_at DESC");
        $q = '%' . $query . '%';
        $stmt->execute([$user_id, $q, $q]);
    } else {
        $stmt = $pdo->prepare("SELECT o.*, u.name AS user_name FROM offers o JOIN users u ON o.user_id = u.id 
                               WHERE o.user_id = ? ORDER BY o.created_at DESC");
        $stmt->execute([$user_id]);
    }
    return $stmt->fetchAll();
}

// --- Nově přidáno: stránkované načítání všech inzerátů
function searchAllOffersPaged($pdo, $query, $limit, $offset) {
    $q = '%' . $query . '%';
    $stmt = $pdo->prepare("SELECT o.*, u.name AS user_name FROM offers o JOIN users u ON o.user_id = u.id 
                           WHERE title LIKE ? OR description LIKE ? 
                           ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->execute([$q, $q, $limit, $offset]);
    return $stmt->fetchAll();
}

function countAllOffers($pdo, $query) {
    $q = '%' . $query . '%';
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM offers WHERE title LIKE ? OR description LIKE ?");
    $stmt->execute([$q, $q]);
    return $stmt->fetchColumn();
}

// --- Nově přidáno: stránkované načítání vlastních inzerátů
function searchUserOffersPaged($pdo, $user_id, $query, $limit, $offset) {
    $q = '%' . $query . '%';
    $stmt = $pdo->prepare("SELECT o.*, u.name AS user_name FROM offers o JOIN users u ON o.user_id = u.id 
                           WHERE o.user_id = ? AND (title LIKE ? OR description LIKE ?) 
                           ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->execute([$user_id, $q, $q, $limit, $offset]);
    return $stmt->fetchAll();
}

function countUserOffers($pdo, $user_id, $query) {
    $q = '%' . $query . '%';
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM offers WHERE user_id = ? AND (title LIKE ? OR description LIKE ?)");
    $stmt->execute([$user_id, $q, $q]);
    return $stmt->fetchColumn();
}
