<?php
require_once __DIR__ . '/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare(
        "INSERT INTO rooms (room_number, room_type, price, status, assigned_staff_id, assigned_staff_name)
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    $stmt->execute([
        $_POST['room_number'],
        $_POST['room_type'],
        $_POST['price'],
        $_POST['status'],
        $_POST['assigned_staff_id'],
        $_POST['assigned_staff_name'],
    ]);
    header('Location: read.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Room - Hotel System</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h1>Add New Room</h1>
  <form method="POST" class="form-box">
    <label>Room Number</label>
    <input type="text" name="room_number" required>

    <label>Room Type</label>
    <select name="room_type" required>
      <option value="Standard">Standard</option>
      <option value="Deluxe">Deluxe</option>
      <option value="Suite">Suite</option>
    </select>

    <label>Price (₱)</label>
    <input type="number" step="0.01" name="price" required>

    <label>Status</label>
    <select name="status" required>
      <option value="Available">Available</option>
      <option value="Occupied">Occupied</option>
      <option value="Maintenance">Maintenance</option>
    </select>

    <!-- ============================================================
         DROPDOWN POPULATED FROM MICROSERVICE API (System 2, port 81)
         Populated dynamically by script.js via fetch()
         ============================================================ -->
    <label>Assigned Staff <small>(loaded from Employee microservice)</small></label>
    <select name="assigned_staff_id" id="staffDropdown" required>
      <option value="">Loading employees...</option>
    </select>
    <input type="hidden" name="assigned_staff_name" id="staffNameHidden">

    <button type="submit" class="btn">Save Room</button>
    <a href="read.php" class="btn secondary">Cancel</a>
  </form>
</div>

<script src="script.js"></script>
<script>
  // Populate the dropdown on page load
  loadStaffDropdown('staffDropdown', 'staffNameHidden');
</script>
</body>
</html>
