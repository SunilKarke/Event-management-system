<?php
require_once __DIR__ . '/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// Only handle POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /Event_M/admin_login.php');
  exit;
}

// Get form inputs
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Check for empty fields
if ($username === '' || $password === '') {
  $_SESSION['flash'] = 'Please enter both username and password.';
  header('Location: /Event_M/admin_login.php');
  exit;
}

// Check admin credentials
$stmt = $mysqli->prepare("SELECT id, password FROM users WHERE username = ? AND role = 'admin' LIMIT 1");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
$stmt->close();

// Validate login
if (!$admin || !password_verify($password, $admin['password'])) {
  $_SESSION['flash'] = 'Invalid admin username or password.';
  header('Location: /Event_M/admin_login.php');
  exit;
}

// Login successful
$_SESSION['user_id'] = $admin['id'];
$_SESSION['flash'] = 'Welcome, Admin!';
header('Location: /Event_M/');
exit;
?>
