<?php
session_start();
include('config/Db.php'); // Include your Db class file

// Validate the session
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'driver') {
    error_log("Invalid session");
    echo 'Driver ID not found in session or invalid role.';
    exit;
}

// Validate the user input
if (!isset($_POST['status']) || !in_array($_POST['status'], ['online', 'offline'])) {
    error_log("Invalid status");
    echo 'Invalid status or status not set.';
    exit;
}

$status = $_POST['status'];

try {
    // Create a new instance of Db class and get the connection
    $db = new Db();
    $pdo = $db->connect(); // Call the connect method to get the PDO object

    // Check if the database connection was successful
    if (!$pdo) {
        error_log("Database connection failed");
        throw new PDOException('Failed to connect to database.');
    }

    // Update the user's status in the database
    $sql = "UPDATE users SET status = ? WHERE user_id = ? AND role = 'driver'";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$status, $_SESSION['user_id']]);

    if ($result) {
        error_log("Driver status updated to: " . $status);
        echo 'Driver status updated to: ' . $status;
    } else {
        error_log("Failed to update driver status");
        echo 'Failed to update driver status.';
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo 'Error updating status: ' . $e->getMessage();
}
?>