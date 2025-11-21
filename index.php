<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/header.php';

// Fetch events ordered by datetime
$stmt = $mysqli->prepare("SELECT e.id, e.title, e.description, e.event_datetime, e.location, u.username, e.created_at FROM events e LEFT JOIN users u ON e.created_by = u.id ORDER BY e.event_datetime ASC");
$stmt->execute();
$res = $stmt->get_result();
$events = $res->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!-- Font Awesome CDN for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
  body {
    background: #f4f7fb;
    font-family: 'Poppins', sans-serif;
  }

  h2 {
    text-align: center;
    font-weight: 600;
    margin-top: 30px;
    color: #007bff;
  }

  p strong {
    color: #333;
  }

  .events {
    list-style: none;
    padding: 0;
    margin-top: 30px;
  }

  .events li {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 25px;
    margin-bottom: 20px;
    transition: transform 0.2s ease, box-shadow 0.3s ease;
  }

  .events li:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.15);
  }

  .events h3 {
    color: #0056b3;
    font-weight: 600;
  }

  .meta {
    font-size: 0.9rem;
    color: #555;
    margin-bottom: 10px;
    line-height: 1.8;
  }

  .meta strong {
    color: #000;
  }

  .meta i {
    color: #007bff;
    margin-right: 6px;
  }

  button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    font-weight: 500;
    transition: 0.3s;
    cursor: pointer;
  }

  button:hover {
    background-color: #0056b3;
    transform: scale(1.05);
  }

  hr {
    border: 0;
    border-top: 1px solid #eaeaea;
    margin-top: 20px;
  }

  .no-events {
    text-align: center;
    color: #666;
    font-size: 1.1rem;
    margin-top: 40px;
  }
</style>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
      <h2><i class="fa-solid fa-calendar-days"></i> Upcoming Events</h2>
      <p class="text-center">Date: <strong><?php echo esc(date('d/m/20y')); ?></strong></p>

      <?php if(empty($events)): ?>
        <p class="no-events">No events yet. Check back soon!</p>
      <?php else: ?>
        <ul class="events">
          <?php foreach($events as $ev): ?>
            <li>
              <h3><?php echo esc($ev['title']); ?></h3>
              <div class="meta">
                <i class="fa-solid fa-calendar-day"></i> <strong>Date:</strong> <?php echo date('F j, Y', strtotime($ev['event_datetime'])); ?><br>
                <i class="fa-regular fa-clock"></i> <strong>Time:</strong> <?php echo date('g:i A', strtotime($ev['event_datetime'])); ?><br>
                <i class="fa-solid fa-location-dot"></i> <strong>Location:</strong> <?php echo esc($ev['location']); ?><br>
                <i class="fa-regular fa-user"></i> <strong>Created by:</strong> <?php echo esc($ev['username'] ?? '—'); ?>
              </div>
              <p><?php echo nl2br(esc($ev['description'])); ?></p> 

              <?php if(!empty($_SESSION['user_id']) && function_exists('is_admin') && !is_admin()): ?>
                <form method="post" action="/Event_M/apply_event.php" style="margin-top:10px;">
                  <input type="hidden" name="event_id" value="<?php echo esc($ev['id']); ?>">
                  <button type="submit"><i class="fa-solid fa-paper-plane"></i> Apply for this Event</button>
                  <hr>
                </form>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
