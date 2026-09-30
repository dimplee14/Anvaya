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
  if ($order_id) {
    // Only allow cancel if order belongs to user and is not delivered/cancelled
    $check = mysqli_query($conn, "SELECT * FROM orders WHERE order_id = $order_id AND user_id = $user_id");
    if ($check && mysqli_num_rows($check) > 0) {
      $order = mysqli_fetch_assoc($check);
      $status = strtolower(trim($order['status']));
      $notCancellable = ['delivered', 'cancelled'];
      if (in_array($status, $notCancellable)) {
        echo json_encode(['success' => false, 'message' => 'Order cannot be cancelled.']);
        exit();
      }
      $update = mysqli_query($conn, "UPDATE orders SET status = 'cancelled' WHERE order_id = $order_id");
      if ($update) {
        echo json_encode(['success' => true]);
      } else {
        echo json_encode(['success' => false, 'message' => 'Database update failed.']);
      }
    } else {
      echo json_encode(['success' => false, 'message' => 'Order not found.']);
    }
  } else {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
  }
  exit();
}
echo json_encode(['success' => false, 'message' => 'Invalid request.']);
exit();