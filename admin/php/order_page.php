<?php
session_start();
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['designer_id'])) {
  header('Location: login.php');
  exit();
}
// Determine user type
$is_admin = isset($_SESSION['admin_id']);
$designer_id = isset($_SESSION['designer_id']) ? $_SESSION['designer_id'] : null;
$user_type = isset($_SESSION['admin_id']) ? 'admin' : (isset($_SESSION['designer_id']) ? 'designer' : '');
include 'db.php';

// Fetch orders with delivery address only
if ($is_admin) {
  $sql = "SELECT o.order_id, CONCAT(u.first_name, ' ', u.last_name) AS customer_name, u.phone AS contact_number, o.delivery_address, d.designer_name, o.delivery_date AS expected_delivery_date, o.status, o.designer_id FROM orders o JOIN users u ON o.user_id = u.user_id LEFT JOIN designers d ON o.designer_id = d.designer_id WHERE o.delivery_address IS NOT NULL AND o.delivery_address != '' ORDER BY o.order_id DESC";
  $result = $conn->query($sql);
} else if ($designer_id) {
  $sql = "SELECT o.order_id, CONCAT(u.first_name, ' ', u.last_name) AS customer_name, u.phone AS contact_number, o.delivery_address, d.designer_name, o.delivery_date AS expected_delivery_date, o.status, o.designer_id FROM orders o JOIN users u ON o.user_id = u.user_id LEFT JOIN designers d ON o.designer_id = d.designer_id WHERE o.delivery_address IS NOT NULL AND o.delivery_address != '' AND o.designer_id = ? ORDER BY o.order_id DESC";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $designer_id);
  $stmt->execute();
  $result = $stmt->get_result();
}
$valid_statuses = ['order_received', 'order_confirm', 'in_process', 'out_for_delivery', 'delivered', 'cancelled'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Order Management</title>
  <link rel="stylesheet" href="../css/order_register.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="admin-layout d-flex">
    <nav class="sidebar bg-dark text-white p-3" style="min-width:220px;min-height:100vh;">
      <h4 class="mb-4">Anvaya</h4>
      <ul class="nav flex-column">
        <?php if ($is_admin): ?>
          <li class="nav-item mb-2"><a class="nav-link text-white" href="dashboard.php">Dashboard</a></li>
          <li class="nav-item mb-2"><a class="nav-link text-white" href="order_register.php">Order Register</a></li>
          <li class="nav-item mb-2"><a class="nav-link text-white active" href="order_page.php">Orders</a></li>
          <li class="nav-item mb-2"><a class="nav-link text-white" href="designer_page.php">Designers</a></li>
          <li class="nav-item mb-2"><a class="nav-link text-white" href="contact_requests.php">Contact Requests</a></li>
          <li class="nav-item mb-2"><a class="nav-link text-white" href="user_profile.php">User Profile</a></li>
        <?php else: ?>
          <li class="nav-item mb-2"><a class="nav-link text-white disabled" tabindex="-1" aria-disabled="true"
              style="pointer-events:none;opacity:0.6;">Dashboard</a></li>
          <li class="nav-item mb-2"><a class="nav-link text-white" href="order_register.php">Order Register</a></li>
          <li class="nav-item mb-2"><a class="nav-link text-white active" href="order_page.php">Orders</a></li>
          <li class="nav-item mb-2"><a class="nav-link text-white disabled" tabindex="-1" aria-disabled="true"
              style="pointer-events:none;opacity:0.6;">Designers</a></li>
          <li class="nav-item mb-2"><a class="nav-link text-white disabled" tabindex="-1" aria-disabled="true"
              style="pointer-events:none;opacity:0.6;">Contact Requests</a></li>
          <li class="nav-item mb-2"><a class="nav-link text-white disabled" tabindex="-1" aria-disabled="true"
              style="pointer-events:none;opacity:0.6;">User Profile</a></li> <?php endif; ?>
        <li class="nav-item logout mt-4"><a class="nav-link text-danger fw-bold" href="logout.php">Log Out</a></li>
      </ul>
    </nav>
    <div class="container main-content">
      <h2 class="mb-4 fw-bold text-center">Order Management</h2>
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="input-group" style="max-width: 320px;">
          <input type="text" id="orderSearchInput" class="form-control" placeholder="Search orders...">
          <button class="btn btn-outline-secondary" type="button" id="orderSearchClear">Clear</button>
        </div>
        <div style="min-width: 180px;">
          <select id="orderStatusFilter" class="form-select">
            <option value="">All Statuses</option>
            <option value="Order Received">Order Received</option>
            <option value="Order Confirmed">Order Confirmed</option>
            <option value="In Process">In Process</option>
            <option value="Out for Delivery">Out for Delivery</option>
            <option value="Delivered">Delivered</option>
            <option value="Cancelled">Cancelled</option>
          </select>
        </div>
      </div>
      <table class="table table-bordered align-middle" id="orderTable">
        <thead class="table-dark">
          <tr>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Contact Number</th>
            <th>Delivery Address</th>
            <th>Designer</th>
            <th>Expected Delivery Date</th>
            <th>Current Status</th>
            <th>Status Update</th>
          </tr>
        </thead>
        <tbody>
          <!-- Example rows, replace with PHP loop for real data -->


          <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <?php
              $status = in_array($row['status'], $valid_statuses) ? $row['status'] : 'unknown';
              ?>
              <tr>
                <td><?= htmlspecialchars($row['order_id']) ?></td>
                <td><?= htmlspecialchars($row['customer_name']) ?></td>
                <?php
                $contact = htmlspecialchars($row['contact_number']);
                $contact_digits = preg_replace('/[^0-9]/', '', $row['contact_number']);
                if (strlen($contact_digits) >= 10) {
                  echo '<td><a href="https://wa.me/91' . substr($contact_digits, -10) . '" target="_blank" style="color:inherit;text-decoration:none;">' . $contact . '</a></td>';
                } else {
                  echo '<td>' . $contact . '</td>';
                }
                ?>
                <td><?= htmlspecialchars($row['delivery_address']) ?></td>
                <td><?= htmlspecialchars($row['designer_name'] ?? '-') ?></td>
                <td><?= htmlspecialchars($row['expected_delivery_date']) ?></td>
                <td class="current-status">
                  <?php
                  // Map status to dashboard badge class
                  $statusClass = '';
                  switch (strtolower($status)) {
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
                    case 'order_received':
                      $statusClass = 'received';
                      break;
                    case 'cancelled':
                      $statusClass = 'cancelled';
                      break;
                    default:
                      $statusClass = 'secondary';
                  }
                  ?>
                  <span class="order-status-badge <?= $statusClass ?>">
                    <?php
                    if ($status == 'order_received')
                      echo 'Order Received';
                    elseif ($status == 'order_confirm')
                      echo 'Order Confirmed';
                    elseif ($status == 'in_process')
                      echo 'In Process';
                    elseif ($status == 'out_for_delivery')
                      echo 'Out for Delivery';
                    elseif ($status == 'delivered')
                      echo 'Delivered';
                    elseif ($status == 'cancelled')
                      echo 'Cancelled';
                    elseif ($status == 'unknown')
                      echo 'Unknown Status';
                    else
                      echo htmlspecialchars($row['status']);
                    ?>
                  </span>
                </td>
                <td>
                  <?php if ($is_admin || ($designer_id && $row['designer_id'] == $designer_id)): ?>
                    <select class="form-select form-select-sm order-status-select">
                      <option value="order_received" <?= $status == 'order_received' ? ' selected' : '' ?>>Order Received
                      </option>
                      <option value="order_confirm" <?= $status == 'order_confirm' ? ' selected' : '' ?>>Order Confirmed</option>
                      <option value="in_process" <?= $status == 'in_process' ? ' selected' : '' ?>>In Process</option>
                      <option value="out_for_delivery" <?= $status == 'out_for_delivery' ? ' selected' : '' ?>>Out for Delivery
                      </option>
                      <option value="delivered" <?= $status == 'delivered' ? ' selected' : '' ?>>Delivered</option>
                      <option value="cancelled" <?= $status == 'cancelled' ? ' selected' : '' ?>>Cancelled</option>
                    </select>
                  <?php else: ?>
                    <span class="text-muted">No Access</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="8" class="text-center">No orders with delivery address found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <script>
      // JS to show status update feedback and sync current status
      document.querySelectorAll('.order-status-select').forEach(function (select) {
        select.addEventListener('change', function () {
          var row = select.closest('tr');
          var orderId = row.children[0].textContent.trim();
          var status = select.value;
          fetch('update_order_status.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'order_id=' + encodeURIComponent(orderId) + '&status=' + encodeURIComponent(status)
          })
            .then(response => response.json())
            .then(data => {
              if (!data.success) {
                alert('Failed to update status in database!');
              } else {
                location.reload(); // Refresh to show updated status
              }
            });
        });
      });

      // Search and filter logic
      var searchInput = document.getElementById('orderSearchInput');
      var searchClear = document.getElementById('orderSearchClear');
      var statusFilter = document.getElementById('orderStatusFilter');
      var table = document.getElementById('orderTable');
      var tbody = table ? table.querySelector('tbody') : null;

      function filterOrders() {
        if (!tbody) return;
        var searchVal = searchInput.value.toLowerCase();
        var statusVal = statusFilter.value;
        Array.from(tbody.rows).forEach(function (row) {
          var orderId = row.children[0].textContent.toLowerCase();
          var userName = row.children[1].textContent.toLowerCase();
          var contact = row.children[2].textContent.toLowerCase();
          var address = row.children[3].textContent.toLowerCase();
          var designer = row.children[4].textContent.toLowerCase();
          var status = row.children[6].querySelector('select').value;
          var matchesSearch = orderId.includes(searchVal) || userName.includes(searchVal) || contact.includes(searchVal) || address.includes(searchVal) || designer.includes(searchVal) || status.toLowerCase().includes(searchVal);
          var matchesStatus = !statusVal || status === statusVal;
          row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
        });
      }
      if (searchInput) searchInput.addEventListener('input', filterOrders);
      if (searchClear) searchClear.addEventListener('click', function () { searchInput.value = ''; filterOrders(); });
      if (statusFilter) statusFilter.addEventListener('change', filterOrders);
      // Initial filter
      filterOrders();
    </script>
</body>

</html>