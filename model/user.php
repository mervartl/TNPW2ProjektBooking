<?php

// Změnit email
function updateEmail($pdo, $userId, $newEmail) {
    $stmt = $pdo->prepare("UPDATE users SET email = ? WHERE id = ?");
    return $stmt->execute([$newEmail, $userId]);
}

// Změnit heslo
function updatePassword($pdo, $userId, $newPassword) {
    $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    return $stmt->execute([$hashed, $userId]);
}

// Odstranit uživatele
function deleteUser($pdo, $userId) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    return $stmt->execute([$userId]);
}

// Získát uživatele podle ID
function getUserById($pdo, $userId) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetch();
}
