<?php
session_start();
include('config/Database.php'); // Include your Db class file

// Validate the session
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'driver') {
    error_log("Invalid session");
    echo 'Driver ID not found in session or invalid role.';
    exit;
}

try {
    // Create a new instance of Db class and get the connection
    $db = new Db();
    $pdo = $db->connect(); // Call the connect method to get the PDO object

    // Check if the database connection was successful
    if (!$pdo) {
        error_log("Database connection failed");
        throw new PDOException('Failed to connect to database.');
    }

    // Get the current driver status from the database
    $sql = "SELECT status FROM users WHERE user_id = ? AND role = 'driver'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['user_id']]);
    $row = $stmt->fetch();

    if ($row) {
        echo $row['status'];
    } else {
        echo 'offline';
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo 'Error getting driver status: ' . $e->getMessage();
}
?>