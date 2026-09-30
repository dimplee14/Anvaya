<?php
// Handles review photo upload for an order
session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
if (!$user_id) {
  echo json_encode(['success' => false, 'message' => 'Not logged in.']);
  exit();
}
$order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
if (!$order_id || !isset($_FILES['photo'])) {
  echo json_encode(['success' => false, 'message' => 'Invalid input.']);
  exit();
}
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
  // Save path to DB (reviews table, photo column)
  include 'db.php';
  $photo_path = 'uploads/review_photos/' . $filename;
  $stmt = $conn->prepare("UPDATE reviews SET photo=? WHERE order_id=? AND user_id=?");
  $stmt->bind_param('sii', $photo_path, $order_id, $user_id);
  $stmt->execute();
  $stmt->close();
  echo json_encode(['success' => true, 'photo' => $photo_path]);
} else {
  echo json_encode(['success' => false, 'message' => 'Upload failed.']);
}
