<?php
// Přidání komentáře k inzerátu
function addComment($pdo, $listingId, $userId, $content) {
    $stmt = $pdo->prepare("INSERT INTO comments (listing_id, user_id, content) VALUES (?, ?, ?)");
    return $stmt->execute([$listingId, $userId, $content]);
}

// Získání všech komentářů k inzerátu
function getCommentsForlisting($pdo, $listingId) {
    $stmt = $pdo->prepare("SELECT c.*, u.name AS user_name FROM comments c JOIN users u ON c.user_id = u.id WHERE listing_id = ? ORDER BY created_at DESC");
    $stmt->execute([$listingId]);
    return $stmt->fetchAll();
}

// Odstranění komentáře podle ID
function deleteComment($pdo, $commentId, $userId) {
    $stmt = $pdo->prepare("DELETE FROM comments WHERE id = ? AND user_id = ?");
    return $stmt->execute([$commentId, $userId]);
}
