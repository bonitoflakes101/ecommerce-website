<?php
session_start();
require '../includes/db_config.php';

$login_success = isset($_SESSION['login_success']) ? $_SESSION['login_success'] : false;


if (!isset($_SESSION['CustomerID'])) {
    header("Location: ../index.php");
    exit();
}
$customerId = $_SESSION['CustomerID'];


function nextAutoIncrement($tablename, $db_conn) {
    $next_auto_increment_sql = "SHOW TABLE STATUS LIKE '{$tablename}'";
    $next_auto_increment_result = mysqli_query($db_conn, $next_auto_increment_sql);
    if (mysqli_num_rows($next_auto_increment_result) > 0) {
        $row=mysqli_fetch_assoc($next_auto_increment_result);
        $next_auto_increment = $row['Auto_increment'];
        return $next_auto_increment;
    }
}


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

/* crc32          */

if (isset($_POST['btnConfirmClicked'])) {
    
    /* header("Location: ../profile.php");
    exit(); */
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechVault Checkout</title>
    <link rel="stylesheet" href="../css/checkoutStyle.css" />
    <script>
        function addCartToOrder() {
            if (confirm("Are you sure you want to order all of these?")) {
                const form = document.createElement("form");
                form.method = "POST";
                form.action = "checkout.php";

                const inputAddingCartToOrder = document.createElement("input");
                inputAddingCartToOrder.type = "hidden";
                inputAddingCartToOrder.name = "btnConfirmClicked";
                inputAddingCartToOrder.value = 1;

                form.appendChild(inputAddingCartToOrder);
                document.body.appendChild(form);
                form.submit();
            }
        }
</script>
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
                <?php
                    if (mysqli_num_rows($show_cart_result) > 0) {
                        while ($row=mysqli_fetch_assoc($show_cart_result)) {
                            $image = $row['ProductImages'];
                            $productName = $row['ProductName'];
                            $quantity = $row['Quantity'];
                            $price = $row['Price'] * $row['Quantity'];
                            $priceFormat = number_format($price, 2);
                            $totalPrice += $price;

                            echo '<div class="item-container">';
                                echo '<div class="image-container">';
                                    echo '<img src="../resources/products/'.$image.  '.png" alt="item-image">';
                                echo '</div>';
                                echo '<div class="name-container">';
                                    echo "<h1>{$productName}</h1>";
                                echo '</div>';
                                echo '<div class="quantity-container">';
                                    echo "<h1>{$quantity}</h1>";
                                echo '</div>';
                                echo '<div class="price-container">';
                                    echo "<h1>₱{$priceFormat}</h1>";
                                echo '</div>';
                            echo '</div>';
                        }
                    }
                    else {
                        echo '<div class="item-container">';
                            echo "<h1>No Items to Show</h1>";
                        echo '</div>';
                    }
                ?>
                
            </div>

            <div class="bottom-container">
                <div class="total-container">
                    <h1><?php if (mysqli_num_rows($show_cart_result) > 0) {
                            $totalPriceFormat = number_format($totalPrice, 3);
                            echo "Total: <span>₱{$totalPriceFormat}</span>";
                        }
                        else {
                            /* echo "Total: <span>P0.00</span>"; */
                        }?></h1>
                </div>
                <div class="button-container">
                    <a href="#"><button class="cancel-button">Cancel</button></a>
                    <a href="#"><button onclick="addCartToOrder()" class="confirm-button">Confirm</button></a>
                </div>
            </div>

        </div>

    </section>
</body>
</html>
