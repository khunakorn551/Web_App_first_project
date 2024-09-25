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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Order</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
                <button type="submit" class="btn btn-primary" name="updateOrder">Submit</button>
            </form>

            <h2 class="mt-5">Order History</h2>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Client ID</th>
                    <th>Status</th>
                    <th>Update Status At</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                // Loop through order history (assuming $orderHistory is an array of arrays)
                ?>
                </tbody>
            </table>

            <form id="logoutForm" method="post">
                <button type="submit" class="btn btn-danger" name="alogout">Logout</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>