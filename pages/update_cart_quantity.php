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

        // Fetch the current quantity
        $query = "SELECT Quantity FROM cartitem WHERE CartItemID = :cartItemID";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':cartItemID' => $cartitemID]);
        $currentQuantity = $stmt->fetchColumn();

        // check the new quantity
        $newQuantity = $currentQuantity + $change;

        // make sure na yung new quantity is greater than or equal to 1
          if ($newQuantity > 3) {
            echo json_encode(['status' => 'error', 'message' => 'Maximum quantity of 3 per item exceeded']);
          } elseif ($newQuantity >= 1) {
            // Update the cart item quantity
            $updateQuery = "UPDATE cartitem SET Quantity = :quantity WHERE CartItemID = :cartItemID";
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->execute([':quantity' => $newQuantity, ':cartItemID' => $cartitemID]);

            echo json_encode(['status' => 'success', 'message' => 'Quantity updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Quantity cannot be less than 1']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Product ID or change not provided']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
