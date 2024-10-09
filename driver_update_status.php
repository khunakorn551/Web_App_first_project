<?php
session_start();
include '../Models/Delivery.Model.php';

if (!isset($_SESSION['key'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $deliveryModel = new DeliveryModel();
    $order = $deliveryModel->getOrderById($order_id);

    if ($order) {
        ?>
        <html>
            <head>
                <title>Update Order Status</title>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
            </head>
            <body>
                <div class="container">
                    <h1>Update Order Status</h1>
                    <form action="driver_update_status.php" method="post">
                        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select name="status" class="form-control">
                                <option value="Pending">Pending</option>
                                <option value="Processing">Processing</option>
                                <option value="Shipped">Shipped</option>
                                <option value="Delivered">Delivered</option>
                                <option value="Canceled">Canceled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </form>
                </div>
            </body>
        </html>
        <?php
    } else {
        echo "Order not found";
    }
} elseif (isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];

    $deliveryModel = new DeliveryModel();
    $result = $deliveryModel->updateOrderStatus($order_id, $new_status);

    if ($result) {
        ?>
        <html>
            <head>
                <title>Order Status Updated</title>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
            </head>
            <body>
                <div class="container">
                    <h1>Order Status Updated</h1>
                    <div class="alert alert-success">
                        Order status updated successfully!
                    </div>
                </div>
            </body>
        </html>
        <?php
        header("Refresh:1; url=view_assigned_order.php");
        exit;
    } else {
        echo "Error updating order status";
    }
} else {
    echo "No order ID provided";
}
?>