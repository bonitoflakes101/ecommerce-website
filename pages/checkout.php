<?php
session_start();
require 'includes/db_config.php';

$login_success = isset($_SESSION['login_success']) ? $_SESSION['login_success'] : false;


if (!isset($_SESSION['CustomerID'])) {
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- <?php print_r($_SESSION) ?> -->


    <table class="table">
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
        <tr>
        <th scope="row">1</th>
        <td>Dell XPS 13</td>
        <td>2024-12-01 17:33:08</td>
        <td>2024-12-04</td>
        <td>1</td>
        <td>1200.00</td>
        <td>Pending</td>
        </tr>
    </tbody>
    </table>
</body>
</html>
