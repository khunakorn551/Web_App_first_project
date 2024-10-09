<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Driver Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f5f5f5;
    }

    .sidebar {
      position: fixed;
      top: 50px;
      left: 0;
      bottom: 0;
      width: 200px;
      background-color: red;
      color: #fff;
      padding: 20px;
    }
    .sidebar a {
      color: #fff;
      text-decoration: none;
      display: block;
      margin-bottom: 10px;
    }
    .sidebar a:hover {
      color: #ccc;
    }

    .main-content {
      margin-left: 200px;
      padding: 20px;
      margin-top: 50px;
    }

    .header {
      background-color: #2196F3;
      color: #fff;
      padding: 10px;
      text-align: center;
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1;
      height: 65px;
    }
    .header h2 {
      margin: 0;
      color: #fff;
    }

    .container {
      max-width: 800px;
      margin: 40px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .quick-access {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      padding: 20px;
    }

    .quick-access a {
      background-color: #2196F3;
      color: #fff;
      text-decoration: none;
      padding: 15px 30px;
      border-radius: 5px;
      margin: 10px;
      cursor: pointer;
    }
    .quick-access a:hover {
      background-color: #1976D2;
    }

    footer {
      background-color: #2196F3;
      color: #fff;
      padding: 10px;
      text-align: center;
      position: fixed;
      bottom: 0;
      width: 100%;
    }
  </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center mb-4">Update Order</h1>
            <form id="updateOrderForm" method="post">
                <div class="form-group">
                    <label for="orderId">Enter Order ID:</label>
                    <input type="text" class="form-control" id="orderId" name="orderId" required />
                </div>
                <div class="form-group">
                    <label for="orderStatus">Select Order Status:</label>
                    <select class="form-control" id="orderStatus" name="orderStatus">
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" name="updateOrder">Submit</button>
            </form>

            <h2 class="mt-5">Order History</h2>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Client ID</th>
                    <th>Status</th>
                    <th>Update Status At</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                // Loop through order history (assuming $orderHistory is an array of arrays)
                ?>
                </tbody>
            </table>

            <form id="logoutForm" method="post">
                <button type="submit" class="btn btn-danger" name="alogout">Logout</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
