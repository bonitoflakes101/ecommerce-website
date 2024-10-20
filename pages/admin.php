<?php
session_start();
require '../includes/db_config.php';

if (!isset($_SESSION['AdminID'])) {
    header("Location: login.php");
    exit;
}

$sql_orders = "SELECT o.OrderID, o.OrderDate, o.Status, c.FirstName, c.LastName 
               FROM `Order` o 
               JOIN Customer c ON o.CustomerID = c.CustomerID 
               ORDER BY o.OrderDate DESC";
$stmt_orders = $pdo->prepare($sql_orders);
$stmt_orders->execute();
$orders = $stmt_orders->fetchAll(PDO::FETCH_ASSOC);

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
    <script>
        function confirmAction(action, orderID) {
            if (confirm("Are you sure you want to " + action + " this order?")) {
                const form = document.createElement("form");
                form.method = "POST";
                form.action = "admin.php";

                const inputOrderID = document.createElement("input");
                inputOrderID.type = "hidden";
                inputOrderID.name = "orderID";
                inputOrderID.value = orderID;

                const inputAction = document.createElement("input");
                inputAction.type = "hidden";
                inputAction.name = "action";
                inputAction.value = action;

                form.appendChild(inputOrderID);
                form.appendChild(inputAction);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function editProduct(productID, productName, manufacturer, price, stock, category) {
            document.getElementById('productID').value = productID;
            document.getElementById('productName').value = productName;
            document.getElementById('manufacturer').value = manufacturer;
            document.getElementById('price').value = price;
            document.getElementById('stock').value = stock;
            document.getElementById('category').value = category;
            document.getElementById('edit_product_button').style.display = 'inline';
            document.getElementById('add_product_button').style.display = 'none';
        }

        function resetForm() {
            document.getElementById('productID').value = '';
            document.getElementById('productName').value = '';
            document.getElementById('manufacturer').value = '';
            document.getElementById('price').value = '';
            document.getElementById('stock').value = '';
            document.getElementById('category').value = '';
            document.getElementById('edit_product_button').style.display = 'none';
            document.getElementById('add_product_button').style.display = 'inline';
        }
    </script>
</head>

<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="admin.php">Home</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
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

            <input type="submit" id="add_product_button" name="add_product" value="Add Product">
            <input type="submit" id="edit_product_button" name="edit_product" value="Edit Product" style="display: none;">
            <button type="button" onclick="resetForm()">Reset Form</button>
        </form>

        <h2>Product List</h2>
        <table>
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Manufacturer</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['ProductID']); ?></td>
                        <td><?php echo htmlspecialchars($product['ProductName']); ?></td>
                        <td><?php echo htmlspecialchars($product['Manufacturer']); ?></td>
                        <td><?php echo htmlspecialchars($product['Price']); ?></td>
                        <td><?php echo htmlspecialchars($product['Stock']); ?></td>
                        <td><?php echo htmlspecialchars($product['Category']); ?></td>
                        <td>
                            <button onclick="editProduct(
                                <?php echo htmlspecialchars($product['ProductID']); ?>,
                                '<?php echo htmlspecialchars($product['ProductName']); ?>',
                                '<?php echo htmlspecialchars($product['Manufacturer']); ?>',
                                <?php echo htmlspecialchars($product['Price']); ?>,
                                <?php echo htmlspecialchars($product['Stock']); ?>,
                                '<?php echo htmlspecialchars($product['Category']); ?>')">Edit</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>

</html>