<?php
ob_start();
session_start();
if (!isset($_SESSION['admin_id'])) {
  echo json_encode(['success' => false, 'error' => 'Unauthorized: Only admin can assign designers.']);
  ob_end_flush();
  exit;
}
header('Content-Type: application/json');
include 'db.php';

$preference_id = isset($_POST['orderId']) ? intval($_POST['orderId']) : 0;
$designer_id = isset($_POST['designerId']) ? intval($_POST['designerId']) : 0;

if ($preference_id && $designer_id) {
  // Check if order exists for this preference_id
  $check = $conn->prepare("SELECT order_id FROM orders WHERE preference_id=?");
  $check->bind_param('i', $preference_id);
  $check->execute();
  $check->store_result();
  if ($check->num_rows > 0) {
    // Exists: update designer_id only (do not change status)
    $stmt = $conn->prepare("UPDATE orders SET designer_id=? WHERE preference_id=?");
    if (!$stmt) {
      echo json_encode(['success' => false, 'error' => 'Prepare failed: ' . $conn->error]);
      ob_end_flush();
      exit;
    }
    $stmt->bind_param('ii', $designer_id, $preference_id);
    $success = $stmt->execute();
    if (!$success) {
      echo json_encode(['success' => false, 'error' => 'Execute failed: ' . $stmt->error]);
      $stmt->close();
      ob_end_flush();
      exit;
    }
    $stmt->close();
  } else {
    // Not exists: insert new order row
    // Get user_id from user_design_preferences
    $user_id = 0;
    $get_user = $conn->prepare("SELECT user_id FROM user_design_preferences WHERE preference_id=?");
    $get_user->bind_param('i', $preference_id);
    $get_user->execute();
    $get_user->bind_result($user_id);
    if ($get_user->fetch()) {
      $get_user->close();
      $insert = $conn->prepare("INSERT INTO orders (user_id, designer_id, preference_id, status) VALUES (?, ?, ?, 'order_received')");
      $insert->bind_param('iii', $user_id, $designer_id, $preference_id);
      $success = $insert->execute();
      $insert->close();
    } else {
      $get_user->close();
      echo json_encode(['success' => false, 'error' => 'User not found for this preference.']);
      ob_end_flush();
      exit;
    }
  }
  $check->close();

  // Get designer name
  $designer_name = '';
  $result = $conn->query("SELECT designer_name FROM designers WHERE designer_id=$designer_id");
  if ($row = $result->fetch_assoc()) {
    $designer_name = $row['designer_name'];
  }

  echo json_encode(['success' => true, 'designerName' => $designer_name]);
  ob_end_flush();
  exit;
}
echo json_encode(['success' => false, 'error' => 'Invalid data']);
ob_end_flush();
