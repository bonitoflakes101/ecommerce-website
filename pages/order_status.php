<?php 

  session_start();  

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .order-status-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .order-info {
            margin-bottom: 20px;
        }
        .order-info p {
            font-size: 18px;
            margin: 10px 0;
        }
        .order-info .label {
            font-weight: bold;
            color: #555;
        }
        .status {
            padding: 10px;
            border-radius: 5px;
            color: #fff;
            display: inline-block;
        }
        .status.pending {
            background-color: #007BFF;
        }
        .status.shipped {
            background-color: #5bc0de;
        }
        .status.delivered {
            background-color: #5cb85c;
        }
        .product-details {
            text-indent: 50px;
        }

    </style>
</head>
<body>

<div class="order-status-container">   

    <h2>Order Status</h2>

    <div><a href="/ecommerce-website/index.php"><button>Home</button></a></div>
    <div class="order-info">
    
    <?php
    require '../includes/db_config.php';
    
    // captures current sessions username
    //NOTE: case sensitive si parameter ('Username')
    $username = $_SESSION['Username'];
    echo' Username Captured: '.htmlspecialchars($username).'';
    
    //getting the usernames id and stor
    $sql2 = "SELECT CustomerID FROM Customer WHERE Username = '$username'";
    $stmt2 = $pdo->query($sql2);

    $userID = $stmt2->fetch();
    $userID = $userID["CustomerID"];
    echo "</br>CustomerID Captured: ".$userID." </br></br>";
    


    $sqlOrder = "SELECT a.OrderID, a.OrderDate, a.Status
            FROM `order` as a
            WHERE a.CustomerID = '$userID'";
    $stmtOrder = $pdo->query($sqlOrder);  
    $order = $stmtOrder->fetch();
    
    $OrderID = $order['OrderID'];
    $OrderDate = $order['OrderDate'];    
    $status = $order['Status'];
    
    
    echo '<p><span class="label">Order Number: </span>' .$OrderID.'</p>';
    echo '<p><span class="label">Order Date: '.$OrderDate.'</p> ';

    $sqlOrderDetails = "SELECT a.Quantity, c.ProductName
                        FROM orderitem as a
                        JOIN `order` as b
                        ON a.OrderID = b.OrderID
                        JOIN product as c 
                        ON a.ProductID = c.ProductID
                        WHERE '$OrderID' = b.OrderID";
    $stmtOrderDetails = $pdo->query($sqlOrderDetails);  

    echo '<p><span class="label">Order Details: </p>';
    while ($row = $stmtOrderDetails->fetch()) {
        echo '<p >'.$row['Quantity'].' '.$row['ProductName'].'</p>';
    
    }
    
   
    

   
    echo '<p><span class="label">Order Status:</span> <span class="status pending">'.$status.'</span></p>';
    
    
      ?>

  



    </div>
</div>

</body>
</html>
