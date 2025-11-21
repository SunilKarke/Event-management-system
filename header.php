<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/db.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Events Manage</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f7f9fc;
      margin: 0;
    }

    header {
      background: linear-gradient(135deg, #020423ff, #00b4d8);
      color: #fff;
      padding: 15px 0;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    header .container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
    }

    header h1 {
      margin: 0;
      font-size: 1.8rem;
      font-weight: 700;
    }

    header h1 a {
      color: #fff;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    header h1 a:hover {
      color: #e0f7ff;
    }

    nav {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
    }

    nav a {
      color: #ffffffcc;
      text-decoration: none;
      font-weight: 500;
      padding: 8px 14px;
      border-radius: 6px;
      transition: all 0.3s ease;
    }

    nav a:hover {
      color: #fff;
      background-color: rgba(255, 255, 255, 0.15);
      transform: translateY(-2px);
    }

    .flash {
      background: #d1ecf1;
      color: #0c5460;
      padding: 10px 15px;
      border-radius: 6px;
      border: 1px solid #bee5eb;
      margin: 15px auto;
      width: 90%;
      max-width: 900px;
      text-align: center;
      animation: fadeIn 0.4s ease-in-out;
    }

    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(-10px);}
      to {opacity: 1; transform: translateY(0);}
    }

    main.container {
      margin-top: 20px;
      padding-bottom: 30px;
    }

    /* Responsive */
    @media (max-width: 768px) {
      header .container {
        flex-direction: column;
        text-align: center;
      }
      nav {
        justify-content: center;
        margin-top: 10px;
      }
    }
  </style>
</head>

<body>
  <header>
    <div class="container">
      <h1><a href="/Event_M/">Event_Management</a></h1>
      <nav>
        <a href="/Event_M/">Home</a>
        <?php if(!empty($_SESSION['user_id'])): ?>
          <?php if(function_exists('is_admin') && is_admin()): ?>
            <a href="/Event_M/add_event.php">Add Event</a>
            <a href="/Event_M/admin.php">Admin Panel</a>
          <?php endif; ?>
          <a href="/Event_M/logout.php">Logout</a>
        <?php else: ?>
          <a href="/Event_M/auth.php">Admin / User SignUp</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <main class="container">
    <?php if(!empty($_SESSION['flash'])): ?>
      <div class="flash"><?php echo esc($_SESSION['flash']); unset($_SESSION['flash']); ?></div>
    <?php endif; ?>
