<?php
session_start();
require '../includes/db_config.php';
// Allow requests from 'http://localhost' 
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



      // ADDING THE PRODUCT TO CART-ITEMS IN THE DB

        // get current users customer id
        $customerID = $_SESSION['CustomerID'];
  
        $cartDataQuery = "SELECT a.CartID, b.CartItemID, b.ProductID, b.Quantity 
                      FROM Cart as a
                      JOIN CartItem as b ON a.CartID = b.CartID
                      WHERE CustomerID = :customerID AND  ProductID = :productID";
        $cartData = $pdo->prepare($cartDataQuery);
        $cartData->execute([
            ":customerID"=> $customerID,
            ":productID"=> $productID
          ]);
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
}




//  FETCHING THE DATA FOR THE CART 


$customerID = $_SESSION['CustomerID'];


$cartItemsQuery = "SELECT a.ProductID, a.CartItemID ,b.ProductImages, b.ProductName, b.Price, a.Quantity
                    FROM cartitem as a
                    JOIN product as b ON a.ProductID = b.ProductID
                    JOIN cart as c ON a.CartID = c.CartID
                    WHERE c.CartID = :customerID
                     ORDER BY a.LastModified DESC";
$cartItemsData = $pdo->prepare($cartItemsQuery);
$cartItemsData->execute([":customerID"=> $customerID]);

// Fetch all the rows
$cartItems = $cartItemsData->fetchAll(PDO::FETCH_ASSOC);

// Return the data as JSON
header('Content-Type: application/json'); // Set the content type to JSON
echo json_encode($cartItems);


