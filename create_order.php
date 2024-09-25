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

if (isset($_POST['Create_Order'])) {
    // Retrieve form data
    $client_id = $_POST["Client_ID"];
    $tracking_number = $_POST["Tracking_NO"];
    $status = $_POST["Status"];
    $driver_id = $_POST["Driver_ID"];

    

    if ($client_id > 0 && $driver_id > 0) {
        // Proceed if both client and driver exist
        $model = new DeliveryModel();
        $model->AdminAddOrder($client_id, $tracking_number, $status, $driver_id);
        $success = true;
        $message = "Order created successfully!";
    } else {
        $success = false;
        if ($client_id == 0) {
            $message = "The specified client ID does not exist or is not assigned the role of 'client'.";
        } else if ($driver_id == 0) {
            $message = "The specified driver ID does not exist or is not assigned the role of 'driver'.";
        }
    }
    
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create New Order</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Create New Order</h2>
        
        <!-- Display message if available -->
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $success ? 'success' : 'danger'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="client_id">Client ID:</label>
                <input type="number" class="form-control" id="client_id" name="Client_ID" required>
            </div>
            <div class="form-group">
                <label for="tracking_number">Tracking Number:</label>
                <input type="text" class="form-control" id="tracking_number" name="Tracking_NO" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="Status" required>
                    <option value="pending">Pending</option>
                    <option value="assigned">Assigned</option>
                    <option value="in_process">In Process</option>
                    <option value="delivered">Delivered</option>
                    <option value="canceled">Canceled</option>
                </select>
            </div>
            <div class="form-group">
                <label for="driver_id">Assign Driver:</label>
                <input type="number" class="form-control" id="driver_id" name="Driver_ID" required>
            </div>
            
            <button type="submit" class="btn btn-primary" name="Create_Order">Create Order</button>
        </form>
        
        <div class="text-right mt-3">
            <a href="login.php" class="btn btn-danger" name="alogout">Logout</a>
        </div>
    </div>
</body>
</html>