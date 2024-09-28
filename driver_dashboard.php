<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Driver Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
  <!-- Driver Dashboard -->
  <div class="container py-5">
    <div class="row">
      <div class="col-md-12">
        <h1 class="display-5 fw-bold">Driver Dashboard</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <a href="driver_update_status.php" class="btn btn-primary btn-lg me-2" id="update-order-status">Update Order Status</a>
        <a href="view_assigned_order.php" class="btn btn-success btn-lg me-2" id="view-assigned-orders">View Assigned Orders</a>
        <a href="logout.html" class="btn btn-danger btn-lg" id="logout">Logout</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>