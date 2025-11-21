<?php
require_once __DIR__ . '/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// Redirect if not logged in
if (empty($_SESSION['user_id'])) {
    $_SESSION['flash'] = 'Please login to apply for an event.';
    header('Location: /Event_M/login.php');
    exit;
}

// Prevent admins from applying
if (function_exists('is_admin') && is_admin()) {
    $_SESSION['flash'] = 'Admins cannot apply for events.';
    header('Location: /Event_M/');
    exit;
}

// Validate event ID
$event_id = intval($_POST['event_id'] ?? 0);
if ($event_id <= 0) {
    $_SESSION['flash'] = 'Invalid event selected.';
    header('Location: /Event_M/');
    exit;
}

$user_id = $_SESSION['user_id'];

// Check if already applied
$stmt = $mysqli->prepare("SELECT id FROM applications WHERE user_id = ? AND event_id = ? LIMIT 1");
$stmt->bind_param('ii', $user_id, $event_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION['flash'] = 'You have already applied for this event.';
    $stmt->close();
    header('Location: /Event_M/');
    exit;
}
$stmt->close();

// Apply for event
$stmt = $mysqli->prepare("INSERT INTO applications (user_id, event_id) VALUES (?, ?)");
$stmt->bind_param('ii', $user_id, $event_id);

if ($stmt->execute()) {
    $_SESSION['flash'] = 'Successfully applied for the event!';
} else {
    $_SESSION['flash'] = 'Something went wrong. Please try again.';
}

$stmt->close();
header('Location: /Event_M/');
exit;
