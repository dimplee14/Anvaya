<?php
include 'db.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
  header('Location: login.php');
  exit();
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>User Profile</title>
  <link rel="stylesheet" href="../css/order_register.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <li class="nav-item mb-2"><a class="nav-link text-white" href="contact_requests.php">Contact Requests</a></li>
        <li class="nav-item mb-2"><a class="nav-link text-white active" href="user_profile.php">User Profile</a></li>
        <li class="nav-item logout mt-4"><a class="nav-link text-danger fw-bold" href="logout.php">Log Out</a></li>
      </ul>

    </nav>
    <div class="container main-content">
      <h2 class="mb-4 fw-bold text-center">All Users</h2>
      <table class="table table-bordered align-middle">
        <thead class="table-dark">
          <tr>
            <th>User ID</th>
            <th>User Name</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Order IDs</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Fetch all users
          $sql = "SELECT user_id, first_name, last_name, phone, email FROM users";
          $result = $conn->query($sql);
          if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $user_id = $row['user_id'];
              $full_name = $row['first_name'] . ' ' . $row['last_name'];
              $phone = $row['phone'];
              $email = $row['email'];
              // Fetch order IDs for this user
              $orders = [];
              $order_sql = "SELECT order_id FROM orders WHERE user_id = '" . $conn->real_escape_string($user_id) . "'";
              $order_result = $conn->query($order_sql);
              if ($order_result && $order_result->num_rows > 0) {
                while ($order_row = $order_result->fetch_assoc()) {
                  $orders[] = $order_row['order_id'];
                }
              }
              echo '<tr>';
              echo '<td>' . htmlspecialchars($user_id) . '</td>';
              echo '<td>' . htmlspecialchars($full_name) . '</td>';
              // Make phone clickable to WhatsApp if valid
              $phone_digits = preg_replace('/[^0-9]/', '', $phone);
              if (strlen($phone_digits) >= 10) {
                echo '<td><a href="https://wa.me/91' . substr($phone_digits, -10) . '" target="_blank">' . htmlspecialchars($phone) . '</a></td>';
              } else {
                echo '<td>' . htmlspecialchars($phone) . '</td>';
              }
              // Make email clickable to mailto
              if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo '<td><a href="mailto:' . htmlspecialchars($email) . '">' . htmlspecialchars($email) . '</a></td>';
              } else {
                echo '<td>' . htmlspecialchars($email) . '</td>';
              }
              echo '<td>' . htmlspecialchars(implode(', ', $orders)) . '</td>';
              echo '</tr>';
            }
          } else {
            echo '<tr><td colspan="5" class="text-center">No users found.</td></tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>