<?php
session_start();
require '../includes/db_config.php';
// Allow requests from 'http://localhost' (you can adjust the origin as needed)
header("Access-Control-Allow-Origin: http://localhost:3000"); // Change the port if necessary
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200); // Send a 200 OK response
    exit(); // Terminate the script for OPTIONS requests
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productID = $_POST['productID'];

    // Process the productID (e.g., add to cart)
    //echo 'Product ' . htmlspecialchars($productID) . ' added to cart!';
}
?>


<?php   
  
        // get current users customer id
        $customerID = $_SESSION['CustomerID'];
  
        $cartDataQuery = "SELECT a.CartID, b.CartItemID, b.ProductID, b.Quantity 
                      FROM Cart as a
                      JOIN CartItem as b ON a.CartID = b.CartID
                      WHERE CustomerID = $customerID AND  ProductID = $productID";
        $cartData = $pdo->query($cartDataQuery);
        $cartData = $cartData->fetch();
  
  
        // check if may existing product na sa cart
        if (isset($cartData['Quantity'])) {
          $cartID = $cartData['CartID'];
          $itemQuantity = $cartData['Quantity'];
          $cartItemID = $cartData['CartItemID'];
  
  
          //checking lang if na ccapture yung data ng maayos
          //echo 'ProductID: '.htmlspecialchars($productID).'  Customer ID: '. htmlspecialchars($customerID).'   CartID: '. htmlspecialchars($cartID).' Quantity: '.htmlspecialchars($itemQuantity). ' CartItemID: '.htmlspecialchars($cartItemID);
  
  
          // ADD Item Quantity if may Existing Product na sa Cart.
          $itemQuantity++;
          $updateQuery = "UPDATE cartitem SET Quantity = :itemQuantity WHERE CartItemID = :cartItemID;";
          $prepareUpdateQuery = $pdo->prepare($updateQuery);
          $prepareUpdateQuery->execute([
            ":itemQuantity" => $itemQuantity,
            ":cartItemID" => $cartItemID
          ]);
  
          // else if wala pang existing product sa cart
        } else {
  
          //capturing cart id muna
          $cartIDQuery = "SELECT CartID FROM Cart WHERE CustomerID = $customerID";
          $cartID = $pdo->query($cartIDQuery);
          $cartID = $cartID->fetch();
          $cartID = $cartID['CartID'];
  
          // query for inserting the product na
          $addToCartQuery = "INSERT INTO cartitem(CartID, ProductID, Quantity) VALUES(:cartID, :productID, 1)";
          $addToCart = $pdo->prepare($addToCartQuery);
          $addToCart->execute([
            ":cartID" => $cartID,
            ":productID" => $productID,
          ]);
        }
      
?>


  <!-- Cart Pop-up -->
  <section class="cart">
    <div class="cart-tab">
      <h1>My Cart</h1>

      
      <div class="cart-list">


        <?php 
          
          $customerID = $_SESSION['CustomerID'];


          $cartItemsQuery = "SELECT a.CartItemID ,b.ProductImages, b.ProductName, b.Price, a.Quantity
                              FROM cartitem as a
                              JOIN product as b ON a.ProductID = b.ProductID
                              JOIN cart as c ON a.CartID = c.CartID
                              WHERE c.CartID = :customerID
                              ORDER BY a.CartItemID DESC";
          $cartItemsData = $pdo->prepare($cartItemsQuery);
          $cartItemsData->execute([":customerID"=> $customerID]);

          while ($row = $cartItemsData->fetch()) {
            echo '<div class="cart-item">';
              // cart item image

              
              // echo '<div class="cart-item-image">
              // <img src="'.htmlspecialchars($row['ProductImages']).'">
              // </div>';
              // echo '';


              echo '<div class="cart-item-image">
                    <img src="resources/images/pc1.png" alt="cart-pic">
                    </div>';

              //cart item product name
              echo '<div class="cart-item-title">
              <p>'.htmlspecialchars($row['ProductName']).'</p>
              </div>';

              // cart item price
              echo '<div class="cart-item-price">
              <p>'.htmlspecialchars($row['Price']).'</p>
              </div>';

              // cart item quantity & buttons
              echo '<div class="cart-item-quantity">
                <span class="minus">-</span>
                <span class="amount">'.htmlspecialchars($row['Quantity']).'</span>
                <span class="Plus">+</span>
              </div>';


            echo  '</div>';

          }
        ?>

        


      </div>

      <!-- Cart Buttons -->
      <div class="cart-buttons">
        <button class="cart-close">Close</button>
        <br>
        <button class="cart-checkout">Checkout</button>

      </div>
    </div>

  </section>