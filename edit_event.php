<?php
require_once __DIR__ . '/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// Allow only admin
if (empty($_SESSION['user_id']) || !is_admin()) {
    $_SESSION['flash'] = 'Only admins can edit events.';
    header('Location: /Event_M/');
    exit;
}

// Get event ID
$event_id = $_GET['id'] ?? 0;
$event_id = intval($event_id);
if (!$event_id) {
    $_SESSION['flash'] = 'Invalid event ID.';
    header('Location: /Event_M/admin.php');
    exit;
}

// Fetch event
$stmt = $mysqli->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param('i', $event_id);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$event) {
    $_SESSION['flash'] = 'Event not found.';
    header('Location: /Event_M/admin.php');
    exit;
}

include __DIR__ . '/header.php';
?>

<h2>Edit Event</h2>

<form action="/Event_M/process_edit_event.php" method="post">
  <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">

  <label>Title:</label>
  <input type="text" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required>

  <label>Description:</label>
  <textarea name="description" required><?php echo htmlspecialchars($event['description']); ?></textarea>

  <label>Event Date:</label>
  <input type="date" name="event_date" value="<?php echo date('Y-m-d', strtotime($event['event_datetime'])); ?>" required>

  <div class="time-group">
    <label>Event Time:</label>
    <div class="time-inputs">
      <?php 
      $hour = intval(date('g', strtotime($event['event_datetime'])));
      $minute = date('i', strtotime($event['event_datetime']));
      $period = date('A', strtotime($event['event_datetime']));
      ?>
      <input type="time" name="event_time" value="<?php echo sprintf('%02d:%02d', $hour, intval($minute)); ?>" required>
      <select name="time_period">
        <option value="AM" <?php echo $period === 'AM' ? 'selected' : ''; ?>>AM</option>
        <option value="PM" <?php echo $period === 'PM' ? 'selected' : ''; ?>>PM</option>
      </select>
    </div>
  </div>

  <label>Location:</label>
  <input type="text" name="location" value="<?php echo htmlspecialchars($event['location']); ?>" required>

  <button type="submit">Update Event</button>
  <a href="/Event_M/admin.php" class="btn-cancel">Cancel</a>
</form>

<style>
form {
  background: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
  max-width: 600px;
  margin: 20px auto;
}
label {
  display: block;
  margin-top: 10px;
  font-weight: 500;
}
input, textarea {
  width: 100%;
  padding: 8px;
  margin-top: 4px;
  border: 1px solid #ccc;
  border-radius: 6px;
}
.time-group {
  margin-top: 10px;
}
.time-inputs {
  display: flex;
  gap: 10px;
  align-items: center;
  margin-top: 4px;
}
.time-inputs input[type="time"] {
  flex: 2;
}
.time-inputs select {
  flex: 1;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 6px;
  background: white;
}
textarea { resize: vertical; height: 100px; }
button, .btn-cancel {
  margin-top: 15px;
  padding: 10px 16px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  text-decoration: none;
  color: #fff;
}
button { background: #1abc9c; }
button:hover { background: #16a085; }
.btn-cancel { background: #777; margin-left: 10px; }
.btn-cancel:hover { background: #555; }
</style>

<?php include __DIR__ . '/footer.php'; ?>
