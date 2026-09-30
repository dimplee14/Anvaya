<?php
session_start();
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['designer_id'])) {
  header('Location: login.php');
  exit();
}
// Determine user type
$user_type = isset($_SESSION['admin_id']) ? 'admin' : (isset($_SESSION['designer_id']) ? 'designer' : '');
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="../css/order_register.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <div class="admin-layout d-flex">
    <nav class="sidebar bg-dark text-white p-3" style="min-width:220px;min-height:100vh;">
      <h4 class="mb-4">Anvaya</h4>
      <ul class="nav flex-column">
        <li class="nav-item mb-2"><a class="nav-link text-white active" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item mb-2"><a class="nav-link text-white" href="order_register.php">Order Register</a></li>
        <li class="nav-item mb-2"><a class="nav-link text-white" href="order_page.php">Orders</a></li>
        <li class="nav-item mb-2"><a class="nav-link text-white " href="designer_page.php">Designers</a></li>
        <li class="nav-item mb-2"><a class="nav-link text-white" href="contact_requests.php">Contact Requests</a></li>
        <li class="nav-item mb-2"><a class="nav-link text-white" href="user_profile.php">User Profile</a></li>
        <li class="nav-item logout mt-4"><a class="nav-link text-danger fw-bold" href="logout.php">Log Out</a></li>
      </ul>
    </nav>
    <div class="container main-content">
      <h2 class="mb-4 fw-bold text-center">Dashboard</h2>

      <?php
      // Fetch dashboard stats
      $totalOrders = $conn->query("SELECT COUNT(*) FROM orders")->fetch_row()[0];
      $completedOrders = $conn->query("SELECT COUNT(*) FROM orders WHERE status='delivered'")->fetch_row()[0];
      $totalClients = $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0];
      $totalDesigners = $conn->query("SELECT COUNT(*) FROM designers")->fetch_row()[0];
      ?>
      <div class="row">
        <div class="col-md-3">
          <div class="card text-white bg-primary mb-3">
            <div class="card-body">
              <h5 class="card-title">Total Orders</h5>
              <p class="card-text fs-3" id="totalOrders"><?php echo $totalOrders; ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-white bg-success mb-3">
            <div class="card-body">
              <h5 class="card-title">Delivered Orders</h5>
              <p class="card-text fs-3" id="completedOrders"><?php echo $completedOrders; ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-white bg-info mb-3">
            <div class="card-body">
              <h5 class="card-title">Total Clients</h5>
              <p class="card-text fs-3" id="totalClients"><?php echo $totalClients; ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-white bg-warning mb-3">
            <div class="card-body">
              <h5 class="card-title">Total Designers</h5>
              <p class="card-text fs-3" id="totalDesigners"><?php echo $totalDesigners; ?></p>
            </div>
          </div>
        </div>
      </div>
      <h2 class="mb-4">Recent Orders</h2>
      <table class="table table-bordered align-middle">
        <thead class="table-dark">
          <tr>
            <th>Order ID</th>
            <th>User Name</th>
            <th>Contact Detail</th>
            <th>Designer Name</th>
            <th>Expected Delivery Date</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Only fetch orders with status from 'order_confirm' onwards (not empty)
          $validStatuses = [
            'order_confirm',
            'in_process',
            'out_for_delivery',
            'delivered',
            'approve',
            'reject'
          ];
          $statusList = "'" . implode("','", $validStatuses) . "'";
          $recentOrders = $conn->query("SELECT o.order_id, u.first_name, u.last_name, u.phone, d.designer_name, o.delivery_date, o.status FROM orders o LEFT JOIN users u ON o.user_id = u.user_id LEFT JOIN designers d ON o.designer_id = d.designer_id WHERE o.status IN ($statusList) ORDER BY o.order_id DESC LIMIT 4");
          if ($recentOrders && $recentOrders->num_rows > 0) {
            while ($row = $recentOrders->fetch_assoc()) {
              echo '<tr>';
              echo '<td><a href="order_page.php" class="text-primary text-decoration-underline">' . htmlspecialchars($row['order_id']) . '</a></td>';
              echo '<td>' . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) . '</td>';
              echo '<td>' . htmlspecialchars($row['phone']) . '</td>';
              echo '<td>' . htmlspecialchars($row['designer_name']) . '</td>';
              echo '<td>' . htmlspecialchars($row['delivery_date']) . '</td>';
              $statusClass = '';
              switch (strtolower($row['status'])) {
                case 'delivered':
                  $statusClass = 'delivered';
                  break;
                case 'in_process':
                  $statusClass = 'process';
                  break;
                case 'order_confirm':
                  $statusClass = 'confirmed';
                  break;
                case 'out_for_delivery':
                  $statusClass = 'warning';
                  break;
                case 'approve':
                  $statusClass = 'success';
                  break;
                case 'reject':
                  $statusClass = 'danger';
                  break;
                default:
                  $statusClass = 'secondary';
              }
              echo '<td><span class="order-status-badge ' . $statusClass . '">' . htmlspecialchars($row['status']) . '</span></td>';
              echo '</tr>';
            }
          } else {
            echo '<tr><td colspan="6" class="text-center">No recent orders found.</td></tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>