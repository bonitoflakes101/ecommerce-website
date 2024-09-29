<?php
// example na we can get data from database
require 'db_config.php';


$sql = "SELECT * FROM Product";
$stmt = $pdo->query($sql);


while ($row = $stmt->fetch()) {
    echo "Product ID: " . $row['ProductID'] . "<br>";
    echo "Product Name: " . $row['ProductName'] . "<br>";
    echo "Description: " . $row['Description'] . "<br>";
    echo "Price: " . $row['Price'] . "<br>";
    echo "Stock: " . $row['Stock'] . "<br>";
    echo "Category: " . $row['Category'] . "<br><br>";
}
