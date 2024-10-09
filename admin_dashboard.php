<?php
    session_start();
    include '../Models/Delivery.Model.php';

    if(!isset($_SESSION['key'])) {
        header("Location:login.php");
    }

    if(isset($_POST['alogout'])) {
         $Signout = new DeliveryModel();
         $Signout->AdminsignOut();  
    }

     
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['CO_btn'])) {
            // Redirect to create order page
            header("Location: create_order.php");
            exit();
         
        } elseif (isset($_POST['UO_btn'])) {
            // Redirect to update orders page
            header("Location: update_orders.php");
            exit();
        }
    }
    ?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f5f5f5;
            }
    
            .container {
                max-width: 800px;
                margin: 40px auto;
                padding: 20px;
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
    
            .header {
                background-color: #2196F3;
                color: #fff;
                padding: 10px;
                border-radius: 10px 10px 0 0;
            }
    
            .header h2 {
                margin: 0;
                color: #fff;
            }
    
            .quick-access {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                padding: 20px;
            }
    
            .quick-access button {
                background-color: #2196F3;
                color: #fff;
                border: none;
                padding: 15px 30px;
                border-radius: 5px;
                margin-bottom: 10px;
                cursor: pointer;
            }
    
            .quick-access button:hover {
                background-color: #1976D2;
            }
    
            .quick-access i {
                margin-right: 10px;
            }
    
            .logout-btn {
                background-color: red;
                color: #fff;
                border: none;
                padding: 15px 30px;
                border-radius: 5px;
                margin-top: 20px;
                cursor: pointer;
                width: 100%;
            }


    
            .logout-btn:hover {
                background-color: #c82333;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h2 class="text-center">Dashboard</h2>
            </div>
            <div class="quick-access">
                <form action="admin_dashboard.php" method="POST">
                    <button class="btn btn-primary" name="CO_btn">
                        <i class="fas fa-shopping-cart"></i>
                        Create Order
                    </button>
                    <button class="btn btn-primary" name="AD_btn">
                        <i class="fas fa-arrow-up"></i>
                        Assign Driver
                    </button>
                    <button class="btn btn-primary" name="UO_btn">
                        <i class="fas fa-edit"></i>
                        Update Orders
                    </button>
                    <div>
                        <button style="background-color: red" class="logout-btn" name="alogout">
                            <i class="fas fa-sign-out-alt"></i>
                            Log out
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/your-fontawesome-kit-id.js" crossorigin="anonymous"></script>
    </body>
    </html>