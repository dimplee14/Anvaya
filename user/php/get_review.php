<?php
// Fetch review for a given order and user
include 'db.php';
session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
if (!$user_id || !$order_id) {
  echo json_encode(['review' => null]);
  exit();
}
$res = $conn->query("SELECT rating, review_text, photo FROM reviews WHERE order_id=$order_id AND user_id=$user_id LIMIT 1");
if ($res && $row = $res->fetch_assoc()) {
  // For compatibility with JS code, return 'review' as 'review' and 'photo_path' as 'photo_path'
  $row['review'] = $row['review_text'];
  $row['photo_path'] = $row['photo'];
  unset($row['review_text'], $row['photo']);
  echo json_encode(['review' => $row]);
} else {
  echo json_encode(['review' => null]);
}
