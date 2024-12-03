<?php
session_start();
require '../includes/db_config.php';
header("Access-Control-Allow-Origin: http://localhost:3000"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// verifyy if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON input
    $input = file_get_contents("php://input");
    $data = json_decode($input, true); // Decode  JSON

    if (isset($data['CartItemID'])) {
        $cartItemID = $data['CartItemID'];

        $deleteQuery = "DELETE FROM cartitem WHERE CartItemID = :cartItemID";
        $delete = $pdo->prepare($deleteQuery);
        $delete->execute([":cartItemID"=>$cartItemID]);

        //  success response
        echo json_encode(['status' => 'success', 'message' => 'Item deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Cart Item ID not provided']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>