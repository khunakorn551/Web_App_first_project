<?php
session_start();
include '../controllers/Delivery.Controller.php';

$deliveryController = new DeliveryController();

// Check if client ID is set in the session
if (!isset($_SESSION['client_id'])) {
    header("Location: login.php");
    exit;
}

// Pagination for current orders
$current_limit = 5; // Number of records per page for current orders
$current_page = isset($_GET['current_page']) ? $_GET['current_page'] : 1;
$current_offset = ($current_page - 1) * $current_limit;

$orders = $deliveryController->getClientOrders($_SESSION['client_id'], $current_limit, $current_offset);

// Pagination for past orders
$history_limit = 5; // Number of records per page for order history
$history_page = isset($_GET['history_page']) ? $_GET['history_page'] : 1;
$history_offset = ($history_page - 1) * $history_limit;

$pastOrders = $deliveryController->getClientPastOrders($_SESSION['client_id'], $history_limit, $history_offset);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Orders</title>
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
    <h2>Client Dashboard</h2>
</div>

<div class="sidebar">
    <h2>Menu</h2>
    <ul>
        <li><a href="client_dashboard.php">View Orders</a></li>
        <li><a href="track_order.php">Track Order</a></li>
        <li><a href="#order-history" id="scroll-to-history">Order History</a></li> <!-- Scroll to Order History -->
        <li><a href="login.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1 class="text-center mb-4">Client Orders</h1>
                <div class="text-left mb-3">
                    <a href="track_order.php" class="btn btn-primary" name="trackorder">Track Order</a>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Tracking Number</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($orders as $order) { ?>
                        <tr>
                            <td><?= $order['order_id'] ?></td>
                            <td><?= $order['tracking_number'] ?></td>
                            <td><?= $order['status'] ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <div class="pagination">
                    <?php
                    $totalOrders = $deliveryController->getTotalClientOrders($_SESSION['client_id']);
                    $totalPages = ceil($totalOrders / $current_limit);
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo "<a href='client_dashboard.php?current_page=$i'>$i</a> ";
                    }
                    ?>
                </div>

                <h1 class="text-center mb-4 mt-5" id="order-history">Order History</h1> <!-- Order History Section -->
                <?php if ($pastOrders) { ?>
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Tracking Number</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($pastOrders as $pastOrder) { ?>
                            <tr>
                                <td><?= $pastOrder['order_id'] ?></td>
                                <td><?= $pastOrder['tracking_number'] ?></td>
                                <td><?= $pastOrder['status'] ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <div class="pagination">
                        <?php
                        $totalPastOrders = $deliveryController->getTotalClientPastOrders($_SESSION['client_id']);
                        $totalPastPages = ceil($totalPastOrders / $history_limit);
                        for ($i = 1; $i <= $totalPastPages; $i++) {
                            echo "<a href='client_orders.php?history_page=$i'>$i</a> ";
                        }
                        ?>
                    </div>
                <?php } else { ?>
                    <p class="text-center">No past orders recorded.</p>
                <?php } ?>
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

<!-- Smooth Scrolling Script -->
<script>
    document.getElementById('scroll-to-history').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('order-history').scrollIntoView({ behavior: 'smooth' });
    });
</script>

</body>
</html>
