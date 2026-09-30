<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header('Location: login.php');
  exit();
}
include 'db.php';

// Handle Mark as Read action
if (isset($_POST['mark_read_id'])) {
  $id = intval($_POST['mark_read_id']);
  $conn->query("UPDATE contact_requests SET status='done' WHERE request_id=$id");
}

// Handle Delete action
if (isset($_POST['delete_id'])) {
  $id = intval($_POST['delete_id']);
  $conn->query("DELETE FROM contact_requests WHERE request_id=$id");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Contact Requests</title>
  <link rel="stylesheet" href="../css/order_register.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <div class="admin-layout d-flex">
    <nav class="sidebar bg-dark text-white p-3" style="min-width:220px;min-height:100vh;">
      <h4 class="mb-4">Anvaya</h4>
      <ul class="nav flex-column">
        <li class="nav-item mb-2"><a class="nav-link text-white" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item mb-2"><a class="nav-link text-white" href="order_register.php">Order Register</a></li>
        <li class="nav-item mb-2"><a class="nav-link text-white" href="order_page.php">Orders</a></li>
        <li class="nav-item mb-2"><a class="nav-link text-white " href="designer_page.php">Designers</a></li>
        <li class="nav-item mb-2"><a class="nav-link text-white active" href="contact_requests.php">Contact Requests</a>
        </li>
        <li class="nav-item mb-2"><a class="nav-link text-white" href="user_profile.php">User Profile</a></li>
        <li class="nav-item logout mt-4"><a class="nav-link text-danger fw-bold" href="logout.php">Log Out</a></li>
      </ul>
    </nav>
    <div class="container mt-5">
      <h2 class="mb-4 fw-bold text-center">Contact Requests</h2>

      <style>
        /* Make message box small and keep all fields in a straight line except subject and message */
        .contact-table td.message-col {
          max-width: 120px;
          white-space: nowrap;
          overflow: hidden;
          text-overflow: ellipsis;
        }

        .contact-table td.subject-col {
          max-width: 180px;
          white-space: nowrap;
          overflow: hidden;
          text-overflow: ellipsis;
        }
      </style>
      <table class="table table-bordered align-middle contact-table">
        <thead class="table-dark">
          <tr>
            <th class="text-center">ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th class="subject-col">Subject</th>
            <th class="message-col">Message</th>
            <th>Date Submitted</th>
            <th>Status</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $result = $conn->query("SELECT * FROM contact_requests ORDER BY date_submitted DESC");
          if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo '<tr>';
              echo '<td class="text-center">' . $row['request_id'] . '</td>';
              echo '<td>' . htmlspecialchars($row['name']) . '</td>';
              // Make email clickable
              $email = htmlspecialchars($row['email']);
              if (filter_var($row['email'], FILTER_VALIDATE_EMAIL)) {
                echo '<td><a href="mailto:' . $email . '" style="color:inherit;text-decoration:none;">' . $email . '</a></td>';
              } else {
                echo '<td>' . $email . '</td>';
              }
              // Make phone clickable to WhatsApp
              $phone = htmlspecialchars($row['phone']);
              $phone_digits = preg_replace('/[^0-9]/', '', $row['phone']);
              if (strlen($phone_digits) >= 10) {
                echo '<td><a href="https://wa.me/91' . substr($phone_digits, -10) . '" target="_blank" style="color:inherit;text-decoration:none;">' . $phone . '</a></td>';
              } else {
                echo '<td>' . $phone . '</td>';
              }
              echo '<td class="subject-col" title="' . htmlspecialchars($row['subject']) . '">' . htmlspecialchars($row['subject']) . '</td>';
              echo '<td class="message-col" title="' . htmlspecialchars($row['message']) . '">' . htmlspecialchars($row['message']) . '</td>';
              echo '<td>' . htmlspecialchars($row['date_submitted']) . '</td>';
              $badge = ($row['status'] === 'pending') ? 'bg-warning text-dark' : 'bg-success';
              echo '<td><span class="badge ' . $badge . ' px-3 py-2">' . ucfirst($row['status']) . '</span></td>';
              echo '<td class="text-center">';
              if ($row['status'] === 'pending') {
                echo '<form method="post" action="" style="display:inline;">
                                        <input type="hidden" name="mark_read_id" value="' . $row['request_id'] . '">
                                        <button type="submit" class="btn btn-sm btn-success">Mark as Read</button>
                                    </form>';
              } else {
                echo '<button class="btn btn-sm btn-secondary" disabled>Marked as Read</button>';
              }
              echo '</td>';
              echo '</tr>';
            }
          } else {
            echo '<tr><td colspan="9" class="text-center">No contact requests found.</td></tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>