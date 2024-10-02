<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our eCommerce Site</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f8f8;
        }

        header {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }

        h1,
        h2 {
            color: #333;
        }

        .auth-buttons {
            margin-top: 10px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .btn {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #218838;
        }

        .product-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }

        .product-item {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            background-color: white;
            width: 200px;
            text-align: center;
        }

        footer {
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
            background-color: #007BFF;
            color: white;
        }
    </style>
</head>

<body>
    <header>
        <h1>Welcome to Our eCommerce Store!</h1>

        <!-- checks if naka log-in  na -->
        <?php if (isset($_SESSION['Username'])): ?>
            <p>Hello, <?php echo htmlspecialchars($_SESSION['Username']); ?>!</p>
            <a href="pages/logout.php" class="btn">Logout</a>

            <!-- if walang naka log-in, continue as guest -->
        <?php else: ?>
            <div class="auth-buttons">
                <a href="pages/login.php" class="btn">Login</a>
                <a href="pages/register.php" class="btn">Register Now</a>
            </div>
        <?php endif; ?>
    </header>

    <!-- mema products, soon to be implemented -->
    <main>
        <h2>Find the best products at the best prices!</h2>

        <h2>Featured Products</h2>
        <div class="product-list">
            <?php
            require 'includes/db_config.php';

            $sql = "SELECT * FROM Product";
            $stmt = $pdo->query($sql);

            while ($row = $stmt->fetch()) {
                echo '<div class="product-item">';
                echo '<h3>' . htmlspecialchars($row['ProductName']) . '</h3>';
                echo '<p>' . htmlspecialchars($row['Description']) . '</p>';
                echo '<p>Price: $' . htmlspecialchars($row['Price']) . '</p>';
                echo '<p>Stock: ' . htmlspecialchars($row['Stock']) . '</p>';
                echo '<a href="pages/login.php?redirect=products.html&id=' . htmlspecialchars($row['ProductID']) . '" class="btn">View Product</a>';
                echo '</div>';
            }
            ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Our eCommerce Store</p>
    </footer>
</body>

</html>