<?php
// Handles review submission with photo in one request
include 'db.php';
session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
if (!$user_id) {
  echo json_encode(['success' => false, 'message' => 'Not logged in.']);
  exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
  $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
  $review = isset($_POST['review']) ? trim($_POST['review']) : '';
  $photo_path = null;
  if ($order_id && $rating && $review) {
    // Check if review already exists for this user and order
    $check_stmt = $conn->prepare("SELECT review_id FROM reviews WHERE order_id = ? AND user_id = ? LIMIT 1");
    $check_stmt->bind_param('ii', $order_id, $user_id);
    $check_stmt->execute();
    $check_stmt->store_result();
    if ($check_stmt->num_rows > 0) {
      $check_stmt->close();
      echo json_encode(['success' => false, 'message' => 'You have already submitted a review for this order.']);
      exit();
    }
    $check_stmt->close();
    // Handle photo upload if present
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
      $targetDir = '../../uploads/review_photos/';
      if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
      }
      $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
      $allowed = ['jpg', 'jpeg', 'png', 'webp'];
      if (!in_array($ext, $allowed)) {
        echo json_encode(['success' => false, 'message' => 'Invalid file type.']);
        exit();
      }
      $filename = 'review_' . $user_id . '_' . $order_id . '_' . time() . '.' . $ext;
      $targetFile = $targetDir . $filename;
      if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
        $photo_path = 'uploads/review_photos/' . $filename;
      } else {
        echo json_encode(['success' => false, 'message' => 'Photo upload failed.']);
        exit();
      }
    }
    $review_esc = mysqli_real_escape_string($conn, $review);
    $stmt = $conn->prepare("INSERT INTO reviews (order_id, user_id, rating, review_text, photo, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param('iiiss', $order_id, $user_id, $rating, $review_esc, $photo_path);
    $success = $stmt->execute();
    $stmt->close();
    if ($success) {
      echo json_encode(['success' => true, 'photo' => $photo_path]);
    } else {
      echo json_encode(['success' => false, 'message' => 'Database error.']);
    }
  } else {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
  }
  exit();
}
echo json_encode(['success' => false, 'message' => 'Invalid request.']);
exit;
