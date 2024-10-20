<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/adminStyle.css">

    <title>Admin Dashboard</title>
    <link
    rel="icon"
    type="image/x-icon"
    href="resources/images/logo-icon.png" />
</head>

<body>

    <section id="main">

        <header>
            <!-- Top Header / Logo Bar -->
            <div class="header-top">
                <!-- Logo -->
                <a href="index.php" class="logo">
                    <img src="resources/images/logo-with-icon.png" alt="logo" />
                </a>

                <a href="logout.php" class="logout-button">Sign-out</a>
            </div>


        </header>



    </section>

    <section id="dashboard">

        <main>

            <div class="admin-header">
                <h1>Admin Dashboard</h1>
                <p>You're logged in as <span>NAME</span> </p>
            </div>

            <div class="stat-container">
                <div class="stat-box-rating">
                    <span>Current Rating</span>
                    <p>5 Stars</p>
                </div>
                <div class="stat-box-itemsold">
                    <span>Items Sold</span>
                    <p>200130</p>
                </div>
            </div>

            <div class="order-management-container">

                <!-- confirm/reject orders -->
                <h2>Order Management</h2>
                <table class="order-table">
                    <thead class="order-header">
                        <tr>
                            <th class="order-id">Order ID</th>
                            <th class="customer-name">Customer Name</th>
                            <th class="order-date">Order Date</th>
                            <th class="status">Status</th>
                            <th class="action">Action</th>
                        </tr>
                    </thead>
                    <tbody class="order-body">
                        <tr>
                            <td>ORDER ID</td>
                            <td>FirstName</td>
                            <td>OrderDate</td>
                            <td>Status</td>
                            <td id="table-buttons">
                                <button class="confirm-button">Confirm</button>
                                <button class="decline-button">Decline</button>
                            </td>

                        </tr>
                        
                    </tbody>

                </table>

            </div>
            <br>
            <div class="order-manager">

                 <!-- add/edit products text field/btn-->
                <h2>Add Products</h2>
                <p>Please Fill up the Required Information</p>
                <br>

                <form action="admin.php" method="POST" class="order-manager-form">
    
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

                    <div class="button-container">
                        <button type="submit" name="add_product" id="add_product_button">Add Product</button>
                    <button type="submit" name="edit_product" id="edit_product_button">Edit Product</button>
                    <button class="reset_form_button" >Reset Form</button>

                    </div>
                    <br>
                </form>
            </div>
            <br>

            <div class="order-management-container">

                <!-- edit btn to text fields/ delete product -->
                <h2>Manage Products</h2>
                <table class="order-table">
                    <thead class="order-header">
                        <tr>
                            <th class="product-id">Product ID</th>
                            <th class="product-name">Product Name</th>
                            <th class="manufacturer">Manufacturer</th>
                            <th class="price">Price</th>
                            <th class="stock">Stock</th>
                            <th class="category">Category</th>
                            <th class="manage-action">Action</th>
                        </tr>
                        
                    <tbody class="order-body">
                        <tr>
                            <td>PRODUCT ID</td>
                            <td>Product Name</td>
                            <td>Manufacturer</td>
                            <td>Price</td>
                            <td>Stock</td>
                            <td>Category</td>
                            <td id="table-buttons">
                                <button class="edit-button">Edit</button>
                                <button class="delete-button">Delete</button>
                            </td>

                        </tr>
                    </tbody>

                </table>

            </div>
        </main>

    </section>

</body>

</html>