<?php
session_start();
include '../controllers/Delivery.Controller.php';

$deliveryController = new DeliveryController();

// Check if client ID is set in the session
if (!isset($_SESSION['client_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['track_order'])) {
    $order_id = $_POST['order_id'];
    $tracking_number = $_POST['tracking_number'];

    $order_details = $deliveryController->getClientOrderDetails($order_id, $tracking_number);

    if ($order_details) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Order Tracking</title>
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
                <li><a href="login.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <h1 class="text-center mb-4">Order Tracking</h1>
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Tracking Number</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?= $order_details['order_id'] ?></td>
                                <td><?= $order_details['tracking_number'] ?></td>
                                <td><?= $order_details['status'] ?></td>
                            </tr>
                            </tbody>
                        </table>
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
        </body>
        </html>
        <?php
    } else {
        echo "Order not found";
    }
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Track Order</title>
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
            <li><a href="login.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <h1 class="text-center mb-4">Track Order</h1>
                    <form action="track_order.php" method="post">
                        <div class="form-group">
                            <label for="order_id">Order ID:</label>
                            <input type="text" class="form-control" name="order_id" required>
                        </div>
                        <div class="form-group">
                            <label for="tracking_number">Tracking Number:</label>
                            <input type="text" class="form-control" name="tracking_number" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="track_order">Track Order</button>
                    </form>
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
    </body>
    </html>
    <?php
}