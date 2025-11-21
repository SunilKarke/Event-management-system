<?php
require_once __DIR__ . '/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// Redirect if not logged in
if (empty($_SESSION['user_id'])) {
    $_SESSION['flash'] = 'Please login to view the admin panel.';
    header('Location: /Event_M/login.php');
    exit;
}

include __DIR__ . '/header.php';

// Fetch users
$users = [];
$res = $mysqli->query("SELECT id, username, role, created_at FROM users ORDER BY id ASC");
if ($res) { $users = $res->fetch_all(MYSQLI_ASSOC); $res->free(); }

// Fetch events
$events = [];
$res = $mysqli->query("SELECT id, title, event_datetime, location, created_by, created_at FROM events ORDER BY id ASC");
if ($res) { $events = $res->fetch_all(MYSQLI_ASSOC); $res->free(); }

// Fetch applications
$applications = [];
$sql = "SELECT a.id, u.username, e.title, a.applied_at 
        FROM applications a 
        JOIN users u ON a.user_id = u.id 
        JOIN events e ON a.event_id = e.id 
        ORDER BY a.applied_at DESC";
$res = $mysqli->query($sql);
if ($res) { $applications = $res->fetch_all(MYSQLI_ASSOC); $res->free(); }
?>

<div class="admin-container">
  <h2>Admin Dashboard</h2>

  <!-- EVENTS -->
  <section>
    <div class="section-header">
      <h3>Events</h3>
      <a href="/Event_M/add_event.php" class="btn add">+ Add New Event</a>
    </div>

    <?php if (empty($events)): ?>
      <p>No events available.</p>
    <?php else: ?>
      <table>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Date & Time</th>
          <th>Location</th>
          <th>Created By</th>
          <th>Created</th>
          <th>Actions</th>
        </tr>
        <?php foreach ($events as $e): ?>
          <tr>
            <td><?= esc($e['id']) ?></td>
            <td><?= esc($e['title']) ?></td>
            <td><?= date('F j, Y g:i A', strtotime($e['event_datetime'])) ?></td>
            <td><?= esc($e['location']) ?></td>
            <td><?= esc($e['created_by']) ?></td>
            <td><?= date('F j, Y g:i A', strtotime($e['created_at'])) ?></td>
            <td class="actions">
              <div class="action-buttons">
                <a href="/Event_M/edit_event.php?id=<?= $e['id'] ?>" class="btn edit">
                  <span class="btn-text">Edit</span>
                </a>
                <a href="/Event_M/delete_event.php?id=<?= $e['id'] ?>" class="btn delete"
                  onclick="return confirm('Are you sure you want to delete this event?');">
                  <span class="btn-text">Delete</span>
                </a>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    <?php endif; ?>
  </section>

  <!-- APPLICATIONS -->
  <section>
    <h3>Event Applications</h3>
    <?php if (empty($applications)): ?>
      <p>No applications yet.</p>
    <?php else: ?>
      <table>
        <tr><th>ID</th><th>User</th><th>Event</th><th>Applied At</th></tr>
        <?php foreach ($applications as $a): ?>
          <tr>
            <td><?= esc($a['id']) ?></td>
            <td><?= esc($a['username']) ?></td>
            <td><?= esc($a['title']) ?></td>
            <td><?= esc($a['applied_at']) ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    <?php endif; ?>
  </section>

  <!-- USERS -->
  <section>
    <h3>Users</h3>
    <?php if (empty($users)): ?>
      <p>No users found.</p>
    <?php else: ?>
      <table>
        <tr><th>ID</th><th>Username</th><th>Role</th><th>Created</th></tr>
        <?php foreach ($users as $u): ?>
          <tr>
            <td><?= esc($u['id']) ?></td>
            <td><?= esc($u['username']) ?></td>
            <td><?= esc($u['role']) ?></td>
            <td><?= esc($u['created_at']) ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    <?php endif; ?>
  </section>
</div>

<style>
.admin-container {
  width: 100%;
  max-width: 100%;
  margin: 0;
  padding: 20px;
  box-sizing: border-box;
}

h2, h3 {
  color: #2c3e50;
  margin-bottom: 8px;
}
.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
table {
  width: 100%;
  border-collapse: collapse;
  margin: 15px 0;
  background: #fff;
  border-radius: 6px;
  overflow: hidden;
  box-shadow: 0 1px 4px rgba(0,0,0,0.1);
}
th, td {
  padding: 10px;
  border-bottom: 1px solid #eee;
  text-align: left;
}
th { background: #f5f6f7; }
tr:hover { background: #f9f9f9; }

.actions { min-width: 160px; }
.action-buttons {
  display: flex;
  gap: 8px;
  justify-content: flex-start;
}
.btn {
  padding: 6px 12px;
  border-radius: 4px;
  text-decoration: none;
  color: white;
  font-size: 14px;
  text-align: center;
  min-width: 70px;
  display: inline-block;
  border: none;
  transition: all 0.2s ease;
}
.btn-text {
  display: inline-block;
  min-width: 40px;
}
.btn.edit { 
  background: #3498db;
  box-shadow: 0 2px 4px rgba(53, 147, 210, 0.2);
}
.btn.edit:hover { 
  background: #2980b9;
  transform: translateY(-1px);
  box-shadow: 0 4px 8px rgba(52, 152, 219, 0.3);
}
.btn.delete { 
  background: #e74c3c;
  box-shadow: 0 2px 4px rgba(231, 76, 60, 0.2);
}
.btn.delete:hover { 
  background: #c0392b;
  transform: translateY(-1px);
  box-shadow: 0 4px 8px rgba(231, 76, 60, 0.3);
}
.btn.add { 
  background: #27ae60;
  box-shadow: 0 2px 4px rgba(39, 174, 96, 0.2);
}
.btn.add:hover { 
  background: #1e8449;
  transform: translateY(-1px);
  box-shadow: 0 4px 8px rgba(39, 174, 96, 0.3);
}

section { margin-bottom: 30px; }
</style>

<?php include __DIR__ . '/footer.php'; ?>
