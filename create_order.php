<?php
session_start();
include '../Models/Delivery.Model.php';

if (!isset($_SESSION['key'])) {
    header("Location: login.php");
    exit;
}

$deliveryModel = new DeliveryModel();
$drivers = $deliveryModel->getDrivers();
$orders = $deliveryModel->getOrders();

if (isset($_POST['createOrder'])) {
    $clientId = $_POST['clientId'];
    $trackingNumber = $_POST['trackingNumber'];
    $status = $_POST['status'];
    $driverId = $_POST['driverId'];

    $deliveryModel->createOrder($clientId, $trackingNumber, $status, $driverId);
    header("Location: create_order.php?message=Order created successfully");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Order</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center mb-4">Create Order</h1>
            <?php if (isset($_GET['message'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?= $_GET['message'] ?>
                </div>
            <?php } ?>
            <form action="create_order.php" method="post">
                <div class="form-group">
                    <label for="clientId">Client ID:</label>
                    <input type="text" class="form-control" id="clientId" name="clientId" required>
                </div>
                <div class="form-group">
                    <label for="trackingNumber">Tracking Number:</label>
                    <input type="text" class="form-control" id="trackingNumber" name="trackingNumber" required>
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select class="form-control" id="status" name="status">
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="driverId">Assign Driver:</label>
                    <select class="form-control" id="driverId" name="driverId">
                        <?php foreach ($drivers as $driver) { ?>
                            <option value="<?= $driver->user_id ?>"><?= $driver->name ?></option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" name="createOrder">Create Order</button>
            </form>
            <h2 class="text-center mt-5">Orders</h2>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Client ID</th>
                    <th>Tracking Number</th>
                    <th>Status</th>
                    <th>Driver ID</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($orders as $order) { ?>
                    <tr>
                        <td><?= $order->order_id ?></td>
                        <td><?= $order->client_id ?></td>
                        <td><?= $order->tracking_number ?></td>
                        <td><?= $order->status ?></td>
                        <td><?= $order->driver_id ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>