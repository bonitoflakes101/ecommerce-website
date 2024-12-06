<?php
session_start();
require '../includes/db_config.php';

// Allow requests from 'http://localhost' 
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
      // Validate product ID
      if (!isset($_POST['productID']) || empty($_POST['productID'])) {
          echo json_encode(['status' => 'error', 'message' => 'Product ID is missing or invalid']);
          exit();
      }

      $productID = htmlspecialchars($_POST['productID']);
      $customerID = $_SESSION['CustomerID'];

      // Check product stock
      $stockQuery = "SELECT ProductID, Stock FROM product WHERE ProductID = :productID AND Stock> 0";
      $stockStmt = $pdo->prepare($stockQuery);
      $stockStmt->execute([":productID" => $productID]);
      $stock = $stockStmt->fetch();

      // Check cart item number
      $cartMaxNumQuery = "SELECT COUNT(b.CartItemID)
                        FROM Cart as a
                        JOIN CartItem as b ON a.CartID = b.CartID
                        WHERE a.CustomerID = :customerID";
      $cartMaxNumQueryStmt = $pdo->prepare($cartMaxNumQuery);
      $cartMaxNumQueryStmt->execute([":customerID" => $customerID]);
      $cartMaxNum = $cartMaxNumQueryStmt->fetchColumn();

      if (!$stock) {
          echo json_encode(['status' => 'error', 'message' => 'Product is out of stock']);
          exit();
      }

      if ($cartMaxNum >= 10) {
        echo json_encode(['status' => 'error', 'message' => 'Max number of item per Cart Reached!']);
        exit();
    }



      // Check if product already exists in the cart
      $cartDataQuery = "
          SELECT a.CartID, b.CartItemID, b.ProductID, b.Quantity 
          FROM Cart as a
          JOIN CartItem as b ON a.CartID = b.CartID
          WHERE a.CustomerID = :customerID AND b.ProductID = :productID
      ";
      $cartDataStmt = $pdo->prepare($cartDataQuery);
      $cartDataStmt->execute([
          ":customerID" => $customerID,
          ":productID" => $productID,
      ]);
      $cartData = $cartDataStmt->fetch();

      if (isset($cartData['Quantity'])) {
          $cartItemID = $cartData['CartItemID'];
          $currentQuantity = $cartData['Quantity'];

          // Check if the maximum quantity is reached
          if ($currentQuantity >= 3) {
              echo json_encode(['status' => 'error', 'message' => 'Maximum quantity of this product in the cart is already reached']);
              exit();
          }

          // Update quantity if below the maximum limit
          $newQuantity = $currentQuantity + 1;

          $updateQuery = "UPDATE CartItem SET Quantity = :newQuantity WHERE CartItemID = :cartItemID";
          $updateStmt = $pdo->prepare($updateQuery);
          $updateStmt->execute([
              ":newQuantity" => $newQuantity,
              ":cartItemID" => $cartItemID,
          ]);
      } else {
          // Insert new product into the cart
          $cartIDQuery = "SELECT CartID FROM Cart WHERE CustomerID = :customerID";
          $cartIDStmt = $pdo->prepare($cartIDQuery);
          $cartIDStmt->execute([':customerID' => $customerID]);
          $cartID = $cartIDStmt->fetch()['CartID'];

          $insertQuery = "INSERT INTO CartItem (CartID, ProductID, Quantity) VALUES (:cartID, :productID, 1)";
          $insertStmt = $pdo->prepare($insertQuery);
          $insertStmt->execute([
              ":cartID" => $cartID,
              ":productID" => $productID,
          ]);
      }

      // Reduce stock after successful cart addition
      $reduceStockQuery = "UPDATE product SET Stock = Stock - 1 WHERE ProductID = :productID";
      $reduceStockStmt = $pdo->prepare($reduceStockQuery);
      $reduceStockStmt->execute([":productID" => $productID]);

      // Return success response
      echo json_encode(['status' => 'success', 'message' => 'Product added to cart successfully']);
      exit();
  } catch (Exception $e) {
      // Handle errors
      echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
      exit();
  }
}


//  FETCHING THE DATA FOR THE CART 

$customerID = $_SESSION['CustomerID'];


$cartItemsQuery = "SELECT a.CartItemID, a.ProductID, a.CartItemID ,b.ProductImages, b.ProductName, b.Price, a.Quantity
                    FROM cartitem as a
                    JOIN product as b ON a.ProductID = b.ProductID
                    JOIN cart as c ON a.CartID = c.CartID
                    WHERE c.CustomerID = :customerID
                     ORDER BY a.LastModified DESC";
$cartItemsData = $pdo->prepare($cartItemsQuery);
$cartItemsData->execute([":customerID"=> $customerID]);

// Fetch all the rows
$cartItems = $cartItemsData->fetchAll(PDO::FETCH_ASSOC);

// Return the data as JSON
header('Content-Type: application/json'); // Set the content type to JSON
echo json_encode($cartItems);


