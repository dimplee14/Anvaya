<?php
// include("db.php");

// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//     $orderId = $_POST['order_id'];
//     $fullname = $_POST['fullname'];
//     $phone = $_POST['phone'];
//     $address = $_POST['address'];
//     $payment = $_POST['payment'];

//     // ✅ Save delivery + payment info & update status
//     $stmt = $conn->prepare("UPDATE orders SET fullname=?, phone=?, address=?, payment_method=?, status='Order Confirmed' WHERE id=?");
//     $stmt->bind_param("ssssi", $fullname, $phone, $address, $payment, $orderId);

//     if ($stmt->execute()) {
//         echo json_encode(["success" => true, "status" => "Order Confirmed"]);
//     } else {
//         echo json_encode(["success" => false, "error" => $conn->error]);
//     }
// }
?>