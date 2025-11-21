<?php
require_once __DIR__ . '/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// Allow only logged-in admins
if (empty($_SESSION['user_id']) || !is_admin()) {
  $_SESSION['flash'] = 'Only admins can update events.';
  header('Location: /Event_M/');
  exit;
}

// Get and check form data
$event_id = intval($_POST['event_id'] ?? 0);
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$event_date = $_POST['event_date'] ?? '';
$event_time = $_POST['event_time'] ?? '';
$time_period = $_POST['time_period'] ?? 'AM';
$location = trim($_POST['location'] ?? '');

// Validate
if (!$event_id || $title === '' || $description === '' || $event_date === '' || $event_time === '' || $location === '') {
  $_SESSION['flash'] = 'Please fill in all fields correctly.';
  header("Location: /Event_M/edit_event.php?id=$event_id");
  exit;
}


list($hours, $minutes) = explode(':', $event_time);
$hours = intval($hours);
if ($time_period === 'PM' && $hours !== 12) {
  $hours += 12;
} elseif ($time_period === 'AM' && $hours === 12) {
  $hours = 0;
}
$event_time = sprintf('%02d:%02d:00', $hours, $minutes);

// Combine date and time
$event_datetime = $event_date . ' ' . $event_time;

// Update event
$stmt = $mysqli->prepare("UPDATE events SET title=?, description=?, event_datetime=?, location=? WHERE id=?");
$stmt->bind_param('ssssi', $title, $description, $event_datetime, $location, $event_id);

if ($stmt->execute()) {
  $_SESSION['flash'] = 'Event updated successfully.';
  header('Location: /Event_M/admin.php');
} else {
  $_SESSION['flash'] = 'Error: could not update event.';
  header("Location: /Event_M/edit_event.php?id=$event_id");
}

$stmt->close();
exit;
?>
