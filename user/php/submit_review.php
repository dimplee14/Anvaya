<?php
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
    $review_esc = mysqli_real_escape_string($conn, $review);
    $stmt = $conn->prepare("INSERT INTO reviews (order_id, user_id, rating, review_text, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param('iiis', $order_id, $user_id, $rating, $review_esc);
    $success = $stmt->execute();
    $stmt->close();
    if ($success) {
      echo json_encode(['success' => true]);
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
