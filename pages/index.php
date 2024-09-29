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
        <h1>Welcome to Our eCommerce Store</h1>
    </header>

    <main>
        <h2>Find the best products at the best prices!</h2>

        <h2>Featured Products</h2>
        <div class="product-list">
            <div class="product-item">
                <h3>Product 1</h3>
                <p>Description of Product 1</p>
                <p>Price: $19.99</p>
                <p>Stock: Available</p>
                <a href="products.html?id=1" class="btn">View Product</a>
            </div>

            <div class="product-item">
                <h3>Product 2</h3>
                <p>Description of Product 2</p>
                <p>Price: $29.99</p>
                <p>Stock: Available</p>
                <a href="products.html?id=2" class="btn">View Product</a>
            </div>

            <div class="product-item">
                <h3>Product 3</h3>
                <p>Description of Product 3</p>
                <p>Price: $39.99</p>
                <p>Stock: Out of Stock</p>
                <a href="products.html?id=3" class="btn">View Product</a>
            </div>

            <div class="product-item">
                <h3>Product 4</h3>
                <p>Description of Product 4</p>
                <p>Price: $49.99</p>
                <p>Stock: Available</p>
                <a href="products.html?id=4" class="btn">View Product</a>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Our eCommerce Store</p>
    </footer>
</body>

</html>