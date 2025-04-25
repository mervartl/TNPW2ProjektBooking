<?php
$dbPath = __DIR__ . '/database/database.sqlite';

if (!file_exists(__DIR__ . '/database')) {
    mkdir(__DIR__ . '/database', 0777, true);
}

$pdo = new PDO("sqlite:$dbPath");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Smažeme tabulky, pokud existují
$pdo->exec("DROP TABLE IF EXISTS listings;");
$pdo->exec("DROP TABLE IF EXISTS users;");
$pdo->exec("DROP TABLE IF EXISTS comments;");

// Vytvoříme tabulky
$pdo->exec("
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL
);

CREATE TABLE listings (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    title TEXT NOT NULL,
    description TEXT,
    location TEXT NOT NULL,
    image_path TEXT,
    created_at TEXT,
    FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE comments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    listing_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (listing_id) REFERENCES listings(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

");

// Vložíme testovacího uživatele
$password = password_hash("heslo123", PASSWORD_DEFAULT);
$pdo->exec("INSERT INTO users (name, email, password) VALUES 
    ('Jan Novák', 'jan@email.cz', '$password');");

$password = password_hash("Heslo123", PASSWORD_DEFAULT);
$pdo->exec("INSERT INTO users (name, email, password) VALUES 
    ('Petr Svoboda', 'petr@email.cz', '$password');");

// Naplníme testovacími daty
$userId = $pdo->lastInsertId();

$stmt = $pdo->prepare("INSERT INTO listings (user_id, title, description, location, image_path, created_at) VALUES 
    (?, ?, ?, ?, ?, ?)");
$stmt->execute([1, 'Sedmdesátky', 'Šumperák', 'Jaroměř', 'uploads/sumperak.jpg', date('Y-m-d H:i:s')]);

$pdo->exec("INSERT INTO comments (listing_id, user_id, content) VALUES 
    (1, 2, 'Kdy je možné se ubytovat?');");

$listings = [
    ['Chalupa v Krkonoších', 'Ubytování s výhledem na Sněžku', 'Pec pod Sněžkou', 'uploads/cottage.jpeg'],
    ['Apartmán v Praze', 'Centrum města, 2+kk', 'Praha', 'uploads/apartment.jpg'],
    ['Chatka u jezera', 'Romantika u vody', 'Lipno', 'uploads/lakehouse.jpg'],
];

foreach ($listings as $o) {
    $stmt = $pdo->prepare("INSERT INTO listings (user_id, title, description, location, image_path, created_at)
                           VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$userId, $o[0], $o[1], $o[2], $o[3], date('Y-m-d H:i:s')]);
}
