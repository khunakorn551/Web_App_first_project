<?php
// Include your database connection file
include '../Models/Delivery.Model.php';

// Create a new instance of the DeliveryModel class
$update = new DeliveryModel();

// Add the update_status_at column to the orders table
$sql = "ALTER TABLE orders ADD COLUMN update_status_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$stmt = $update->connect()->prepare($sql);
$stmt->execute();

echo "Column added successfully!";
?>