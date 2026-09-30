<?php
// update_empty_order_status.php
// Run this script once to update all orders with empty or NULL status to 'order_received'.

include 'db.php';

$sql = "UPDATE orders SET status = 'order_received' WHERE status IS NULL OR status = ''";
if ($conn->query($sql) === TRUE) {
  echo "Order statuses updated successfully.";
} else {
  echo "Error updating order statuses: " . $conn->error;
}
