<?php
ob_start();
// process_final_approval.php - Handles final approval form submission and updates orders table by preference_id, setting status to 'approve'
header('Content-Type: application/json');
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $preference_id = isset($_POST['preferenceId']) ? intval($_POST['preferenceId']) : 0;
  $final_style = isset($_POST['finalStyle']) ? trim($_POST['finalStyle']) : '';
  $final_measurement = isset($_POST['finalMeasurement']) ? trim($_POST['finalMeasurement']) : '';
  $final_price = isset($_POST['finalPrice']) ? floatval($_POST['finalPrice']) : 0;
  $expected_delivery = isset($_POST['expectedDeliveryDate']) ? $_POST['expectedDeliveryDate'] : '';

  if ($preference_id && $final_style && $final_measurement && $final_price && $expected_delivery) {
    // Check if order exists for this preference_id
    $check = $conn->prepare("SELECT order_id FROM orders WHERE preference_id=?");
    $check->bind_param('i', $preference_id);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
      // Exists: update all approval fields
      $stmt = $conn->prepare("UPDATE orders SET final_style_desc=?, measurement=?, final_price=?, delivery_date=?, status='approve' WHERE preference_id=?");
      $stmt->bind_param('ssdsi', $final_style, $final_measurement, $final_price, $expected_delivery, $preference_id);
      $success = $stmt->execute();
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
        $insert = $conn->prepare("INSERT INTO orders (user_id, preference_id, final_style_desc, measurement, final_price, delivery_date, status) VALUES (?, ?, ?, ?, ?, ?, 'approve')");
        $insert->bind_param('iissds', $user_id, $preference_id, $final_style, $final_measurement, $final_price, $expected_delivery);
        $success = $insert->execute();
        $insert->close();
      } else {
        $get_user->close();
        echo json_encode(['success' => false, 'error' => 'User not found for this preference.']);
        exit;
      }
    }
    $check->close();
    if ($success) {
      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['success' => false, 'error' => $conn->error]);
    }
  } else {
    echo json_encode(['success' => false, 'error' => 'Missing required fields.']);
  }
  exit;
}
echo json_encode(['success' => false, 'error' => 'Invalid request.']);
exit;
