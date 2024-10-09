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

<div class="header">
  <h2>Driver Dashboard</h2>
</div>

<div class="sidebar">
  <h2>Menu</h2>
  <ul>
    <li><a href="driver_dashboard.php">Dashboard</a></li>
    <li><a href="view_assigned_order.php">View Assigned Orders</a></li>
    <li><a href="delivery_history.php">Delivery History</a></li>
    <li><a href="login.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
  </ul>
</div>

<div class="main-content">
  <div class="container py-5">
    <div class="quick-access">
      <div class="row">
        <div class="col-md-12">
          <a href="view_assigned_order.php" class="btn btn-primary btn-lg me-2" id="view-assigned-orders">View Assigned Orders</a>
          <button class="btn btn-success btn-lg" id="status-toggle">Go Online</button> <!-- Status button -->
        </div>
      </div>
    </div>
  </div>
</div>

<footer>
  <p>&copy; 2023 Delivery Management System</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  const statusToggleBtn = document.getElementById('status-toggle');
  
  // Assuming the driver's online status is stored in a database
  let isOnline = false; // By default, the driver is offline

  statusToggleBtn.addEventListener('click', function() {
    // Toggle online/offline status
    isOnline = !isOnline;
    statusToggleBtn.textContent = isOnline ? "Go Offline" : "Go Online";
    statusToggleBtn.classList.toggle('btn-success', !isOnline);
    statusToggleBtn.classList.toggle('btn-danger', isOnline);

    // Make an AJAX request to update the driver's status in the database
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_driver_status.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      if (xhr.status === 200) {
        console.log('Status updated successfully');
      } else {
        console.log('Failed to update status');
      }
    };
    xhr.send('isOnline=' + (isOnline ? 1 : 0));
  });
});
</script>
</body>
</html>
