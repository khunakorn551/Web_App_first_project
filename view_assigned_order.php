<?php
session_start();
include '../Models/Delivery.Model.php';

if (!isset($_SESSION['key'])) {
    header("Location: login.php");
    exit;
}

$deliveryModel = new DeliveryModel();
$clients = $deliveryModel->getClients();

// Pagination
$limit = 5; // Number of records per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch assigned orders for the logged-in driver
$orders = $deliveryModel->getAssignedOrders($_SESSION['key']['user_id'], $limit, $offset);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Assigned Orders</title>
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
        .pagination a {
            font-size: 18px;
            margin: 0 5px;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #f0f0f0;
            text-decoration: none;
            color: #337ab7;
        }
        .pagination a:hover {
            background-color: #e0e0e0;
            color: #23527c;
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
    <h2>Driver Dashboard</h2>
</div>

<div class="sidebar">
    <h2>Menu</h2>
    <ul>
        <li><a href="driver_dashboard.php">Dashboard</a></li>
        <li><a href="view_assigned_order.php">View Assigned Orders</a></li>
        <li><a href="delivery_history.php">Delivery History</a></li> <!-- New link -->
        <li><a href="login.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
    </ul>
</div>


<div class="main-content">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1 class="text-center mb-4">View Assigned Orders</h1>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Client</th>
                        <th>Status</th>
                        <th>Tracking Number</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($orders as $order) { ?>
                        <tr>
                            <td><?= $order['order_id'] ?></td>
                            <td>
                                <?php 
                                $clientName = '';
                                foreach ($clients as $client) {
                                    if ($client->user_id == $order['client_id']) {
                                        $clientName = $client->name;
                                        break;
                                    }
                                }
                                echo $clientName;
                                ?>
                            </td>
                            <td><?= $order['status'] ?></td>
                            <td><?= $order['tracking_number'] ?></td>
                            <td>
                                <a href="driver_update_status.php?order_id=<?= $order['order_id'] ?>" class="btn btn-primary">Update Status</a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination">
                    <?php
                    $totalOrders = $deliveryModel->getTotalAssignedOrders($_SESSION['key']['user_id']);
                    $totalPages = ceil($totalOrders / $limit);
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo "<a href='view_assigned_order.php?page=$i#orders'>$i</a> ";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <p>&copy; 2023 Delivery Management System</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Smooth Scrolling to Orders Section -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    if (window.location.hash === '#orders') {
        document.getElementById('orders').scrollIntoView({ behavior: 'smooth' });
    }
});
</script>

</body>
</html>
