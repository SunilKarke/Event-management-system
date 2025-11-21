<?php
require_once __DIR__ . '/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/header.php';
?>

<div class="login-panels">
  <!-- User Panel -->
  <section class="panel">
    <h2>User Access</h2>
    <div class="tabs">
      <button onclick="showTab('user-login')" class="tab-btn active">Login</button>
      <button onclick="showTab('user-signup')" class="tab-btn">Sign Up</button>
    </div>

    <div id="user-login" class="tab-content active">
      <h3>User Login</h3>
      <form method="post" action="/Event_M/process_login.php">
        <label>Username<br><input type="text" name="username" required></label>
        <label>Password<br><input type="password" name="password" required></label>
        <button type="submit">Login</button>
      </form>
    </div>

    <div id="user-signup" class="tab-content">
      <h3>User Sign Up</h3>
      <form method="post" action="/Event_M/process_signup.php">
        <label>Full Name<br><input type="text" name="full_name" required></label>
        <label>Email<br><input type="email" name="email" required></label>
        <label>Phone Number<br><input type="tel" name="phone" required></label>
        <label>Username<br><input type="text" name="username" required></label>
        <label>Password<br><input type="password" name="password" required></label>
        <label>Confirm Password<br><input type="password" name="confirm_password" required></label>
        <button type="submit">Sign Up</button>
      </form>
    </div>
  </section>

  <!-- Admin Panel -->
  <section class="panel">
    <h2>Admin Access</h2>
    <div class="tabs">
      <button onclick="showTab('admin-login')" class="tab-btn active">Admin Login</button>
      <button onclick="showTab('admin-signup')" class="tab-btn">Admin Sign Up</button>
    </div>

    <div id="admin-login" class="tab-content active">
      <h3>Admin Login</h3>
      <form method="post" action="/Event_M/process_admin_login.php">
        <label>Username<br><input type="text" name="username" required></label>
        <label>Password<br><input type="password" name="password" required></label>
        <button type="submit">Login as Admin</button>
      </form>
    </div>

    <div id="admin-signup" class="tab-content">
      <h3>Admin Sign Up</h3>
      <form method="post" action="/Event_M/process_admin_signup.php">
        <label>Full Name<br><input type="text" name="full_name" required></label>
        <label>Email<br><input type="email" name="email" required></label>
        <label>Phone Number<br><input type="tel" name="phone" required></label>
        <label>Username<br><input type="text" name="username" required></label>
        <label>Password<br><input type="password" name="password" required></label>
        <label>Confirm Password<br><input type="password" name="confirm_password" required></label>
        <label>Admin Code<br><input type="password" name="admin_code" required></label>
        <button type="submit">Sign Up as Admin</button>
      </form>
    </div>
  </section>
</div>
<style>
body {
  font-family: "Poppins", sans-serif;
  background: linear-gradient(135deg, #e0f7fa, #f1f8e9);
  margin: 0;
  padding: 0;
}

.login-panels {
  display: flex;
  gap: 30px;
  justify-content: center;
  align-items: flex-start;
  flex-wrap: wrap;
  padding: 60px 20px;
}

.panel {
  flex: 1;
  max-width: 600px;
  background: #ffffff;
  padding: 30px 40px;
  border-radius: 14px;
  box-shadow: 0 6px 20px rgba(0,0,0,0.08);
  transition: all 0.3s ease;
}

.panel:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

h2 {
  text-align: center;
  color: #004d40;
  font-weight: 600;
  margin-bottom: 20px;
}

.tabs {
  display: flex;
  justify-content: space-around;
  border-bottom: 2px solid #e0e0e0;
  margin-bottom: 20px;
}

.tab-btn {
  background: none;
  border: none;
  padding: 12px 18px;
  font-size: 1rem;
  cursor: pointer;
  color: #607d8b;
  transition: all 0.3s ease;
  border-radius: 6px 6px 0 0;
}

.tab-btn.active {
  color: #00695c;
  background: #e0f2f1;
  font-weight: 600;
  box-shadow: inset 0 -3px 0 #004d40;
}

.tab-content {
  display: none;
}

.tab-content.active {
  display: block;
  animation: fadeIn 0.4s ease;
}

form {
  margin-top: 15px;
}

label {
  display: block;
  margin-bottom: 12px;
  font-size: 0.95rem;
  color: #37474f;
}

input {
  width: 100%;
  padding: 10px 12px;
  margin-top: 6px;
  border: 1px solid #b0bec5;
  border-radius: 8px;
  outline: none;
  font-size: 0.95rem;
  background: #fafafa;
  transition: all 0.3s ease;
}

input:focus {
  border-color: #00695c;
  background: #fff;
}

button {
  width: 100%;
  padding: 12px;
  background: linear-gradient(90deg, #00796b, #004d40);
  color: white;
  font-weight: 600;
  border: none;
  border-radius: 8px;
  margin-top: 15px;
  cursor: pointer;
  letter-spacing: 0.5px;
  transition: all 0.3s ease;
}

button:hover {
  background: linear-gradient(90deg, #004d40, #00796b);
  transform: scale(1.03);
  box-shadow: 0 4px 12px rgba(0, 77, 64, 0.2);
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>


<script>
function showTab(tabId) {
  const panel = document.querySelector('#' + tabId).closest('.panel');
  panel.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
  panel.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
  document.getElementById(tabId).classList.add('active');
  panel.querySelector(`button[onclick*="${tabId}"]`).classList.add('active');
}
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
