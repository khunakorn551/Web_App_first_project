<?php
session_start();
require 'Database.php'; // Assuming you have a Database.php file to handle connections

// Check if the driver is logged in
if (!isset($_SESSION['driver_id'])) {
    http_response_code(403);
    echo 'Unauthorized';
    exit;
}

$driver_id = $_SESSION['driver_id']; // Assuming the driver ID is stored in the session
$is_online = isset($_POST['isOnline']) ? (int) $_POST['isOnline'] : 0;

try {
    // Create a PDO connection
    $db = new Db();
    $pdo = $db->connect();

    // Update the driver's status in the database
    $stmt = $pdo->prepare('UPDATE drivers SET is_online = :is_online WHERE id = :driver_id');
    $stmt->execute([
        ':is_online' => $is_online,
        ':driver_id' => $driver_id
    ]);

    echo 'Status updated successfully';
} catch (PDOException $e) {
    echo 'Failed to update status: ' . $e->getMessage();
}
?>
