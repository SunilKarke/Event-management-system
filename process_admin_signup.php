<?php
require_once __DIR__ . '/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /Event_M/admin_signup.php');
  exit;
}

// Get form data
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$admin_code = trim($_POST['admin_code'] ?? '');

// Check required fields
if ($username === '' || $password === '' || $admin_code === '') {
  $_SESSION['flash'] = 'Please fill in all fields.';
  header('Location: /Event_M/admin_signup.php');
  exit;
}

// Verify admin code
if ($admin_code !== ADMIN_REGISTRATION_CODE) {
  $_SESSION['flash'] = 'Invalid admin code.';
  header('Location: /Event_M/admin_signup.php');
  exit;
}

// Check if username already exists
$stmt = $mysqli->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
  $_SESSION['flash'] = 'Username already exists.';
  $stmt->close();
  header('Location: /Event_M/admin_signup.php');
  exit;
}
$stmt->close();

// Create new admin account
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$stmt = $mysqli->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'admin')");
$stmt->bind_param('ss', $username, $hashed_password);

if ($stmt->execute()) {
  $_SESSION['user_id'] = $stmt->insert_id;
  $_SESSION['flash'] = 'Admin account created successfully!';
  header('Location: /Event_M/');
} else {
  $_SESSION['flash'] = 'Error: Could not create admin account.';
  header('Location: /Event_M/admin_signup.php');
}

$stmt->close();
exit;
?>
