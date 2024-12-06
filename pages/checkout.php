<?php
session_start();
require '../includes/db_config.php';

$login_success = isset($_SESSION['login_success']) ? $_SESSION['login_success'] : false;


if (!isset($_SESSION['CustomerID'])) {
    header("Location: ../index.php");
    exit();
}
$customerId = $_SESSION['CustomerID'];

/* Customer Details: Start */
$customerDetailsSql = "SELECT FirstName, LastName, FullAddress FROM ecommerce_db.customer WHERE CustomerID = {$customerId}";
$customerDetailsResult = mysqli_query($db_conn, $customerDetailsSql);
$firstName = "";
$lastName = "";
$address = "";
if (mysqli_num_rows($customerDetailsResult) > 0) {
    $row=mysqli_fetch_assoc($customerDetailsResult);
    $firstName = $row['FirstName'];
    $lastName = $row['LastName'];
    $address = $row['FullAddress'];
}
/* Customer Details: End */

/* Cart Item Details: Start */
$totalPrice = 0.00;
$show_cart_sql = "SELECT b.ProductImages, b.ProductName, a.Quantity, b.Price
                    FROM cartitem as a
                    JOIN product as b ON a.ProductID = b.ProductID
                    JOIN cart as c ON a.CartID = c.CartID
                    WHERE c.CustomerID = {$customerId}
					ORDER BY a.LastModified DESC";
$show_cart_result = mysqli_query($db_conn, $show_cart_sql);


/* Cart Item Details: End */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechVault Checkout</title>
    <link rel="stylesheet" href="../css/checkoutStyle.css" />
</head>
<body>

    <section id="main-popup">

        <div class="main-container">
            <div class="title-container">
                <h1>Order Summary</h1>
                <div class="customer-info">
                    <h2><?php echo $firstName . " " . $lastName; ?></h2>
                    <h3><?php echo $address; ?></h3>
                </div>

            </div>
            <div class="general-container">
                <div class="item-container">
                    <div class="image-container">
                        <img src="resources/images/pc1.png" alt="item-image">
                    </div>
                    <div class="name-container">
                        <h1>item Name</h1>
                    </div>
                    <div class="quantity-container">
                        <h1>Quantity</h1>
                    </div>
                    <div class="price-container">
                        <h1>Price</h1>
                    </div>
                </div>


<!-- <div class="item-container">
    <h1>No Items to Show</h1>
    Set Total to 0.00 Pesos
</div> -->
                
            </div>

            <div class="bottom-container">
                <div class="total-container">
                    <h1><?php if (mysqli_num_rows($show_cart_result) > 0) {
                            echo "Total: <span>P{$totalPrice}</span>";
                        }
                        else {
                            /* echo "Total: <span>P0.00</span>"; */
                        }?></h1>
                </div>
                <div class="button-container">
                    <a href="#"><button class="cancel-button">Cancel</button></a>
                    <a href="#"><button class="confirm-button">Confirm</button></a>
                </div>
            </div>

        </div>

    </section>


    
</body>
</html>
