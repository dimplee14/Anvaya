<?php

// DEBUG: Show all errors for troubleshooting
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';
header('Content-Type: application/json');
if (!isset($conn) || !$conn || $conn->connect_error) {
  echo json_encode([
    'reviews' => [],
    'error' => 'Database connection error',
    'conn' => isset($conn) ? $conn->connect_error : 'not set'
  ]);
  exit();
}

// Join reviews with users to get customer name
$sql = "SELECT r.review_text AS review, r.rating, r.photo AS photo_path, r.created_at, CONCAT(u.first_name, ' ', u.last_name) AS customer_name FROM reviews r JOIN users u ON r.user_id = u.user_id WHERE r.review_text IS NOT NULL AND r.review_text != '' AND r.rating IS NOT NULL AND r.photo IS NOT NULL AND r.photo != '' AND r.created_at IS NOT NULL ORDER BY r.created_at DESC LIMIT 3";
$result = $conn->query($sql);
$reviews = [];
if ($result) {
  while ($row = $result->fetch_assoc()) {
    $reviews[] = $row;
  }
} else {
  echo json_encode([
    'reviews' => [],
    'error' => 'Query failed',
    'sql' => $sql,
    'db_error' => $conn->error
  ]);
  exit();
}
echo json_encode(['reviews' => $reviews]);
exit();
