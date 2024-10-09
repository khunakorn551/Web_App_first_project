<?php
session_start();
include '../Models/Delivery.Model.php';

if (isset($_POST['login'])) {
    // Login logic remains the same
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $role = $_POST['role'];

    if (!empty($role) && !empty($email) && !empty($pass)) {
        $model = new DeliveryModel();
        $result = $model->signIn($email, $pass, $role);

        if ($result) {
            if ($role == 'admin') {
                $_SESSION['admin_id'] = $result['user_id'];
                $_SESSION['key'] = ['user_id' => $result['user_id']]; 
                header("Location: admin_dashboard.php");
                exit;
            } elseif ($role == 'driver') {
                $_SESSION['driver_id'] = $result['user_id'];
                $_SESSION['key'] = ['user_id' => $result['user_id']]; 
                header("Location: driver_dashboard.php");
                exit;
            } elseif ($role == 'client') {
                $_SESSION['client_id'] = $result['user_id'];
                $_SESSION['key'] = ['user_id' => $result['user_id']]; 
                header("Location: client_dashboard.php");
                exit;
            }
        } else {
            echo "Incorrect email or password";
        }
    }
}

if (isset($_POST['Register'])) {
    // Redirect to registration page
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        body{
            background: linear-gradient(to right, #ff0000, #0000ff); /* Red to blue gradient background */
        }

        .register {
            margin-top: 150px;
        }
    </style>

</head>
<body>
    
    <div class="container" >
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                        <div class="card register"> 
                            <div class="card-header text-center text-primary">
                                <h2>Login</h2>
                            </div>
                            <div class="card-body">
                                <form action="login.php" method="POST">
                                    <div class="form-group">
                                        <label for="">Email:</label>
                                        <input type="email" class="form-control" name="email" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Password:</label>
                                        <input type="password" class="form-control" name="pass" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <label>Role:</label><br>
                                        <div>
                                            <label>
                                                <input type="radio" name="role" value="admin" required>
                                                Admin
                                            </label>
                                        </div>
                                        <div>
                                            <label>
                                                <input type="radio" name="role" value="driver">
                                                Driver
                                            </label>
                                        </div>
                                        <div>
                                            <label>
                                                <input type="radio" name="role" value="client">
                                                Client
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">

                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-primary mt-3" name="login">Login</button>
                                            <button class="btn btn-primary mt-3" name="Register" onclick="this.form.action='index.php';">Register</button>
                                        </div >
                                        <div class="col-md-3">

                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                               <div class="row">
                                <div class="col-md-2">

                                </div>
                                <div class="col-md-8 text-center">
                                    <p>Copyright &copy; Rindra Delivery</p>
                                </div>
                                <div class="col-md-2">

                                </div>
                               </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
