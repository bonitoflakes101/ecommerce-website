<?php
session_start();
require '../includes/db_config.php';

$login_success = isset($_SESSION['login_success']) ? $_SESSION['login_success'] : false;


if (!isset($_SESSION['CustomerID'])) {
    header("Location: ../index.php");
    exit();
}
$customerId = $_SESSION['CustomerID'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <script src="../js/checkout.js"></script> -->
    <script>
        function confirmDelete(cartItemID) {
            if (confirm("Are you sure you want to cancel ordering this product?")) {
                console.log("Deleted "+cartItemID);
            }
        }
    </script>
</head>
<body>
    <!-- Cart Table -->
    <table class="table">
    <caption>Current Cart</caption>
    <thead>
        <tr>
        <th scope="col">Cart Item ID</th>
        <th scope="col">Product Name</th>
        <th scope="col">Price</th>
        <th scope="col">Quantity</th>
        <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $sql = "SELECT a.CartItemID , b.ProductName, b.Price, a.Quantity
                    FROM cartitem as a
                    JOIN product as b ON a.ProductID = b.ProductID
                    JOIN cart as c ON a.CartID = c.CartID
                    WHERE c.CustomerID = {$customerId}
					ORDER BY a.LastModified DESC";
            $result = mysqli_query($db_conn, $sql);
            if ($result) {
                while ($row=mysqli_fetch_assoc($result)) {
                    $cartItemID = $row['CartItemID'];
                    $productName = $row['ProductName'];
                    $price = $row['Price'];
                    $quantity = $row['Quantity'];
                    echo '<tr>
                            <th scope="row">'.$cartItemID.'</th>
                            <td>'.$productName.'</td>
                            <td>'.$price.'</td>
                            <td>'.$quantity.'</td>
                            <td>
                                <button onclick="confirmDelete('.$cartItemID.')">Cancel</button>
                            </td>
                        </tr>';
                }
            }
        ?>
    </tbody>
    </table>

    <!-- Submit Button: Process Cart to be Orders -->
    <button type="submit">Process Cart to Order</button>

    <!-- Orders Table -->
    <table class="table">
    <caption>Current Orders</caption>
    <thead>
        <tr>
        <th scope="col">Order Item ID</th>
        <th scope="col">Product Name</th>
        <th scope="col">Order Date</th>
        <th scope="col">Estimated Delivery Date</th>
        <th scope="col">Quantity</th>
        <th scope="col">Price</th>
        <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $sql = "SELECT 
                        oi.OrderItemID,
                        p.ProductName,
                        o.OrderDate,
                        o.EstimatedDeliveryDate,
                        oi.Quantity,
                        oi.Price,
                        o.Status
                    FROM 
                        `Order` o
                    JOIN 
                        Customer c ON o.CustomerID = c.CustomerID
                    JOIN 
                        OrderItem oi ON o.OrderID = oi.OrderID
                    JOIN 
                        Product p ON oi.ProductID = p.ProductID
                    WHERE 
                        c.CustomerID = {$customerId}
                    ORDER BY 
                        o.OrderDate DESC,
                        oi.OrderItemID ASC";
            $result = mysqli_query($db_conn, $sql);
            if ($result) {
                while ($row=mysqli_fetch_assoc($result)) {
                    $orderItemID = $row['OrderItemID'];
                    $productName = $row['ProductName'];
                    $orderDate = $row['OrderDate'];
                    $estimatedDeliveryDate = $row['EstimatedDeliveryDate'];
                    $quantity = $row['Quantity'];
                    $price = $row['Price'];
                    $status = $row['Status'];

                    echo '<tr>
                            <th scope="row">'.$orderItemID.'</th>
                            <td>'.$productName.'</td>
                            <td>'.$orderDate.'</td>
                            <td>'.$estimatedDeliveryDate.'</td>
                            <td>'.$quantity.'</td>
                            <td>'.$price.'</td>
                            <td>'.$status.'</td>
                        </tr>';
                }
            }
        ?>
    </tbody>
    </table>
</body>
</html>
