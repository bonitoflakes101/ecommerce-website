<?php
session_start();
require '../includes/db_config.php';

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (isset($data['cartitemID']) && isset($data['change'])) {
        $cartitemID = $data['cartitemID'];
        $change = $data['change'];

        try {
            // Fetch the current quantity and product ID
            $query = "
                SELECT ci.Quantity, ci.ProductID, p.Stock 
                FROM cartitem ci
                JOIN product p ON ci.ProductID = p.ProductID
                WHERE ci.CartItemID = :cartItemID
            ";
            $stmt = $pdo->prepare($query);
            $stmt->execute([':cartItemID' => $cartitemID]);
            $itemData = $stmt->fetch();

            if (!$itemData) {
                echo json_encode(['status' => 'error', 'message' => 'Cart item not found']);
                exit();
            }

            $currentQuantity = $itemData['Quantity'];
            $productID = $itemData['ProductID'];
            $stock = $itemData['Stock'];

            // Calculate the new quantity
            $newQuantity = $currentQuantity + $change;

            if ($newQuantity > 3) {
                echo json_encode(['status' => 'error', 'message' => 'Maximum quantity of 3 per item reached']);
            } elseif ($newQuantity < 1) {
                echo json_encode(['status' => 'error', 'message' => 'Quantity cannot be less than 1']);
            } elseif ($change > 0 && $stock < $change) {
                echo json_encode(['status' => 'error', 'message' => 'Not enough stock available to increase quantity']);
            } else {
                // Update the cart item quantity
                $updateQuery = "UPDATE cartitem SET Quantity = :quantity WHERE CartItemID = :cartItemID";
                $updateStmt = $pdo->prepare($updateQuery);
                $updateStmt->execute([':quantity' => $newQuantity, ':cartItemID' => $cartitemID]);

                // Update the stock
                if ($change > 0) {
                    // Decrease stock if quantity increases
                    $stockQuery = "UPDATE product SET Stock = Stock - :change WHERE ProductID = :productID";
                } else {
                    // Increase stock if quantity decreases
                    $stockQuery = "UPDATE product SET Stock = Stock + :change WHERE ProductID = :productID";
                    $change = abs($change); // Convert to positive for stock restoration
                }
                $stockStmt = $pdo->prepare($stockQuery);
                $stockStmt->execute([':change' => $change, ':productID' => $productID]);

                echo json_encode(['status' => 'success', 'message' => 'Quantity updated successfully']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error updating quantity: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Product ID or change not provided']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
