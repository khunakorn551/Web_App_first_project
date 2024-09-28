<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Past Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    // Start the session to access the client's ID
    session_start();

    // Include the DeliveryController class
    include '../controllers/Delivery.Controller.php';

    // Create a new instance of the DeliveryController class
    $deliveryController = new DeliveryController();

    // Check if the client is logged in
    if (isset($_SESSION['client_id'])) {
        // Get the client's ID from the session
        $clientId = $_SESSION['client_id'];

        // Get the client's past orders
        $orders = $deliveryController->getClientPastOrders($clientId);

        // Check if there are any past orders
        if ($orders) {
            ?>
            <!-- Display the past orders in a table -->
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <h1 class="text-center mb-4">Past Orders</h1>
                        <table class="table table-striped table-bordered border-dark">
                            <thead class="table-dark">
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
                    </div>
                </div>
            </div>
            <?php
        } else {
            ?>
            <!-- Display a message if there are no past orders -->
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <h1 class="text-center mb-4">No Past Orders Found</h1>
                        <p class="text-center">You do not have any past orders.</p>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        // Redirect the client to the login page if they are not logged in
        header("Location: client_login.php");
        exit;
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>