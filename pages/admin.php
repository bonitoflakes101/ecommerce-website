<?php
session_start();
require '../includes/db_config.php';

if (!isset($_SESSION['AdminID'])) {
    header("Location: login.php");
    exit;
}
// for confirm/reject orders form
$sql_orders = "SELECT o.OrderID, o.OrderDate, o.Status, c.FirstName, c.LastName 
               FROM `Order` o 
               JOIN Customer c ON o.CustomerID = c.CustomerID 
               ORDER BY o.OrderDate DESC";
$stmt_orders = $pdo->prepare($sql_orders);
$stmt_orders->execute();
$orders = $stmt_orders->fetchAll(PDO::FETCH_ASSOC);

// for products table to add/edit/delete
$sql_products = "SELECT * FROM Product";
$stmt_products = $pdo->prepare($sql_products);
$stmt_products->execute();
$products = $stmt_products->fetchAll(PDO::FETCH_ASSOC);

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // confirm/reject orders
    if (isset($_POST['action'])) {
        $orderID = $_POST['orderID'];
        $action = $_POST['action'];

        if ($action === 'confirm') {
            $sql_confirm = "UPDATE `Order` SET Status = 'Confirmed' WHERE OrderID = :orderID";
            $stmt_confirm = $pdo->prepare($sql_confirm);
            $stmt_confirm->execute(['orderID' => $orderID]);
            $message = "Order #$orderID confirmed successfully.";
        } elseif ($action === 'reject') {
            $sql_reject = "UPDATE `Order` SET Status = 'Cancelled' WHERE OrderID = :orderID";
            $stmt_reject = $pdo->prepare($sql_reject);
            $stmt_reject->execute(['orderID' => $orderID]);
            $message = "Order #$orderID rejected successfully.";
        }

        header("Location: admin.php?message=" . urlencode($message));
        exit;
    }

    // add/edit products
    if (isset($_POST['add_product'])) {
        // add a product
        $sql_add = "INSERT INTO Product (ProductName, Manufacturer, Price, Stock, Category) 
                    VALUES (:productName, :manufacturer, :price, :stock, :category)";
        $stmt_add = $pdo->prepare($sql_add);
        $stmt_add->execute([
            'productName' => $_POST['productName'],
            'manufacturer' => $_POST['manufacturer'],
            'price' => $_POST['price'],
            'stock' => $_POST['stock'],
            'category' => $_POST['category']
        ]);

        $message = "Product added successfully!";
    } elseif (isset($_POST['edit_product']) && isset($_POST['productID'])) {
        // edit a product
        $sql_edit = "UPDATE Product SET ProductName = :productName, Manufacturer = :manufacturer, 
                     Price = :price, Stock = :stock, Category = :category 
                     WHERE ProductID = :productID";
        $stmt_edit = $pdo->prepare($sql_edit);
        $stmt_edit->execute([
            'productName' => $_POST['productName'],
            'manufacturer' => $_POST['manufacturer'],
            'price' => $_POST['price'],
            'stock' => $_POST['stock'],
            'category' => $_POST['category'],
            'productID' => $_POST['productID']
        ]);

        $message = "Product edited successfully!";
    } elseif (isset($_POST['delete_product']) && isset($_POST['productID'])) {
        // deletes a product
        $sql_delete = "DELETE FROM Product WHERE ProductID = :productID";
        $stmt_delete = $pdo->prepare($sql_delete);
        $stmt_delete->execute(['productID' => $_POST['productID']]);

        $message = "Product deleted successfully!";
    }

    header("Location: admin.php?message=" . urlencode($message));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/main.css">
    <script src="../js/admin.js"></script>

    <link rel="stylesheet" href="../css/mainStyle.css" />
    <link rel="stylesheet" href="../css/admin.css" />
</head>

<body>
    <!-- Main Header -->
    <section id="main">
        <!-- Header -->
        <header>
            <!-- Top Header / Logo Bar -->
            <div class="header-top">
                <!-- Logo -->
                <a href="../index.php" class="logo">
                    <img src="../resources/images/logo-with-icon.png" alt="logo" />
                </a>

                <a href="logout.php" class="logout-button">Logout</a>
            </div>


        </header>


        <main>
            <!-- confirm/reject orders -->
            <h2>Orders Management</h2>
            <?php if (isset($_GET['message'])): ?>
                <p><?php echo htmlspecialchars($_GET['message']); ?></p>
            <?php endif; ?>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['OrderID']); ?></td>
                            <td><?php echo htmlspecialchars($order['FirstName'] . ' ' . $order['LastName']); ?></td>
                            <td><?php echo htmlspecialchars($order['OrderDate']); ?></td>
                            <td><?php echo htmlspecialchars($order['Status']); ?></td>
                            <td>
                                <button onclick="confirmAction('confirm', <?php echo $order['OrderID']; ?>)">Confirm</button>
                                <button onclick="confirmAction('reject', <?php echo $order['OrderID']; ?>)">Reject</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- add/edit products text field/btn-->
            <h2>Manage Products</h2>
            <form action="admin.php" method="POST">
                <input type="hidden" name="productID" id="productID" value="">
                <label for="productName">Product Name:</label>
                <input type="text" id="productName" name="productName" required>

                <label for="manufacturer">Manufacturer:</label>
                <input type="text" id="manufacturer" name="manufacturer" required>

                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" required>

                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" required>

                <label for="category">Category:</label>
                <select name="category" id="category" required>
                    <option value="Laptops">Laptops</option>
                    <option value="Desktops">Desktops</option>
                    <option value="Processors">Processors</option>
                    <option value="Motherboards">Motherboards</option>
                    <option value="Graphics Card">Graphics Card</option>
                    <option value="Memory & Storage">Memory & Storage</option>
                    <option value="Hardware">Hardware</option>
                </select>

                <button type="submit" name="add_product" id="add_product_button">Add Product</button>
                <button type="submit" name="edit_product" id="edit_product_button" style="display:none;">Edit Product</button>
                <button type="button" onclick="resetForm()">Reset Form</button>
            </form>

            <!-- edit btn to text fields/ delete product -->
            <table class="table">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Manufacturer</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>

            <div class="table-body">
                <table class="table">
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <!-- product tables -->
                                <td><?php echo htmlspecialchars($product['ProductID']); ?></td>
                                <td><?php echo htmlspecialchars($product['ProductName']); ?></td>
                                <td><?php echo htmlspecialchars($product['Manufacturer']); ?></td>
                                <td><?php echo htmlspecialchars($product['Price']); ?></td>
                                <td><?php echo htmlspecialchars($product['Stock']); ?></td>
                                <td><?php echo htmlspecialchars($product['Category']); ?></td>
                                <td>
                                    <button onclick="editProduct(<?php echo $product['ProductID']; ?>, '<?php echo htmlspecialchars($product['ProductName']); ?>', '<?php echo htmlspecialchars($product['Manufacturer']); ?>', <?php echo $product['Price']; ?>, <?php echo $product['Stock']; ?>, '<?php echo htmlspecialchars($product['Category']); ?>')">Edit</button>
                                    <button onclick="confirmDelete(<?php echo $product['ProductID']; ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </main>
</body>

</html>