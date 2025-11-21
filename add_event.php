<?php
require_once __DIR__ . '/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/header.php';

// Allow  admins to access this page
if (!function_exists('is_admin') || !is_admin()) {
  $_SESSION['flash'] = 'Only admins can add events.';
  header('Location: /Event_M/');
  exit;
}
?>

<h2>Add Event</h2>

<form method="post" action="/Event_M/process_add_event.php">
  <label>Event Title</label>
  <input type="text" name="title" required>

  <label>Description</label>
  <textarea name="description" rows="4" placeholder="Enter event details..."></textarea>

  <label>Event Date</label>
  <input type="date" name="event_date" required>

  <div class="time-group">
    <label>Event Time</label>
    <div class="time-inputs">
      <input type="time" name="event_time" required>
      <select name="time_period" required>
        <option value="AM">AM</option>
        <option value="PM">PM</option>
      </select>
    </div>
  </div>

  <label>Location/Place</label>
  <input type="text" name="location" required placeholder="Enter event location...">
<!-- 
  <label>Maximum Participants</label>
  <input type="number" name="max_participants" required value="" min="1"> -->

  <button type="submit">Add Event</button>
</form>

<style>
form {
  max-width: 600px;
  margin: 20px auto;
}
label {
  display: block;
  margin-top: 15px;
  font-weight: bold;
}
input[type="text"],
input[type="date"],
input[type="time"],
textarea {
  width: 100%;
  padding: 8px;
  margin-top: 5px;
  border: 1px solid #ddd;
  border-radius: 4px;
}
.time-group {
  margin-top: 15px;
}
.time-inputs {
  display: flex;
  gap: 10px;
  align-items: center;
  margin-top: 5px;
}
.time-inputs input[type="time"] {
  flex: 2;
}
.time-inputs select {
  flex: 1;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 4px;
  background: white;
}
textarea {
  resize: vertical;
  min-height: 100px;
}
button {
  display: block;
  width: 100%;
  padding: 10px;
  margin-top: 20px;
  background: #27ae60;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
button:hover {
  background: #219a52;
}
</style>

<?php require_once __DIR__ . '/footer.php'; ?>
