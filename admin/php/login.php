<?php
ob_start();
session_start();
include 'db.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';
  // Fixed admin credentials
  $fixed_username = 'admin';
  $fixed_password = 'admin123';
  if ($username === $fixed_username && $password === $fixed_password) {
    $_SESSION['admin_id'] = 1;
    $_SESSION['user_type'] = 'admin';
    header('Location: dashboard.php');
    exit();
  } else if (!empty($username) && !empty($password)) {
    // Check designers table
    $stmt = $conn->prepare("SELECT designer_id, password_hash FROM designers WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows === 1) {
      $stmt->bind_result($designer_id, $password_hash);
      $stmt->fetch();
      if (password_verify($password, $password_hash)) {
        $_SESSION['designer_id'] = $designer_id;
        $_SESSION['user_type'] = 'designer';
        header('Location: order_page.php'); // Designers now go to admin panel
        exit();
      } else {
        $error = 'Password incorrect. Hash in DB: ' . htmlspecialchars($password_hash) . ' | Entered: ' . htmlspecialchars($password);
      }
    } else {
      $error = 'Designer not found for username: ' . htmlspecialchars($username);
    }
    $stmt->close();
  } else {
    $error = 'Please enter both username and password.';
  }
}
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <link rel="stylesheet" href="../css/order_register.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      background: #f8f9fa;
    }

    .login-container {
      max-width: 400px;
      margin: 80px auto;
    }

    .login-card {
      border-radius: 12px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }
  </style>
</head>

<body>
  <div class="login-container">
    <div class="card login-card p-4">
      <h3 class="mb-4 text-center">Anvaya Admin Login</h3>
      <?php if ($error): ?>
        <div class="alert alert-danger text-center py-2"> <?php echo $error; ?> </div>
      <?php endif; ?>
      <form method="post" action="">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Enter password"
            required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>

    </div>
  </div>
</body>

</html>