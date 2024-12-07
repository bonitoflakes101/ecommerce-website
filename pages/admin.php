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

        $sql_insert_manufacturer = "INSERT INTO Manufacturer (ManufacturerName) 
                                    VALUES (:ManufacturerName)
                                    ON DUPLICATE KEY UPDATE ManufacturerName = ManufacturerName";
        $stmt_insert_manufacturer = $pdo->prepare($sql_insert_manufacturer);
        $stmt_insert_manufacturer->execute([
            'ManufacturerName' => $_POST['ManufacturerName']
        ]);

        $sql_add_product = "INSERT INTO Product (ProductName, ManufacturerName, Description, Price, Stock, Category) 
                            VALUES (:productName, :ManufacturerName, :Description, :price, :stock, :category)";
        $stmt_add_product = $pdo->prepare($sql_add_product);
        $stmt_add_product->execute([
            'productName' => $_POST['productName'],
            'ManufacturerName' => $_POST['ManufacturerName'],
            'Description' => $_POST['Description'],
            'price' => $_POST['price'],
            'stock' => $_POST['stock'],
            'category' => $_POST['category']
        ]);




        $message = "Product added successfully!";
    } elseif (isset($_POST['edit_product']) && isset($_POST['productID'])) {
        // edit a product
        $sql_edit = "UPDATE Product SET ProductName = :productName, ManufacturerName = :ManufacturerName, 
                     Price = :price, Stock = :stock, Category = :category 
                     WHERE ProductID = :productID";
        $stmt_edit = $pdo->prepare($sql_edit);
        $stmt_edit->execute([
            'productName' => $_POST['productName'],
            'ManufacturerName' => $_POST['ManufacturerName'],
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
    <title>TechVault</title>
    <link
        rel="icon"
        type="image/x-icon"
        href="../resources/images/logo-icon.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="../js/admin.js"></script>


    <!-- <link rel="stylesheet" href="../css/mainStyle.css" /> -->
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

                <a href="logout.php" class="logout-button">Sign-out</a>
            </div>


        </header>
    </section>

    <section id="dashboard">
        <main>
            <div class="admin-header">
                <h1>Admin Dashboard</h1>
            </div>

            <div class="order-management-container">
                <h2>Order Management</h2>

                <!-- Display any message -->
                <?php if (isset($_GET['message'])): ?>
                    <p><?php echo htmlspecialchars($_GET['message']); ?></p>
                <?php endif; ?>

                <table class="order-table">
                    <thead class="order-header">
                        <tr>
                            <th class="order-id">
                                <div class="header-container">
                                    <span>Order ID</span>
                                    <form method="GET" class="sort-form">
                                        <input type="hidden" name="sort_by" value="OrderID">
                                        <input type="hidden" name="order" value="<?php echo isset($_GET['order']) && $_GET['order'] === 'asc' ? 'desc' : 'asc'; ?>">
                                        <button type="submit" class="sort-button">
                                            <img width="24" height="24" src="https://img.icons8.com/material-sharp/24/sort.png" alt="sort" />
                                        </button>
                                    </form>
                                </div>
                            </th>
                            <th class="customer-name">
                                <div class="header-container">
                                    <span>Customer Name</span>
                                    <form method="GET" class="sort-form">
                                        <input type="hidden" name="sort_by" value="CustomerName">
                                        <input type="hidden" name="order" value="<?php echo isset($_GET['order']) && $_GET['order'] === 'asc' ? 'desc' : 'asc'; ?>">
                                        <button type="submit" class="sort-button">
                                            <img width="24" height="24" src="https://img.icons8.com/material-sharp/24/sort.png" alt="sort" />
                                        </button>
                                    </form>
                                </div>
                            </th>
                            <th class="order-date">
                                <div class="header-container">
                                    <span>Order Date</span>
                                    <form method="GET" class="sort-form">
                                        <input type="hidden" name="sort_by" value="OrderDate">
                                        <input type="hidden" name="order" value="<?php echo isset($_GET['order']) && $_GET['order'] === 'asc' ? 'desc' : 'asc'; ?>">
                                        <button type="submit" class="sort-button">
                                            <img width="24" height="24" src="https://img.icons8.com/material-sharp/24/sort.png" alt="sort" />
                                        </button>
                                    </form>
                                </div>
                            </th>
                            <th class="status">
                                <div class="header-container">
                                    <span>Status</span>
                                    <form method="GET" class="sort-form">
                                        <input type="hidden" name="sort_by" value="Status">
                                        <input type="hidden" name="order" value="<?php echo isset($_GET['order']) && $_GET['order'] === 'asc' ? 'desc' : 'asc'; ?>">
                                        <button type="submit" class="sort-button">
                                            <img width="24" height="24" src="https://img.icons8.com/material-sharp/24/sort.png" alt="sort" />
                                        </button>
                                    </form>
                                </div>
                            </th>
                            <th class="action">Action</th>
                        </tr>
                    </thead>
                    <tbody class="order-body">
                        <?php
                        // Sort logic
                        $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'OrderID'; // Default sort by Order ID
                        $order = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'desc' : 'asc';

                        usort($orders, function ($a, $b) use ($sort_by, $order) {
                            if ($sort_by === 'CustomerName') {
                                $a_value = strtolower($a['FirstName'] . ' ' . $a['LastName']);
                                $b_value = strtolower($b['FirstName'] . ' ' . $b['LastName']);
                            } else {
                                $a_value = strtolower($a[$sort_by]);
                                $b_value = strtolower($b[$sort_by]);
                            }

                            if ($order === 'asc') {
                                return $a_value <=> $b_value;
                            } else {
                                return $b_value <=> $a_value;
                            }
                        });

                        // Display sorted orders
                        foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['OrderID']); ?></td>
                                <td><?php echo htmlspecialchars($order['FirstName'] . ' ' . $order['LastName']); ?></td>
                                <td><?php echo htmlspecialchars($order['OrderDate']); ?></td>
                                <td><?php echo htmlspecialchars($order['Status']); ?></td>
                                <td id="table-buttons">
                                    <?php if ($order['Status'] !== 'Confirmed'): ?>
                                        <button class="confirm-button" onclick="confirmAction('confirm', <?php echo $order['OrderID']; ?>)">Confirm</button>
                                    <?php else: ?>
                                        <button class="confirm-button" disabled style="background-color: grey; cursor: not-allowed;">Confirmed</button>
                                    <?php endif; ?>

                                    <?php if ($order['Status'] !== 'Cancelled'): ?>
                                        <button class="decline-button" onclick="confirmAction('reject', <?php echo $order['OrderID']; ?>)">Decline</button>
                                    <?php else: ?>
                                        <button class="decline-button" disabled style="background-color: grey; cursor: not-allsowed;">Cancelled</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>



            <br>

            <div class="admin-container">
                <div class="order-manager">
                    <!-- add/edit products text field/btn-->
                    <h2>Manage Products</h2>
                    <form action="admin.php" method="POST" class="order-manager-form">
                        <input type="hidden" name="productID" id="productID" value="">
                        <label for="productName">Product Name:</label>
                        <input type="text" id="productName" name="productName" required>

                        <label for="ManufacturerName">Manufacturer:</label>
                        <input type="text" id="ManufacturerName" name="ManufacturerName" required>

                        <label for="Description">Description:</label>
                        <input type="text" id="Description" name="Description" required>

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
                        <div class="button-container">
                            <button type="submit" name="add_product" id="add_product_button">Add Product</button>
                            <button type="submit" name="edit_product" id="edit_product_button" style="display:none;">Edit Product</button>
                            <button type="button" onclick="resetForm()" class="reset_form_button">Reset Form</button>
                        </div>
                    </form>
                </div>
                <br>

                <div class="product-management-container">
                    <!-- edit btn to text fields/ delete product -->
                    <div class="table-container">
                        <table class="product-table">
                            <thead class="product-header">
                                <tr>
                                    <th class="product-id">Product ID</th>
                                    <th class="product-name">Product Name</th>
                                    <th class="ManufacturerName">Manufacturer</th>
                                    <th class="Description">Description</th>
                                    <th class="price">Price</th>
                                    <th class="stock">Stock</th>
                                    <th class="category">Category</th>
                                    <th class="manage-action">Action</th>
                                </tr>
                            </thead>
                            <tbody class="product-body">
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <!-- product tables -->
                                        <td><?php echo htmlspecialchars($product['ProductID']); ?></td>
                                        <td><?php echo htmlspecialchars($product['ProductName']); ?></td>
                                        <td><?php echo htmlspecialchars($product['ManufacturerName']); ?></td>
                                        <td><?php echo htmlspecialchars($product['Description']); ?></td>
                                        <td><?php echo htmlspecialchars($product['Price']); ?></td>
                                        <td><?php echo htmlspecialchars($product['Stock']); ?></td>
                                        <td><?php echo htmlspecialchars($product['Category']); ?></td>
                                        <td id="table-buttons">
                                            <button class="edit-button" onclick="editProduct(<?php echo $product['ProductID']; ?>, '<?php echo htmlspecialchars($product['ProductName']); ?>', '<?php echo htmlspecialchars($product['ManufacturerName']); ?>', '<?php echo htmlspecialchars($product['Description']); ?>',<?php echo $product['Price']; ?>, <?php echo $product['Stock']; ?>, '<?php echo htmlspecialchars($product['Category']); ?>')">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="delete-button" onclick="confirmDelete(<?php echo $product['ProductID']; ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </section>
</body>

</html>