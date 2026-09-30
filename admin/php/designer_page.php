<?php
include 'db.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
  header('Location: login.php');
  exit();
}
// Handle Delete Designer
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_designer'])) {
  $id = intval($_POST['deleteDesignerId']);
  $stmt = $conn->prepare("DELETE FROM designers WHERE designer_id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->close();
  header("Location: designer_page.php");
  exit();
}

// Handle Add Designer
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_designer'])) {
  $name = trim($_POST['designerName']);
  $username = trim($_POST['designerUsername']);
  $password = $_POST['designerPassword'];
  $phone = trim($_POST['designerPhone']);
  $email = trim($_POST['designerEmail']);
  $password_hash = password_hash($password, PASSWORD_DEFAULT);
  $stmt = $conn->prepare("INSERT INTO designers (designer_name, username, password_hash, phone, email, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
  $stmt->bind_param("sssss", $name, $username, $password_hash, $phone, $email);
  $stmt->execute();
  $stmt->close();
  header("Location: designer_page.php");
  exit();
}

// Handle Edit Designer
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_designer'])) {
  $id = intval($_POST['editDesignerId']);
  $name = trim($_POST['editDesignerName']);
  $username = trim($_POST['editDesignerUsername']);
  $phone = trim($_POST['editDesignerPhone']);
  $email = trim($_POST['editDesignerEmail']);
  $update_password = !empty($_POST['editDesignerPassword']);
  if ($update_password) {
    $password_hash = password_hash($_POST['editDesignerPassword'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE designers SET designer_name=?, username=?, password_hash=?, phone=?, email=? WHERE designer_id=?");
    $stmt->bind_param("sssssi", $name, $username, $password_hash, $phone, $email, $id);
  } else {
    $stmt = $conn->prepare("UPDATE designers SET designer_name=?, username=?, phone=?, email=? WHERE designer_id=?");
    $stmt->bind_param("ssssi", $name, $username, $phone, $email, $id);
  }
  $stmt->execute();
  $stmt->close();
  header("Location: designer_page.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Designer Management</title>
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
        <li class="nav-item mb-2"><a class="nav-link text-white active" href="designer_page.php">Designers</a></li>
        <li class="nav-item mb-2"><a class="nav-link text-white" href="contact_requests.php">Contact Requests</a></li>
        <li class="nav-item mb-2"><a class="nav-link text-white" href="user_profile.php">User Profile</a></li>
        <li class="nav-item logout mt-4"><a class="nav-link text-danger fw-bold" href="logout.php">Log Out</a></li>
      </ul>
    </nav>
    <div class="container main-content">
      <h2 class="mb-4 fw-bold text-center">Designer Management</h2>
      <button class="btn btn-primary mb-3" id="registerDesignerBtn">+ Register Designer</button>
      <div id="designerFormContainer" style="display:none;">
        <div class="card mb-4">
          <div class="card-body">
            <form action="designer_page.php" method="POST" id="designerRegisterForm">
              <div class="mb-3">
                <label for="designerName" class="form-label">Designer Name</label>
                <input type="text" class="form-control" id="designerName" name="designerName" required>
              </div>
              <div class="mb-3">
                <label for="designerUsername" class="form-label">Username</label>
                <input type="text" class="form-control" id="designerUsername" name="designerUsername" required>
              </div>
              <div class="mb-3">
                <label for="designerPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="designerPassword" name="designerPassword" required>
              </div>
              <div class="mb-3">
                <label for="designerPhone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="designerPhone" name="designerPhone" required>
              </div>
              <div class="mb-3">
                <label for="designerEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="designerEmail" name="designerEmail" required>
              </div>
              <button type="submit" class="btn btn-success" name="add_designer">Register</button>
              <button type="button" class="btn btn-secondary" id="cancelDesignerForm">Cancel</button>
            </form>
          </div>
        </div>
      </div>
      <table class="table table-bordered align-middle" id="designerTable">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Designer Name</th>
            <th>Username</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM designers ORDER BY designer_id DESC";
          $result = $conn->query($sql);
          if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo '<tr>';
              echo '<td>' . htmlspecialchars($row['designer_id']) . '</td>';
              echo '<td>' . htmlspecialchars($row['designer_name']) . '</td>';
              echo '<td>' . htmlspecialchars($row['username']) . '</td>';
              echo '<td>' . htmlspecialchars($row['phone']) . '</td>';
              echo '<td>' . htmlspecialchars($row['email']) . '</td>';
              echo '<td>';
              echo '<button class="btn btn-sm btn-warning editDesignerBtn" data-id="' . $row['designer_id'] . '" data-username="' . htmlspecialchars($row['username']) . '"><i class="bi bi-pencil"></i></button> ';
              echo '<form method="POST" action="designer_page.php" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this designer?\');">';
              echo '<input type="hidden" name="deleteDesignerId" value="' . $row['designer_id'] . '">';
              echo '<button type="submit" class="btn btn-sm btn-danger" name="delete_designer">Delete</button>';
              echo '</form>';
              echo '</td>';
              echo '</tr>';
            }
          } else {
            echo '<tr><td colspan="6" class="text-center">No designers found.</td></tr>';
          }
          ?>
          <!-- Bootstrap Icons -->
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        </tbody>
      </table>
    </div>
  </div>
  <!-- Edit Designer Modal -->
  <div class="modal fade" id="editDesignerModal" tabindex="-1" aria-labelledby="editDesignerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editDesignerModalLabel">Edit Designer Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="designer_page.php" method="POST" id="editDesignerForm">
            <input type="hidden" id="editDesignerId" name="editDesignerId">
            <div class="mb-3">
              <label for="editDesignerName" class="form-label">Designer Name</label>
              <input type="text" class="form-control" id="editDesignerName" name="editDesignerName" required>
            </div>
            <div class="mb-3">
              <label for="editDesignerUsername" class="form-label">Username</label>
              <input type="text" class="form-control" id="editDesignerUsername" name="editDesignerUsername" required>
            </div>
            <div class="mb-3">
              <label for="editDesignerPassword" class="form-label">Password (leave blank to keep unchanged)</label>
              <input type="password" class="form-control" id="editDesignerPassword" name="editDesignerPassword">
            </div>
            <div class="mb-3">
              <label for="editDesignerPhone" class="form-label">Phone Number</label>
              <input type="text" class="form-control" id="editDesignerPhone" name="editDesignerPhone" required>
            </div>
            <div class="mb-3">
              <label for="editDesignerEmail" class="form-label">Email</label>
              <input type="email" class="form-control" id="editDesignerEmail" name="editDesignerEmail" required>
            </div>
            <button type="submit" class="btn btn-success" name="edit_designer">Save Changes</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Show/Hide Register Designer Form
      document.getElementById('registerDesignerBtn').onclick = function () {
        document.getElementById('designerFormContainer').style.display = 'block';
      };
      document.getElementById('cancelDesignerForm').onclick = function () {
        document.getElementById('designerFormContainer').style.display = 'none';
      };
      // Edit Designer Modal Logic
      document.querySelectorAll('.editDesignerBtn').forEach(function (btn) {
        btn.onclick = function () {
          var modalEl = document.getElementById('editDesignerModal');
          if (modalEl) {
            var row = btn.closest('tr');
            var id = row.children[0].textContent;
            var name = row.children[1].textContent;
            var username = row.children[2].textContent;
            var phone = row.children[3].textContent;
            var email = row.children[4].textContent;
            document.getElementById('editDesignerId').value = id;
            document.getElementById('editDesignerName').value = name;
            document.getElementById('editDesignerUsername').value = username;
            document.getElementById('editDesignerPassword').value = '';
            document.getElementById('editDesignerPhone').value = phone;
            document.getElementById('editDesignerEmail').value = email;
            var modal = new bootstrap.Modal(modalEl);
            modal.show();
          }
        };
      });
      // Delete Designer (frontend only)
      document.querySelectorAll('.deleteDesignerBtn').forEach(function (btn) {
        btn.onclick = function () {
          if (confirm('Are you sure you want to delete this designer?')) {
            btn.closest('tr').remove();
          }
        };
      });
    });
  </script>
</body>

</html>