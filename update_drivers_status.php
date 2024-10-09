<?php
session_start();
include '../Models/DeliveryModel.php'; // Ensure this is the correct path to your model

// Check if the driver is logged in
if (!isset($_SESSION['driver_id'])) {
    http_response_code(403); // Unauthorized access
    exit;
}

// Check if the status and driver_id are sent via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status']) && isset($_POST['driver_id'])) {
    $status = $_POST['status'];
    $driver_id = $_POST['driver_id']; // Use driver_id for accuracy

    // Initialize the DeliveryModel
    $model = new DeliveryModel();

    // Call the updateDriverStatus method
    if ($model->updateDriverStatus($driver_id, $status)) {
        echo "Status updated successfully";
    } else {
        http_response_code(500); // Internal Server Error
        echo "Failed to update status";
    }
} else {
    http_response_code(400); // Bad request
    echo "Invalid request";
}
?>
