<?php

    session_start();
    include '../Models/Delivery.Model.php';

    if(!isset($_SESSION['key'])) {
        header("Location:login.php");
    }

    if(isset($_POST['logout'])) {
         $Signout = new DeliveryModel();
         $Signout->ClientsignOut();
    }

    if(isset($_POST['cart'])) {
        $cart = new DeliveryModel();
        
    }

    

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="display-5">Client Dashboard</h1>
        <form id="login-form">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" class="form-control">
            </div>
            <div class="mb-3">
                <label for="order-number" class="form-label">Order Number:</label>
                <input type="text" id="order-number" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <div id="order-status" class="mt-5">
            <h2>Order Status</h2>
            <table id="order-status-table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Order ID</th>
                        <th scope="col">Order Status</th>
                        <th scope="col">Order Details</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- order status will be rendered here -->
                </tbody>
            </table>
        </div>

        <div id="order-history" class="mt-5">
            <h2>Order History</h2>
            <table id="order-history-table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Order ID</th>
                        <th scope="col">Order Date</th>
                        <th scope="col">Order Status</th>
                        <th scope="col">View Order Details</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- order history will be rendered here -->
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>