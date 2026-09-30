<?php
include 'db.php';
session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
if (!$user_id) {
  echo json_encode(['success' => false, 'message' => 'Not logged in.']);
  exit();
}

// Get POST data
$order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
$delivery_address = isset($_POST['delivery_address']) ? trim($_POST['delivery_address']) : '';

if (!$order_id || !$delivery_address) {
  echo json_encode(['success' => false, 'message' => 'Missing order ID or address.']);
  exit();
}

$sql = "UPDATE orders SET delivery_address = ?, status = 'order_confirm' WHERE order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $delivery_address, $order_id);
if ($stmt->execute()) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'message' => 'Failed to update order.']);
}
$stmt->close();
$conn->close();
?>