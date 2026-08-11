<?php
require_once __DIR__ . '/db_config.php';

$id = intval($_GET['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare(
        "UPDATE rooms SET room_number=?, room_type=?, price=?, status=?, assigned_staff_id=?, assigned_staff_name=?
         WHERE room_id=?"
    );
    $stmt->execute([
        $_POST['room_number'],
        $_POST['room_type'],
        $_POST['price'],
        $_POST['status'],
        $_POST['assigned_staff_id'],
        $_POST['assigned_staff_name'],
        $id,
    ]);
    header('Location: read.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM rooms WHERE room_id = ?");
$stmt->execute([$id]);
$room = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$room) {
    die("Room not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Room - Hotel System</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h1>Edit Room #<?= htmlspecialchars($room['room_number']) ?></h1>
  <form method="POST" class="form-box">
    <label>Room Number</label>
    <input type="text" name="room_number" value="<?= htmlspecialchars($room['room_number']) ?>" required>

    <label>Room Type</label>
    <select name="room_type" required>
      <?php foreach (['Standard','Deluxe','Suite'] as $t): ?>
        <option value="<?= $t ?>" <?= $room['room_type'] === $t ? 'selected' : '' ?>><?= $t ?></option>
      <?php endforeach; ?>
    </select>

    <label>Price (₱)</label>
    <input type="number" step="0.01" name="price" value="<?= $room['price'] ?>" required>

    <label>Status</label>
    <select name="status" required>
      <?php foreach (['Available','Occupied','Maintenance'] as $s): ?>
        <option value="<?= $s ?>" <?= $room['status'] === $s ? 'selected' : '' ?>><?= $s ?></option>
      <?php endforeach; ?>
    </select>

    <!-- ============================================================
         DROPDOWN POPULATED FROM MICROSERVICE API (System 2, port 81)
         Pre-selects the room's currently assigned staff member
         ============================================================ -->
    <label>Assigned Staff <small>(loaded from Employee microservice)</small></label>
    <select name="assigned_staff_id" id="staffDropdown" required>
      <option value="<?= $room['assigned_staff_id'] ?>" selected><?= htmlspecialchars($room['assigned_staff_name']) ?></option>
    </select>
    <input type="hidden" name="assigned_staff_name" id="staffNameHidden" value="<?= htmlspecialchars($room['assigned_staff_name']) ?>">

    <button type="submit" class="btn">Update Room</button>
    <a href="read.php" class="btn secondary">Cancel</a>
  </form>
</div>

<script src="script.js"></script>
<script>
  // Populate dropdown, keeping the current staff pre-selected
  loadStaffDropdown('staffDropdown', 'staffNameHidden', <?= (int)$room['assigned_staff_id'] ?>);
</script>
</body>
</html>
