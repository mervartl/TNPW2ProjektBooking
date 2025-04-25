<?php
function addComment($pdo, $offerId, $userId, $content) {
    $stmt = $pdo->prepare("INSERT INTO comments (offer_id, user_id, content) VALUES (?, ?, ?)");
    return $stmt->execute([$offerId, $userId, $content]);
}

function getCommentsForOffer($pdo, $offerId) {
    $stmt = $pdo->prepare("SELECT c.*, u.name AS user_name FROM comments c JOIN users u ON c.user_id = u.id WHERE offer_id = ? ORDER BY created_at DESC");
    $stmt->execute([$offerId]);
    return $stmt->fetchAll();
}

function deleteComment($pdo, $commentId, $userId) {
    $stmt = $pdo->prepare("DELETE FROM comments WHERE id = ? AND user_id = ?");
    return $stmt->execute([$commentId, $userId]);
}
