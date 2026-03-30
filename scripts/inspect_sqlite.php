<?php

$db = new PDO('sqlite:' . __DIR__ . '/../database/database.sqlite');

echo "[tables]\n";
foreach ($db->query("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name") as $row) {
    echo $row[0], PHP_EOL;
}

echo "\n[users]\n";
try {
    foreach ($db->query("SELECT id, name, email, role FROM users") as $row) {
        echo json_encode($row), PHP_EOL;
    }
} catch (Throwable $e) {
    echo $e->getMessage(), PHP_EOL;
}
