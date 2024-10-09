<?php
session_start();
include '../Models/Delivery.Model.php';

// Ensure the user is logged in
if (!isset($_SESSION['key'])) {
    header("Location: login.php");
    exit;
}

// Instantiate the DeliveryModel object
$deliveryModel = new DeliveryModel();

// Fetch the drivers and clients to associate with the orders
$drivers = $deliveryModel->getDrivers();
$clients = $deliveryModel->getClients();

// Convert clients and drivers arrays to associative arrays for lookup
$clientsAssoc = [];
foreach ($clients as $client) {
    $clientsAssoc[$client->user_id] = $client->name;
}

$driversAssoc = [];
foreach ($drivers as $driver) {
    $driversAssoc[$driver->user_id] = $driver->name;
}

// Pagination logic
$limit = 5; // Set the number of records per page to 5
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch total number of records
$totalRecords = $deliveryModel->getTotalOrders(); // Ensure this returns the correct total count

// Calculate total pages based on the limit of 5 records per page
$totalPages = ceil($totalRecords / $limit);

// Fetch the order history (delivered or cancelled orders)
$orderHistory = $deliveryModel->getOrderHistory($limit, $offset);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order History</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f9f9f9;
        }
        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .sidebar {
            position: fixed;
            top: 65px;
            left: 0;
            bottom: 0;
            width: 200px;
            background-color: red;
            color: #fff;
            padding: 20px;
            overflow-y: auto;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
        }
        .sidebar a:hover {
            color: #ccc;
        }
        .main-content {
            margin-left: 220px;
            padding: 20px;
            margin-top: 65px;
        }
        .header {
            background-color: #2196F3;
            color: #fff;
            padding: 10px;
            text-align: center;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1;
            height: 65px;
        }
        .header h1 {
            font-size: 24px;
        }
        .footer {
            background-color: #2196F3;
            color: #fff;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .pagination .page-link {
            font-size: 18px;
            margin: 0 5px;
            padding: 8px 16px;
            border-radius: 5px;
            background-color: #f0f0f0;
            color: #337ab7;
            text-decoration: none;
        }
        .pagination .page-link:hover {
            background-color: #e0e0e0;
            color: #23527c;
        }
        .pagination .active .page-link {
            background-color: #337ab7;
            color: white;
            border-color: #337ab7;
        }
    </style>
</head>
<body>

<!-- Header -->
<div class="header">
    <h1>Delivery Management System - Order History</h1>
</div>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Menu</h2>
    <ul class="list-unstyled">
        <li><a href="admin_dashboard.php">Dashboard</a></li>
        <li><a href="create_order.php">Create Order</a></li>
        <li><a href="update_orders.php">Update Order</a></li>
        <li><a href="order_history.php">View Order History</a></li> <!-- New Menu Item -->
        <li><a href="login.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
    </ul>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="container mt-5">
        <h2 class="mb-4">Order History</h2>

        <?php if (empty($orderHistory)) { ?>
            <p class="alert alert-info">No order history found.</p>
        <?php } else { ?>
            <!-- Bootstrap Responsive Table -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="bg-primary">
                        <tr>
                            <th>Order ID</th>
                            <th>Client Name</th>
                            <th>Tracking Number</th>
                            <th>Status</th>
                            <th>Driver Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderHistory as $order) { ?>
                            <tr>
                                <td><?= htmlspecialchars($order->order_id) ?></td>
                                <td><?= htmlspecialchars($clientsAssoc[$order->client_id]) ?></td>
                                <td><?= htmlspecialchars($order->tracking_number) ?></td>
                                <td><?= htmlspecialchars(ucfirst($order->status)) ?></td>
                                <td><?= htmlspecialchars($driversAssoc[$order->driver_id]) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1) { ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <!-- Previous Page Link -->
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= max(1, $page - 1) ?>">Previous</a>
                        </li>
                        
                        <!-- Page Links -->
                        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php } ?>
                        
                        <!-- Next Page Link -->
                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= min($totalPages, $page + 1) ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            <?php } ?>
        <?php } ?>
    </div>
</div>

<!-- Footer -->
<div class="footer">
    <p>&copy; 2024 Delivery Management System</p>
</div>

</body>
</html>
