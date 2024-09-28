<?php
session_start();
include '../Models/Delivery.Model.php';

if (!isset($_SESSION['key'])) {
    header("Location: login.php");
    exit;
}

$deliveryModel = new DeliveryModel();
$orders = $deliveryModel->getAssignedOrders($_SESSION['key']['user_id']);

?>

<!DOCTYPE html>
<html>
<head>
    <title>View Assigned Orders</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center mb-4">View Assigned Orders</h1>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Client ID</th>
                    <th>Status</th>
                    <th>Tracking Number</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($orders as $order) { ?>
                    <tr>
                        <td><?= $order['order_id'] ?></td>
                        <td><?= $order['client_id'] ?></td>
                        <td><?= $order['status'] ?></td>
                        <td><?= $order['tracking_number'] ?></td>
                        <td>
                            <a href="driver_update_status.php?order_id=<?= $order['order_id'] ?>">Update Status</a>
                        </td>
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