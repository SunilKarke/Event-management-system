<?php
require_once __DIR__ . '/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// Only handle POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /Event_M/login.php');
  exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Check if fields are empty
if ($username === '' || $password === '') {
  $_SESSION['flash'] = 'Please enter both username and password.';
  header('Location: /Event_M/login.php');
  exit;
}

// Check user in database
$stmt = $mysqli->prepare("SELECT id, password FROM users WHERE username = ? LIMIT 1");
$stmt->bind_param('s', $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Verify user
if (!$user || !password_verify($password, $user['password'])) {
  $_SESSION['flash'] = 'Invalid username or password.';
  header('Location: /Event_M/login.php');
  exit;
}

// Login success
$_SESSION['user_id'] = $user['id'];
$_SESSION['flash'] = 'Login successful!';
header('Location: /Event_M/');
exit;
?>
