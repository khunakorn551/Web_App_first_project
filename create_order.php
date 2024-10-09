<?php
session_start();
include '../Models/Delivery.Model.php';

// Enable error reporting for debugging (you can disable this in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['key'])) {
    header("Location: login.php");
    exit;
}

// Instantiate the DeliveryModel object
$deliveryModel = new DeliveryModel();

// Fetch drivers and clients
$drivers = $deliveryModel->getDrivers();
$clients = $deliveryModel->getClients();

// Convert clients and drivers arrays to associative arrays for faster lookup
$clientsAssoc = [];
foreach ($clients as $client) {
    $clientsAssoc[$client->user_id] = $client->name;
}

$driversAssoc = [];
foreach ($drivers as $driver) {
    $driversAssoc[$driver->user_id] = $driver->name;
}

// Pagination and search/filter handling
$limit = 5; // Number of records per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$searchQuery = '';
$statusFilter = '';
if (isset($_GET['search'])) {
    $searchQuery = trim($_GET['search']);
}
if (isset($_GET['status'])) {
    $statusFilter = trim($_GET['status']);
}

// Fetch orders
$orders = $deliveryModel->getOrders($limit, $offset, $searchQuery, $statusFilter);

// Create Order
if (isset($_POST['createOrder'])) {
    $clientId = $_POST['clientId'];
    $trackingNumber = 'DLV-' . date('Ymd') . '-' . str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
    $status = $_POST['status'];
    $driverId = $_POST['driverId'];

    try {
        $deliveryModel->createOrder($clientId, $trackingNumber, $status, $driverId);
        header("Location: create_order.php?message=Order created successfully");
        exit;
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
        echo "<div class='alert alert-danger' role='alert'>$errorMessage</div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Order</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f9f9f9;
        }
        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .pagination a, .pagination .page-link {
            font-size: 18px;
            margin: 0 5px;
            padding: 8px 16px;
            border-radius: 5px;
            background-color: #f0f0f0;
            text-decoration: none;
            color: #337ab7;
        }
        .pagination a:hover, .pagination .page-link:hover {
            background-color: #e0e0e0;
            color: #23527c;
        }
        .sidebar {
            position: fixed;
            top: 65px;
            left: 0;
            bottom: 0;
            width: 200px;
            background-color: red;
            color: #fff;
            padding: 20px;
            overflow-y: auto;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
        }
        .sidebar a:hover {
            color: #ccc;
        }
        .main-content {
            margin-left: 220px;
            padding: 20px;
            margin-top: 65px;
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
        .footer {
            background-color: #2196F3;
            color: #fff;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        table {
            width: 100%;
            font-size: 18px;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 15px;
            text-align: center;
        }
        table th {
            background-color: #f2f2f2;
        }
        table td {
            background-color: #fff;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Delivery Management System</h1>
</div>

<div class="sidebar">
    <h2>Menu</h2>
    <ul class="list-unstyled">
        <li><a href="admin_dashboard.php">Dashboard</a></li>
        <li><a href="create_order.php">Create Order</a></li>
        <li><a href="update_orders.php">Update Order</a></li>
        <li><a href="order_history.php">View Order History</a></li>
        <li><a href="login.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
    </ul>

    <!-- Separate Search Form -->
    <form method="GET" action="create_order.php" class="mt-4">
        <div class="form-group">
            <label for="search">Search by Order ID:</label>
            <input type="text" name="search" class="form-control" placeholder="Enter Order ID" value="<?= htmlspecialchars($searchQuery) ?>">
        </div>
        <button class="btn btn-light btn-block" type="submit">Search</button>
    </form>

    <!-- Separate Filter Form -->
    <form method="GET" action="create_order.php" class="mt-4">
        <div class="form-group">
            <label for="status">Filter by Status:</label>
            <select name="status" class="form-control">
                <option value="">All</option>
                <option value="pending" <?= $statusFilter === 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="processing" <?= $statusFilter === 'processing' ? 'selected' : '' ?>>Processing</option>
                <option value="shipped" <?= $statusFilter === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                <option value="delivered" <?= $statusFilter === 'delivered' ? 'selected' : '' ?>>Delivered</option>
                <option value="cancelled" <?= $statusFilter === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
            </select>
        </div>
        <button class="btn btn-light btn-block" type="submit">Filter</button>
    </form>
</div>

<div class="main-content">
    <div class="container mt-5">
        <!-- Display Success Message -->
        <?php if (isset($_GET['message'])) { ?>
            <div class="alert alert-success" role="alert">
                <?= htmlspecialchars($_GET['message']) ?>
            </div>
        <?php } ?>

        <!-- Create Order Form -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Create Order</h2>
                <form action="create_order.php" method="post">
                    <div class="form-group">
                        <label for="clientId">Client:</label>
                        <select class="form-control" id="clientId" name="clientId" required>
                            <option value="" disabled selected>Select Client</option>
                            <?php foreach ($clients as $client) { ?>
                                <option value="<?= htmlspecialchars($client->user_id) ?>"><?= htmlspecialchars($client->name) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="trackingNumber">Tracking Number:</label>
                        <input type="text" class="form-control" id="trackingNumber" name="trackingNumber" value="<?= 'DLV-' . date('Ymd') . '-' . str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT) ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="driverId">Assign Driver:</label>
                        <select class="form-control" id="driverId" name="driverId" required>
                            <option value="" disabled selected>Select Driver</option>
                            <?php foreach ($drivers as $driver) { ?>
                                <option value="<?= htmlspecialchars($driver->user_id) ?>"><?= htmlspecialchars($driver->name) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" name="createOrder">Create Order</button>
                </form>
            </div>
        </div>

        <hr>

        <!-- Orders List -->
        <h2 class="mt-5">Orders List</h2>

        <?php if (empty($orders)) { ?>
            <p>No orders found.</p>
        <?php } else { ?>
            <table class="table table-striped" id="orders">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Client Name</th>
                        <th>Tracking Number</th>
                        <th>Status</th>
                        <th>Driver Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order) { ?>
                        <tr>
                            <td><?= htmlspecialchars($order->order_id) ?></td>
                            <td>
                                <?php
                                if (isset($clientsAssoc[$order->client_id])) {
                                    echo htmlspecialchars($clientsAssoc[$order->client_id]);
                                } else {
                                    echo 'N/A';
                                }
                                ?>
                            </td>
                            <td><?= htmlspecialchars($order->tracking_number) ?></td>
                            <td>
                                <!-- Inline status update dropdown -->
                                <select class="form-control status-dropdown" data-order-id="<?= htmlspecialchars($order->order_id) ?>">
                                    <option value="pending" <?= $order->status === 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="processing" <?= $order->status === 'processing' ? 'selected' : '' ?>>Processing</option>
                                    <option value="shipped" <?= $order->status === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                    <option value="delivered" <?= $order->status === 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                    <option value="cancelled" <?= $order->status === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                            </td>
                            <td>
                                <?php
                                if (isset($driversAssoc[$order->driver_id])) {
                                    echo htmlspecialchars($driversAssoc[$order->driver_id]);
                                } else {
                                    echo 'N/A';
                                }
                                ?>
                            </td>
                            <td><button class="btn btn-primary btn-sm update-status-btn" data-order-id="<?= htmlspecialchars($order->order_id) ?>">Update</button></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <?php
            $totalRecords = $deliveryModel->getTotalOrders($searchQuery, $statusFilter);
            $totalPages = ceil($totalRecords / $limit);
            if ($totalPages > 1):
            ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <!-- Previous Page Link -->
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= max(1, $page - 1) ?>&search=<?= urlencode($searchQuery) ?>&status=<?= urlencode($statusFilter) ?>#orders">Previous</a>
                        </li>
                        <!-- Page Number Links -->
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($searchQuery) ?>&status=<?= urlencode($statusFilter) ?>#orders"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <!-- Next Page Link -->
                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= min($totalPages, $page + 1) ?>&search=<?= urlencode($searchQuery) ?>&status=<?= urlencode($statusFilter) ?>#orders">Next</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        <?php } ?>
    </div>
</div>

<div class="footer">
    <p>&copy; 2024 Delivery Management System</p>
</div>

<!-- Smooth Scrolling to Orders Section -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    // Handle the status update without refreshing the page
    $('.update-status-btn').on('click', function() {
        var orderId = $(this).data('order-id');
        var newStatus = $(this).closest('tr').find('.status-dropdown').val();

        $.ajax({
            url: 'update_order_status.php',
            type: 'POST',
            data: {
                orderId: orderId,
                newStatus: newStatus
            },
            success: function(response) {
                alert('Order status updated successfully!');
            },
            error: function() {
                alert('Error updating order status. Please try again.');
            }
        });
    });
</script>

</body>
</html>
