<?php
include 'db.php';
session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$address = isset($_POST['address']) ? trim($_POST['address']) : '';
$order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
$response = ['success' => false];

if ($user_id && $address !== '' && $order_id > 0) {
  // Always update delivery address and set status to 'order_confirm' for this order and user
  $update_sql = "UPDATE orders SET delivery_address = ?, status = 'order_confirm' WHERE order_id = ? AND user_id = ?";
  $stmt = $conn->prepare($update_sql);
  $stmt->bind_param('sii', $address, $order_id, $user_id);
  if ($stmt->execute() && $stmt->affected_rows > 0) {
    $response['success'] = true;
    $response['message'] = 'Delivery address updated and order confirmed.';
  } else {
    $response['message'] = 'Order row found, but address not updated. (Maybe same address or DB error: ' . $conn->error . ')';
  }
  $stmt->close();
} else {
  $response['message'] = 'User not logged in, address is empty, or invalid order.';
}
header('Content-Type: application/json');
echo json_encode($response);
