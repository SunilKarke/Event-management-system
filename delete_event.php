<?php
require_once __DIR__ . '/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// Check if user is logged in and is admin
if (empty($_SESSION['user_id']) || !is_admin()) {
    $_SESSION['flash'] = 'Access denied. Admin privileges required.';
    header('Location: /Event_M/'); exit;
}

// Validate event ID
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$event_id) {
    $_SESSION['flash'] = 'Invalid event ID.';
    header('Location: /Event_M/admin.php'); exit;
}

// Start transaction
$mysqli->begin_transaction();

try {
    // Delete related applications first
    $stmt = $mysqli->prepare("DELETE FROM applications WHERE event_id = ?");
    $stmt->bind_param('i', $event_id);
    $stmt->execute();
    $stmt->close();
    
    // Delete the event
    $stmt = $mysqli->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param('i', $event_id);
    $stmt->execute();
    $stmt->close();
    
    // Commit transaction
    $mysqli->commit();
    $_SESSION['flash'] = 'Event and related applications deleted successfully.';
    
} catch (Exception $e) {
    // Rollback on error
    $mysqli->rollback();
    $_SESSION['flash'] = 'Error deleting event: ' . $e->getMessage();
}

header('Location: /Event_M/admin.php');