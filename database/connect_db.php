<?php
$pdo = new PDO("sqlite:" . __DIR__ . "/../database/database/database.sqlite");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
