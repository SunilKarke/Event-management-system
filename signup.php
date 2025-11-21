<?php
require_once __DIR__ . '/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/header.php';
?>

<h2>Sign up</h2>
<form method="post" action="/Event_M/process_signup.php">
  <label>Username<br><input type="text" name="username" required></label>
  <label>Password<br><input type="password" name="password" required></label>
  <button type="submit">Sign up</button>
</form>

<?php require_once __DIR__ . '/footer.php'; ?>
