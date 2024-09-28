<?php
session_start();
include '../Models/Delivery.Model.php';

if (!isset($_SESSION['key'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['alogout'])) {
    $Signout = new DeliveryModel();
    $Signout->DriversignOut();
}

if (isset($_POST['updateOrder'])) {
    $deliveryController = new DeliveryController();
    $orderId = filter_var($_POST['orderId'], FILTER_SANITIZE_NUMBER_INT);
    $orderStatus = filter_var($_POST['orderStatus'], FILTER_SANITIZE_STRING);
    try {
        $deliveryController->updateOrderStatus($orderId, $orderStatus);
        $message = "Order status updated successfully";
    } catch (Exception $e) {
        $message = "Error updating order status: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Order</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center mb-4">Update Order</h1>
            <form id="updateOrderForm" method="post">
                <div class="form-group">
                    <label for="orderId">Enter Order ID:</label>
                    <input type="text" class="form-control" id="orderId" name="orderId" required />
                </div>
                <div class="form-group">
                    <label for="orderStatus">Select Order Status:</label>
                    <select class="form-control" id="orderStatus" name="orderStatus">
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2" name="updateOrder">Submit</button>
                    <form id="logoutForm" method="post">
                        <button type="submit" class="btn btn-danger" name="alogout">Logout</button>
                    </form>
                </div>
            </form>

            <?php if (isset($message)) { ?>
                <div class="alert alert-success" role="alert">
                    <?= $message ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>