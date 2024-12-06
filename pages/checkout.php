<?php
session_start();
require '../includes/db_config.php';

$login_success = isset($_SESSION['login_success']) ? $_SESSION['login_success'] : false;


if (!isset($_SESSION['CustomerID'])) {
    header("Location: ../index.php");
    exit();
}
$customerId = $_SESSION['CustomerID'];
$arrayCartItemID = array();
$totalPrice = 0.00;



function nextAutoIncrement($tablename, $db_conn) {
    $next_auto_increment_sql = "SHOW TABLE STATUS LIKE '{$tablename}'";
    $next_auto_increment_result = mysqli_query($db_conn, $next_auto_increment_sql);
    if (mysqli_num_rows($next_auto_increment_result) > 0) {
        $row=mysqli_fetch_assoc($next_auto_increment_result);
        $next_auto_increment = $row['Auto_increment'];
        return $next_auto_increment;
    }
}

function hashMe($originalHashNumber) {
    $hashed = $originalHashNumber + rand(1,100000);
    $output = filter_var($hashed, FILTER_SANITIZE_NUMBER_INT);
    return $output;
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

/* Confirm Button: Start */
if (isset($_POST['btnConfirmClicked'])) {
    //Set random value for Order ID.
    $next = nextAutoIncrement("order", $db_conn);
    $insert_orderID = hashMe($next);

    //Get +3 days excluding weekend:
    $threeBusinessDays = $_POST['threeBusinessDays'];

    //Create new Order to database:
    $createOrder = "INSERT INTO `Order` (OrderID, OrderDate, Status, EstimatedDeliveryDate, CustomerID, AdminID) VALUES ({$insert_orderID}, NOW(), 'Pending', '{$threeBusinessDays}', {$customerId}, 1)";
    mysqli_query($db_conn, $createOrder);
    
    //Convert cartitems to orderitems
    $addCart_sql = "SELECT a.CartID, a.CartItemID, a.ProductID, a.Quantity, b.Price
                    FROM cartitem as a
                    JOIN product as b ON a.ProductID = b.ProductID
                    JOIN cart as c ON a.CartID = c.CartID
                    WHERE c.CustomerID = {$customerId}";
    $addCart_result = mysqli_query($db_conn, $addCart_sql);
    if (mysqli_num_rows($addCart_result) > 0) {

        while ($row=mysqli_fetch_assoc($addCart_result)) {
            $aCartID = $row['CartID'];
            $aCartItemID = $row['CartItemID'];
            $aProductID = $row['ProductID'];
            $aQuantity = $row['Quantity'];
            $aPrice = $row['Price'] * $row['Quantity'];

            array_push($arrayCartItemID, $aCartItemID);

            $createOrderItem = "INSERT INTO OrderItem (OrderID, ProductID, Quantity, Price) VALUES ($insert_orderID, $aProductID, $aQuantity, $aPrice)";
            mysqli_query($db_conn, $createOrderItem);
        }
    }
    //Delete cart items
    foreach ($arrayCartItemID as $id) {
        $deleteCartItem_sql = "DELETE FROM cartitem WHERE CartItemID = {$id}";
        mysqli_query($db_conn, $deleteCartItem_sql);
    }
    header("Location: ../profile.php");
    exit();
}

if (isset($_POST['btnIndexClicked'])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST['btnProfileClicked'])) {
    header("Location: ../profile.php");
    exit();
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
        function addBusinessDays(currentDate, daysToAdd) {
            let date = new Date(currentDate);
            let addedDays = 0;

            while (addedDays < daysToAdd) {
                date.setDate(date.getDate() + 1); // Move to the next day
                const dayOfWeek = date.getDay();

                // Check if the day is not a weekend (0 = Sunday, 6 = Saturday)
                if (dayOfWeek !== 0 && dayOfWeek !== 6) {
                    addedDays++;
                }
            }

            // Format the date to YYYY-MM-DD
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-based
            const day = String(date.getDate()).padStart(2, '0');

            return `${year}-${month}-${day}`;
        }
        const today = new Date(); // Current date
        const formattedToday = today.toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format

        function addCartToOrder() {
            if (confirm("Are you sure you want to order all of these?")) {
                const form = document.createElement("form");
                form.method = "POST";
                form.action = "checkout.php";

                const inputAddingCartToOrder = document.createElement("input");
                inputAddingCartToOrder.type = "hidden";
                inputAddingCartToOrder.name = "btnConfirmClicked";
                inputAddingCartToOrder.value = 1;

                const inputThreeBusinessDays = document.createElement("input");
                inputThreeBusinessDays.type = "hidden";
                inputThreeBusinessDays.name = "threeBusinessDays";
                inputThreeBusinessDays.value = addBusinessDays(formattedToday, 3);

                form.appendChild(inputAddingCartToOrder);
                form.appendChild(inputThreeBusinessDays);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function backToIndex() {
            const form = document.createElement("form");
            form.method = "POST";
            form.action = "checkout.php";

            const inputBack = document.createElement("input");
            inputBack.type = "hidden";
            inputBack.name = "btnIndexClicked";
            inputBack.value = 1;

            form.appendChild(inputBack);
            document.body.appendChild(form);
            form.submit();
        }

        function goToProfile() {
            const form = document.createElement("form");
            form.method = "POST";
            form.action = "checkout.php";

            const inputProfile = document.createElement("input");
            inputProfile.type = "hidden";
            inputProfile.name = "btnProfileClicked";
            inputProfile.value = 1;

            form.appendChild(inputProfile);
            document.body.appendChild(form);
            form.submit();
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
                    $show_cart_sql = "SELECT b.ProductImages, b.ProductName, a.Quantity, b.Price
                    FROM cartitem as a
                    JOIN product as b ON a.ProductID = b.ProductID
                    JOIN cart as c ON a.CartID = c.CartID
                    WHERE c.CustomerID = {$customerId}
					ORDER BY a.LastModified DESC";

                    $show_cart_result = mysqli_query($db_conn, $show_cart_sql);
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
                    <?php
                        if (mysqli_num_rows($show_cart_result) > 0) {
                            echo '<a href="#"><button onclick="backToIndex()" class="cancel-button">Cancel</button></a>';
                            echo '<a href="#"><button onclick="addCartToOrder()" class="confirm-button">Confirm</button></a>';
                        }
                        else {
                            echo '<a href="#"><button onclick="backToIndex()" class="cancel-button">Back to Main Page</button></a>';
                            echo '<a href="#"><button onclick="goToProfile()" class="confirm-button">Go to Profile</button></a>';
                        }
                    ?>
                </div>
            </div>

        </div>

    </section>
</body>
</html>
