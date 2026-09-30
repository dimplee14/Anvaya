<?php
// update_order_status.php - Updates the status of an order in the orders table
header('Content-Type: application/json');
include 'db.php';


$order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
$status = isset($_POST['status']) ? trim($_POST['status']) : '';
$valid_statuses = ['order_received', 'order_confirmed', 'in_process', 'out_for_delivery', 'delivered', 'cancelled', 'approve'];

// Default to 'approve' if status is empty or invalid
if (!$status || !in_array($status, $valid_statuses)) {
  $status = 'approve';
}

if ($order_id) {
  $stmt = $conn->prepare("UPDATE orders SET status=? WHERE order_id=?");
  if (!$stmt) {
    echo json_encode(['success' => false, 'error' => 'Prepare failed: ' . $conn->error]);
    exit;
  }
  $stmt->bind_param('si', $status, $order_id);
  $success = $stmt->execute();
  $stmt->close();
  if ($success) {
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
  }
  exit;
}
echo json_encode(['success' => false, 'error' => 'Invalid data']);
exit;
