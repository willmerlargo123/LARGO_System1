<?php
require_once __DIR__ . '/db_config.php';

$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM rooms WHERE room_id = ?");
    $stmt->execute([$id]);
}

header('Location: read.php');
exit;
