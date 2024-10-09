<?php
session_start();
if (isset($_POST['status'])) {
    $_SESSION['status'] = $_POST['status'];
    echo 'Session status updated to: ' . $_SESSION['status'];
} else {
    echo 'Invalid status or status not set.';
}
?>