<?php
// order_register.php - Admin panel order register page
// This page will display orders, allow designer assignment, approve/reject, and popup for final details
session_start();
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['designer_id'])) {
  header('Location: login.php');
  exit();
}
$is_admin = isset($_SESSION['admin_id']);
$designer_id = isset($_SESSION['designer_id']) ? $_SESSION['designer_id'] : null;
include 'db.php';

$designers = [];
$designer_sql = "SELECT designer_id, designer_name FROM designers ORDER BY designer_name";
$designer_result = $conn->query($designer_sql);
if ($designer_result && $designer_result->num_rows > 0) {
  while ($designer = $designer_result->fetch_assoc()) {
    $designers[] = $designer;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Register - Admin Panel</title>
  <link rel="stylesheet" href="../css/order_register.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <div class="admin-layout d-flex">
    <nav class="sidebar bg-dark text-white p-3" style="min-width:220px;min-height:100vh;">
      <h4 class="mb-4">Anvaya</h4>
      <ul class="nav flex-column">
        <?php if ($is_admin): ?>
          <li class="nav-item mb-2"><a class="nav-link text-white" href="dashboard.php">Dashboard</a></li>
          <li class="nav-item mb-2"><a class="nav-link text-white active" href="order_register.php">Order Register</a>
          </li>
          <li class="nav-item mb-2"><a class="nav-link text-white" href="order_page.php">Orders</a></li>
          <li class="nav-item mb-2"><a class="nav-link text-white" href="designer_page.php">Designers</a></li>
          <li class="nav-item mb-2"><a class="nav-link text-white" href="contact_requests.php">Contact Requests</a></li>
          <li class="nav-item mb-2"><a class="nav-link text-white" href="user_profile.php">User Profile</a></li>
        <?php else: ?>
          <li class="nav-item mb-2"><a class="nav-link text-white disabled" tabindex="-1" aria-disabled="true"
              style="pointer-events:none;opacity:0.6;">Dashboard</a></li>
          <li class="nav-item mb-2"><a class="nav-link text-white active" href="order_register.php">Order Register</a>
          </li>
          <li class="nav-item mb-2"><a class="nav-link text-white" href="order_page.php">Orders</a></li>
          <li class="nav-item mb-2"><a class="nav-link text-white disabled" tabindex="-1" aria-disabled="true"
              style="pointer-events:none;opacity:0.6;">Designers</a></li>
          <li class="nav-item mb-2"><a class="nav-link text-white disabled" tabindex="-1" aria-disabled="true"
              style="pointer-events:none;opacity:0.6;">Contact Requests</a></li>
<li class="nav-item mb-2"><a class="nav-link text-white disabled" tabindex="-1" aria-disabled="true"
              style="pointer-events:none;opacity:0.6;">User Profile</a></li>        <?php endif; ?>
        <li class="nav-item logout mt-4"><a class="nav-link text-danger fw-bold" href="logout.php">Log Out</a></li>
      </ul>
    </nav>
    <div class="container main-content">
      <h2 class="mb-4 fw-bold text-center">Order Register</h2>
      <?php
      // Sample orders array (replace with DB fetch in production)
      // $orders = [
      //     [
      //         'id' => 1,
      //         'name' => 'Priya Sharma',
      //         'occasion' => 'Wedding',
      //         'style' => 'Lehenga',
      //         'budget' => 'Under 30,000',
      //         'selected_products' => 'Saree Name 1, Saree Name 2',
      //         'images' => ['img1.jpg', 'img2.jpg'],
      //         'age' => '26 to 35',
      //         'height' => '161 to 170 cm',
      //         'size' => 'Medium (M)',
      //         'color' => 'Pastel colors',
      //         'agree' => true,
      //         'status' => 'Pending',
      //     ],
      //     [
      //         'id' => 2,
      //         'name' => 'Amit Verma',
      //         'occasion' => 'Festival',
      //         'style' => 'Kurta',
      //         'budget' => 'Under 10,000',
      //         'selected_products' => 'Saree Name 3',
      //         'images' => ['img3.jpg'],
      //         'age' => '18 to 25',
      //         'height' => '150 to 160 cm',
      //         'size' => 'Small (S)',
      //         'color' => 'Bold & vibrant colors',
      //         'agree' => true,
      //         'status' => 'Pending',
      //     ],
      // ];
      
      // DB connection
      

      // SQL with JOIN
      

      // Ensure every user_design_preferences row has an order row with status 'order_received'
      $missing_orders_sql = "SELECT udp.preference_id, udp.user_id FROM user_design_preferences udp LEFT JOIN orders o ON o.preference_id = udp.preference_id WHERE o.preference_id IS NULL";
      $missing_orders_result = $conn->query($missing_orders_sql);
      if ($missing_orders_result && $missing_orders_result->num_rows > 0) {
        while ($row = $missing_orders_result->fetch_assoc()) {
          $insert = $conn->prepare("INSERT INTO orders (user_id, preference_id, status) VALUES (?, ?, 'order_received')");
          $insert->bind_param('ii', $row['user_id'], $row['preference_id']);
          $insert->execute();
          $insert->close();
        }
      }

      if ($is_admin) {
        $sql = "
    SELECT 
        udp.preference_id AS order_id,
        CONCAT(u.first_name, ' ', u.last_name) AS name,
        u.phone AS phone_number,
        udp.occasion,
        udp.style,
        udp.budget,
        udp.liked_items AS selected_products,
        udp.uploaded_photo AS images,
        udp.age,
        udp.height,
        udp.approx_size AS size,
        udp.colour AS color,
        o.designer_id,
        d.designer_name,
        o.status
    FROM user_design_preferences udp
    JOIN users u ON udp.user_id = u.user_id
    LEFT JOIN orders o ON o.preference_id = udp.preference_id
    LEFT JOIN designers d ON o.designer_id = d.designer_id
    ORDER BY udp.preference_id DESC
    ";
        $result = $conn->query($sql);
      } else if ($designer_id) {
        // Designers see only their assigned orders
        $sql = "
    SELECT 
        udp.preference_id AS order_id,
        CONCAT(u.first_name, ' ', u.last_name) AS name,
        u.phone AS phone_number,
        udp.occasion,
        udp.style,
        udp.budget,
        udp.liked_items AS selected_products,
        udp.uploaded_photo AS images,
        udp.age,
        udp.height,
        udp.approx_size AS size,
        udp.colour AS color,
        o.designer_id,
        d.designer_name,
        o.status
    FROM user_design_preferences udp
    JOIN users u ON udp.user_id = u.user_id
    LEFT JOIN orders o ON o.preference_id = udp.preference_id
    LEFT JOIN designers d ON o.designer_id = d.designer_id
    WHERE o.designer_id = $designer_id
    ORDER BY udp.preference_id DESC
    ";
        $result = $conn->query($sql);
      }
      $orders = [];

      if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $orders[] = [
            'id' => $row['order_id'],
            'name' => $row['name'],
            'phone_number' => $row['phone_number'],
            'occasion' => $row['occasion'],
            'style' => $row['style'],
            'budget' => $row['budget'],
            'selected_products' => $row['selected_products'],
            'images' => explode(',', $row['images']), // split CSV of image names
            'age' => $row['age'],
            'height' => $row['height'],
            'size' => $row['size'],
            'color' => $row['color'],
            'designer' => $row['designer_name'],
            'status' => $row['status']
          ];
        }
      }

      // Test output
      ?>
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="input-group" style="max-width: 320px;">
          <input type="text" id="orderSearchInput" class="form-control" placeholder="Search orders...">
          <button class="btn btn-outline-secondary" type="button" id="orderSearchClear">Clear</button>
        </div>
        <div class="d-flex gap-2" style="min-width: 400px;">
          <div style="min-width: 180px;">
            <select id="orderStatusFilter" class="form-select">
              <option value="">All Statuses</option>
              <option value="Approved">Approved</option>
              <option value="Pending">Pending</option>
              <option value="Rejected">Rejected</option>
            </select>
          </div>
          <div style="min-width: 200px;">
            <select id="designerAssignedFilter" class="form-select">
              <option value="">All Designer Assignments</option>
              <option value="assigned">Assigned Designer</option>
              <option value="not-assigned">Not Assigned Designer</option>
            </select>
          </div>
        </div>
      </div>
      <div id="order-list">
        <table class="table table-bordered align-middle">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Phone</th>
              <th>Designer</th>
              <th>Status</th>
              <th>View</th>
            </tr>
          </thead>
          <tbody id="orderTableBody">
            <?php foreach ($orders as $order): ?>
              <tr>
                <td><?= $order['id'] ?></td>
                <td><?= htmlspecialchars($order['name']) ?></td>
                <td>
                  <?php
                  $phone = isset($order['phone_number']) ? htmlspecialchars($order['phone_number']) : '9876543210';
                  $phone_digits = preg_replace('/[^0-9]/', '', $phone);
                  if (strlen($phone_digits) >= 10) {
                    echo '<a href="https://wa.me/91' . substr($phone_digits, -10) . '" target="_blank" style="color:inherit;text-decoration:none;">' . $phone . '</a>';
                  } else {
                    echo $phone;
                  }
                  ?>
                </td>
                <td>
                  <?php
                  // Show designer name or dash
                  echo !empty($order['designer']) ? htmlspecialchars($order['designer']) : '&mdash;';
                  ?>
                </td>
                <td><span
                    class="badge <?= $order['status'] === 'Approved' ? 'bg-success' : ($order['status'] === 'Rejected' ? 'bg-danger' : 'bg-secondary') ?>"><?= $order['status'] ?></span>
                </td>
                <td><button class="btn btn-primary btn-sm view-btn" data-order-id="<?= $order['id'] ?>">View</button></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <!-- Popup Modal for View -->
      <div class="modal fade" id="orderViewModal" tabindex="-1" aria-labelledby="orderViewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="orderViewModalLabel">Order Details</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="order-modal-body">
              <!-- Order details will be loaded here by JS -->
              <!-- <div class="mb-3" id="designerDropdownContainer">
                                <label for="designerDropdown" class="form-label">Assign Designer</label>
                                <select class="form-select" id="designerDropdown">
                                    <option value="">-- Select Designer --</option>
                                    <option value="Designer 1">Designer 1</option>
                                    <option value="Designer 2">Designer 2</option>
                                    <option value="Designer 3">Designer 3</option>
                                </select>
                            </div> -->
              <?php if ($is_admin || $designer_id): ?>
                <div class="mb-3" id="designerDropdownContainer">
                  <label for="designerDropdown" class="form-label">Assign Designer</label>
                  <select class="form-select" id="designerDropdown">
                    <option value="">-- Select Designer --</option>
                    <?php
                    // Fetch designers from database
                    $designer_sql = "SELECT designer_id, designer_name FROM designers ORDER BY designer_name";
                    $designer_result = $conn->query($designer_sql);
                    if ($designer_result && $designer_result->num_rows > 0) {
                      while ($designer = $designer_result->fetch_assoc()) {
                        echo '<option value="' . $designer['designer_id'] . '">' . htmlspecialchars($designer['designer_name']) . '</option>';
                      }
                    }
                    ?>
                  </select>
                </div>
              <?php endif; ?>

            </div>
            <div class="modal-footer d-flex justify-content-between">
              <?php if ($is_admin || $designer_id): ?>
                <button type="button" class="btn btn-success" id="approveBtn">Approve</button>
                <button type="button" class="btn btn-danger" id="rejectBtn">Reject</button>
              <?php endif; ?>
              <?php if ($is_admin || $designer_id): ?>
                <button type="button" class="btn btn-secondary" id="assignDesignerBtn">Assign Designer</button>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <!-- Popup Modal for Final Approval -->
      <div class="modal fade" id="finalApproveModal" tabindex="-1" aria-labelledby="finalApproveModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="finalApproveModalLabel">Final Approval Details</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="finalApprovalForm">
              <div class="modal-body">
                <div class="mb-3">
                  <label for="finalStyle" class="form-label">Final Style Description</label>
                  <textarea class="form-control" id="finalStyle" name="finalStyle" rows="2" required></textarea>
                </div>
                <div class="mb-3">
                  <label for="finalMeasurement" class="form-label">Final Measurement</label>
                  <input type="text" class="form-control" id="finalMeasurement" name="finalMeasurement" required>
                </div>
                <div class="mb-3">
                  <label for="finalPrice" class="form-label">Final Price</label>
                  <input type="number" class="form-control" id="finalPrice" name="finalPrice" required>
                </div>
                <div class="mb-3">
                  <label for="expectedDeliveryDate" class="form-label">Expected Delivery Date</label>
                  <input type="date" class="form-control" id="expectedDeliveryDate" name="expectedDeliveryDate"
                    required>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Place JS at end of body for proper DOM access -->
  <script>
    const designers = <?php echo json_encode($designers, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
    // Pass all orders to JS for dynamic modal rendering
    const orders = <?php echo json_encode($orders, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
  </script>
  <script src="../js/order_register.js"></script>
</body>

</html>