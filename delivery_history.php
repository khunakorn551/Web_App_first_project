<?php
session_start();
include '../Models/Delivery.Model.php';

if (!isset($_SESSION['key'])) {
    header("Location: login.php");
    exit;
}

$deliveryModel = new DeliveryModel();
$clients = $deliveryModel->getClients();

// Pagination for Delivered Orders
$limit = 5; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch delivered orders for the logged-in driver with pagination
$deliveredOrders = $deliveryModel->getDeliveredOrders($_SESSION['key']['user_id'], $limit, $offset);

// Fetch total number of delivered orders for pagination calculation
$totalDeliveredOrders = $deliveryModel->getTotalDeliveredOrders($_SESSION['key']['user_id']);

// Calculate total pages, ensure at least 1 page is displayed even if no orders are found
$totalPages = ($totalDeliveredOrders > 0) ? ceil($totalDeliveredOrders / $limit) : 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery History</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
        }
        .sidebar {
            position: fixed;
            top: 50px;
            left: 0;
            bottom: 0;
            width: 200px;
            background-color: red;
            color: #fff;
            padding: 20px;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
        }
        .sidebar a:hover {
            color: #ccc;
        }
        .main-content {
            margin-left: 200px;
            padding: 20px;
            margin-top: 50px;
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
        .header h2 {
            margin: 0;
            color: #fff;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        footer {
            background-color: #2196F3;
            color: #fff;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>Delivery History</h2>
</div>

<div class="sidebar">
    <h2>Menu</h2>
    <ul>
        <li><a href="driver_dashboard.php">Dashboard</a></li>
        <li><a href="view_assigned_order.php">View Assigned Orders</a></li>
        <li><a href="delivery_history.php">Delivery History</a></li> <!-- Link for Delivery History -->
        <li><a href="login.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1 class="text-center mb-4">Delivered Orders</h1>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Client</th>
                        <th>Status</th>
                        <th>Tracking Number</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($deliveredOrders)): ?>
                        <tr>
                            <td colspan="4" class="text-center">No delivered orders found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($deliveredOrders as $order) { ?>
                            <tr>
                                <td><?= htmlspecialchars($order['order_id']) ?></td>
                                <td>
                                    <?php 
                                    $clientName = '';
                                    foreach ($clients as $client) {
                                        if ($client->user_id == $order['client_id']) {
                                            $clientName = $client->name;
                                            break;
                                        }
                                    }
                                    echo htmlspecialchars($clientName);
                                    ?>
                                </td>
                                <td><?= htmlspecialchars($order['status']) ?></td>
                                <td><?= htmlspecialchars($order['tracking_number']) ?></td>
                            </tr>
                        <?php } ?>
                    <?php endif; ?>
                    </tbody>
                </table>

                <!-- Pagination for Delivered Orders -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <!-- Previous Link -->
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="<?= ($page <= 1) ? '#' : 'delivery_history.php?page=' . ($page - 1) ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo; Previous</span>
                            </a>
                        </li>

                        <!-- Page Number Links -->
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                <a class="page-link" href="delivery_history.php?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <!-- Next Link -->
                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="<?= ($page >= $totalPages) ? '#' : 'delivery_history.php?page=' . ($page + 1) ?>" aria-label="Next">
                                <span aria-hidden="true">Next &raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>
    </div>
</div>

<footer>
    <p>&copy; 2024 Delivery Management System</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
