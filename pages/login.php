<?php
session_start();

require '../includes/db_config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password.";
    } else {
        $sql = "SELECT CustomerID, Username, Password FROM Customer WHERE Username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        $customer = $stmt->fetch();

        if ($password) { // check if may pw

            // 1.) check if admin
            $sql_admin = "SELECT AdminID, Username, Password FROM Admin WHERE Username = :username";
            $stmt_admin = $pdo->prepare($sql_admin);
            $stmt_admin->execute(['username' => $username]);
            $admin = $stmt_admin->fetch();

            // check if tama
            if ($admin && $password === $admin['Password']) {
                $_SESSION['AdminID'] = $admin['AdminID'];
                $_SESSION['AdminUsername'] = $admin['Username'];

                header("Location: admin.php"); // to admin page
                exit;
            }

            // 2.) If admin not found, check for Customer credentials
            $sql_customer = "SELECT CustomerID, Username, Password FROM Customer WHERE Username = :username";
            $stmt_customer = $pdo->prepare($sql_customer);
            $stmt_customer->execute(['username' => $username]);
            $customer = $stmt_customer->fetch();

            // check if tama
            if ($customer && $password === $customer['Password']) {
                $_SESSION['CustomerID'] = $customer['CustomerID'];
                $_SESSION['Username'] = $customer['Username'];

                header("Location: ../index.php"); // to homepage
                exit;
            }

            // 3.) if both wala, then show error message
            $error = "Invalid username or password.";
        } else {
            $error = "Password must be provided.";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to Our eCommerce Site</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f8f8;
        }

        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .btn {
            display: block;
            width: 100%;
            background-color: #007BFF;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .register-link,
        .browse-link {
            text-align: center;
            margin-top: 10px;
        }

        .register-link a,
        .browse-link a {
            color: #007BFF;
            text-decoration: none;
        }

        .register-link a:hover,
        .browse-link a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login to Your Account</h2>

        <?php if (isset($_SESSION['success_message'])): ?>
            <p style="color: green;"><?php echo htmlspecialchars($_SESSION['success_message']); ?></p>
            <?php unset($_SESSION['success_message']); //clears
            ?>
        <?php endif; ?>

        <?php if (isset($error) && !empty($error)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form action="" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class='btn'>Login</button>
        </form>




        <div class="register-link">
            <p>Don't have an account? <a href="register.php">Register here</a>.</p>
        </div>

        <div class="browse-link">
            <p>Want to browse first? <a href="../index.php">Continue as Guest</a>.</p>
        </div>
    </div>
</body>

</html>