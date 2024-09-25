<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include '../Models/Delivery.Model.php';

// Initialize variables
$message = '';
$success = false;

if(isset($_POST['alogout'])) {
  $Signout = new DeliveryModel();
  $Signout->AdminsignOut();  
}

// Create a new instance of the DeliveryModel class
$update = new DeliveryModel();

// Check if the form has been submitted
if (isset($_POST['update_order'])) {
  $Order_ID = $_POST["order_id"];
  $Order_status = $_POST["order_status"];
  $client_id = $_POST["client_id"]; // Assuming you add a form field for client_id
  $driver_id = $_POST["driver_id"]; // Assuming you add a form field for driver_id

  if (!empty($driver_id) && is_numeric($driver_id) && !empty($client_id) && is_numeric($client_id)) { 
      $update->AdminUpdateOrder($Order_status, $Order_ID);
      $success = true;
      $message = "Order updated successfully!";
  } else {
      $success = false;
      if (empty($client_id) || !is_numeric($client_id)) {
          $message = "Invalid client ID provided.";
      } else if (empty($driver_id) || !is_numeric($driver_id)) {
          $message = "Invalid driver ID provided.";
      } 
  }
}

// Display error message
if (isset($message)) {
  echo "<p>$message</p>";
}
?>

<?php
// ... (rest of the PHP code remains the same)
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Order</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f9f9f9;
    }
    .container {
      max-width: 800px;
      margin: 40px auto;
      padding: 20px;
      background-color: #fff;
      border: 1px solid #ddd;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Update Order</h2>
    <form action="update_orders.php" method="POST">
      <div class="form-group">
        <label for="order_id">Enter Order ID:</label>
        <input type="text" id="order_id" name="order_id" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="client_id">Enter Client ID:</label>
        <input type="text" id="client_id" name="client_id" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="driver_id">Enter Driver ID:</label>
        <input type="text" id="driver_id" name="driver_id" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="order_status">Select Order Status:</label>
        <select id="order_status" name="order_status" class="form-control" required>
          <option value="pending">Pending</option>
          <option value="assigned">Assigned</option>
          <option value="in_process">In Process</option>
          <option value="delivered">Delivered</option>
          <option value="canceled">Canceled</option>
        </select>
      </div>
      <button type="submit" name="update_order" class="btn btn-primary">Submit</button>
    </form>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Client ID</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Retrieve data from database and display it in the table
        $orders = $update->getAllOrders();
        foreach ($orders as $order) {
          echo "<tr>";
          echo "<td>$order->order_id</td>";
          echo "<td>$order->client_id</td>";
          echo "<td>$order->status</td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>

    <div class="text-right">
      <a href="login.php" class="btn btn-danger" name="alogout">Logout</a>
    </div>
  </div>
</body>
</html>