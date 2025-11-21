<?php


$DB_HOST = '127.0.0.1';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'event_m';

define('ADMIN_REGISTRATION_CODE', 'Event_M_Admin_2025');


$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

function esc($value) {
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}


function is_admin() {
    global $mysqli;

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['user_id'])) {
        return false;
    }

    $user_id = (int) $_SESSION['user_id'];

    
    $check = $mysqli->query("SHOW COLUMNS FROM users LIKE 'role'");
    $hasRoleColumn = $check && $check->num_rows > 0;
    if ($check) $check->free();

    if ($hasRoleColumn) {
        // Fetch user role
        $stmt = $mysqli->prepare("SELECT role FROM users WHERE id = ? LIMIT 1");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $row = $result->fetch_assoc()) {
            $stmt->close();
            return ($row['role'] === 'admin');
        }

        $stmt->close();
    }

    return $user_id === 1;
}
?>
