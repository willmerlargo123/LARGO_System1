<?php
require_once __DIR__ . '/db_config.php';

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    header('Location: delete.php?id=' . intval($_GET['id']));
    exit;
}

$stmt = $pdo->query("SELECT * FROM rooms ORDER BY room_id DESC");
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Hotel System - Rooms</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h1>🏨 Hotel Room Management</h1>
  <a class="btn" href="create.php">+ Add New Room</a>

  <table>
    <tr>
      <th>Room #</th><th>Type</th><th>Price</th><th>Status</th>
      <th>Assigned Staff</th><th>Actions</th>
    </tr>
    <?php foreach ($rooms as $r): ?>
    <tr>
      <td><?= htmlspecialchars($r['room_number']) ?></td>
      <td><?= htmlspecialchars($r['room_type']) ?></td>
      <td>₱<?= number_format($r['price'], 2) ?></td>
      <td><span class="badge <?= strtolower($r['status']) ?>"><?= $r['status'] ?></span></td>
      <td><?= htmlspecialchars($r['assigned_staff_name']) ?></td>
      <td>
        <a href="update.php?id=<?= $r['room_id'] ?>">Edit</a> |
        <a href="delete.php?id=<?= $r['room_id'] ?>" onclick="return confirm('Delete this room?');">Delete</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
</div>
</body>
</html>
