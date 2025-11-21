<?php
require_once __DIR__ . '/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /Event_M/');
  exit;
}

// Check if user is logged in
if (empty($_SESSION['user_id'])) {
  $_SESSION['flash'] = 'Please login to add events.';
  header('Location: /Event_M/login.php');
  exit;
}

// Get data
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$event_date = $_POST['event_date'] ?? '';
$event_time = $_POST['event_time'] ?? '';
$time_period = $_POST['time_period'] ?? 'AM';
$location = trim($_POST['location'] ?? '');

// Validate inputs
if ($title === '' || $event_date === '' || $event_time === '' || $location === '') {
  $_SESSION['flash'] = 'Event title, date, time, and location are required.';
  header('Location: /Event_M/add_event.php');
  exit;
}

// Convert time 
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

// Insert event into database
$stmt = $mysqli->prepare("INSERT INTO events (title, description, event_datetime, location, created_by) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param('ssssi', $title, $description, $event_datetime, $location, $_SESSION['user_id']);

if ($stmt->execute()) {
  $_SESSION['flash'] = 'Event added successfully!';
} else {
  $_SESSION['flash'] = 'Error: Could not add event.';
}

$stmt->close();
header('Location: /Event_M/');
exit;
?>
