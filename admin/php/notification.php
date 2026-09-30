<?php
include 'db.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notifications</title>
    <link rel="stylesheet" href="../css/order_register.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="admin-layout d-flex">
        <nav class="sidebar bg-dark text-white p-3" style="min-width:220px;min-height:100vh;">
            <h4 class="mb-4">Anvaya</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a class="nav-link text-white" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item mb-2"><a class="nav-link text-white" href="order_page.php">Orders</a></li>
                <li class="nav-item mb-2"><a class="nav-link text-white" href="order_register.php">Order Register</a></li>
                <li class="nav-item mb-2"><a class="nav-link text-white" href="designer_page.php">Designers</a></li>
                <li class="nav-item mb-2"><a class="nav-link text-white" href="contact_requests.php">Contact Requests</a></li>
                <!-- <li class="nav-item mb-2"><a class="nav-link text-white active" href="notification.php">Notifications</a></li> -->
                <li class="nav-item mb-2"><a class="nav-link text-white" href="user_profile.php">User Profile</a></li>
            </ul>
        </nav>
        <div class="container main-content">
            <h2 class="mb-4 fw-bold text-center">Notifications</h2>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">New Order Placed</h5>
                    <p class="card-text">Order #106 placed by <strong>Rohit Mehra</strong>. <span class="badge bg-info">Just now</span></p>
                    <a href="order_page.php" class="btn btn-primary btn-sm">View Order</a>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Order Approved</h5>
                    <p class="card-text">Order #105 has been approved. <span class="badge bg-success">5 min ago</span></p>
                    <a href="order_page.php" class="btn btn-primary btn-sm">View Order</a>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Designer Assigned</h5>
                    <p class="card-text">Designer <strong>Priya Singh</strong> assigned to Order #104. <span class="badge bg-warning text-dark">10 min ago</span></p>
                    <a href="order_page.php" class="btn btn-primary btn-sm">View Order</a>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Order Delivered</h5>
                    <p class="card-text">Order #103 delivered to <strong>Michael Lee</strong>. <span class="badge bg-secondary">1 hour ago</span></p>
                    <a href="order_page.php" class="btn btn-primary btn-sm">View Order</a>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Contact Request Received</h5>
                    <p class="card-text">New contact request from <strong>Amit Verma</strong>. <span class="badge bg-primary">2 hours ago</span></p>
                    <a href="contact_requests.php" class="btn btn-outline-primary btn-sm">View Request</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
