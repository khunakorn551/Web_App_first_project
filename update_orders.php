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
  $client_name = $_POST["client_name"];
  $driver_name = $_POST["driver_name"];

  // Retrieve client ID and driver ID from database
  $client_id = $update->getClientIdByName($client_name);
  $driver_id = $update->getDriverIdByName($driver_name);

  if (!empty($client_id) && !empty($driver_id)) {
    $update->AdminUpdateOrder($Order_status, $Order_ID, $client_id, $driver_id);
    $success = true;
    $message = "Order updated successfully!";
  } else {
    $success = false;
    if (empty($client_id)) {
      $message = "Invalid client name provided.";
    } else if (empty($driver_id)) {
      $message = "Invalid driver name provided.";
    }
  }
}

// Display error message
if (isset($message)) {
  echo "<p>$message</p>";
}

// pagination
$limit = 6; // number of records per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$orders = $update->getAllOrders($limit, $offset);

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
    .pagination a {
      font-size: 18px; /* adjust the font size to your liking */
      margin: 0 5px; /* add some spacing between links */
      padding: 5px 10px; /* add some padding to make the links more prominent */
      border-radius: 5px; /* add a subtle border radius */
      background-color: #f0f0f0; /* add a light background color */
      text-decoration: none; /* remove the underline */
      color: #337ab7; /* use a darker blue color for the links */
    }
    .pagination a:hover {
      background-color: #e0e0e0; /* change the background color on hover */
      color: #23527c; /* change the text color on hover */
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
        <label for="client_name">Select Client Name:</label>
        <select id="client_name" name="client_name" class="form-control" required>
          <?php
          // Retrieve client names from database and display them as options
          $client_names = $update->getClientNames();
          foreach ($client_names as $client_name) {
            echo "<option value='$client_name'>$client_name</option>";
          }
          ?>
        </select>
      </div>
      <div class="form-group">
        <label for="driver_name">Select Driver Name:</label>
        <select id="driver_name" name="driver_name" class="form-control" required>
          <?php
          // Retrieve driver names from database and display them as options
          $driver_names = $update->getDriverNames();
          foreach ($driver_names as $driver_name) {
            echo "<option value='$ driver_name'>$driver_name</option>";
          }
          ?>
        </select>
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
      <button type="submit" name="update_order" class=" btn btn-primary">Submit</button>
    </form>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Client Name</th>
          <th>Driver Name</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Retrieve data from database and display it in the table
        foreach ($orders as $order) {
          echo "<tr>";
          echo "<td>$order->order_id</td>";
          echo "<td>$order->client_name</td>";
          echo "<td>$order->driver_name</td>";
          echo "<td>$order->status</td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>

    <div class="pagination">
      <?php
      $total_orders = $update->getTotalOrders();
      $total_pages = ceil($total_orders / $limit);
      for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='update_orders.php?page=$i'>$i</a> ";
      }
      ?>
    </div>

    <div class="text-left">
      <a href="login.php" class="btn btn-danger" name="alogout">Logout</a>
    </div>
  </div>
</body>
</html>