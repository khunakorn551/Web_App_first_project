<?php
session_start();
include '../Models/Delivery.Model.php';

if (!isset($_SESSION['key'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderId = $_POST['orderId'];
    $newStatus = $_POST['newStatus'];

    $deliveryModel = new DeliveryModel();

    try {
        $deliveryModel->updateOrderStatus($orderId, $newStatus);
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>
