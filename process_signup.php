<?php
require_once __DIR__ . '/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /Event_M/signup.php'); exit; }

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    $_SESSION['flash'] = 'Username and password required.';
    header('Location: /Event_M/signup.php'); exit;
}

// Check if user exists
$stmt = $mysqli->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $_SESSION['flash'] = 'Username already taken.';
    $stmt->close();
    header('Location: /Event_M/signup.php'); exit;
}
$stmt->close();

$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param('ss', $username, $hash);
if ($stmt->execute()) {
    $_SESSION['user_id'] = $stmt->insert_id;
    $_SESSION['flash'] = 'Registered and logged in.';
    $stmt->close();
    header('Location: /Event_M/'); exit;
} else {
    $_SESSION['flash'] = 'Failed to create account.';
    $stmt->close();
    header('Location: /Event_M/signup.php'); exit;
}
?>
